<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Factura;
use App\Models\Pago;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;
use App\Models\MetodoPago;
use App\Models\CajaChica;
use App\Models\MovimientoCajaChica;
use App\Mail\ReciboMail;
use Illuminate\Support\Facades\Mail;

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

        $metodoPago = MetodoPago::find($request->idMetodoPago);

        if ($metodoPago?->descripcion === 'Efectivo') {

            $cajaAbierta = CajaChica::whereDate('fecha', today())
                ->where('estado', 'Abierta')
                ->exists();

            if (!$cajaAbierta) {

                return back()
                    ->withInput()
                    ->withErrors([
                        'caja' => 'Debe abrir una caja chica antes de registrar un pago en efectivo.'
                    ]);
            }
        }

        $pagos = Pago::where('idFactura', $factura->idFactura)
            ->whereIn('idPago', $request->pagos)
            ->get();

        // Todos los pagos de esta operación compartirán este código
        $codigoRecibo = Str::uuid()->toString();

        DB::transaction(function () use ($request, $pagos, $metodoPago, $codigoRecibo) {

            foreach ($pagos as $pago) {

                $pago->update([
                    'idMetodoPago' => $request->idMetodoPago,
                    'idUsuario' => Auth::id(),
                    'fechaRealizacion' => Carbon::today(),
                    'referenciaPago' => $request->referenciaPago,
                    'observacion' => $request->observacion,
                    'estado' => 'Pagado',
                    'codigoRecibo' => $codigoRecibo,
                ]);
            }

            if ($metodoPago?->descripcion === 'Efectivo') {

                $caja = CajaChica::whereDate('fecha', today())
                    ->where('estado', 'Abierta')
                    ->first();

                $total = $pagos->sum('monto');

                MovimientoCajaChica::create([
                    'idUsuario' => Auth::id(),
                    'idCajaChica' => $caja->idCajaChica,
                    'hora' => now()->format('H:i:s'),
                    'monto' => $total,
                    'tipo' => 'Ingreso',
                    'descripcion' => 'Pago de factura FAC-' .
                        str_pad($pagos->first()->factura->idFactura, 6, '0', STR_PAD_LEFT),
                ]);

                $caja->increment('monto', $total);
            }
        });

        $this->actualizarEstadoFactura($factura);

        return redirect()
            ->route('facturacion.show', $factura)
            ->with([
                'success' => 'Pago registrado correctamente.',
                'mostrarModalDocumento' => true,
                'tipoDocumento' => 'recibo',
                'codigoRecibo' => $codigoRecibo,
                'montoRecibo' => $pagos->sum('monto'),
                'idPago' => $pagos->first()->idPago,
            ]);
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

    public function pdf(Pago $pago)
    {
        $pagos = Pago::with([
            'factura.consulta.paciente.persona',
            'factura.consulta.odontologo.persona',
            'metodoPago',
            'usuario.persona',
        ])
            ->where('codigoRecibo', $pago->codigoRecibo)
            ->orderBy('numeroCuota')
            ->get();

        $factura = $pagos->first()->factura;

        $pdf = Pdf::loadView('pagos.pdf', compact(
            'pagos',
            'factura'
        ));

        $pdf->setPaper([0, 0, 612, 396]);

        return $pdf->stream(
            'REC-' . str_pad($pagos->first()->idPago, 6, '0', STR_PAD_LEFT) . '.pdf'
        );
    }

    public function enviarCorreo(Request $request, Pago $pago)
    {
        $request->validate([
            'correo' => ['required', 'email'],
        ]);

        Mail::to($request->correo)->send(
            new ReciboMail($pago)
        );

        return redirect()
            ->route('facturacion.show', $pago->factura)
            ->with('success', 'Recibo enviado correctamente.');
    }
}
