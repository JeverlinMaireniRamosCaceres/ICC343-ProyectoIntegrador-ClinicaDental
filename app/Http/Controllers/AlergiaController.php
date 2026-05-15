<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alergia;

class AlergiaController extends Controller
{
    public function index()
    {
        return view('alergias.index');
    }

    public function create()
    {
        return view('alergias.create');
    }

    public function store(Request $request)
    {
        $request -> validate([
            'nombre' => 'required|string|max:100|unique:alergias,nombre'
        ], [
            'nombre.unique' => 'Esta alergia ya existe.'
        ]);

        Alergia::create([
            'nombre' => $request -> nombre
        ]);

        return redirect()->route('alergias.index')->with('success', 'Alergia creada correctamente');
    }
}
