@extends('layouts.app')

@section('title', 'Historial de Facturas')

@section('content')
    <div class="container-fluid py-3 px-3">

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm rounded-4 border-0 mb-4" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold page-title mb-1 fs-3">Historial de facturas</h2>
            </div>
            <a href="{{ route('facturacion.create', [
                'return' => request()->fullUrl(),
            ]) }}"
                class="btn btn-medical-primary rounded-pill px-4 py-2 fw-medium shadow-sm">
                <i class="bi bi-plus-lg me-2"></i>
                Nueva factura
            </a>
        </div>

        <div class="card border-0 shadow-sm rounded-4 bg-white">
            <div class="card-body p-0">

                <div class="p-3 border-bottom border-light-subtle">
                    <div
                        class="d-flex flex-column flex-md-row justify-content-between align-items-stretch align-items-md-center gap-3">

                        <div class="position-relative flex-grow-1 flex-md-grow-0"
                            style="width: 100%; max-width: 350px; min-width: 300px;">
                            <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                            <form method="GET" action="{{ route('facturacion.index') }}" id="formBuscar" class="m-0">
                                <input type="text" name="buscar" id="buscarFactura" value="{{ request('buscar') }}"
                                    class="form-control rounded-pill ps-5 border-light-subtle bg-light-subtle py-2"
                                    placeholder="Buscar por paciente...">
                            </form>
                        </div>

                        <div class="d-flex flex-wrap align-items-center gap-2 justify-content-start justify-content-md-end">

                            <div class="d-flex gap-1 bg-light p-1 rounded-pill border border-light-subtle"
                                style="height: 38px;">

                                <button type="button"
                                    class="btn btn-sm rounded-pill px-3 btn-filtro fw-medium active border-0"
                                    data-filtro="">
                                    Todos
                                </button>

                                <button type="button"
                                    class="btn btn-sm rounded-pill px-3 btn-filtro fw-medium border-0 text-muted"
                                    data-filtro="pendiente">
                                    Pendiente
                                </button>

                                <button type="button"
                                    class="btn btn-sm rounded-pill px-3 btn-filtro fw-medium border-0 text-muted"
                                    data-filtro="parcial">
                                    Parcial
                                </button>

                                <button type="button"
                                    class="btn btn-sm rounded-pill px-3 btn-filtro fw-medium border-0 text-muted"
                                    data-filtro="pagada">
                                    Pagada
                                </button>

                                <button type="button"
                                    class="btn btn-sm rounded-pill px-3 btn-filtro fw-medium border-0 text-muted"
                                    data-filtro="anulada">
                                    Anulada
                                </button>

                            </div>

                            <div class="d-flex align-items-center gap-2 bg-light p-1 rounded-pill border border-light-subtle"
                                style="width: 310px; height: 38px;">
                                <input type="date" name="fecha_desde" id="filtroFechaDesde"
                                    class="form-control form-control-sm border-0 bg-transparent rounded-pill px-2 date-input text-muted"
                                    value="{{ request('fecha_desde') }}" style="width: 125px; box-shadow: none;">

                                <span class="text-muted opacity-50 fw-bold">→</span>

                                <input type="date" name="fecha_hasta" id="filtroFechaHasta"
                                    class="form-control form-control-sm border-0 bg-transparent rounded-pill px-2 date-input text-muted"
                                    value="{{ request('fecha_hasta') }}" style="width: 125px; box-shadow: none;">
                            </div>

                        </div>

                    </div>
                </div>

                <div id="contenedorTablaFacturas">
                    @include('facturacion.partials.tabla')
                </div>

            </div>
        </div>

    </div>

    @include('facturacion.partials.modal-anular-factura')

    <style>
        .btn-filtro {
            transition: all 0.2s ease;
            font-size: 0.85rem;
            background: transparent;
            display: flex;
            align-items: center;
        }

        .btn-filtro.active {
            background-color: #ffffff !important;
            color: #0ea5e9 !important;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.08) !important;
            font-weight: 600 !important;
        }

        .btn-filtro:not(.active):hover {
            color: #212529 !important;
            background-color: rgba(0, 0, 0, 0.04);
        }

        .date-input {
            font-size: 0.85rem;
        }

        .date-input::-webkit-calendar-picker-indicator {
            cursor: pointer;
            opacity: 0.6;
        }

        .date-input::-webkit-calendar-picker-indicator:hover {
            opacity: 1;
        }
    </style>

    <script src="{{ asset('js/historial-factura.js') }}"></script>
@endsection
