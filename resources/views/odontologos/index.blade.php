@extends('layouts.app')

@section('content')

<div class="container-fluid px-4">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold mb-0">Odontólogos</h2>

        <div class="d-flex align-items-center gap-2">
            <div class="position-relative">
                <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                <input type="text"
                       class="form-control rounded-pill ps-5 border-0 shadow-sm"
                       placeholder="Buscar odontólogo..."
                       style="width: 280px;">
            </div>

            <a href="{{ route('odontologos.create') }}" class="btn btn-primary rounded-pill px-4 shadow-sm">
                <i class="bi bi-plus-lg me-1"></i> Nuevo
            </a>
        </div>
    </div>

    <!-- Cards -->
    <div class="row g-3">

        <!-- Odontólogo 1 -->
        <div class="col-md-6 col-xl-4">
            <div class="card border-0 shadow-sm rounded-4 card-hover">
                <div class="card-body">

                    <div class="d-flex align-items-start justify-content-between mb-3">
                        <div class="d-flex align-items-center gap-3">
                            <div class="rounded-circle bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center"
                                 style="width: 48px; height: 48px;">
                                <i class="bi bi-person-badge fs-4"></i>
                            </div>

                            <div>
                                <h6 class="fw-bold mb-1">Dr. Juan Pérez</h6>
                                <small class="text-muted">Odontólogo general</small>
                            </div>
                        </div>

                    </div>

                    <div class="mb-3">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <i class="bi bi-award text-muted"></i>
                            <span class="text-muted">Exequatur:</span>
                            <span class="fw-semibold">12345</span>
                        </div>

                        <div class="d-flex align-items-center gap-2 mb-2">
                            <i class="bi bi-credit-card-2-front text-muted"></i>
                            <span class="text-muted">Cédula:</span>
                            <span>001-1234567-8</span>
                        </div>

                        <div class="d-flex align-items-center gap-2 mb-2">
                            <i class="bi bi-telephone text-muted"></i>
                            <span>809-555-1234</span>
                        </div>

                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-envelope text-muted"></i>
                            <span class="text-truncate">juan.perez@email.com</span>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 border-top pt-3">
                        <a href="{{ route('odontologos.show', 1) }}"
                           class="btn btn-sm btn-secondary rounded-pill px-3">
                            <i class="bi bi-eye"></i>
                        </a>

                        <a href="{{ route('odontologos.edit', 1) }}"
                           class="btn btn-sm btn-warning rounded-pill px-3 text-white">
                            <i class="bi bi-pencil"></i>
                        </a>

                        <button type="button"
                                class="btn btn-sm btn-danger rounded-pill px-3"
                                data-bs-toggle="modal"
                                data-bs-target="#modalEliminarOdontologo"
                                data-id="1"
                                data-nombre="Dr. Juan Pérez">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>

                </div>
            </div>
        </div>

        <!-- Odontólogo 2 -->
        <div class="col-md-6 col-xl-4">
            <div class="card border-0 shadow-sm rounded-4 card-hover">
                <div class="card-body">

                    <div class="d-flex align-items-start justify-content-between mb-3">
                        <div class="d-flex align-items-center gap-3">
                            <div class="rounded-circle bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center"
                                 style="width: 48px; height: 48px;">
                                <i class="bi bi-person-badge fs-4"></i>
                            </div>

                            <div>
                                <h6 class="fw-bold mb-1">Dra. Laura Gómez</h6>
                                <small class="text-muted">Ortodoncia</small>
                            </div>
                        </div>

                    </div>

                    <div class="mb-3">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <i class="bi bi-award text-muted"></i>
                            <span class="text-muted">Exequatur:</span>
                            <span class="fw-semibold">67890</span>
                        </div>

                        <div class="d-flex align-items-center gap-2 mb-2">
                            <i class="bi bi-credit-card-2-front text-muted"></i>
                            <span class="text-muted">Cédula:</span>
                            <span>002-9876543-1</span>
                        </div>

                        <div class="d-flex align-items-center gap-2 mb-2">
                            <i class="bi bi-telephone text-muted"></i>
                            <span>829-555-8899</span>
                        </div>

                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-envelope text-muted"></i>
                            <span class="text-truncate">laura.gomez@email.com</span>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 border-top pt-3">
                        <a href="{{ route('odontologos.show', 2) }}"
                           class="btn btn-sm btn-secondary rounded-pill px-3">
                            <i class="bi bi-eye"></i>
                        </a>

                        <a href="{{ route('odontologos.edit', 2) }}"
                           class="btn btn-sm btn-warning rounded-pill px-3 text-white">
                            <i class="bi bi-pencil"></i>
                        </a>

                        <button type="button"
                                class="btn btn-sm btn-danger rounded-pill px-3"
                                data-bs-toggle="modal"
                                data-bs-target="#modalEliminarOdontologo"
                                data-id="2"
                                data-nombre="Dra. Laura Gómez">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>

                </div>
            </div>
        </div>

        <!-- Odontólogo 3 -->
        <div class="col-md-6 col-xl-4">
            <div class="card border-0 shadow-sm rounded-4 card-hover">
                <div class="card-body">

                    <div class="d-flex align-items-start justify-content-between mb-3">
                        <div class="d-flex align-items-center gap-3">
                            <div class="rounded-circle bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center"
                                 style="width: 48px; height: 48px;">
                                <i class="bi bi-person-badge fs-4"></i>
                            </div>

                            <div>
                                <h6 class="fw-bold mb-1">Dr. Carlos Ramírez</h6>
                                <small class="text-muted">Endodoncia</small>
                            </div>
                        </div>

                    </div>

                    <div class="mb-3">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <i class="bi bi-award text-muted"></i>
                            <span class="text-muted">Exequatur:</span>
                            <span class="fw-semibold">54321</span>
                        </div>

                        <div class="d-flex align-items-center gap-2 mb-2">
                            <i class="bi bi-credit-card-2-front text-muted"></i>
                            <span class="text-muted">Cédula:</span>
                            <span>003-4567890-2</span>
                        </div>

                        <div class="d-flex align-items-center gap-2 mb-2">
                            <i class="bi bi-telephone text-muted"></i>
                            <span>849-555-4422</span>
                        </div>

                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-envelope text-muted"></i>
                            <span class="text-truncate">carlos.ramirez@email.com</span>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 border-top pt-3">
                        <a href="{{ route('odontologos.show', 3) }}"
                           class="btn btn-sm btn-secondary rounded-pill px-3">
                            <i class="bi bi-eye"></i>
                        </a>

                        <a href="{{ route('odontologos.edit', 3) }}"
                           class="btn btn-sm btn-warning rounded-pill px-3 text-white">
                            <i class="bi bi-pencil"></i>
                        </a>

                        <button type="button"
                                class="btn btn-sm btn-danger rounded-pill px-3"
                                data-bs-toggle="modal"
                                data-bs-target="#modalEliminarOdontologo"
                                data-id="3"
                                data-nombre="Dr. Carlos Ramírez">
                            <i class="bi bi-trash"></i>
                        </button>
                    </div>

                </div>
            </div>
        </div>

    </div>

        <div class="d-flex justify-content-between align-items-center mt-4 px-2">
        <span class="text-muted small">Mostrando 1–1 de 1 resultados</span>

        <nav>
            <ul class="pagination pagination-sm mb-0">
                <li class="page-item disabled">
                    <a class="page-link" href="#">‹</a>
                </li>
                <li class="page-item active">
                    <a class="page-link" href="#">1</a>
                </li>
                <li class="page-item disabled">
                    <a class="page-link" href="#">›</a>
                </li>
            </ul>
        </nav>
    </div>

