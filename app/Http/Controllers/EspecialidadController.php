<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Especialidad;

class EspecialidadController extends Controller
{
    public function index(Request $request)
    {
        $buscar = $request->input('buscar');

        $porPagina = (int) $request->input('porPagina', 6);

        if (!in_array($porPagina, [10, 25, 50, 100])) {
            $porPagina = 10;
        }

        $especialidades = Especialidad::query()
            ->when($buscar, function ($query, $buscar) {
                $query->where('nombre', 'like', "%{$buscar}%");
            })
            ->orderBy('idEspecialidad', 'asc')
            ->paginate($porPagina)
            ->withQueryString();

        if ($request->ajax()) {
            return view(
                'especialidades.partials.tabla',
                compact('especialidades', 'porPagina')
            )->render();
        }

        return view(
            'especialidades.index',
            compact(
                'especialidades',
                'buscar',
                'porPagina'
            )
        );
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

        return redirect()
            ->route('especialidades.index')
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
        $request->validate(
            [
                'nombre' => 'required|string|max:100|unique:especialidades,nombre,' . $id . ',idEspecialidad'
            ],
            [
                'nombre.required' => 'El nombre es obligatorio.',
                'nombre.unique' => 'Esta especialidad ya existe.'
            ]
        );

        $especialidad = Especialidad::findOrFail($id);
        $especialidad->update($request->all());

        return redirect()
            ->route('especialidades.index')
            ->with('success', 'Especialidad actualizada correctamente');
    }

    public function destroy($id)
    {
        $especialidad = Especialidad::findOrFail($id);
        $especialidad->delete();

        return redirect()->route('especialidades.index')->with('success', 'Especialidad eliminada correctamente');
    }
}
