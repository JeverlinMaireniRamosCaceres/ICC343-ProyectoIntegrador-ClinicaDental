@extends('layouts.app')

@section('title', 'Compras')

@section('content')
    <div class="container-fluid py-4 px-5">

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

                                <input type="text" name="buscar" value="{{ request('buscar') }}"
                                    class="form-control rounded-pill ps-5 search-input" placeholder="Buscar por proveedor...">

                            </form>

                        </div>

                        <!-- estado -->
                        <select name="estado" class="form-select rounded-pill" style="width: 200px;">

                            <option value="">
                                Todos los estados
                            </option>

                            <option value="pagada">
                                Pagada
                            </option>

                            <option value="pendiente">
                                Pendiente
                            </option>

                        </select>

                        <!-- fecha -->
                        <input type="date" name="fecha" class="form-control rounded-pill" style="width: 200px;">

                    </div>

                </div>

                <!-- tabla -->
                <div id="contenedorTablaUsuarios">

                    @include('compras.partials.tabla')

                </div>

            </div>

        </div>

    </div>

@endsection
