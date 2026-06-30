<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CajaChica;
use App\Models\MovimientoCajaChica;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class CajaChicaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $porPagina = (int) $request->input('porPagina', 6);

        if (!in_array($porPagina, [10, 25, 50, 100])) {
            $porPagina = 10;
        }

        $cajas = CajaChica::query();

        if ($request->filled('fecha')) {
            $cajas->whereDate('fecha', $request->fecha);
        }

        $cajas = $cajas
            ->orderByDesc('fecha')
            ->orderByDesc('horaApertura')
            ->paginate($porPagina)
            ->withQueryString();

        if ($request->ajax()) {
            return view(
                'caja_chica.partials.tabla',
                compact('cajas', 'porPagina')
            )->render();
        }

        return view(
            'caja_chica.index',
            compact('cajas', 'porPagina')
        );
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
    public function show($id)
    {
        $caja = CajaChica::with('movimientos')->findOrFail($id);
        return view('caja_chica.show', compact('caja'));
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
            'fecha' => ['required', 'date', Rule::unique('caja_chicas', 'fecha'),],
            'horaApertura' => 'required|date_format:H:i',
            'saldoInicial' => 'required|numeric|gt:0',
        ], [
            'fecha.unique' => 'Ya existe una caja para esta fecha.',
            'saldoInicial.gt' => 'El saldo inicial debe ser mayor que cero.',
        ]);
    }

    public function registrarEgreso(Request $request, CajaChica $caja)
    {
        $request->validate([
            'monto' => ['required', 'numeric', 'min:0.01'],
            'descripcion' => ['required', 'string', 'max:255'],
        ]);

        if ($request->monto > $caja->monto) {
            return back()->withErrors([
                'monto' => 'El monto excede el saldo disponible.'
            ]);
        }

        DB::transaction(function () use ($request, $caja) {

            MovimientoCajaChica::create([
                'idUsuario' => 1, // Cambiar luego por auth()->user()->idUsuario
                'idCajaChica' => $caja->idCajaChica,
                'hora' => now()->format('H:i:s'),
                'monto' => $request->monto,
                'tipo' => 'Egreso',
                'descripcion' => $request->descripcion,
            ]);

            $caja->decrement('monto', $request->monto);
        });

        return redirect()
            ->route('caja-chica.show', $caja->idCajaChica)
            ->with('success', 'Egreso registrado correctamente.');
    }

    public function cerrarCaja(Request $request, $idCaja)
    {
        $request->validate([
            'montoContado' => 'required|numeric|min:0',
        ]);

        $caja = CajaChica::findOrFail($idCaja);

        $caja->horaCierre = now()->format('H:i:s');

        $caja->diferencia = $request->montoContado - $caja->monto;

        $caja->estado = 'Cerrada';

        $caja->save();

        return redirect()
            ->route('caja-chica.show', $idCaja)
            ->with('success', 'Caja cerrada correctamente.');
    }
}
