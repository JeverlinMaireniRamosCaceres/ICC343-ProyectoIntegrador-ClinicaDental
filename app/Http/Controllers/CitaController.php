<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CitaController extends Controller
{
    
    public function index()
    {
        return view('citas.index');
    }

    public function create()
    {
        return view('citas.create');
    }

    public function store(Request $request)
    {

        return redirect()->route('citas.index');
    }

    public function show($id)
    {
        return view('citas.show', compact('id'));
    }

    public function edit($id)
    {
        return view('citas.edit', compact('id'));
    }

    public function update(Request $request, $id)
    {
        return redirect()->route('citas.index');
    }

    public function destroy($id)
    {
        return redirect()->route('citas.index');
    }
}