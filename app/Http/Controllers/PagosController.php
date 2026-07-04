<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Factura;
use App\Models\Pago;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class PagosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'idFactura' => 'required|exists:facturas,idFactura',
            'idMetodoPago' => 'required|exists:metodo_pagos,idMetodoPago',
            'pagos' => 'required|array|min:1',
            'pagos.*' => 'exists:pagos,idPago',
            'referenciaPago' => 'nullable|string|max:100',
            'observacion' => 'nullable|string',
        ]);

        $factura = Factura::findOrFail($request->idFactura);

        $pagos = Pago::where('idFactura', $factura->idFactura)
            ->whereIn('idPago', $request->pagos)
            ->get();

        DB::transaction(function () use ($request, $pagos) {

            foreach ($pagos as $pago) {

                $pago->update([
                    'idMetodoPago' => $request->idMetodoPago,
                    'idUsuario' => Auth::id(),
                    'fechaRealizacion' => Carbon::today(),
                    'referenciaPago' => $request->referenciaPago,
                    'observacion' => $request->observacion,
                    'estado' => 'Pagado',
                ]);
            }
        });

        $this->actualizarEstadoFactura($factura);

        return redirect()
            ->route('facturacion.show', $factura->idFactura)
            ->with('success', 'Pago registrado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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

    private function actualizarEstadoFactura(Factura $factura): void
    {
        $pendientes = $factura->pagos()
            ->where('estado', 'Pendiente')
            ->count();

        if ($pendientes === 0) {

            $factura->estado = 'Pagada';
        } elseif ($pendientes === $factura->cantidadCuotas) {

            $factura->estado = 'Pendiente';
        } else {

            $factura->estado = 'Parcial';
        }

        $factura->save();
    }
}
