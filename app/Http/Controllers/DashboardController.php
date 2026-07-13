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

        $mesesAnio = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];
        $labelsDinamicos = [];
        $mesesIncluidos = [];

        $tempInicio = $inicio->copy()->startOfMonth();
        while ($tempInicio->lte($fin)) {
            $mesNum = $tempInicio->month;
            $anioNum = $tempInicio->year;
            $key = $anioNum . '-' . $mesNum;

            if (!isset($mesesIncluidos[$key])) {
                $mesesIncluidos[$key] = [
                    'num' => $mesNum,
                    'anio' => $anioNum,
                    'label' => $mesesAnio[$mesNum - 1] . ($fechaInicioInput ? ' ' . substr($anioNum, -2) : '')
                ];
            }
            $tempInicio->addMonth();
        }

        $pagosQuery = Consulta::selectRaw('MONTH(fecha) as mes, YEAR(fecha) as anio, COUNT(*) as cantidad')
            ->where('estado', 'pendiente');
        
        if ($fechaInicioInput && $fechaFinInput) {
            $pagosQuery->whereBetween('fecha', [$inicio->toDateString(), $fin->toDateString()]);
        } else {
            $pagosQuery->whereBetween('fecha', [Carbon::now()->startOfYear()->toDateString(), $fin->toDateString()]);
        }

        $pagosPendientes = $pagosQuery->groupBy('anio', 'mes')->get();

        $dataPendientes = [];
        foreach ($mesesIncluidos as $mesInfo) {
            $registro = $pagosPendientes->first(function ($item) use ($mesInfo) {
                return $item->mes == $mesInfo['num'] && $item->anio == $mesInfo['anio'];
            });
            $dataPendientes[] = $registro ? $registro->cantidad : 0;
            $labelsDinamicos[] = $mesInfo['label'];
        }

        $pacientesQuery = Paciente::selectRaw('MONTH(created_at) as mes, YEAR(created_at) as anio, COUNT(*) as cantidad');

        if ($fechaInicioInput && $fechaFinInput) {
            $pacientesQuery->whereBetween('created_at', [$inicio, $fin]);
        } else {
            $pacientesQuery->whereBetween('created_at', [Carbon::now()->startOfYear(), $fin]);
        }

        $pacientesRegistrados = $pacientesQuery->groupBy('anio', 'mes')->get();

        $dataPacientes = [];
        foreach ($mesesIncluidos as $mesInfo) {
            $registro = $pacientesRegistrados->first(function ($item) use ($mesInfo) {
                return $item->mes == $mesInfo['num'] && $item->anio == $mesInfo['anio'];
            });
            $dataPacientes[] = $registro ? $registro->cantidad : 0;
        }

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

        $ingresosQuery = Pago::selectRaw('MONTH(fechaRealizacion) as mes, YEAR(fechaRealizacion) as anio, SUM(monto) as total_ingresos')
            ->where('estado', 'Pagado');
            
        if ($fechaInicioInput && $fechaFinInput) {
            $ingresosQuery->whereBetween('fechaRealizacion', [$inicio->toDateString(), $fin->toDateString()]);
        } else {
            $ingresosQuery->whereBetween('fechaRealizacion', [Carbon::now()->startOfYear()->toDateString(), $fin->toDateString()]);
        }

        $ingresos = $ingresosQuery->groupBy('anio', 'mes')->get();

        $dataIngresos = [];
        foreach ($mesesIncluidos as $mesInfo) {
            $registro = $ingresos->first(function ($item) use ($mesInfo) {
                return $item->mes == $mesInfo['num'] && $item->anio == $mesInfo['anio'];
            });
            $dataIngresos[] = $registro ? $registro->total_ingresos : 0;
        }

        $consumoQuery = MovimientoCajaChica::selectRaw('MONTH(created_at) as mes, YEAR(created_at) as anio, SUM(monto) as total_consumo')
            ->where('tipo', 'Egreso');
            
        if ($fechaInicioInput && $fechaFinInput) {
            $consumoQuery->whereBetween('created_at', [$inicio, $fin]);
        } else {
            $consumoQuery->whereBetween('created_at', [Carbon::now()->startOfYear(), $fin]);
        }

        $consumos = $consumoQuery->groupBy('anio', 'mes')->get();

        $dataConsumoCaja = [];
        foreach ($mesesIncluidos as $mesInfo) {
            $registro = $consumos->first(function ($item) use ($mesInfo) {
                return $item->mes == $mesInfo['num'] && $item->anio == $mesInfo['anio'];
            });
            $dataConsumoCaja[] = $registro ? $registro->total_consumo : 0;
        }

        return view('dashboard', [
            'labels' => $labelsDinamicos,
            'dataPendientes' => $dataPendientes,
            'dataPacientes' => $dataPacientes,
            'dataVencimientos' => $dataVencimientos,
            'productosVencimiento' => $productosVencimiento,
            'dataIngresos' => $dataIngresos,
            'dataConsumoCaja' => $dataConsumoCaja
        ]);
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
            }
        } elseif ($tipo === 'mes_especifico') {
            $fechaInicio = Carbon::parse($valor)->startOfMonth();
            $fechaFin = Carbon::parse($valor)->addMonth()->endOfMonth();
        }

        $mesesAnio = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];
        $labelsDinamicos = [];
        $mesesIncluidos = [];

        $tempInicio = $fechaInicio->copy()->startOfMonth();
        while ($tempInicio->lte($fechaFin)) {
            $mesNum = $tempInicio->month;
            $anioNum = $tempInicio->year;
            $key = $anioNum . '-' . $mesNum;

            if (!isset($mesesIncluidos[$key])) {
                $mesesIncluidos[$key] = [
                    'num' => $mesNum,
                    'anio' => $anioNum,
                    'label' => [$mesesAnio[$mesNum - 1], $anioNum]
                ];
                $labelsDinamicos[] = $mesesIncluidos[$key]['label'];
            }
            $tempInicio->addMonth();
        }

        $pagosPendientes = Consulta::selectRaw('MONTH(fecha) as mes, YEAR(fecha) as anio, COUNT(*) as cantidad')
            ->where('estado', 'pendiente')
            ->whereBetween('fecha', [$fechaInicio->toDateString(), $fechaFin->toDateString()])
            ->groupBy('anio', 'mes')->get();

        $dataPendientes = [];
        foreach ($mesesIncluidos as $mesInfo) {
            $registro = $pagosPendientes->first(function ($item) use ($mesInfo) {
                return $item->mes == $mesInfo['num'] && $item->anio == $mesInfo['anio'];
            });
            $dataPendientes[] = $registro ? $registro->cantidad : 0;
        }

        $pacientesRegistrados = Paciente::selectRaw('MONTH(created_at) as mes, YEAR(created_at) as anio, COUNT(*) as cantidad')
            ->whereBetween('created_at', [$fechaInicio, $fechaFin])
            ->groupBy('anio', 'mes')->get();

        $dataPacientes = [];
        foreach ($mesesIncluidos as $mesInfo) {
            $registro = $pacientesRegistrados->first(function ($item) use ($mesInfo) {
                return $item->mes == $mesInfo['num'] && $item->anio == $mesInfo['anio'];
            });
            $dataPacientes[] = $registro ? $registro->cantidad : 0;
        }

        $ingresos = Pago::selectRaw('MONTH(fechaRealizacion) as mes, YEAR(fechaRealizacion) as anio, SUM(monto) as total_ingresos')
            ->where('estado', 'Pagado')
            ->whereBetween('fechaRealizacion', [$fechaInicio->toDateString(), $fechaFin->toDateString()])
            ->groupBy('anio', 'mes')->get();

        $dataIngresos = [];
        foreach ($mesesIncluidos as $mesInfo) {
            $registro = $ingresos->first(function ($item) use ($mesInfo) {
                return $item->mes == $mesInfo['num'] && $item->anio == $mesInfo['anio'];
            });
            $dataIngresos[] = $registro ? $registro->total_ingresos : 0;
        }

        $consumos = MovimientoCajaChica::selectRaw('MONTH(created_at) as mes, YEAR(created_at) as anio, SUM(monto) as total_consumo')
            ->where('tipo', 'Egreso')
            ->whereBetween('created_at', [$fechaInicio, $fechaFin])
            ->groupBy('anio', 'mes')->get();

        $dataConsumoCaja = [];
        foreach ($mesesIncluidos as $mesInfo) {
            $registro = $consumos->first(function ($item) use ($mesInfo) {
                return $item->mes == $mesInfo['num'] && $item->anio == $mesInfo['anio'];
            });
            $dataConsumoCaja[] = $registro ? $registro->total_consumo : 0;
        }

        return response()->json([
            'labels'           => $labelsDinamicos,
            'dataPendientes'   => $dataPendientes,
            'dataPacientes'    => $dataPacientes,
            'dataIngresos'     => $dataIngresos,
            'dataConsumoCaja'  => $dataConsumoCaja,
        ]);
    }
}