<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\DetalleCompra;
use App\Models\ProductoProcedimiento;

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
        $movimientos = $entradas->concat($salidas)
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
                return view('inventario.partials.tabla-movimientos',
                    compact('movimientosPag'))->render();
            }

            return view('inventario.partials.tabla',
                compact('productos'))->render();
        }        

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
            'movimientosPag'
        ));


    }


}
