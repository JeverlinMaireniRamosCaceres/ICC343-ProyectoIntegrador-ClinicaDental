<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Procedimiento;

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
            ->paginate(10)
            ->withQueryString();

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
        $request->validate([
            'nombre' => 'required|string|max:100',
            'precio' => 'required|numeric|min:0'
        ]);

        Procedimiento::create([
            'nombre' => $request->nombre,
            'precio' => $request->precio
        ]);

        return redirect()->route('procedimientos.index')->with('success', 'Procedimiento creado correctamente');
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
        $request->validate([
            'nombre' => 'required|string|max:100',
            'precio' => 'required|numeric|min:0'
        ]);

        $procedimiento = Procedimiento::findOrFail($id);

        $procedimiento->update([
            'nombre' => $request->nombre,
            'precio' => $request->precio
        ]);

        return redirect()->route('procedimientos.index')->with('success', 'Procedimiento actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $procedimiento = Procedimiento::findOrFail($id);

        $procedimiento->delete();

        return redirect()
            ->route('procedimientos.index')
            ->with('success', 'Procedimiento eliminado correctamente');
    }
}
