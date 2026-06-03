<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proveedor;
use Illuminate\Validation\Rule;

class InventarioController extends Controller
{
    public function index()
    {
        return view('inventario.index');
    }
}
