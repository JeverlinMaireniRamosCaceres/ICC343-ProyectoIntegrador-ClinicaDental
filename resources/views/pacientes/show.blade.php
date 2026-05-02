@extends('layouts.app')

@section('title', 'Detalle Paciente')

@section('content')
<div class="container-fluid py-4 px-5">

<div class="d-flex align-items-center mb-4">
    <a href="{{ route('pacientes.index') }}" class="btn btn-light btn-sm rounded-pill me-3">
        <i class="bi bi-arrow-left"></i>
    </a>

    <h2 class="fw-bold text-dark mb-0">Detalle del paciente</h2>
</div>

    <!-- Perfil Encabezado -->
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-4">
            <div class="d-flex align-items-center">

                <div class="patient-icon me-4">
                    <i class="bi bi-person-vcard"></i>
                </div>

                <div class="flex-grow-1">
                    <h2 class="fw-bold text-dark mb-1">Juan Martínez</h2>

                    <div class="d-flex flex-wrap gap-3">
                        <span class="badge bg-light text-muted fw-normal">
                            <i class="bi bi-card-text me-1 text-primary"></i> 402-0000000-1
                        </span>
                        <span class="badge bg-light text-muted fw-normal">
                            <i class="bi bi-telephone me-1 text-primary"></i> 809-555-0123
                        </span>
                        <span class="badge bg-light text-muted fw-normal">
                            <i class="bi bi-envelope me-1 text-primary"></i> juan.m@email.com
                        </span>
                        <span class="badge bg-light text-muted fw-normal">
                            <i class="bi bi-calendar-event me-1 text-primary"></i> 28 años
                        </span>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Pestañas de Información -->
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-white border-0 p-0">
            <ul class="nav patient-tabs px-4" id="pacienteTab" role="tablist">
                <li class="nav-item">
                    <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#info">
                        Información General
                    </button>
                </li>

                <li class="nav-item">
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#historia">
                        Alergias y Antecedentes
                    </button>
                </li>

                <li class="nav-item">
                    <button class="nav-link" data-bs-toggle="tab" data-bs-target="#fichaClinica">
                        Ficha Clínica
                    </button>
                </li>
            </ul>
        </div>

        <div class="tab-content p-4">
            <!-- Información General -->
            <div class="tab-pane fade show active" id="info">
                <div class="row g-4">
                    <div class="col-md-4">
                        <span class="text-muted small fw-bold">Nombre completo</span>
                        <p class="fw-semibold mb-0">Juan Martínez Espinal</p>
                    </div>

                    <div class="col-md-4">
                        <span class="text-muted small fw-bold">Cédula</span>
                        <p class="fw-semibold mb-0">402-0000000-1</p>
                    </div>

                    <div class="col-md-4">
                        <span class="text-muted small fw-bold">Teléfono</span>
                        <p class="fw-semibold mb-0">809-555-0123</p>
                    </div>

                    <div class="col-md-4">
                        <span class="text-muted small fw-bold">Correo</span>
                        <p class="fw-semibold mb-0">juan.m@email.com</p>
                    </div>

                    <div class="col-md-4">
                        <span class="text-muted small fw-bold">Fecha de nacimiento</span>
                        <p class="fw-semibold mb-0">01/05/1998</p>
                    </div>

                    <div class="col-md-4">
                        <span class="text-muted small fw-bold">Edad</span>
                        <p class="fw-semibold mb-0">28 años</p>
                    </div>
                </div>
            </div>

            <!-- Alergias y Antecedentes -->
            <div class="tab-pane fade" id="historia">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="p-3 bg-danger bg-opacity-10 rounded-3 border-start border-danger border-4">
                            <h6 class="text-danger fw-bold">
                                <i class="bi bi-exclamation-triangle me-2"></i>Alergias
                            </h6>
                            <p class="mb-0">Penicilina, Látex.</p>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="p-3 bg-light rounded-3 border">
                            <h6 class="fw-bold text-dark">
                                <i class="bi bi-clipboard2-pulse me-2 text-primary"></i>Antecedentes médicos
                            </h6>
                            <p class="mb-0 text-muted">Diabetes, Hipertensión.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Ficha clinica -->
            <div class="tab-pane fade" id="fichaClinica">
                <p class="text-muted mb-0">No hay ficha clínica registrada para este paciente.</p>
            </div>
        </div>
    </div>
</div>
@endsection