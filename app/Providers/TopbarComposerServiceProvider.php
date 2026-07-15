<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Producto;
use App\Models\DetalleCompra;

class TopbarComposerServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        View::composer('components.topbar', function ($view) {

            if (!auth()->check()) {
                $view->with('totalAlertasTopbar', 0)
                    ->with('alertasSinStockTopbar', collect())
                    ->with('alertasStockBajoTopbar', collect())
                    ->with('alertasVencimientoTopbar', collect())
                    ->with('alertasSoloVencidoTopbar', collect());
                return;
            }

            $alertasSinStock = Producto::where('stockActual', '<=', 0)
                ->get(['idProducto', 'nombre']);

            $alertasStockBajo = Producto::where('stockActual', '>', 0)
                ->whereColumn('stockActual', '<=', 'stockMinimo')
                ->get(['idProducto', 'nombre', 'stockActual', 'stockMinimo']);

            $alertasVencimiento = DetalleCompra::with('producto')
                ->whereNotNull('fechaVencimiento')
                ->where('cantidadDisponible', '>', 0)
                ->where('fechaVencimiento', '>=', now())
                ->where('fechaVencimiento', '<=', now()->addDays(30))
                ->orderBy('fechaVencimiento', 'asc')
                ->get()
                ->unique('idProducto');

            $alertasSoloVencido = Producto::where('stockActual', '>', 0)
                ->whereHas('detallesCompra')
                ->whereDoesntHave('detallesCompra', function ($q) {
                    $q->where('cantidadDisponible', '>', 0)
                        ->where(function ($q2) {
                            $q2->whereNull('fechaVencimiento')
                                ->orWhere('fechaVencimiento', '>=', now()->startOfDay());
                        });
                })
                ->get(['idProducto', 'nombre']);

            $total = $alertasSinStock->count()
                + $alertasStockBajo->count()
                + $alertasVencimiento->count()
                + $alertasSoloVencido->count();

            $view->with('totalAlertasTopbar', $total)
                ->with('alertasSinStockTopbar', $alertasSinStock)
                ->with('alertasStockBajoTopbar', $alertasStockBajo)
                ->with('alertasVencimientoTopbar', $alertasVencimiento)
                ->with('alertasSoloVencidoTopbar', $alertasSoloVencido);
        });
    }
}