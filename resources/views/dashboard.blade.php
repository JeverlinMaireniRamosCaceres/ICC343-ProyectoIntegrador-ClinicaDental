@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <div class="card p-3 shadow-sm border-0 d-flex flex-row justify-content-between align-items-center flex-wrap gap-3">
            <div>
                <h4 class="fw-bold text-dark m-0">Panel de Control</h4>
                <p class="text-muted small m-0">Análisis y rendimiento del sistema</p>
            </div>
            
            <div class="d-flex align-items-center flex-wrap gap-3">
                <div class="btn-group" role="group" aria-label="Filtros rápidos">
                    <button type="button" class="btn btn-outline-primary btn-filtro-rapido" data-periodo="este-mes">Este Mes</button>
                    <button type="button" class="btn btn-outline-primary btn-filtro-rapido" data-periodo="ultimo-trimestre">Último Trimestre</button>
                    <button type="button" class="btn btn-outline-primary active btn-filtro-rapido" data-periodo="este-ano">Este Año</button>
                    <button type="button" class="btn btn-outline-primary btn-filtro-rapido" data-periodo="historico">Histórico</button>
                </div>

                <div class="d-flex align-items-center gap-2 border-start ps-3">
                    <span class="text-secondary small fw-semibold text-nowrap">O elegir mes:</span>
                    
                    <button type="button" class="btn btn-outline-secondary d-flex align-items-center justify-content-center" 
                            style="height: 38px; width: 45px;" 
                            onclick="document.getElementById('filtro_mes_exacto').showPicker()" 
                            title="Seleccionar mes desde el calendario">
                        <i class="bi bi-calendar-date fs-5"></i>
                    </button>

                    <input type="month" 
                           id="filtro_mes_exacto" 
                           max="{{ date('Y-m') }}"
                           style="position: absolute; opacity: 0; width: 0; height: 0; pointer-events: none;">

                    <a href="{{ url()->current() }}" class="btn btn-outline-secondary d-flex align-items-center justify-content-center" 
                       style="height: 38px; width: 45px;" title="Limpiar Filtros">
                        <i class="bi bi-arrow-clockwise fs-5"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    
    <div class="col-md-6">
        <div class="card p-4 shadow-sm" style="height: 380px;">
            <h5 class="card-title fw-bold text-secondary mb-3">Cantidad de pagos pendientes por mes</h5>
            <div style="position: relative; height: 280px; width: 100%;">
                <canvas id="graficoPagosPendientes"></canvas>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card p-4 shadow-sm" style="height: 380px;">
            <h5 class="card-title fw-bold text-secondary mb-3">Pacientes registrados</h5>
            <div style="position: relative; height: 280px; width: 100%;">
                <canvas id="graficoPacientes"></canvas>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card p-4 shadow-sm" style="height: 380px;">
            <div class="d-flex align-items-center mb-3">
                <i class="bi bi-cash-stack text-success fs-4 me-2"></i>
                <h5 class="card-title fw-bold text-secondary m-0">Ingresos totales</h5>
            </div>
            <div style="position: relative; height: 280px; width: 100%;">
                <canvas id="graficoIngresos"></canvas>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card p-4 shadow-sm" style="height: 380px;">
            <div class="d-flex align-items-center mb-3">
                <i class="bi bi-wallet2 text-warning fs-4 me-2"></i>
                <h5 class="card-title fw-bold text-secondary m-0">Consumo de caja chica</h5>
            </div>
            <div style="position: relative; height: 280px; width: 100%;">
                <canvas id="graficoCajaChica"></canvas>
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
    let chartPendientes, chartPacientes, chartVencimientos, chartIngresos, chartCajaChica;

    const baseChartOptions = {
        responsive: true,
        maintainAspectRatio: false,
        layout: { padding: { top: 10 } }
    };

    function formatCurrency(value) {
        return 'RD$ ' + Math.round(value).toLocaleString(undefined, { maximumFractionDigits: 0 });
    }

    function buildCountOptions() {
        return {
            ...baseChartOptions,
            scales: {
                y: {
                    beginAtZero: true,
                    grace: '15%',
                    ticks: { precision: 0, stepSize: 1 }
                }
            }
        };
    }

    function buildCurrencyOptions(tooltipLabel) {
        return {
            ...baseChartOptions,
            scales: {
                y: {
                    beginAtZero: true,
                    grace: '15%',
                    ticks: {
                        precision: 0,
                        callback: function(value) { return formatCurrency(value); }
                    }
                }
            },
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) { return tooltipLabel + ': ' + formatCurrency(context.parsed.y); }
                    }
                }
            }
        };
    }

    function puntoVisible(context) {
        return context.raw === 0 ? 0 : 4;
    }

    function puntoVisibleHover(context) {
        return context.raw === 0 ? 0 : 6;
    }

    document.addEventListener('DOMContentLoaded', function () {
        const labelsMeses = {!! json_encode($labels) !!};

        const ctxPendientes = document.getElementById('graficoPagosPendientes');
        if (ctxPendientes) {
            chartPendientes = new Chart(ctxPendientes, {
                type: 'bar',
                data: {
                    labels: labelsMeses,
                    datasets: [{
                        label: 'Pagos pendientes',
                        data: {!! json_encode($dataPendientes) !!},
                        backgroundColor: 'rgba(25, 135, 84, 0.05)',
                        borderColor: '#0ea5e9',
                        borderWidth: 2.5,
                        borderRadius: 4
                    }]
                },
                options: buildCountOptions()
            });
        }

        const ctxPacientes = document.getElementById('graficoPacientes');
        if (ctxPacientes) {
            chartPacientes = new Chart(ctxPacientes, {
                type: 'line',
                data: {
                    labels: labelsMeses,
                    datasets: [{
                        label: 'Pacientes nuevos',
                        data: {!! json_encode($dataPacientes) !!},
                        borderColor: '#0ea5e9',
                        backgroundColor: 'rgba(25, 135, 84, 0.05)',
                        borderWidth: 2.5,
                        tension: 0.35,
                        fill: true,
                        pointRadius: puntoVisible,
                        pointHoverRadius: puntoVisibleHover
                    }]
                },
                options: buildCountOptions()
            });
        }

        const ctxIngresos = document.getElementById('graficoIngresos');
        if (ctxIngresos) {
            chartIngresos = new Chart(ctxIngresos, {
                type: 'line',
                data: {
                    labels: labelsMeses,
                    datasets: [{
                        label: 'Ingresos totales',
                        data: {!! isset($dataIngresos) ? json_encode($dataIngresos) : '[]' !!},
                        borderColor: '#0ea5e9',
                        backgroundColor: 'rgba(14, 165, 233, 0.1)',
                        borderWidth: 2.5,
                        tension: 0.35,
                        fill: true,
                        pointRadius: puntoVisible,
                        pointHoverRadius: puntoVisibleHover
                    }]
                },
                options: buildCurrencyOptions('Ingresos')
            });
        }

        const ctxCajaChica = document.getElementById('graficoCajaChica');
        if (ctxCajaChica) {
            chartCajaChica = new Chart(ctxCajaChica, {
                type: 'bar',
                data: {
                    labels: labelsMeses,
                    datasets: [{
                        label: 'Consumo de caja chica',
                        data: {!! isset($dataConsumoCaja) ? json_encode($dataConsumoCaja) : '[]' !!},
                        backgroundColor: 'rgba(14, 165, 233, 0.1)',
                        borderColor: '#0ea5e9',
                        borderWidth: 2.5,
                        borderRadius: 4
                    }]
                },
                options: buildCurrencyOptions('Consumo')
            });
        }

        const ctxVencimientos = document.getElementById('graficoVencimientos');
        if (ctxVencimientos) {
            chartVencimientos = new Chart(ctxVencimientos, {
                type: 'doughnut',
                data: {
                    labels: ['Ya vencidos', 'Próximos 15 Días', 'Próximos 30 Días'],
                    datasets: [{
                        data: {!! json_encode($dataVencimientos) !!},
                        backgroundColor: ['#003366', '#0065cbe1', '#0ea5e9'],
                        borderWidth: 2,
                        hoverOffset: 4
                    }]
                },
                options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { position: 'bottom' } } }
            });
        }

        const botonesRapidos = document.querySelectorAll('.btn-filtro-rapido');
        const inputMesEspecifco = document.getElementById('filtro_mes_exacto');

        botonesRapidos.forEach(boton => {
            boton.addEventListener('click', function() {
                botonesRapidos.forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                inputMesEspecifco.value = '';

                const periodo = this.getAttribute('data-periodo');
                actualizarDashboard('periodo', periodo);
            });
        });

        if (inputMesEspecifco) {
            inputMesEspecifco.addEventListener('change', function() {
                if (this.value) {
                    botonesRapidos.forEach(b => b.classList.remove('active'));
                    actualizarDashboard('mes_especifico', this.value);
                }
            });
        }

        function actualizarDashboard(tipo, valor) {
            const url = `{{ route('dashboard.data') }}?tipo=${tipo}&valor=${valor}`;

            fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(res => {
                if (chartPendientes) {
                    chartPendientes.data.labels = res.labels;
                    chartPendientes.data.datasets[0].data = res.dataPendientes.map(Number);
                    chartPendientes.update();
                }

                if (chartPacientes) {
                    chartPacientes.data.labels = res.labels;
                    chartPacientes.data.datasets[0].data = res.dataPacientes.map(Number);
                    chartPacientes.update();
                }

                if (chartIngresos) {
                    chartIngresos.data.labels = res.labels;
                    chartIngresos.data.datasets[0].data = res.dataIngresos.map(Number);
                    chartIngresos.update();
                }

                if (chartCajaChica) {
                    chartCajaChica.data.labels = res.labels;
                    chartCajaChica.data.datasets[0].data = res.dataConsumoCaja.map(Number);
                    chartCajaChica.update();
                }
            })
            .catch(error => console.error("Error al procesar el filtro:", error));
        }
    });
</script>
@endsection