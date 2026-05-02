<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UsuariosController extends Controller
{
    public function index()
    {
        return view('usuarios.index');
    }

    public function create()
    {
        return view('usuarios.create');
    }

    public function store(Request $request)
    {
        // no hace nada por ahora
        return redirect()->route('usuarios.index');
    }

    public function show($id)
    {
        return view('usuarios.show', compact('id'));
    }

    public function edit($id)
    {
        return view('usuarios.edit', compact('id'));
    }

    public function update(Request $request, $id)
    {
        return redirect()->route('usuarios.index');
    }

    public function destroy($id)
    {
        return redirect()->route('usuarios.index');
    }
}