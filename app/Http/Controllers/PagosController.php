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
use Illuminate\Pagination\LengthAwarePaginator;

class PagosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $vista = in_array($request->input('vista'), ['pendientes', 'vencidos', 'recibos', 'anulados'])
            ? $request->input('vista')
            : 'pendientes';

        $buscar = trim($request->input('buscar'));
        $fechaDesde = $request->fecha_desde;
        $fechaHasta = $request->fecha_hasta;

        $porPagina = (int) $request->input('porPagina', 10);

        if (!in_array($porPagina, [10, 25, 50, 100])) {
            $porPagina = 10;
        }

        $pagos = match ($vista) {
            'vencidos' => $this->paginarVencidos($buscar, $fechaDesde, $fechaHasta, $porPagina),
            'recibos' => $this->paginarRecibos($buscar, $fechaDesde, $fechaHasta, $porPagina, 'Pagado'),
            'anulados' => $this->paginarRecibos($buscar, $fechaDesde, $fechaHasta, $porPagina, 'Anulado'),
            default => $this->paginarPendientes($buscar, $fechaDesde, $fechaHasta, $porPagina),
        };

        $estadisticas = $this->obtenerEstadisticas();

        if ($request->ajax()) {
            return view("pagos.partials.tabla-{$vista}", compact('pagos', 'porPagina', 'vista'))->render();
        }

        return view('pagos.index', array_merge(compact('pagos', 'buscar', 'porPagina', 'vista'), $estadisticas));
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

    private function paginarPendientes(?string $buscar, ?string $fechaDesde, ?string $fechaHasta, int $porPagina)
    {
        return Pago::with(['factura.consulta.paciente.persona'])
            ->whereNull('codigoRecibo')
            ->where('estado', 'Pendiente')
            ->when($buscar, fn($q) => $this->aplicarBusqueda($q, $buscar))
            ->when($fechaDesde, fn($q) => $q->whereDate('fechaVencimiento', '>=', $fechaDesde))
            ->when($fechaHasta, fn($q) => $q->whereDate('fechaVencimiento', '<=', $fechaHasta))
            ->orderBy('fechaVencimiento')
            ->paginate($porPagina)
            ->appends(request()->except('page'));
    }

    private function paginarVencidos(?string $buscar, ?string $fechaDesde, ?string $fechaHasta, int $porPagina)
    {
        return Pago::with(['factura.consulta.paciente.persona'])
            ->whereNull('codigoRecibo')
            ->where('estado', 'Pendiente')
            ->whereDate('fechaVencimiento', '<', today())
            ->when($buscar, fn($q) => $this->aplicarBusqueda($q, $buscar))
            ->when($fechaDesde, fn($q) => $q->whereDate('fechaVencimiento', '>=', $fechaDesde))
            ->when($fechaHasta, fn($q) => $q->whereDate('fechaVencimiento', '<=', $fechaHasta))
            ->orderBy('fechaVencimiento')
            ->paginate($porPagina)
            ->appends(request()->except('page'));
    }

    private function paginarRecibos(?string $buscar, ?string $fechaDesde, ?string $fechaHasta, int $porPagina, string $estado)
    {
        $grupos = Pago::selectRaw("
            codigoRecibo,
            MIN(idPago) as idPago,
            SUM(monto) as montoTotal,
            COUNT(*) as cantidadCuotas,
            MAX(fechaRealizacion) as fechaRealizacion
        ")
            ->whereNotNull('codigoRecibo')
            ->where('estado', $estado)
            ->when($buscar, fn($q) => $this->aplicarBusqueda($q, $buscar))
            ->when($fechaDesde, fn($q) => $q->whereDate('fechaRealizacion', '>=', $fechaDesde))
            ->when($fechaHasta, fn($q) => $q->whereDate('fechaRealizacion', '<=', $fechaHasta))
            ->groupBy('codigoRecibo')
            ->orderByDesc('fechaRealizacion')
            ->paginate($porPagina)
            ->appends(request()->except('page'));

        $primerPagos = Pago::with(['factura.consulta.paciente.persona'])
            ->whereIn('idPago', collect($grupos->items())->pluck('idPago'))
            ->get()
            ->keyBy('idPago');

        $grupos->getCollection()->transform(function ($grupo) use ($primerPagos) {
            $grupo->pago = $primerPagos->get($grupo->idPago);
            return $grupo;
        });

        return $grupos;
    }

    private function aplicarBusqueda($query, string $buscar)
    {
        $soloDigitos = preg_replace('/\D/', '', $buscar);
        $codigoBuscado = str_ireplace('rcb-', '', $buscar);

        return $query->where(function ($q) use ($buscar, $soloDigitos, $codigoBuscado) {
            $q->whereHas('factura.consulta.paciente.persona', function ($q2) use ($buscar) {
                $q2->whereRaw("CONCAT(nombre, ' ', apellido) like ?", ["%{$buscar}%"]);
            });

            if ($soloDigitos !== '') {
                $q->orWhereRaw("LPAD(idFactura, 6, '0') like ?", ["%{$soloDigitos}%"]);
            }

            if ($codigoBuscado !== $buscar) {
                $q->orWhere('codigoRecibo', 'like', "{$codigoBuscado}%");
            }
        });
    }

    private function obtenerEstadisticas(): array
    {
        return [

            'pendientePorCobrar' => Pago::whereNull('codigoRecibo')
                ->where('estado', 'Pendiente')
                ->sum('monto'),

            'vencidoPorCobrar' => Pago::whereNull('codigoRecibo')
                ->where('estado', 'Pendiente')
                ->whereDate('fechaVencimiento', '<', today())
                ->sum('monto'),

            'cobradoHoy' => Pago::where('estado', 'Pagado')
                ->whereDate('fechaRealizacion', today())
                ->sum('monto'),

            'cobradoEsteMes' => Pago::where('estado', 'Pagado')
                ->whereYear('fechaRealizacion', today()->year)
                ->whereMonth('fechaRealizacion', today()->month)
                ->sum('monto'),

        ];
    }
}
