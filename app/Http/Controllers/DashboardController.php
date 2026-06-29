<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Consulta;
use App\Models\Paciente;
use App\Models\Producto;
use App\Models\DetalleCompra;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $añoActual = Carbon::now()->year;
        $mesesAnio = ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];

        // PAGOS PENDIENTES
        $pagosPendientes = Consulta::selectRaw('MONTH(fecha) as mes, COUNT(*) as cantidad')
            ->where('estado', 'pendiente')
            ->whereYear('fecha', $añoActual)
            ->groupBy('mes')
            ->orderBy('mes')
            ->get();

        $dataPendientes = [];
        for ($i = 1; $i <= 12; $i++) {
            $registro = $pagosPendientes->firstWhere('mes', $i);
            $dataPendientes[] = $registro ? $registro->cantidad : 0;
        }

        // PACIENTES REGISTRADOS
        $pacientesRegistrados = Paciente::selectRaw('MONTH(created_at) as mes, COUNT(*) as cantidad')
            ->whereYear('created_at', $añoActual)
            ->groupBy('mes')
            ->orderBy('mes')
            ->get();

        $dataPacientes = [];
        for ($i = 1; $i <= 12; $i++) {
            $registro = $pacientesRegistrados->firstWhere('mes', $i);
            $dataPacientes[] = $registro ? $registro->cantidad : 0;
        }

        // PRODUCTOS CON BAJO STOCK
        $productosBajoStock = Producto::whereRaw('stockActual <= stockMinimo')
            ->orderBy('stockActual', 'asc')
            ->limit(10)
            ->get();

        $labelsProductos = $productosBajoStock->pluck('nombre')->toArray();
        $dataStockActual = $productosBajoStock->pluck('stockActual')->toArray();
        $dataStockMinimo = $productosBajoStock->pluck('stockMinimo')->toArray();

        // PRODUCTOS PRÓXIMOS A VENCER (RANGOS: 15 Y 30 DÍAS)
        $hoy = Carbon::now()->toDateString(); 
        $en15Dias = Carbon::now()->addDays(15)->toDateString();
        $en30Dias = Carbon::now()->addDays(30)->toDateString();

        $vencidos = DetalleCompra::where('fechaVencimiento', '<', $hoy)->count();
        
        $vencen15Dias = DetalleCompra::where('fechaVencimiento', '>=', $hoy)
            ->where('fechaVencimiento', '<=', $en15Dias)
            ->count();
            
        $vencen30Dias = DetalleCompra::where('fechaVencimiento', '>', $en15Dias)
            ->where('fechaVencimiento', '<=', $en30Dias)
            ->count();

        $dataVencimientos = [$vencidos, $vencen15Dias, $vencen30Dias];

        $productosVencimiento = DetalleCompra::with('producto')
            ->whereNotNull('fechaVencimiento')
            ->orderBy('fechaVencimiento', 'asc')
            ->limit(10)
            ->get()
            ->map(function ($detalle) {
                $fechaVenc = Carbon::parse($detalle->fechaVencimiento)->startOfDay();
                $hoyActual = Carbon::now()->startOfDay();
                $detalle->diasRestantes = $hoyActual->diffInDays($fechaVenc, false);
                return $detalle;
            });

        return view('dashboard', [
            'labels' => $mesesAnio,
            'dataPendientes' => $dataPendientes,
            'dataPacientes' => $dataPacientes,
            'labelsProductos' => $labelsProductos,
            'dataStockActual' => $dataStockActual,
            'dataStockMinimo' => $dataStockMinimo,
            'dataVencimientos' => $dataVencimientos,
            'productosVencimiento' => $productosVencimiento
        ]);
    }
}