<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alergia;

class AlergiaController extends Controller
{

    public function index(Request $request)
    {
        $buscar = $request->input('buscar');

        $porPagina = (int) $request->input('porPagina', 6);

        if (!in_array($porPagina, [6, 10, 25, 50, 100])) {
            $porPagina = 6;
        }

        $alergias = Alergia::query()
            ->when($buscar, function ($query, $buscar) {
                $query->where('nombre', 'like', "%{$buscar}%");
            })
            ->orderBy('idAlergia', 'asc')
            ->paginate($porPagina)
            ->withQueryString();

        if ($request->ajax()) {
            return view(
                'alergias.partials.tabla',
                compact('alergias', 'porPagina')
            )->render();
        }

        return view(
            'alergias.index',
            compact(
                'alergias',
                'buscar',
                'porPagina'
            )
        );
    }

    public function create()
    {
        return view('alergias.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100|unique:alergias,nombre'
        ], [
            'nombre.unique' => 'Esta alergia ya existe.'
        ]);

        Alergia::create([
            'nombre' => $request->nombre
        ]);

        return redirect()->route('alergias.index')->with('success', 'Alergia creada correctamente');
    }

    public function edit($id)
    {
        $alergia = Alergia::findOrFail($id);
        return view('alergias.edit', compact('alergia'));
    }

    public function update(Request $request, $id)
    {

        $request->validate(
            [
                'nombre' => 'required|string|max:100|unique:alergias,nombre,' . $id . ',idAlergia'
            ],
            ['nombre.unique' => 'Esta alergia ya se encuentra registrada en el sistema.']
        );

        $alergia = Alergia::findOrFail($id);
        $alergia->update($request->all());

        return redirect()->route('alergias.index')->with('success', 'Alergia actualizada correctamente');
    }

    public function destroy($id)
    {
        $alergia = Alergia::findOrFail($id);

        $alergia->delete();

        return redirect()
            ->route('alergias.index')
            ->with('success', 'Alergia eliminada correctamente');
    }
}
