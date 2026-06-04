<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CajaChica;

class CajaChicaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $cajas = CajaChica::query();

        if ($request->filled('fecha')) {

            $cajas->whereDate('fecha', $request->fecha);
        }

        $cajas = $cajas
            ->orderByDesc('fecha')
            ->orderByDesc('horaApertura')
            ->paginate(6);

        if ($request->ajax()) {

            return view(
                'caja_chica.partials.tabla',
                compact('cajas')
            )->render();
        }

        return view('caja_chica.index', compact('cajas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('caja_chica.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('caja_chica.show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
