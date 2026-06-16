<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Procedimiento;
use App\Models\ProductoProcedimiento;
use Illuminate\Validation\Rule;

class ProcedimientoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $buscar = $request->buscar;

        $procedimientos = Procedimiento::when($buscar, function ($query, $buscar) {
            $query->where('nombre', 'like', "%{$buscar}%");
        })
            ->orderBy('idProcedimiento')
            ->paginate(6)
            ->withQueryString();

        if ($request->ajax()) {
            return view('procedimientos.partials.tabla', compact('procedimientos'));
        }

        return view('procedimientos.index', compact('procedimientos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('procedimientos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $this->validarProcedimiento($request);

        Procedimiento::create($data);

        return redirect()
            ->route('procedimientos.index')
            ->with('success', 'Procedimiento creado correctamente.');
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
        $procedimiento = Procedimiento::findOrFail($id);
        return view('procedimientos.edit', compact('procedimiento'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $procedimiento = Procedimiento::findOrFail($id);

        $data = $this->validarProcedimiento($request, $procedimiento->idProcedimiento);

        $procedimiento->update($data);

        return redirect()
            ->route('procedimientos.index')
            ->with('success', 'Procedimiento actualizado correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $procedimiento = Procedimiento::findOrFail($id);

        $estaVinculadoAProducto = ProductoProcedimiento::where('idProcedimiento', $id)
            ->whereHas('producto')
            ->exists();

        if ($estaVinculadoAProducto) {
            return redirect()
                ->route('procedimientos.index')
                ->with('error', "No se puede eliminar el procedimiento '{$procedimiento->nombre}' porque está vinculado a uno o más productos de consumo.");
        }

        $procedimiento->delete();

        return redirect()
            ->route('procedimientos.index')
            ->with('success', 'Procedimiento eliminado correctamente');
    }

    private function validarProcedimiento(Request $request, ?int $idProcedimiento = null): array
    {
        return $request->validate(
            [
                'nombre' => [
                    'required',
                    'string',
                    'max:100',
                    Rule::unique('procedimientos', 'nombre')
                        ->ignore($idProcedimiento, 'idProcedimiento')
                ],

                'precio' => 'required|numeric|gt:0'
            ],
            [
                'nombre.required' => 'El nombre del procedimiento es obligatorio.',
                'nombre.unique' => 'Ya existe un procedimiento con este nombre.',
                'nombre.max' => 'El nombre del procedimiento no puede exceder los 100 caracteres.',

                'precio.required' => 'El precio es obligatorio.',
                'precio.numeric' => 'El precio debe ser un valor numérico.',
                'precio.gt' => 'El precio debe ser mayor que 0.'
            ]
        );
    }
}
