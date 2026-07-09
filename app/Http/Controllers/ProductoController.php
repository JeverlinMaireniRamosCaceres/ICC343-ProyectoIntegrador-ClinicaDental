<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $buscar = $request->input('buscar');

        $porPagina = (int) $request->input('porPagina', 10);

        if (!in_array($porPagina, [10, 25, 50, 100])) {
            $porPagina = 10;
        }

        $productos = Producto::query()
            ->when($buscar, function ($query, $buscar) {
                $query->where('nombre', 'like', "%{$buscar}%")
                    ->orWhere('descripcion', 'like', "%{$buscar}%");
            })
            ->orderBy('idProducto', 'asc')
            ->paginate($porPagina)
            ->withQueryString();

        if ($request->ajax()) {
            return view('productos.partials.tabla', compact('productos', 'porPagina'))->render();
        }

        return view('productos.index', compact('productos', 'buscar', 'porPagina'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('productos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'nombre' => 'required|string|max:100|unique:productos,nombre',
                'descripcion' => 'nullable|string|max:255',
                'stockActual' => 'required|integer|min:0',
                'stockMinimo' => 'required|integer|min:0',
                'unidadMedida' => 'required|string|max:50'
            ],
            [
                'nombre.required' => 'El nombre es obligatorio.',
                'nombre.unique' => 'Este producto ya existe.',

                'stockActual.required' => 'El stock inicial es obligatorio.',
                'stockActual.integer' => 'El stock inicial debe ser un número entero.',
                'stockActual.min' => 'El stock inicial no puede ser negativo.',

                'stockMinimo.required' => 'El stock mínimo es obligatorio.',
                'stockMinimo.integer' => 'El stock mínimo debe ser un número entero.',
                'stockMinimo.min' => 'El stock mínimo no puede ser negativo.',

                'unidadMedida.required' => 'Debes seleccionar una unidad de medida.',
            ]
        );

        Producto::create($request->all());

        return redirect()
            ->route('productos.index')
            ->with('success', 'Producto creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $producto = Producto::findOrFail($id);

        return view('productos.edit', compact('producto'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate(
            [
                'nombre' => 'required|string|max:100|unique:productos,nombre,' . $id . ',idProducto',
                'descripcion' => 'nullable|string|max:255',
                'stockMinimo' => 'required|integer|min:0',
                'unidadMedida' => 'required|string|max:50'

            ],
            [
                'nombre.required' => 'El nombre es obligatorio.',
                'nombre.unique' => 'Este producto ya existe.',

                'stockMinimo.required' => 'El stock mínimo es obligatorio.',
                'stockMinimo.integer' => 'El stock mínimo debe ser un número entero.',
                'stockMinimo.min' => 'El stock mínimo no puede ser negativo.',
            ]
        );

        $producto = Producto::findOrFail($id);
        $producto->update($request->all());

        return redirect()
            ->route('productos.index')
            ->with('success', 'Producto actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $producto = Producto::findOrFail($id);

        try {
            $producto->delete();

            return redirect()
                ->route('productos.index')
                ->with('success', 'Producto eliminado correctamente.');
        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() === '23000' || str_contains($e->getMessage(), 'a foreign key constraint fails')) {
                return redirect()
                    ->route('productos.index')
                    ->with('error', "No se puede eliminar el producto '{$producto->nombre}' porque está siendo utilizado en compras, facturación u otros registros del sistema.");
            }

            throw $e;
        }
    }
}
