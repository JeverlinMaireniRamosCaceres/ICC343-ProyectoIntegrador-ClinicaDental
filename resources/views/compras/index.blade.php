@extends('layouts.app')

@section('title', 'Compras')

@section('content')

    <div class="container-fluid py-2 px-2">

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm rounded-4 border-0 mb-4" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                {{ session('success') }}

                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>
                <h2 class="fw-bold text-dark mb-1">Compras</h2>
            </div>

            <a href="{{ route('compras.create') }}" class="btn btn-medical-primary rounded-pill px-4 shadow-sm">

                <i class="bi bi-plus-lg me-1"></i>
                Nueva

            </a>

        </div>

        <!-- card -->
        <div class="card border-0 shadow-sm rounded-4">

            <div class="card-body p-0">

                <!-- barra busqueda -->
                <div class="p-4 border-bottom">

                    <div class="d-flex gap-3 flex-wrap align-items-center">

                        <!-- búsqueda -->
                        <div class="position-relative" style="width: 350px;">

                            <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>

                            <form method="GET" action="{{ route('compras.index') }}">

                                <input type="text" name="buscar" id="buscarCompra" value="{{ request('buscar') }}"
                                    class="form-control rounded-pill ps-5 search-input"
                                    placeholder="Buscar por proveedor...">

                            </form>

                        </div>

                        <div class="d-flex gap-3 ms-auto flex-wrap align-items-center">

                            <!-- estado -->
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-sm rounded-pill px-3 btn-filtro active"
                                    data-filtro="">Todos</button>
                                <button type="button" class="btn btn-sm rounded-pill px-3 btn-filtro"
                                    data-filtro="pagada">Pagada</button>
                                <button type="button" class="btn btn-sm rounded-pill px-3 btn-filtro"
                                    data-filtro="pendiente">Pendiente</button>
                                    <button type="button" class="btn btn-sm rounded-pill px-3 btn-filtro"
                                       data-filtro="anulada">Anulada</button>
                            </div>

                            <!-- fecha -->
                            <input type="date" name="fecha" id="filtroFecha" class="form-control date-input"
                                style="width: 150px;">
                        </div>

                    </div>

                </div>

                <!-- tabla -->
                <div id="contenedorTablaCompras">
                    @include('compras.partials.tabla')

                </div>

            </div>

        </div>

    </div>



    <script src="{{ asset('js/compras.js') }}"></script>

@endsection