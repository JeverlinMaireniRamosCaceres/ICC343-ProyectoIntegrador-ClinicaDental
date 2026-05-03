<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OdontologoController extends Controller
{
    public function index()
    {
        return view('odontologos.index');
    }

    public function create()
    {
        return view('odontologos.create');
    }

    public function store(Request $request)
    {
        return redirect()->route('odontologos.index');
    }

    public function show($id)
    {
        return view('odontologos.show', compact('id'));
    }

    public function edit($id)
    {
        return view('odontologos.edit', compact('id'));
    }

    public function update(Request $request, $id)
    {
        return redirect()->route('odontologos.index');
    }

    public function destroy($id)
    {
        return redirect()->route('odontologos.index');
    }
}