<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\DetalleCompra;
use App\Models\ProductoProcedimiento;
use App\Models\Ajuste;
use Barryvdh\DomPDF\Facade\Pdf;

class InventarioController extends Controller
{
    public function index(Request $request)
    {

        $buscar = $request->buscar;
        $filtro = $request->filtro;

        $productos = Producto::with('detallesCompra')

            ->when($buscar, function ($query) use ($buscar) {
                $query->where('nombre', 'like', "%{$buscar}%");
            })

            ->when($filtro === 'normal', function ($query) {
                $query->whereColumn('stockActual', '>', 'stockMinimo');
            })

            ->when($filtro === 'bajo', function ($query) {
                $query->where('stockActual', '>', 0)
                    ->whereColumn('stockActual', '<=', 'stockMinimo');
            })

            ->when($filtro === 'agotado', function ($query) {
                $query->where('stockActual', '<=', 0);
            })

            ->paginate(5)
            ->withQueryString();

        // metricas para las tarjetas
        $totalProductos = Producto::count();

        $stockBajo = Producto::where('stockActual', '>', 0)
            ->whereColumn('stockActual', '<=', 'stockMinimo')
            ->count();

        $sinStock = Producto::where('stockActual', '<=', 0)->count();

        $porVencer = DetalleCompra::whereNotNull('fechaVencimiento')
            ->where('fechaVencimiento', '>=', now())
            ->where('fechaVencimiento', '<=', now()->addDays(30))
            ->distinct('idProducto')
            ->count('idProducto');

        // alertas agrupadas
        $alertasSinStock = Producto::where('stockActual', '<=', 0)
            ->get(['idProducto', 'nombre', 'stockActual', 'unidadMedida']);

        $alertasStockBajo = Producto::where('stockActual', '>', 0)
            ->whereColumn('stockActual', '<=', 'stockMinimo')
            ->get(['idProducto', 'nombre', 'stockActual', 'stockMinimo', 'unidadMedida']);

        $alertasVencimiento = DetalleCompra::with('producto')
            ->whereNotNull('fechaVencimiento')
            ->where('fechaVencimiento', '>=', now())
            ->where('fechaVencimiento', '<=', now()->addDays(30))
            ->orderBy('fechaVencimiento', 'asc')
            ->get()
            ->unique('idProducto');

        $totalAlertas = $alertasSinStock->count()
            + $alertasStockBajo->count()
            + $alertasVencimiento->count();

        // movimientos

        // entradas
        $entradas = DetalleCompra::with('producto')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(fn($d) => [
                'fecha' => $d->created_at,
                'producto' => $d->producto->nombre ?? '—',
                'tipo' => 'ENTRADA',
                'cantidad' => $d->cantidad,
                'motivo' => 'Compra #' . str_pad($d->idCompras, 4, '0', STR_PAD_LEFT),
            ]);

        // salidas
        $salidas = ProductoProcedimiento::with(['producto', 'procedimiento'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(fn($p) => [
                'fecha' => $p->created_at,
                'producto' => $p->producto->nombre ?? '—',
                'tipo' => 'SALIDA',
                'cantidad' => $p->cantidad,
                'motivo' => 'Procedimiento #' . $p->idProcedimiento . ': ' . ($p->procedimiento->nombre ?? '—'),
            ]);

        // combinar, ordenar y paginar movimientos
        $ajustes = Ajuste::with('producto')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(fn($a) => [
                'fecha' => $a->created_at,
                'producto' => $a->producto->nombre ?? '—',
                'tipo' => $a->stockNuevo < $a->stockAnterior ? 'SALIDA' : 'ENTRADA',
                'cantidad' => abs($a->stockNuevo - $a->stockAnterior),
                'motivo' => 'Ajuste: ' . $a->motivo,
            ]);

        $movimientos = $entradas->concat($salidas)->concat($ajustes)
            ->sortByDesc('fecha')
            ->values();

        $paginaActual = $request->get('pagMov', 1);
        $porPagina = 10;
        $movimientosPag = new \Illuminate\Pagination\LengthAwarePaginator(
            $movimientos->forPage($paginaActual, $porPagina),
            $movimientos->count(),
            $porPagina,
            $paginaActual,
            ['pageName' => 'pagMov', 'path' => request()->url(), 'query' => request()->query(),]
        );

        if ($request->ajax()) {
            $tipo = $request->get('tipo');

            if ($tipo === 'movimientos') {
                return view(
                    'inventario.partials.tabla-movimientos',
                    compact('movimientosPag')
                )->render();
            }

            return view(
                'inventario.partials.tabla',
                compact('productos')
            )->render();
        }

        $todosProductos = Producto::orderBy('nombre')->get(['idProducto', 'nombre', 'stockActual', 'unidadMedida']);

        return view('inventario.index', compact(
            'productos',
            'totalProductos',
            'stockBajo',
            'sinStock',
            'porVencer',
            'alertasSinStock',
            'alertasStockBajo',
            'alertasVencimiento',
            'totalAlertas',
            'movimientosPag',
            'todosProductos'
        ));


    }

    public function ajuste(Request $request)
    {
        $request->validate([
            'idProducto' => 'required|exists:productos,idProducto',
            'nuevoStock' => 'required|integer|min:0',
            'motivo' => 'required|string',
        ]);

        $producto = Producto::findOrFail($request->idProducto);

        Ajuste::create([
            'idProducto' => $producto->idProducto,
            'idUsuario' => auth()->id(),
            'stockAnterior' => $producto->stockActual,
            'stockNuevo' => $request->nuevoStock,
            'motivo' => $request->motivo,
            'observacion' => $request->observacion,
        ]);

        $producto->stockActual = $request->nuevoStock;
        $producto->save();

        return redirect()->route('inventario.index')
            ->with('success', "Stock de \"{$producto->nombre}\" ajustado correctamente.");
    }

    public function buscarProductos(Request $request)
    {
        $texto = $request->texto;

        $productos = Producto::where(
            'nombre',
            'like',
            "%{$texto}%"
        )
            ->limit(10)
            ->get();

        return response()->json($productos);
    }

    public function detalle($id)
    {
        $producto = Producto::with([
            'detallesCompra' => function ($q) {
                $q->with('compra.proveedor')
                    ->orderBy('fechaVencimiento', 'asc');
            }
        ])->findOrFail($id);

        return view('inventario.detalle', compact('producto'));
    }

    public function reporte()
    {
        $productos = Producto::with([
            'detallesCompra' => function ($query) {
                $query->orderBy('fechaVencimiento', 'asc');
            }
        ])
            ->orderBy('nombre')
            ->get();

        foreach ($productos as $producto) {

            // estado del stock
            if ($producto->stockActual <= 0) {
                $producto->estadoStock = 'Sin stock';
            } elseif ($producto->stockActual <= $producto->stockMinimo) {
                $producto->estadoStock = 'Stock bajo';
            } else {
                $producto->estadoStock = 'Normal';
            }

            // proximo vencimiento de los lotes 
            $proximoLote = $producto->detallesCompra
                ->filter(function ($lote) {
                    return $lote->fechaVencimiento &&
                        Carbon::parse($lote->fechaVencimiento)->isFuture();
                })
                ->sortBy('fechaVencimiento')
                ->first();

            $producto->proximoVencimiento = $proximoLote
                ? Carbon::parse($proximoLote->fechaVencimiento)->format('d/m/Y')
                : null;

            // informacion de los lotes
            foreach ($producto->detallesCompra as $lote) {

                if (!$lote->fechaVencimiento) {

                    $lote->fechaVencimientoFormateada = 'N/A';
                    $lote->estadoLote = 'Sin fecha';
                    $lote->diasRestantes = null;

                    continue;
                }

                $fechaVencimiento = Carbon::parse($lote->fechaVencimiento);

                $lote->fechaVencimientoFormateada =
                    $fechaVencimiento->format('d/m/Y');

                $dias = now()->diffInDays($fechaVencimiento, false);

                $lote->diasRestantes = $dias;

                if ($dias < 0) {

                    $lote->estadoLote = 'Vencido';

                } elseif ($dias <= 30) {

                    $lote->estadoLote = 'Por vencer';

                } else {

                    $lote->estadoLote = 'Vigente';
                }
            }
        }

        $totalProductos = $productos->count();

        $sinStock = $productos
            ->where('stockActual', '<=', 0)
            ->count();

        $stockBajo = $productos
            ->filter(function ($producto) {
                return $producto->stockActual > 0
                    && $producto->stockActual <= $producto->stockMinimo;
            })
            ->count();

        $fechaReporte = now()->format('d/m/Y H:i');

        $pdf = Pdf::loadView(
            'inventario.reporte',
            [
                'productos' => $productos,
                'totalProductos' => $totalProductos,
                'sinStock' => $sinStock,
                'stockBajo' => $stockBajo,
                'fechaReporte' => $fechaReporte,
            ]
        )->setPaper('a4', 'portrait');

        $nombreArchivo = 'inventario' . now()->format('d-m-Y') . '.pdf';

        return $pdf->stream($nombreArchivo);
    }


}
