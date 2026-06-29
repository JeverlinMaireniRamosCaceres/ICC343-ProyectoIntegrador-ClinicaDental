@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="row g-4">
    
    <div class="col-md-6">
        <div class="card p-4 shadow-sm" style="height: 380px;">
            <h5 class="card-title fw-bold text-secondary mb-3">Cantidad de pagos pendientes por mes</h5>
            <canvas id="graficoPagosPendientes"></canvas>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card p-4 shadow-sm" style="height: 380px;">
            <h5 class="card-title fw-bold text-secondary mb-3">pacientes registrados</h5>
            <canvas id="graficoPacientes"></canvas>
        </div>
    </div>

    <div class="col-12">
        <div class="card p-4 shadow-sm">
            <div class="d-flex align-items-center mb-4">
                <i class="bi bi-exclamation-triangle-fill text-danger fs-4 me-2"></i>
                <h5 class="card-title fw-bold text-secondary m-0">Alertas de inventario</h5>
            </div>
            
            <div class="row g-4">
                <div class="col-md-6">
                    <div style="height: 320px;">
                        <canvas id="graficoBajoStock"></canvas>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="table-responsive" style="max-height: 320px; overflow-y: auto;">
                        <table class="table table-hover align-middle m-0">
                            <thead class="table-light sticky-top">
                                <tr>
                                    <th>Producto</th>
                                    <th class="text-center">Mínimo</th>
                                    <th class="text-center">Actual</th>
                                    <th class="text-center">Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $hayProductos = false; @endphp
                                @foreach($labelsProductos as $index => $nombreProducto)
                                    @php 
                                        $hayProductos = true;
                                        $actual = $dataStockActual[$index];
                                        $minimo = $dataStockMinimo[$index];
                                        $porcentaje = $minimo > 0 ? ($actual / $minimo) * 100 : 0;
                                    @endphp
                                    <tr>
                                        <td class="fw-semibold text-dark">{{ $nombreProducto }}</td>
                                        <td class="text-center text-muted">{{ $minimo }}</td>
                                        <td class="text-center fw-bold text-danger">{{ $actual }}</td>
                                        <td class="text-center">
                                            @if($actual == 0)
                                                <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-20 px-2 py-1">Agotado</span>
                                            @elseif($porcentaje <= 50)
                                                <span class="badge bg-danger bg-opacity-10 text-danger px-2 py-1">Crítico</span>
                                            @else
                                                <span class="badge bg-warning bg-opacity-10 text-warning px-2 py-1">Bajo stock</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach

                                @if(!$hayProductos)
                                    <tr>
                                        <td colspan="4" class="text-center text-muted py-4">
                                            <i class="bi bi-check-circle-fill text-success fs-3 d-block mb-2"></i>
                                            Todo el inventario se encuentra en niveles óptimos.
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="card p-4 shadow-sm">
            <div class="d-flex align-items-center mb-4">
                <i class="bi bi-calendar-x-fill text-danger fs-4 me-2"></i>
                <h5 class="card-title fw-bold text-secondary m-0">Vencimientos a corto plazo</h5>
            </div>
            
            <div class="row g-4 align-items-center">
                <div class="col-md-5">
                    <div style="position: relative; height: 280px;">
                        <canvas id="graficoVencimientos"></canvas>
                    </div>
                </div>

                <div class="col-md-7">
                    <div class="table-responsive" style="max-height: 280px; overflow-y: auto;">
                        <table class="table table-hover align-middle m-0">
                            <thead class="table-light sticky-top">
                                <tr>
                                    <th>Producto</th>
                                    <th class="text-center">Vencimiento</th>
                                    <th class="text-center">Estado / Alerta</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($productosVencimiento as $lote)
                                    <tr>
                                        <td class="fw-semibold text-dark">
                                            {{ $lote->producto ? $lote->producto->nombre : 'Producto no registrado' }}
                                        </td>
                                        <td class="text-center text-muted fw-mono small">
                                            {{ \Carbon\Carbon::parse($lote->fechaVencimiento)->format('d/m/Y') }}
                                        </td>
                                        <td class="text-center">
                                            @if($lote->diasRestantes < 0)
                                                <span class="badge bg-dark px-2 py-1">Ya vencido</span>
                                            @elseif($lote->diasRestantes == 0)
                                                <span class="badge bg-danger px-2 py-1">¡Vence hoy!</span>
                                            @elseif($lote->diasRestantes == 1)
                                                <span class="badge bg-danger px-2 py-1">Vence mañana</span>
                                            @elseif($lote->diasRestantes <= 15)
                                                <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-30 px-2 py-1">Próximos 15 d</span>
                                            @elseif($lote->diasRestantes <= 30)
                                                <span class="badge bg-warning text-dark px-2 py-1">Próximos 30 d</span>
                                            @else
                                                <span class="badge bg-success bg-opacity-10 text-success px-2 py-1">Seguro (+30 d)</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="3" class="text-center text-muted py-5">
                                            <i class="bi bi-shield-check text-success fs-2 d-block mb-2"></i>
                                            No hay lotes con fechas de vencimiento registradas.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const labelsMeses = {!! json_encode($labels) !!};

        // PAGOS PENDIENTES
        const ctxPendientes = document.getElementById('graficoPagosPendientes');
        if (ctxPendientes) {
            new Chart(ctxPendientes, {
                type: 'bar',
                data: {
                    labels: labelsMeses,
                    datasets: [{
                        label: 'Consultas Pendientes',
                        data: {!! json_encode($dataPendientes) !!},
                        backgroundColor: 'rgba(220, 53, 69, 0.7)',
                        borderColor: '#dc3545',
                        borderWidth: 1.5,
                        borderRadius: 4
                    }]
                },
                options: { responsive: true, maintainAspectRatio: false }
            });
        }

        // PACIENTES REGISTRADOS
        const ctxPacientes = document.getElementById('graficoPacientes');
        if (ctxPacientes) {
            new Chart(ctxPacientes, {
                type: 'line',
                data: {
                    labels: labelsMeses,
                    datasets: [{
                        label: 'Pacientes Nuevos',
                        data: {!! json_encode($dataPacientes) !!},
                        borderColor: '#198754',
                        backgroundColor: 'rgba(25, 135, 84, 0.05)',
                        borderWidth: 2.5,
                        tension: 0.35,
                        fill: true
                    }]
                },
                options: { responsive: true, maintainAspectRatio: false }
            });
        }

        // PRODUCTOS CON BAJO STOCK
        const ctxStock = document.getElementById('graficoBajoStock');
        if (ctxStock) {
            new Chart(ctxStock, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($labelsProductos) !!},
                    datasets: [
                        {
                            label: 'Stock actual disponible',
                            data: {!! json_encode($dataStockActual) !!},
                            backgroundColor: 'rgba(255, 193, 7, 0.8)',
                            borderColor: '#ffc107',
                            borderWidth: 1.5,
                            borderRadius: 4
                        },
                        {
                            label: 'Stock mínimo requerido',
                            data: {!! json_encode($dataStockMinimo) !!},
                            backgroundColor: 'rgba(108, 117, 125, 0.4)',
                            borderColor: '#6c757d',
                            borderWidth: 1.5,
                            borderRadius: 4
                        }
                    ]
                },
                options: {
                    indexAxis: 'y',
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        x: { beginAtZero: true, ticks: { stepSize: 1 } }
                    }
                }
            });
        }

        // PRÓXIMOS A VENCER (Doughnut de 15 y 30 días)
        const ctxVencimientos = document.getElementById('graficoVencimientos');
        if (ctxVencimientos) {
            new Chart(ctxVencimientos, {
                type: 'doughnut',
                data: {
                    labels: ['Ya vencidos', 'Próximos 15 Días', 'Próximos 30 Días'],
                    datasets: [{
                        data: {!! json_encode($dataVencimientos) !!},
                        backgroundColor: [
                            '#212529', // Ya vencidos
                            '#dc3545', // Próximos 15 días (Rojo - Peligro)
                            '#fd7e14'  // Próximos 30 días (Naranja - Advertencia)
                        ],
                        borderWidth: 2,
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });
        }
    });
</script>
@endsection