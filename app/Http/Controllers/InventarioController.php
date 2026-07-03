<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\DetalleCompra;
use App\Models\ProductoProcedimiento;
use App\Models\Ajuste;
use App\Models\MovimientoInventario;
use Barryvdh\DomPDF\Facade\Pdf;

class InventarioController extends Controller
{
    public function index(Request $request)
    {
        $buscar = $request->buscar;
        $filtro = $request->filtro;

        $porPaginaProductos = (int) $request->input('porPagina', 5);

        if (!in_array($porPaginaProductos, [10, 25, 50, 100])) {
            $porPaginaProductos = 10;
        }

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

            ->paginate($porPaginaProductos)
            ->withQueryString();

        // métricas para las tarjetas
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

        // entradas
        $entradas = MovimientoInventario::with('producto')
            ->where('tipo', 'ENTRADA')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(fn($m) => [
                'fecha' => $m->created_at,
                'producto' => $m->producto->nombre ?? '—',
                'tipo' => 'ENTRADA',
                'cantidad' => $m->cantidad,
                'motivo' => $m->motivo,
            ]);

        // salidas
        $salidas = MovimientoInventario::with(['producto', 'procedimiento'])
            ->where('tipo', 'SALIDA')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(fn($m) => [
                'fecha' => $m->created_at,
                'producto' => $m->producto->nombre ?? '—',
                'tipo' => 'SALIDA',
                'cantidad' => $m->cantidad,
                'motivo' => $m->procedimiento
                    ? 'Procedimiento: ' . $m->procedimiento->nombre
                    : $m->motivo,
            ]);

        // ajustes
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
        $porPaginaMovimientos = 10;

        $movimientosPag = new \Illuminate\Pagination\LengthAwarePaginator(
            $movimientos->forPage($paginaActual, $porPaginaMovimientos),
            $movimientos->count(),
            $porPaginaMovimientos,
            $paginaActual,
            [
                'pageName' => 'pagMov',
                'path' => request()->url(),
                'query' => request()->query(),
            ]
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
                compact('productos', 'porPaginaProductos')
            )->render();
        }

        $todosProductos = Producto::orderBy('nombre')
            ->get(['idProducto', 'nombre', 'stockActual', 'unidadMedida']);

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
            'todosProductos',
            'porPaginaProductos'
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

    public function lotes($id)
    {
        $lotes = DetalleCompra::where('idProducto', $id)
            ->with('compra.proveedor')
            ->orderBy('fechaVencimiento', 'asc')
            ->get()
            ->map(fn($d) => [
                'idDetalleCompra' => $d->idDetalleCompra,
                'cantidad' => $d->cantidad,
                'fechaVencimiento' => $d->fechaVencimiento
                    ? \Carbon\Carbon::parse($d->fechaVencimiento)->format('d/m/Y')
                    : 'Sin fecha',
                'compra' => '#' . str_pad($d->idCompras, 4, '0', STR_PAD_LEFT)
                    . ' — ' . ($d->compra->proveedor->nombre ?? '—'),
            ]);

        return response()->json($lotes);
    }

    public function detalle($id)
    {
        $producto = Producto::with([
            'detallesCompra' => function ($q) {
                $q->with('compra.proveedor')
                    ->where(function ($query) {
                        $query->whereNull('fechaVencimiento')
                            ->orWhere('fechaVencimiento', '>=', now()->subMonth());
                    })
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


                $dias = now()
                    ->startOfDay()
                    ->diffInDays($fechaVencimiento->startOfDay(), false);

                $lote->diasRestantes = (int) $dias;

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

    public function reporteOrdenCompra()
    {
        $productos = Producto::with([
            'detallesCompra.compra.proveedor'
        ])
            ->whereColumn('stockActual', '<=', 'stockMinimo')
            ->orderBy('nombre')
            ->get();

        foreach ($productos as $producto) {

            // Estado del stock
            $producto->estadoStock = $producto->stockActual <= 0
                ? 'Sin stock'
                : 'Stock bajo';

            // Cantidad sugerida a comprar
            $producto->cantidadComprar = max(
                0,
                $producto->stockMinimo - $producto->stockActual
            );

            // Proveedores a los que se ha comprado el producto
            $producto->proveedores = $producto->detallesCompra

                // Ignorar compras eliminadas o sin proveedor
                ->filter(function ($detalle) {
                    return $detalle->compra !== null
                        && $detalle->compra->proveedor !== null;
                })

                // Agrupar por proveedor
                ->groupBy(function ($detalle) {
                    return $detalle->compra->proveedor->idProveedor;
                })

                // Obtener la última compra realizada a cada proveedor
                ->map(function ($comprasProveedor) {

                    $ultimaCompra = $comprasProveedor
                        ->sortByDesc(function ($detalle) {
                            return $detalle->compra->fecha;
                        })
                        ->first();

                    return (object) [
                        'nombre' => $ultimaCompra->compra->proveedor->nombre,
                        'fechaUltimaCompra' => Carbon::parse(
                            $ultimaCompra->compra->fecha
                        )->format('d/m/Y'),
                    ];
                })

                ->sortBy('nombre')
                ->values();
        }

        $sinStock = $productos
            ->where('stockActual', '<=', 0)
            ->count();

        $stockBajo = $productos
            ->where('stockActual', '>', 0)
            ->count();

        $fechaReporte = now()->format('d/m/Y H:i');

        $pdf = Pdf::loadView(
            'inventario.reporteOrden',
            [
                'productos' => $productos,
                'totalProductos' => $productos->count(),
                'sinStock' => $sinStock,
                'stockBajo' => $stockBajo,
                'fechaReporte' => $fechaReporte,
            ]
        )->setPaper('a4', 'portrait');

        $nombreArchivo = 'reporte-orden-compra-' . now()->format('d-m-Y') . '.pdf';

        return $pdf->stream($nombreArchivo);
    }

}
