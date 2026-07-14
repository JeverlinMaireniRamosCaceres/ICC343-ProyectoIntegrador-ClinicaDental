@extends('layouts.app')

@section('title', 'Caja chica')

@section('content')
    <div class="container-fluid py-2 px-2">

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm rounded-4 border-0 mb-4" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                {{ session('success') }}

                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- header -->
        <div class="d-flex justify-content-between align-items-center mb-3">

            <div>
                <h2 class="fw-bold page-title mb-1">Historial de cajas chicas</h2>
            </div>

            @rol('Administrador')
            <a href="{{ route('caja-chica.create') }}" class="btn btn-medical-primary rounded-pill px-4 shadow-sm">

                <i class="bi bi-cash-coin"></i>
                Abrir caja

            </a>
            @endrol

        </div>

        <!-- card -->
        <div class="card border-0 shadow-sm rounded-4">

            <div class="card-body p-0">

                <!-- filtro por fecha -->
                <div class="p-4 border-bottom d-flex justify-content-start">
                    <div class="d-flex align-items-center bg-light p-1 rounded-pill border border-light-subtle"
                        style="width: 250px; height: 38px;">

                        <input type="date" name="fecha" id="filtroFecha"
                            class="form-control form-control-sm border-0 bg-transparent rounded-pill px-2 date-input text-muted"
                            value="{{ request('fecha') }}" style="box-shadow: none;">

                    </div>
                </div>

                <!-- tabla -->
                <div id="contenedorTablaCajas">

                    @include('caja_chica.partials.tabla')

                </div>

            </div>

        </div>

    </div>

    <script src="{{ asset('js/caja-chica.js') }}"></script>
@endsection
