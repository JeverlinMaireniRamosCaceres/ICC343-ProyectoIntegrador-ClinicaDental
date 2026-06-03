<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;

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

        if ($request->ajax()) {
            return view(
                'inventario.partials.tabla',
                compact('productos')
            )->render();
        }

        return view(
            'inventario.index',
            compact('productos')
        );

    }


}
