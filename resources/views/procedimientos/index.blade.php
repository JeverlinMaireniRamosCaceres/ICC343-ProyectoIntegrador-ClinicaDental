@extends('layouts.app')

@section('title', 'Procedimientos')

@section('content')
    <div class="container py-4">

        <div class="d-flex align-items-center justify-content-between mb-4">
            <h2 class="fw-semibold mb-0">Procedimientos</h2>
            <div class="d-flex align-items-center gap-2">

                <form method="GET" action="{{ route('procedimientos.index') }}">
                    <div class="d-flex align-items-center gap-2 px-3 py-2 bg-light rounded-pill border border-transparent"
                        style="width: 280px; transition: border-color 0.2s;"
                        onfocusin="this.style.background='#fff'; this.style.borderColor='#2563EB';"
                        onfocusout="this.style.background=''; this.style.borderColor='transparent';">
                        <i class="bi bi-search text-secondary" style="font-size: 14px;"></i>
                        <input type="text" name="buscar" value="{{ request('buscar') }}"
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

        <div class="card border-0 shadow-sm rounded-3">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="px-4 py-3 text-muted fw-semibold small">ID</th>
                            <th class="px-4 py-3 text-muted fw-semibold small">Nombre</th>
                            <th class="px-4 py-3 text-muted fw-semibold small">Precio</th>
                            <th class="px-4 py-3 text-muted fw-semibold small">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($procedimientos as $procedimiento)
                            <tr>
                                <td class="px-4 text-muted">{{ $procedimiento->idProcedimiento }}</td>
                                <td class="px-4 fw-medium">{{ $procedimiento->nombre }}</td>
                                <td class="px-4 fw-semibold">
                                    RD$ {{ number_format($procedimiento->precio, 2) }}
                                </td>
                                <td class="px-4">
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('procedimientos.edit', $procedimiento->idProcedimiento) }}"
                                            class="btn btn-sm btn-warning rounded-pill px-3"
                                            style="color:white;"
                                            title="Editar">
                                            <i class="bi bi-pencil-fill"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-danger rounded-pill px-3"
                                            title="Eliminar" data-bs-toggle="modal" data-bs-target="#modalEliminar"
                                            data-id="{{ $procedimiento->idProcedimiento }}"
                                            data-nombre="{{ $procedimiento->nombre }}">
                                            <i class="bi bi-trash3-fill"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-5">
                                    No se encontraron procedimientos.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex align-items-center justify-content-between px-4 py-3 border-top">
                <small class="text-muted">
                    Mostrando {{ $procedimientos->firstItem() }}–{{ $procedimientos->lastItem() }}
                    de {{ $procedimientos->total() }} resultados
                </small>
                {{ $procedimientos->links() }}
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
