@extends('layouts.app')

@section('title', 'Consultas')

@section('content')

    <div class="container-fluid py-2 px-2">

        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>
                <h2 class="fw-bold text-dark mb-1">Consultas</h2>
            </div>

            <a href="{{ route('consultas.create') }}" class="btn btn-medical-primary rounded-pill px-4 shadow-sm">
                <i class="bi bi-plus-lg me-1"></i>
                Nueva
            </a>

        </div>

        <!-- Tabla -->
        <div class="card border-0 shadow-sm rounded-4">

            <div class="card-body p-0">

                <div class="p-4 border-bottom">
                    <div class="position-relative" style="max-width: 350px;">
                        <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                        <input type="text" id="buscarConsulta" value="{{ request('buscar') }}"
                            class="form-control rounded-pill ps-5 search-input" placeholder="Buscar por paciente...">
                    </div>
                </div>

                <!-- tabla con consultas -->
                <div id="contenedorTablaConsultas">
                    @include('consultas.partials.tabla')
                </div>


            </div>

        </div>

    </div>

    <script src="{{ asset('js/consultas.js') }}"></script>
    @include('consultas.partials.modal-create-paciente')
    @include('consultas.partials.modal-create-tratamiento')

@endsection