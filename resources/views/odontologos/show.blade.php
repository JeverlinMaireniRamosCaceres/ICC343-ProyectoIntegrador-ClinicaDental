@extends('layouts.app')

@section('title', 'Detalle Odontólogo')

@section('content')
<div class="container-fluid py-4 px-5">

    <!-- Header -->
    <div class="d-flex align-items-center mb-4">
        <a href="{{ route('odontologos.index') }}" class="btn btn-light btn-sm rounded-pill me-3">
            <i class="bi bi-arrow-left"></i>
        </a>

        <h2 class="fw-bold text-dark mb-0">Detalle del odontólogo</h2>
    </div>

    <!-- Card perfil -->
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-4">

            <div class="d-flex align-items-center">

                <!-- Icono -->
                <div class="patient-icon me-4">
                    <i class="bi bi-person-badge"></i>
                </div>

                <!-- Info -->
                <div class="flex-grow-1">
                    <h2 class="fw-bold text-dark mb-1">Dr. Juan Pérez</h2>

                    <div class="d-flex flex-wrap gap-3">

                        <span class="badge bg-light text-muted fw-normal">
                            <i class="bi bi-award me-1 text-primary"></i>
                            Exequatur: 12345
                        </span>

                    </div>
                </div>

            </div>

        </div>
    </div>

    <!-- Tabs  -->
    <div class="card border-0 shadow-sm rounded-4">

        <div class="card-header bg-white border-0 p-0">
            <ul class="nav patient-tabs px-4" role="tablist">

                <li class="nav-item">
                    <button class="nav-link active"
                            data-bs-toggle="tab"
                            data-bs-target="#info">
                        Información general
                    </button>
                </li>

                <li class="nav-item">
                    <button class="nav-link"
                            data-bs-toggle="tab"
                            data-bs-target="#contacto">
                        Contacto
                    </button>
                </li>

                <li class="nav-item">
                    <button class="nav-link"
                            data-bs-toggle="tab"
                            data-bs-target="#profesional">
                        Información profesional
                    </button>
                </li>

            </ul>
        </div>

        <div class="tab-content p-4">

            <!-- Información General -->
        <div class="tab-pane fade show active" id="info">

            <div class="row g-4">

                <div class="col-md-4">
                    <span class="text-muted small fw-bold">Nombre</span>
                    <p class="fw-semibold mb-0">Juan</p>
                </div>

                <div class="col-md-4">
                    <span class="text-muted small fw-bold">Apellido</span>
                    <p class="fw-semibold mb-0">Pérez</p>
                </div>

                <div class="col-md-4">
                    <span class="text-muted small fw-bold">Cédula</span>
                    <p class="fw-semibold mb-0">001-1234567-8</p>
                </div>

                <div class="col-md-4">
                    <span class="text-muted small fw-bold">Fecha de nacimiento</span>
                    <p class="fw-semibold mb-0">12/05/1990</p>
                </div>

                <div class="col-md-4">
                    <span class="text-muted small fw-bold">Teléfono</span>
                    <p class="fw-semibold mb-0">809-555-1234</p>
                </div>

                <div class="col-md-4">
                    <span class="text-muted small fw-bold">Correo</span>
                    <p class="fw-semibold mb-0">juan@email.com</p>
                </div>

            </div>

        </div>

            <!-- Contacto -->
            <div class="tab-pane fade" id="contacto">

                <div class="row g-4">

                    <div class="col-md-4">
                        <span class="text-muted small fw-bold">Teléfono</span>
                        <p class="fw-semibold mb-0">809-555-1234</p>
                    </div>

                    <div class="col-md-4">
                        <span class="text-muted small fw-bold">Correo electrónico</span>
                        <p class="fw-semibold mb-0">juan.perez@email.com</p>
                    </div>

                </div>

            </div>

            <!-- Profesional -->
            <div class="tab-pane fade" id="profesional">

                <div class="row g-4">

                    <!-- Exequatur -->
                    <div class="col-md-4">
                        <span class="text-muted small fw-bold">Exequatur</span>
                        <p class="fw-semibold mb-0">12345</p>
                    </div>

                    <!-- Especialidades -->
                    <div class="col-12">
                        <span class="text-muted small fw-bold">Especialidades</span>

                        <div class="mt-2 d-flex flex-wrap gap-2">

                            <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-2">
                                Ortodoncia
                            </span>

                            <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-2">
                                Endodoncia
                            </span>

                            <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-2">
                                Odontología general
                            </span>

                        </div>
                    </div>

                </div>

            </div>

            </div>

        </div>

    </div>

</div>
@endsection