@extends('layouts.app')

@section('title', 'Procedimientos')

@section('content')
    <div class="container py-4">

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-3 border-0 shadow-sm mb-4" role="alert">
                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-check-circle-fill"></i>
                    <div>{{ session('success') }}</div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show rounded-3 border-0 shadow-sm mb-4" role="alert">
                <div class="d-flex align-items-center gap-2">
                    <i class="bi bi-exclamation-triangle-fill"></i>
                    <div>{{ session('error') }}</div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="d-flex align-items-center justify-content-between mb-4">
            <h2 class="fw-semibold mb-0">Procedimientos</h2>
            <div class="d-flex align-items-center gap-2">

                {{-- Se quita el comportamiento de submit por defecto del form para manejarlo con JS --}}
                <form method="GET" action="{{ route('procedimientos.index') }}" onsubmit="event.preventDefault();">
                    <div class="d-flex align-items-center gap-2 px-3 py-2 bg-light rounded-pill border border-transparent"
                        style="width: 280px; transition: border-color 0.2s;"
                        onfocusin="this.style.background='#fff'; this.style.borderColor='#2563EB';"
                        onfocusout="this.style.background=''; this.style.borderColor='transparent';">
                        <i class="bi bi-search text-secondary" style="font-size: 14px;"></i>
                        {{-- ID AGREGADO AQUÍ --}}
                        <input type="text" name="buscar" id="buscarProcedimiento" value="{{ request('buscar') }}"
                            class="border-0 bg-transparent p-0 w-100" style="outline: none; font-size: 14px;"
                            placeholder="Buscar procedimiento...">
                    </div>
                </form>

                <a href="{{ route('procedimientos.create') }}"
                    class="btn btn-primary d-flex align-items-center gap-2 rounded-pill px-4">
                    <i class="bi bi-plus-lg"></i> Nuevo
                </a>
            </div>
        </div>

        {{-- ID CONTENEDOR DE LA TABLA ASÍNCRONA --}}
        <div class="card border-0 shadow-sm rounded-3" id="contenedorTablaProcedimientos">
            @include('procedimientos.partials.tabla')
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
                        <h5 class="modal-title fw-semibold mb-0" id="modalEliminarLabel">Eliminar procedimiento</h5>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body pt-3">
                    <p class="text-muted mb-0">
                        ¿Estás seguro de que deseas eliminar <strong id="modalNombre"></strong>?
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
    <script src="{{ asset('js/procedimientos.js') }}"></script>
    <script>
        const modalEliminar = document.getElementById('modalEliminar');
        modalEliminar.addEventListener('show.bs.modal', function(e) {
            const btn = e.relatedTarget;
            const id = btn.getAttribute('data-id');
            const nombre = btn.getAttribute('data-nombre');

            document.getElementById('modalNombre').textContent = nombre;
            document.getElementById('formEliminar').action = `/procedimientos/${id}`;
        });
    </script>
@endsection