<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proveedor;
use Illuminate\Validation\Rule;

class ProveedorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $buscar = $request->input('buscar');

        $porPagina = (int) $request->input('porPagina', 6);

        if (!in_array($porPagina, [10, 25, 50, 100])) {
            $porPagina = 10;
        }

        $proveedores = Proveedor::withTrashed()
            ->when($buscar, function ($query, $buscar) {
                $query->where('nombre', 'like', "%{$buscar}%")
                    ->orWhere('correo', 'like', "%{$buscar}%")
                    ->orWhere('telefono', 'like', "%{$buscar}%");
            })
            ->orderBy('idProveedor', 'asc')
            ->paginate($porPagina)
            ->withQueryString();

        if ($request->ajax()) {
            return view('proveedores.partials.tabla', compact('proveedores', 'porPagina'))->render();
        }

        return view('proveedores.index', compact(
            'proveedores',
            'buscar',
            'porPagina'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return view('proveedores.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate(
            [
                'nombre' => 'required|unique:proveedores,nombre',
                'telefono' => [
                    'required',
                    'unique:proveedores,telefono',
                    'regex:/^(809|829|849)-\d{3}-\d{4}$/'
                ],
                'correo' => 'required|email:rfc,dns|unique:proveedores,correo',
            ],
            [
                'nombre.required' => 'El nombre es obligatorio.',
                'nombre.unique' => 'Ya existe un proveedor con ese nombre.',

                'telefono.required' => 'El teléfono es obligatorio.',
                'telefono.unique' => 'Ese teléfono ya está registrado.',
                'telefono.regex' => 'El teléfono debe tener el formato 809-555-1234.',

                'correo.required' => 'El correo es obligatorio.',
                'correo.email' => 'Ingrese un correo válido.',
                'correo.unique' => 'Ese correo ya está registrado.'
            ]
        );

        Proveedor::create([
            'nombre' => $request->nombre,
            'telefono' => $request->telefono,
            'correo' => $request->correo,
        ]);

        return redirect()
            ->route('proveedores.index')
            ->with('success', 'Proveedor registrado correctamente.');
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
        $proveedor = Proveedor::withTrashed()->findOrFail($id);

        return view('proveedores.edit', compact('proveedor'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $proveedor = Proveedor::withTrashed()->findOrFail($id);

        $request->validate(
            [
                'nombre' => 'required|unique:proveedores,nombre,' . $id . ',idProveedor',

                'telefono' => [
                    'required',
                    'regex:/^(809|829|849)-\d{3}-\d{4}$/',
                    'unique:proveedores,telefono,' . $id . ',idProveedor'
                ],

                'correo' => 'required|email:rfc,dns|unique:proveedores,correo,' . $id . ',idProveedor',
            ],
            [
                'nombre.required' => 'El nombre es obligatorio.',
                'nombre.unique' => 'Ya existe un proveedor con ese nombre.',

                'telefono.required' => 'El teléfono es obligatorio.',
                'telefono.unique' => 'Ese teléfono ya está registrado.',
                'telefono.regex' => 'El teléfono debe tener el formato 809-555-1234.',

                'correo.required' => 'El correo es obligatorio.',
                'correo.email' => 'Ingrese un correo válido.',
                'correo.unique' => 'Ese correo ya está registrado.'
            ]
        );

        $proveedor->nombre = $request->nombre;
        $proveedor->telefono = $request->telefono;
        $proveedor->correo = $request->correo;

        $proveedor->save();

        return redirect()
            ->route('proveedores.index')
            ->with('success', 'Proveedor actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $proveedor = Proveedor::findOrFail($id);

        $proveedor->delete();

        return redirect()
            ->route('proveedores.index')
            ->with('success', 'Proveedor dado de baja correctamente.');
    }

    public function activar($id)
    {
        $proveedor = Proveedor::withTrashed()->findOrFail($id);

        $proveedor->restore();

        return redirect()
            ->route('proveedores.index')
            ->with('success', 'Proveedor activado correctamente.');
    }
}
