@extends('layouts.app')

@section('title', 'Productos')

@section('content')
    <div class="container py-2 px-2">

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show shadow-sm rounded-4 border-0 mb-4" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm rounded-4 border-0 mb-4" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="d-flex align-items-center justify-content-between mb-4">
            <h2 class="fw-semibold mb-0">Productos</h2>

            <a href="{{ route('productos.create') }}"
                class="btn d-flex align-items-center gap-2 rounded-pill px-4 text-white" style="background-color: #0ea5e9;">
                <i class="bi bi-plus-lg"></i> Nuevo
            </a>
        </div>

        <div class="card border-0 shadow-sm rounded-4">

            <div class="p-4 border-bottom">
                <div class="position-relative" style="max-width: 350px;">
                    <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>

                    <form method="GET" action="{{ route('productos.index') }}" onsubmit="event.preventDefault();">
                        <input type="text" name="buscar" id="buscarProducto" {{-- ID usado por el JS --}}
                            value="{{ request('buscar') }}" class="form-control rounded-pill ps-5 search-input"
                            placeholder="Buscar producto..." autocomplete="off">
                    </form>
                </div>
            </div>

            <div id="contenedorTablaProductos">
                @include('productos.partials.tabla')
            </div>

        </div>
    </div>

    <div class="modal fade" id="modalEliminar" tabindex="-1" aria-labelledby="modalEliminarLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow rounded-3">
                <div class="modal-header border-0 pb-0">
                    <div class="d-flex align-items-center gap-2">
                        <div class="rounded-circle bg-danger bg-opacity-10 d-flex align-items-center justify-content-center"
                            style="width: 40px; height: 40px;">
                            <i class="bi bi-trash3-fill text-danger" style="font-size: 16px;"></i>
                        </div>
                        <h5 class="modal-title fw-semibold mb-0" id="modalEliminarLabel">Eliminar producto</h5>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body pt-3">
                    <p class="text-muted mb-0">
                        ¿Estás seguro de que deseas eliminar el producto <strong id="modalNombre"></strong>?
                    </p>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">
                        Cancelar
                    </button>
                    <form id="formEliminar" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger rounded-pill px-4">
                            <i class="bi bi-trash3-fill me-1"></i> Eliminar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>

        const modalEliminar = document.getElementById('modalEliminar');
        modalEliminar.addEventListener('show.bs.modal', function(e) {
            const btn = e.relatedTarget;
            const id = btn.getAttribute('data-id');
            const nombre = btn.getAttribute('data-nombre');

            document.getElementById('modalNombre').textContent = nombre;
            document.getElementById('formEliminar').action = `/productos/${id}`;
        });
    </script>


    <script src="{{ asset('js/producto.js') }}"></script>
@endsection
