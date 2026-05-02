@extends('layouts.app')

@section('content')

<div class="container-fluid px-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold mb-0">Usuarios</h2>

        <div class="d-flex align-items-center gap-2">
            <div class="position-relative">
                <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                <input type="text"
                       class="form-control rounded-pill ps-5 border-0 shadow-sm"
                       placeholder="Buscar usuario..."
                       style="width: 270px;">
            </div>

            <a href="{{ route('usuarios.create') }}" class="btn btn-primary rounded-pill px-4 shadow-sm">
                <i class="bi bi-plus-lg me-1"></i> Nuevo
            </a>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-3">
        <div class="table-responsive">

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="px-4 py-3 text-muted fw-semibold small">ID</th>
                        <th class="px-4 py-3 text-muted fw-semibold small">Usuario</th>
                        <th class="px-4 py-3 text-muted fw-semibold small">Persona</th>
                        <th class="px-4 py-3 text-muted fw-semibold small">Rol</th>
                        <th class="px-4 py-3 text-muted fw-semibold small">Fecha creación</th>
                        <th class="px-4 py-3 text-muted fw-semibold small">Estado</th>
                        <th class="px-4 py-3 text-muted fw-semibold small text-center">Acciones</th>
                    </tr>
                </thead>

                    <tbody>
                        <tr>
                            <td class="ps-4">1</td>

                            <td>
                                <div class="fw-semibold">admin</div>
                                <small class="text-muted">Usuario administrador</small>
                            </td>

                            <td>
                                <span class="text-muted">Persona #1</span>
                            </td>

                            <td>
                                <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-2">
                                    Administrador
                                </span>
                            </td>

                            <td>01/05/2026</td>

                            <td>
                                <span class="badge bg-success-subtle text-success rounded-pill px-3 py-2">
                                    Activo
                                </span>
                            </td>

                            <td class="text-center align-middle">
                                <div class="d-flex justify-content-center align-items-center gap-2">

                                    <a href="{{ route('usuarios.edit', 1) }}"
                                       class="btn btn-sm btn-warning rounded-pill px-3 text-white">
                                        <i class="bi bi-pencil"></i>
                                    </a>

                                    <button type="button"
                                            class="btn btn-sm btn-danger rounded-pill px-3"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modalEliminarUsuario"
                                            data-id="1"
                                            data-usuario="admin">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td class="ps-4">2</td>

                            <td>
                                <div class="fw-semibold">recepcion</div>
                                <small class="text-muted">Usuario recepción</small>
                            </td>

                            <td>
                                <span class="text-muted">Persona #2</span>
                            </td>

                            <td>
                                <span class="badge bg-info-subtle text-info rounded-pill px-3 py-2">
                                    Recepcionista
                                </span>
                            </td>

                            <td>28/04/2026</td>

                            <td>
                                <span class="badge bg-success-subtle text-success rounded-pill px-3 py-2">
                                    Activo
                                </span>
                            </td>

                            <td class="text-center align-middle">
                                <div class="d-flex justify-content-center align-items-center gap-2">

                                    <a href="{{ route('usuarios.edit', 2) }}"
                                       class="btn btn-sm btn-warning rounded-pill px-3 text-white">
                                        <i class="bi bi-pencil"></i>
                                    </a>

                                    <button type="button"
                                            class="btn btn-sm btn-danger rounded-pill px-3"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modalEliminarUsuario"
                                            data-id="2"
                                            data-usuario="recepcion">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td class="ps-4">3</td>

                            <td>
                                <div class="fw-semibold">doctor</div>
                                <small class="text-muted">Usuario odontólogo</small>
                            </td>

                            <td>
                                <span class="text-muted">Persona #3</span>
                            </td>

                            <td>
                                <span class="badge bg-secondary-subtle text-secondary rounded-pill px-3 py-2">
                                    Odontólogo
                                </span>
                            </td>

                            <td>25/04/2026</td>

                            <td>
                                <span class="badge bg-danger-subtle text-danger rounded-pill px-3 py-2">
                                    Inactivo
                                </span>
                            </td>

                            <td class="text-center align-middle">
                                <div class="d-flex justify-content-center align-items-center gap-2">

                                    <a href="{{ route('usuarios.edit', 3) }}"
                                       class="btn btn-sm btn-warning rounded-pill px-3 text-white">
                                        <i class="bi bi-pencil"></i>
                                    </a>

                                    <button type="button"
                                            class="btn btn-sm btn-danger rounded-pill px-3"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modalEliminarUsuario"
                                            data-id="3"
                                            data-usuario="doctor">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-between align-items-center px-4 py-3 border-top">
                <span class="text-muted small">Mostrando 1–3 de 3 resultados</span>

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


<!-- Modal eliminar usuario -->
<div class="modal fade" id="modalEliminarUsuario" tabindex="-1" aria-labelledby="modalEliminarUsuarioLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow rounded-4">

            <div class="modal-header border-0 pb-0">
                <div class="d-flex align-items-center gap-2">
                    <div class="rounded-circle bg-danger bg-opacity-10 d-flex align-items-center justify-content-center"
                         style="width: 42px; height: 42px;">
                        <i class="bi bi-trash3-fill text-danger"></i>
                    </div>

                    <div>
                        <h5 class="modal-title fw-bold mb-0" id="modalEliminarUsuarioLabel">
                            Eliminar usuario
                        </h5>
                        <small class="text-muted">Esta acción no se puede deshacer</small>
                    </div>
                </div>

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>

            <div class="modal-body pt-3">
                <p class="mb-0">
                    ¿Estás seguro de que deseas eliminar el usuario
                    <strong id="nombreUsuarioEliminar">usuario</strong>?
                </p>
            </div>

            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">
                    Cancelar
                </button>

                <form id="formEliminarUsuario" action="{{ route('usuarios.destroy', 1) }}" method="POST">
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
    const modalEliminarUsuario = document.getElementById('modalEliminarUsuario');

    modalEliminarUsuario.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;

        const id = button.getAttribute('data-id');
        const usuario = button.getAttribute('data-usuario');

        document.getElementById('nombreUsuarioEliminar').textContent = usuario;

        const form = document.getElementById('formEliminarUsuario');
        form.action = `/usuarios/${id}`;
    });
</script>

@endsection