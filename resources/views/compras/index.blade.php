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

                                <input type="text" name="buscar" id="buscarCompra" value="{{ request('buscar') }}"
                                    class="form-control rounded-pill ps-5 search-input" placeholder="Buscar por proveedor...">

                            </form>

                        </div>

                        <!-- estado -->
                        <select name="estado" id="filtroEstado" class="form-select rounded-pill" style="width: 200px;">

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
                        <input type="date" name="fecha" id="filtroFecha" class="form-control rounded-pill" style="width: 200px;">

                    </div>

                </div>

                <!-- tabla -->
                <div id="contenedorTablaCompras">

                    @include('compras.partials.tabla')

                </div>

            </div>

        </div>

    </div>

    <!-- modal dar de baja -->
    <div class="modal fade" id="modalEliminarCompra" tabindex="-1" aria-hidden="true">

        <div class="modal-dialog modal-dialog-centered">

            <div class="modal-content border-0 shadow rounded-4">

                <div class="modal-header border-0 pb-0">

                    <div class="d-flex align-items-center gap-2">

                        <div class="rounded-circle bg-danger bg-opacity-10 d-flex align-items-center justify-content-center"
                            style="width: 42px; height: 42px;">

                            <i class="bi bi-trash3-fill text-danger"></i>

                        </div>

                        <div>
                            <h5 class="fw-bold mb-0">Eliminar compra</h5>
                        </div>

                    </div>

                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>

                </div>

                <div class="modal-body pt-3">

                    <p class="mb-0">
                        ¿Estás seguro de que deseas eliminar esta compra?
                    </p>

                </div>

                <div class="modal-footer border-0 pt-0">

                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">

                        Cancelar

                    </button>

                    <form id="formEliminarCompra" method="POST">

                        @csrf
                        @method('DELETE')

                        <button type="submit" class="btn btn-danger rounded-pill px-4">

                            Eliminar

                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

    <script src="{{ asset('js/compras.js') }}"></script>

@endsection