</div>


<!-- Modal eliminar odontólogo -->
<div class="modal fade" id="modalEliminarOdontologo" tabindex="-1" aria-labelledby="modalEliminarOdontologoLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow rounded-4">

            <div class="modal-header border-0 pb-0">
                <div class="d-flex align-items-center gap-2">
                    <div class="rounded-circle bg-danger bg-opacity-10 d-flex align-items-center justify-content-center"
                         style="width: 42px; height: 42px;">
                        <i class="bi bi-trash3-fill text-danger"></i>
                    </div>

                    <div>
                        <h5 class="modal-title fw-bold mb-0" id="modalEliminarOdontologoLabel">
                            Eliminar odontólogo
                        </h5>
                        <small class="text-muted">Esta acción no se puede deshacer</small>
                    </div>
                </div>

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>

            <div class="modal-body pt-3">
                <p class="mb-0">
                    ¿Estás seguro de que deseas eliminar a
                    <strong id="nombreOdontologoEliminar">este odontólogo</strong>?
                </p>
            </div>

            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">
                    Cancelar
                </button>

                <form id="formEliminarOdontologo" action="{{ route('odontologos.destroy', 1) }}" method="POST">
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


<script>
    const modalEliminarOdontologo = document.getElementById('modalEliminarOdontologo');

    modalEliminarOdontologo.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;

        const id = button.getAttribute('data-id');
        const nombre = button.getAttribute('data-nombre');

        document.getElementById('nombreOdontologoEliminar').textContent = nombre;

        const form = document.getElementById('formEliminarOdontologo');
        form.action = `/odontologos/${id}`;
    });
</script>

@endsection