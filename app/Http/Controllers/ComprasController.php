<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Compra;
use App\Models\Proveedor;
use App\Models\Producto;

class ComprasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $buscar = $request->input('buscar');
        $estado = $request->input('estado');
        $fecha = $request->input('fecha');

        $compras = Compra::query()
            ->when($buscar, function ($query) use ($buscar) {
                $query->whereHas('proveedor', function ($q) use ($buscar) {
                    $q->where('nombre', 'like', "%{$buscar}%");
                });
            })
            ->when($estado, function ($query) use ($estado) {
                $query->where('estado', $estado);
            })
            ->when($fecha, function ($query) use ($fecha) {
                $query->where('fecha', $fecha);
            })
            ->orderBy('idCompras', 'asc')
            ->paginate(6)
            ->withQueryString();

        if ($request->ajax()) {
            return view('compras.partials.tabla', compact('compras'))->render();
        }
        return view('compras.index', compact('compras', 'buscar', 'estado', 'fecha'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $proveedores = Proveedor::orderBy('idProveedor')->get();
        //$productos = Producto::orderBy('idProducto')->get();
        return view('compras.create', compact('proveedores'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return view('compras.show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('compras.edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }
}
