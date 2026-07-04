<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Factura;
use App\Models\Consulta;
use App\Models\Pago;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FacturacionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $buscar = trim($request->buscar);
        $estado = $request->estado;
        $fechaDesde = $request->fecha_desde;
        $fechaHasta = $request->fecha_hasta;
        $porPagina = $request->get('porPagina', 10);

        $facturas = Factura::with([
            'consulta.paciente.persona'
        ])

            ->when($buscar, function ($query) use ($buscar) {

                $numeroFactura = preg_replace('/\D/', '', $buscar);

                $query->where(function ($q) use ($buscar, $numeroFactura) {

                    if ($numeroFactura !== '') {
                        $q->orWhere('idFactura', (int) $numeroFactura);
                    }

                    $q->orWhereHas('consulta.paciente.persona', function ($persona) use ($buscar) {
                        $persona->where('nombre', 'like', "%{$buscar}%")
                            ->orWhere('apellido', 'like', "%{$buscar}%");
                    });
                });
            })

            ->when($estado, function ($query) use ($estado) {
                $query->where('estado', ucfirst($estado));
            })

            ->when($fechaDesde, function ($query) use ($fechaDesde) {
                $query->whereDate('created_at', '>=', $fechaDesde);
            })

            ->when($fechaHasta, function ($query) use ($fechaHasta) {
                $query->whereDate('created_at', '<=', $fechaHasta);
            })

            ->latest()
            ->paginate($porPagina)
            ->withQueryString();

        if ($request->ajax()) {
            return view('facturacion.partials.tabla', compact('facturas', 'porPagina'))->render();
        }

        return view('facturacion.index', compact('facturas', 'porPagina'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $fecha = $request->input('fecha', now()->toDateString());

        $consultas = Consulta::with([
            'paciente.persona',
            'odontologo.persona',
        ])
            ->doesntHave('factura')
            ->whereDate('fecha', $fecha)
            ->orderBy('fecha')
            ->get();

        $consulta = null;

        if ($request->filled('consulta')) {

            $consulta = Consulta::with([
                'paciente.persona',
                'odontologo.persona',
                'detalles.procedimiento',
            ])->findOrFail($request->consulta);
        }

        $return = $request->input('return', url()->previous());

        return view('facturacion.create', compact(
            'consulta',
            'consultas',
            'return',
            'fecha'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'idConsulta' => 'required|exists:consultas,idConsulta',
            'cantidadCuotas' => 'required|integer|min:1',
            'tipoDescuento' => 'nullable|in:Monto,Porcentaje',
            'valorDescuento' => 'nullable|numeric|min:0',
            'fechasVencimiento' => 'required|array|min:1',
            'fechasVencimiento.*' => 'required|date',
        ]);

        $consulta = $this->obtenerConsulta($request->idConsulta);

        $totales = $this->calcularTotales(
            $consulta,
            $request->tipoDescuento,
            $request->valorDescuento
        );

        DB::transaction(function () use ($request, $consulta, $totales, &$factura) {

            $factura = $this->crearFactura($consulta, $request, $totales);

            $this->crearPagos(
                $factura,
                $request->fechasVencimiento,
                $totales['total']
            );
        });

        return redirect()
            ->route('facturacion.show', $factura)
            ->with('success', 'Factura creada correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return view('facturacion.show');
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

    public function consultas(Request $request)
    {
        $fecha = $request->input('fecha', now()->toDateString());
        $buscar = trim($request->input('buscar', ''));

        $consultas = Consulta::with([
            'paciente.persona',
            'odontologo.persona',
        ])
            ->doesntHave('factura');

        if ($buscar !== '') {

            $consultas->whereHas('paciente.persona', function ($query) use ($buscar) {

                $query->where(function ($q) use ($buscar) {

                    $q->where('nombre', 'like', "%{$buscar}%")
                        ->orWhere('apellido', 'like', "%{$buscar}%")
                        ->orWhereRaw("CONCAT(nombre, ' ', apellido) LIKE ?", ["%{$buscar}%"]);
                });
            });
        } else {

            $consultas->whereDate('fecha', $fecha);
        }

        $consultas = $consultas
            ->orderByDesc('fecha')
            ->get();

        return view('facturacion.partials.tabla-consultas', compact(
            'consultas',
            'fecha'
        ));
    }

    private function obtenerConsulta(int $idConsulta): Consulta
    {
        return Consulta::with('detalles')
            ->findOrFail($idConsulta);
    }

    private function calcularTotales(Consulta $consulta, ?string $tipoDescuento, ?float $valorDescuento): array
    {
        $valorDescuento ??= 0;

        $subtotal = $consulta->detalles->sum('subtotal');

        $montoDescuento = 0;
        $porcentajeDescuento = 0;

        if ($tipoDescuento === 'Monto') {

            $montoDescuento = min($valorDescuento, $subtotal);
        } elseif ($tipoDescuento === 'Porcentaje') {

            $porcentajeDescuento = min($valorDescuento, 100);
            $montoDescuento = $subtotal * ($porcentajeDescuento / 100);
        }

        return [
            'subtotal' => $subtotal,
            'total' => $subtotal - $montoDescuento,
            'tipoDescuento' => $tipoDescuento,
            'montoDescuento' => $montoDescuento,
            'porcentajeDescuento' => $porcentajeDescuento,
        ];
    }

    private function crearFactura(Consulta $consulta, Request $request, array $totales): Factura
    {
        return Factura::create([
            'idConsulta' => $consulta->idConsulta,
            'total' => $totales['total'],
            'cantidadCuotas' => $request->cantidadCuotas,
            'tipoDescuento' => $totales['tipoDescuento'],
            'montoDescuento' => $totales['montoDescuento'],
            'porcentajeDescuento' => $totales['porcentajeDescuento'],
            'estado' => 'Pendiente',
        ]);
    }

    private function crearPagos(Factura $factura, array $fechasVencimiento, float $total): void
    {
        $cantidadCuotas = count($fechasVencimiento);

        $montoCuota = round($total / $cantidadCuotas, 2);
        $restante = $total;

        foreach ($fechasVencimiento as $i => $fechaVencimiento) {

            $monto = ($i === $cantidadCuotas - 1)
                ? $restante
                : $montoCuota;

            Pago::create([
                'idFactura' => $factura->idFactura,
                'idMetodoPago' => null,
                'idUsuario' => Auth::id(),
                'fechaVencimiento' => $fechaVencimiento,
                'monto' => $monto,
                'numeroCuota' => $i + 1,
                'estado' => 'Pendiente',
            ]);

            $restante -= $monto;
        }
    }
}
