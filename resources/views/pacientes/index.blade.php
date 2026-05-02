@extends('layouts.app')

@section('title', 'Pacientes')

@section('content')
<div class="container-fluid py-4 px-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-dark mb-0">Pacientes</h2>

        <div class="d-flex align-items-center gap-2">
            <div class="input-group rounded-pill bg-white shadow-sm" style="width: 280px;">
                <span class="input-group-text bg-transparent border-0 ps-3">
                    <i class="bi bi-search text-muted"></i>
                </span>
                <input type="text" class="form-control border-0 bg-transparent" placeholder="Buscar paciente...">
            </div>

            <a href="{{ route('pacientes.create') }}" class="btn btn-primary rounded-pill px-4">
                <i class="bi bi-plus-lg me-2"></i>Nuevo
            </a>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-md-6 col-xl-4">
            <div class="card border-0 shadow-sm rounded-4 h-100 paciente-card">
                <div class="card-body p-4">
                    
                    <div class="mb-3">
                        <h5 class="fw-bold mb-1">Juan Martínez</h5>
                    </div>

                    <div class="patient-info mb-4">
                        <p class="mb-2">
                            <i class="bi bi-person-vcard me-2 text-muted"></i>
                            <span>402-0000000-1</span>
                        </p>
                        <p class="mb-2">
                            <i class="bi bi-telephone me-2 text-muted"></i>
                            <span>809-555-0123</span>
                        </p>
                        <p class="mb-2">
                            <i class="bi bi-envelope me-2 text-muted"></i>
                            <span>juan@email.com</span>
                        </p>
                        <p class="mb-0">
                            <i class="bi bi-calendar-event me-2 text-muted"></i>
                            <span>28 años</span>
                        </p>
                    </div>

                    <div class="d-flex justify-content-end gap-2">
                        <a href="{{ route('pacientes.show', 1) }}" class="btn btn-sm btn-secondary rounded-pill px-3">
                            <i class="bi bi-eye"></i>
                        </a>

                        <a href="{{ route('pacientes.edit', 1) }}" class="btn btn-sm btn-warning text-white rounded-pill px-3">
                            <i class="bi bi-pencil-fill"></i>
                        </a>

                        <button type="button"
                                class="btn btn-sm btn-danger rounded-pill px-3"
                                data-bs-toggle="modal"
                                data-bs-target="#modalEliminarPaciente"
                                data-id="1"
                                data-nombre="Juan Martínez">
                            <i class="bi bi-trash-fill"></i>
                        </button>


                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center mt-4 px-1">
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

<div class="modal fade" id="modalEliminarPaciente" tabindex="-1" aria-labelledby="modalEliminarPacienteLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow rounded-3">

            <div class="modal-header border-0 pb-0">
                <div class="d-flex align-items-center gap-2">
                    <div class="rounded-circle bg-danger bg-opacity-10 d-flex align-items-center justify-content-center"
                         style="width: 40px; height: 40px;">
                        <i class="bi bi-trash3-fill text-danger" style="font-size: 16px;"></i>
                    </div>

                    <h5 class="modal-title fw-semibold mb-0" id="modalEliminarPacienteLabel">
                        Eliminar paciente
                    </h5>
                </div>

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>

            <div class="modal-body pt-3">
                <p class="text-muted mb-0">
                    ¿Estás seguro de que deseas eliminar <strong id="modalNombrePaciente">este paciente</strong>?
                </p>
            </div>

            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">
                    Cancelar
                </button>

                <form id="formEliminarPaciente" method="POST" action="{{ route('pacientes.destroy', 1) }}">
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