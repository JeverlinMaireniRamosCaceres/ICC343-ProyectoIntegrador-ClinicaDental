<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        return redirect()->route('alergias.index');
    }
}