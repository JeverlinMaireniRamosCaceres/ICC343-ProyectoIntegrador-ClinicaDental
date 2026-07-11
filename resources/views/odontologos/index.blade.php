@extends('layouts.app')

@section('title', 'Odontólogos')

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
                <h2 class="fw-bold page-title mb-1">Odontólogos</h2>
            </div>

            @rol('Administrador')
                <a href="{{ route('odontologos.create') }}" class="btn btn-medical-primary rounded-pill px-4 shadow-sm">
                    <i class="bi bi-plus-lg me-1"></i>
                    Nuevo
                </a>
            @endrol

        </div>

        <!-- card -->
        <div class="card border-0 shadow-sm rounded-4">

            <div class="card-body p-0">

                <!-- barra busqueda -->
                <div class="p-4 border-bottom">

                    <div class="position-relative" style="max-width: 350px;">

                        <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>

                        <form method="GET" action="{{ route('odontologos.index') }}">

                            <input type="text" name="buscar" id="buscarOdontologo" value="{{ request('buscar') }}"
                                class="form-control rounded-pill ps-5 search-input" placeholder="Buscar odontólogo ...">
                        </form>

                    </div>

                </div>

                <!-- tabla -->
                <div id="contenedorTablaOdontologos">
                    @include('odontologos.partials.tabla')
                </div>

            </div>

        </div>

    </div>

    @include('odontologos.partials.modal-desactivar')
    @include('odontologos.partials.modal-activar')
    <script src="{{ asset('js/odontologos.js') }}"></script>

@endsection
