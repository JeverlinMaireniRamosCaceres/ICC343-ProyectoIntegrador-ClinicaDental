<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alergia;

class AlergiaController extends Controller
{

    public function index(Request $request)
    {
        $buscar = $request->input('buscar');

        $alergias = Alergia::query()
            ->when($buscar, function ($query, $buscar) {
                $query->where('nombre', 'like', "%{$buscar}%");
            })
            ->orderBy('idAlergia', 'asc')
            ->paginate(6)
            ->withQueryString();

            if ($request->ajax()) {
                return view('alergias.partials.tabla', compact('alergias'))->render();
            }

        return view('alergias.index', compact('alergias', 'buscar'));
    }

    public function create()
    {
        return view('alergias.create');
    }

    public function store(Request $request)
    {
        $request -> validate([
            'nombre' => 'required|string|max:100'
        ]);

        Alergia::create([
            'nombre' => $request -> nombre
        ]);

        return redirect()->route('alergias.index')->with('success', 'Alergia creada correctamente');
    }
}
