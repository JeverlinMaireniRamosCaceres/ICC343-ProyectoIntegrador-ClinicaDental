<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Consulta;
use App\Models\Paciente;
use App\Models\Producto;
use App\Models\DetalleCompra;
use App\Models\Pago;
use App\Models\MovimientoCajaChica;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $fechaInicioInput = $request->input('fecha_inicio');
        $fechaFinInput = $request->input('fecha_fin');

        if ($fechaInicioInput && $fechaFinInput) {
            $inicio = Carbon::parse($fechaInicioInput)->startOfDay();
            $fin = Carbon::parse($fechaFinInput)->endOfDay();
        } else {
            $inicio = Carbon::now()->startOfYear();
            $fin = Carbon::now()->addMonth()->endOfMonth();
        }

        $metricas = $this->obtenerMetricasDashboard($inicio, $fin);

        $hoy = Carbon::now();
        $refString = $hoy->toDateString();
        $en15Dias = $hoy->copy()->addDays(15)->toDateString();
        $en30Dias = $hoy->copy()->addDays(30)->toDateString();

        $vencidos = DetalleCompra::where('fechaVencimiento', '<', $refString)->count();
        $vencen15 = DetalleCompra::where('fechaVencimiento', '>=', $refString)->where('fechaVencimiento', '<=', $en15Dias)->count();
        $vencen30 = DetalleCompra::where('fechaVencimiento', '>', $en15Dias)->where('fechaVencimiento', '<=', $en30Dias)->count();

        $dataVencimientos = [$vencidos, $vencen15, $vencen30];

        $productosVencimiento = DetalleCompra::with('producto')
            ->whereNotNull('fechaVencimiento')
            ->orderBy('fechaVencimiento', 'asc')
            ->limit(10)
            ->get()
            ->map(function ($detalle) use ($hoy) {
                $fechaVenc = Carbon::parse($detalle->fechaVencimiento)->startOfDay();
                $hoyActual = $hoy->copy()->startOfDay();
                $detalle->diasRestantes = $hoyActual->diffInDays($fechaVenc, false);
                return $detalle;
            });

        return view('dashboard', array_merge($metricas, [
            'dataVencimientos' => $dataVencimientos,
            'productosVencimiento' => $productosVencimiento,
        ]));
    }

    public function obtenerDatosFiltrados(Request $request)
    {
        $tipo = $request->input('tipo', 'periodo');
        $valor = $request->input('valor', 'este-mes');

        $fechaInicio = null;
        $fechaFin = Carbon::now()->addMonth()->endOfMonth();

        if ($tipo === 'periodo') {
            switch ($valor) {
                case 'este-mes':
                    $fechaInicio = Carbon::now()->startOfMonth();
                    break;
                case 'ultimo-trimestre':
                    $fechaInicio = Carbon::now()->subMonths(3)->startOfMonth();
                    break;
                case 'este-ano':
                    $fechaInicio = Carbon::now()->startOfYear();
                    break;
                case 'historico':
                    $fechaInicio = Carbon::now()->subYears(5)->startOfYear();
                    break;
                default:
                    $fechaInicio = Carbon::now()->startOfYear();
                    break;
            }
        } elseif ($tipo === 'mes_especifico') {
            $fechaInicio = Carbon::parse($valor)->startOfMonth();
            $fechaFin = Carbon::parse($valor)->addMonth()->endOfMonth();
        }

        $metricas = $this->obtenerMetricasDashboard($fechaInicio, $fechaFin);

        return response()->json($metricas);
    }

    private function obtenerMetricasDashboard(Carbon $inicio, Carbon $fin): array
    {
        $rango = $this->generarRangoDeMeses($inicio, $fin);
        $mesesIncluidos = $rango['meses'];
        $labels = $rango['labels'];

        // --- PAGOS PENDIENTES ---
        $pagosPendientes = Pago::selectRaw('MONTH(fechaVencimiento) as mes, YEAR(fechaVencimiento) as anio, COUNT(*) as cantidad')
            ->where('estado', 'Pendiente')
            ->whereBetween('fechaVencimiento', [$inicio, $fin])
            ->groupBy('anio', 'mes')
            ->get();

        $dataPendientes = $this->extraerDatosPorMes($pagosPendientes, $mesesIncluidos, 'cantidad');

        // --- PACIENTES REGISTRADOS ---
        $pacientesRegistrados = Paciente::selectRaw('MONTH(created_at) as mes, YEAR(created_at) as anio, COUNT(*) as cantidad')
            ->whereBetween('created_at', [$inicio, $fin])
            ->groupBy('anio', 'mes')
            ->get();

        $dataPacientes = $this->extraerDatosPorMes($pacientesRegistrados, $mesesIncluidos, 'cantidad');

        // --- INGRESOS REALIZADOS (SÓLO PAGADAS) ---
        $ingresos = Pago::selectRaw('MONTH(fechaRealizacion) as mes, YEAR(fechaRealizacion) as anio, SUM(monto) as total_ingresos')
            ->where('estado', 'Pagado')
            ->whereNotNull('fechaRealizacion')
            ->whereBetween('fechaRealizacion', [$inicio, $fin])
            ->groupBy('anio', 'mes')
            ->get();

        $dataIngresos = $this->extraerDatosPorMes($ingresos, $mesesIncluidos, 'total_ingresos', true);

        // --- CONSUMO DE CAJA CHICA ---
        $consumos = MovimientoCajaChica::selectRaw('MONTH(created_at) as mes, YEAR(created_at) as anio, SUM(monto) as total_consumo')
            ->where('tipo', 'Egreso')
            ->where('descripcion', 'not like', 'Anulación de recibo%')
            ->whereBetween('created_at', [$inicio, $fin])
            ->groupBy('anio', 'mes')
            ->get();

        $dataConsumoCaja = $this->extraerDatosPorMes($consumos, $mesesIncluidos, 'total_consumo', true);

        return [
            'labels' => $labels,
            'dataPendientes' => $dataPendientes,
            'dataPacientes' => $dataPacientes,
            'dataIngresos' => $dataIngresos,
            'dataConsumoCaja' => $dataConsumoCaja,
        ];
    }

    private function generarRangoDeMeses(Carbon $inicio, Carbon $fin): array
    {
        $mesesAnio = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];

        $mesesIncluidos = [];
        $labels = [];

        $tempInicio = $inicio->copy()->startOfMonth();
        while ($tempInicio->lte($fin)) {
            $mesNum = $tempInicio->month;
            $anioNum = $tempInicio->year;
            $key = $anioNum . '-' . $mesNum;

            if (!isset($mesesIncluidos[$key])) {
                $label = $mesesAnio[$mesNum - 1] . ' ' . substr($anioNum, -2);

                $mesesIncluidos[$key] = [
                    'num' => $mesNum,
                    'anio' => $anioNum,
                    'label' => $label,
                ];

                $labels[] = $label;
            }

            $tempInicio->addMonth();
        }

        return [
            'meses' => $mesesIncluidos,
            'labels' => $labels,
        ];
    }

    private function extraerDatosPorMes($coleccion, array $mesesIncluidos, string $campo, bool $comoFloat = false): array
    {
        $datos = [];

        foreach ($mesesIncluidos as $mesInfo) {
            $registro = $coleccion->first(function ($item) use ($mesInfo) {
                return (int) $item->mes === (int) $mesInfo['num'] && (int) $item->anio === (int) $mesInfo['anio'];
            });

            if (!$registro) {
                $datos[] = $comoFloat ? 0.0 : 0;
                continue;
            }

            $valor = $registro->{$campo};
            $datos[] = $comoFloat ? (float) $valor : (int) $valor;
        }

        return $datos;
    }
}