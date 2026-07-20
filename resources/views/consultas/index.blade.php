@extends('layouts.app')

@section('title', 'Consultas')

@section('content')

    <div class="container-fluid py-2 px-2">

        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>
                <h2 class="fw-bold text-dark mb-1">Consultas</h2>
            </div>

            @if (auth()->user()->persona)
                <a href="{{ route('consultas.create') }}?return={{ urlencode(request()->fullUrl()) }}"
                    class="btn btn-medical-primary rounded-pill px-4 shadow-sm">
                    <i class="bi bi-plus-lg me-1"></i>
                    Nueva
                </a>
            @endif

        </div>

        <!-- Tabla -->
        <div class="card border-0 shadow-sm rounded-4">

            <div class="card-body p-0">

                <div class="p-4 border-bottom">

                    <div class="d-flex gap-3 flex-wrap align-items-center">

                        <div class="position-relative" style="width: 350px;">

                            <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>

                            <input type="text" id="buscarConsulta" value="{{ request('buscar') }}"
                                class="form-control rounded-pill ps-5 search-input" placeholder="Buscar por paciente...">

                        </div>

                        <div class="d-flex gap-3 ms-auto flex-wrap align-items-center">

                            <div class="d-flex align-items-center gap-2 bg-light p-1 rounded-pill border border-light-subtle"
                                style="width: 310px; height: 38px;">

                                <input type="date" id="filtroFechaDesde"
                                    class="form-control form-control-sm border-0 bg-transparent rounded-pill px-2"
                                    value="{{ request('fecha_desde') }}" style="width:125px; box-shadow:none;">

                                <span class="text-muted opacity-50 fw-bold">→</span>

                                <input type="date" id="filtroFechaHasta"
                                    class="form-control form-control-sm border-0 bg-transparent rounded-pill px-2"
                                    value="{{ request('fecha_hasta') }}" style="width:125px; box-shadow:none;">
                            </div>

                        </div>

                    </div>

                </div>

                <!-- tabla con consultas -->
                <div id="contenedorTablaConsultas">
                    @include('consultas.partials.tabla')
                </div>

            </div>

        </div>

    </div>

    <script src="{{ asset('js/consulta.js') }}"></script>
    @include('consultas.partials.modal-create-paciente')
    @include('consultas.partials.modal-create-tratamiento')

@endsection
