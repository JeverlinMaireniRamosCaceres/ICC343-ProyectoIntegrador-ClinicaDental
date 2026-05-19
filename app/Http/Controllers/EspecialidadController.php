<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Especialidad;

class EspecialidadController extends Controller
{
    public function index()
    {
        return view('especialidades.index');
    }

    public function create()
    {
        return view('especialidades.create');
    }

    public function store(Request $request)
    {
        $nombre = ucfirst(strtolower(trim($request->nombre)));

        $request->merge([
            'nombre' => $nombre
        ]);

        $request->validate(
            [
                'nombre' => 'required|string|max:100|unique:especialidades,nombre'
            ],
            [
                'nombre.unique' => 'Esta especialidad ya existe.',
                'nombre.required' => 'El nombre es obligatorio.'
            ]
        );

        Especialidad::create([
            'nombre' => $nombre
        ]);

        return back()
            ->with('success', 'Especialidad registrada correctamente.');
    }

    public function show($id)
    {
        $especialidad = Especialidad::findOrFail($id);
        return view('especialidades.show', compact('especialidad'));
    }

    public function edit($id)
    {
        $especialidad = Especialidad::findOrFail($id);
        
        return view('especialidades.edit', compact('especialidad'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:100'
        ]);

        $especialidad = Especialidad::findOrFail($id);
        $especialidad->update($request->all());

        return redirect()->route('especialidades.index')->with('success', 'Especialidad actualizada correctamente');
    }

    public function destroy($id)
    {
        $especialidad = Especialidad::findOrFail($id);
        $especialidad->delete();

        return redirect()->route('especialidades.index')->with('success', 'Especialidad eliminada correctamente');
    }
}