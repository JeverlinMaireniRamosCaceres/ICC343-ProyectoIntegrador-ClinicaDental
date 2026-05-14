@extends('layouts.app')

@section('title', 'Alergias')

@section('content')

<div class="container-fluid py-4 px-5">

    <!-- header -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h2 class="fw-bold page-title mb-1">Alergias</h2>
        </div>

        <a href="{{ route('alergias.create') }}"
        class="btn btn-medical-primary rounded-pill px-4 shadow-sm">

            <i class="bi bi-plus-lg me-1"></i>
            Nueva alergia

        </a>
    </div>

    <!-- card de la tabla -->
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-0">

            <!-- barra de busqueda -->
            <div class="p-4 border-bottom">
                <div class="position-relative" style="max-width: 350px;">
                    <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>

                    <input type="text"
                           class="form-control rounded-pill ps-5 search-input"
                           placeholder="Buscar alergia...">
                </div>
            </div>

            <!-- valores tabla -->
            <div class="table-responsive">
                <table class="table table-hover-custom align-middle mb-0">

                    <thead class="table-light">
                        <tr>
                            <th class="px-4 py-3 text-muted fw-semibold small">ID</th>
                            <th class="px-4 py-3 text-muted fw-semibold small">Nombre</th>
                            <th class="px-4 py-3 text-muted fw-semibold small text-center">Acciones</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td class="px-4 fw-semibold">1</td>
                            <td class="px-4">Penicilina</td>
                            <td class="px-4 text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('alergias.edit', 1) }}"
                                       class="btn btn-sm btn-warning rounded-pill px-3 text-white">
                                        <i class="bi bi-pencil"></i>
                                    </a>

                                    <button type="button"
                                            class="btn btn-sm btn-danger rounded-pill px-3"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modalEliminarAlergia"
                                            data-id="1"
                                            data-nombre="Penicilina">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td class="px-4 fw-semibold">2</td>
                            <td class="px-4">Látex</td>
                            <td class="px-4 text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('alergias.edit', 2) }}"
                                       class="btn btn-sm btn-warning rounded-pill px-3 text-white">
                                        <i class="bi bi-pencil"></i>
                                    </a>

                                    <button type="button"
                                            class="btn btn-sm btn-danger rounded-pill px-3"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modalEliminarAlergia"
                                            data-id="2"
                                            data-nombre="Látex">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td class="px-4 fw-semibold">3</td>
                            <td class="px-4">Anestesia local</td>
                            <td class="px-4 text-center">
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('alergias.edit', 3) }}"
                                       class="btn btn-sm btn-warning rounded-pill px-3 text-white">
                                        <i class="bi bi-pencil"></i>
                                    </a>

                                    <button type="button"
                                            class="btn btn-sm btn-danger rounded-pill px-3"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modalEliminarAlergia"
                                            data-id="3"
                                            data-nombre="Anestesia local">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>

                </table>
            </div>

            <!-- paginacion -->
            <div class="d-flex justify-content-between align-items-center px-4 py-3 border-top">
                <span class="text-muted small">
                    Mostrando 1–3 de 3 resultados
                </span>

                <nav>
                    <ul class="pagination pagination-sm mb-0">
                        <li class="page-item disabled">
                            <a class="page-link rounded-start" href="#">‹</a>
                        </li>

                        <li class="page-item active">
                            <a class="page-link" href="#">1</a>
                        </li>

                        <li class="page-item disabled">
                            <a class="page-link rounded-end" href="#">›</a>
                        </li>
                    </ul>
                </nav>
            </div>

        </div>
    </div>

</div>

<!-- modal eliminar alergia -->
<div class="modal fade" id="modalEliminarAlergia" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow rounded-4">

            <div class="modal-header border-0 pb-0">
                <div class="d-flex align-items-center gap-2">
                    <div class="rounded-circle bg-danger bg-opacity-10 d-flex align-items-center justify-content-center"
                         style="width: 42px; height: 42px;">
                        <i class="bi bi-trash3-fill text-danger"></i>
                    </div>

                    <div>
                        <h5 class="fw-bold mb-0">Eliminar alergia</h5>
                        <small class="text-muted">Esta acción no se puede deshacer</small>
                    </div>
                </div>

                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body pt-3">
                <p class="mb-0">
                    ¿Estás seguro de que deseas eliminar
                    <strong id="nombreAlergiaEliminar">esta alergia</strong>?
                </p>
            </div>

            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">
                    Cancelar
                </button>

                <form id="formEliminarAlergia" action="{{ route('alergias.destroy', 1) }}" method="POST">
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

<script src="{{ asset('js/alergias/modal-eliminar-alergia.js') }}"></script>

@endsection