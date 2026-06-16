@extends('layouts.app')

@section('title', 'Procedimientos')

@section('content')
    <div class="container-fluid py-4 px-5">

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
                <h2 class="fw-bold page-title mb-1">Procedimientos</h2>
            </div>

            <a href="{{ route('procedimientos.create') }}" class="btn btn-medical-primary rounded-pill px-4 shadow-sm">

                <i class="bi bi-plus-lg me-1"></i>
                Nuevo

            </a>

        </div>

        <!-- card -->
        <div class="card border-0 shadow-sm rounded-4">

            <div class="card-body p-0">

                <!-- barra busqueda -->
                <div class="p-4 border-bottom">

                    <div class="position-relative" style="max-width: 350px;">

                        <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>

                        <form method="GET" action="{{ route('procedimientos.index') }}">

                            <input type="text" name="buscar" id="buscarProcedimiento" value="{{ request('buscar') }}"
                                class="form-control rounded-pill ps-5 search-input" placeholder="Buscar procedimiento...">
                        </form>

                    </div>

                </div>

                <!-- tabla -->
                <div id="contenedorTablaProcedimientos">

                    @include('procedimientos.partials.tabla')

                </div>

            </div>

        </div>

    </div>
    @include('procedimientos.partials.modal-eliminar')
    <script src="{{ asset('js/procedimientos.js') }}"></script>

@endsection


