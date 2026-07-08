@extends('layouts.app')

@section('title', 'Pagos')

@section('content')
    <div class="container-fluid py-2 px-2">

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm rounded-4 border-0 mb-4" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                {{ session('success') }}

                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="d-flex justify-content-between align-items-center mb-3">
            <div>
                <h2 class="fw-bold page-title mb-1">
                    Historial de Pagos
                </h2>
            </div>
        </div>

        <div class="row g-3 mb-3">

            {{-- Pendiente por cobrar --}}
            <div class="col-md-6 col-xl-3">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body">

                        <div class="d-flex justify-content-between align-items-start">

                            <div>
                                <small class="text-muted fw-medium">
                                    Cuotas pendientes
                                </small>

                                <h3 class="fw-bold mb-1 mt-2">
                                    RD$ {{ number_format($pendientePorCobrar, 2) }}
                                </h3>

                            </div>

                            <div class="rounded-circle bg-warning-subtle d-flex align-items-center justify-content-center"
                                style="width:40px;height:40px;">
                                <i class="bi bi-hourglass-split text-warning fs-4"></i>
                            </div>

                        </div>

                    </div>
                </div>
            </div>

            {{-- Vencido por cobrar --}}
            <div class="col-md-6 col-xl-3">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body">

                        <div class="d-flex justify-content-between align-items-start">

                            <div>
                                <small class="text-muted fw-medium">
                                    Cuotas vencidas
                                </small>

                                <h3 class="fw-bold mb-1 mt-2">
                                    RD$ {{ number_format($vencidoPorCobrar, 2) }}
                                </h3>

                            </div>

                            <div class="rounded-circle bg-danger-subtle d-flex align-items-center justify-content-center"
                                style="width:40px;height:40px;">
                                <i class="bi bi-exclamation-triangle-fill text-danger fs-4"></i>
                            </div>

                        </div>

                    </div>
                </div>
            </div>

            {{-- Cobrado hoy --}}
            <div class="col-md-6 col-xl-3">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body">

                        <div class="d-flex justify-content-between align-items-start">

                            <div>
                                <small class="text-muted fw-medium">
                                    Cobros del día
                                </small>

                                <h3 class="fw-bold mb-1 mt-2">
                                    RD$ {{ number_format($cobradoHoy, 2) }}
                                </h3>

                            </div>

                            <div class="rounded-circle bg-success-subtle d-flex align-items-center justify-content-center"
                                style="width:40px;height:40px;">
                                <i class="bi bi-cash-stack text-success fs-4"></i>
                            </div>

                        </div>

                    </div>
                </div>
            </div>

            {{-- Cobrado este mes --}}
            <div class="col-md-6 col-xl-3">
                <div class="card border-0 shadow-sm rounded-4 h-100">
                    <div class="card-body">

                        <div class="d-flex justify-content-between align-items-start">

                            <div>
                                <small class="text-muted fw-medium">
                                    Cobros del mes
                                </small>

                                <h3 class="fw-bold mb-1 mt-2">
                                    RD$ {{ number_format($cobradoEsteMes, 2) }}
                                </h3>

                            </div>

                            <div class="rounded-circle bg-primary-subtle d-flex align-items-center justify-content-center"
                                style="width:40px;height:40px;">
                                <i class="bi bi-calendar-check-fill text-primary fs-4"></i>
                            </div>

                        </div>

                    </div>
                </div>
            </div>

        </div>

        <div class="card border-0 shadow-sm rounded-4">

            <div class="card-body p-0">

                <div class="p-3 border-bottom border-light-subtle">

                    <div
                        class="d-flex flex-column flex-md-row justify-content-between align-items-stretch align-items-md-center gap-3">

                        {{-- Buscador --}}
                        <div class="position-relative flex-grow-1 flex-md-grow-0"
                            style="width:100%; max-width:350px; min-width:300px;">

                            <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>

                            <form method="GET" action="{{ route('pagos.index') }}" id="formBuscar" class="m-0">

                                <input type="text" name="buscar" id="buscarPago" value="{{ request('buscar') }}"
                                    class="form-control rounded-pill ps-5 border-light-subtle bg-light-subtle py-2"
                                    placeholder="Buscar paciente, factura o recibo...">

                            </form>

                        </div>

                        <div class="d-flex flex-wrap align-items-center gap-2 justify-content-start justify-content-md-end">

                            {{-- Vistas --}}
                            <div class="d-flex gap-1 bg-light p-1 rounded-pill border border-light-subtle"
                                style="height: 38px;">

                                <button type="button"
                                    class="btn btn-sm rounded-pill px-3 btn-filtro fw-medium {{ $vista === 'pendientes' ? 'active border-0' : 'border-0 text-muted' }}"
                                    data-vista="pendientes">
                                    Pendientes
                                </button>

                                <button type="button"
                                    class="btn btn-sm rounded-pill px-3 btn-filtro fw-medium {{ $vista === 'vencidos' ? 'active border-0' : 'border-0 text-muted' }}"
                                    data-vista="vencidos">
                                    Vencidos
                                </button>

                                <button type="button"
                                    class="btn btn-sm rounded-pill px-3 btn-filtro fw-medium {{ $vista === 'recibos' ? 'active border-0' : 'border-0 text-muted' }}"
                                    data-vista="recibos">
                                    Recibos
                                </button>

                                <button type="button"
                                    class="btn btn-sm rounded-pill px-3 btn-filtro fw-medium {{ $vista === 'anulados' ? 'active border-0' : 'border-0 text-muted' }}"
                                    data-vista="anulados">
                                    Anulados
                                </button>

                            </div>

                            {{-- Fechas --}}
                            <div class="d-flex align-items-center gap-2 bg-light p-1 rounded-pill border border-light-subtle"
                                style="width:310px;height:38px;">

                                <input type="date" id="filtroFechaDesde"
                                    class="form-control form-control-sm border-0 bg-transparent rounded-pill px-2 date-input text-muted"
                                    value="{{ request('fecha_desde') }}" style="width:125px; box-shadow:none;">

                                <span class="text-muted opacity-50 fw-bold">
                                    →
                                </span>

                                <input type="date" id="filtroFechaHasta"
                                    class="form-control form-control-sm border-0 bg-transparent rounded-pill px-2 date-input text-muted"
                                    value="{{ request('fecha_hasta') }}" style="width:125px; box-shadow:none;">

                            </div>

                        </div>

                    </div>

                </div>

                <div id="contenedorTablaPagos">

                    @include("pagos.partials.tabla-{$vista}")

                </div>

            </div>

        </div>

    </div>



    <script src="{{ asset('js/pago.js') }}"></script>

@endsection
