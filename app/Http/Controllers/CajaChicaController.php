<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CajaChica;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;


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

        $this->validarCajaAbierta();

        $this->validarDatos($request);

        CajaChica::create([
            'idUsuarioApertura' => 1,
            'fecha' => $request->fecha,
            'horaApertura' => $request->horaApertura,
            'saldoInicial' => $request->saldoInicial,
            'monto' => $request->saldoInicial,
            'estado' => 'Abierta',
            'diferencia' => 0,
        ]);

        return redirect()
            ->route('caja-chica.index')
            ->with('success', 'Caja abierta exitosamente.');
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

    private function validarCajaAbierta()
    {
        if (CajaChica::where('estado', 'Abierta')->exists()) {
            abort(
                redirect()
                    ->back()
                    ->withInput()
                    ->withErrors([
                        'fecha' => 'Ya existe una caja abierta.'
                    ])
            );
        }
    }

    private function validarDatos(Request $request)
    {
        $request->validate([
            'fecha' => [
                'required',
                'date',
                Rule::unique('caja_chicas', 'fecha'),
            ],
            'horaApertura' => 'required|date_format:H:i',
            'saldoInicial' => 'required|numeric|gt:0',
        ], [
            'fecha.unique' => 'Ya existe una caja para esta fecha.',
            'saldoInicial.gt' => 'El saldo inicial debe ser mayor que cero.',
        ]);
    }
}
