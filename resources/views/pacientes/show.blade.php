@extends('layouts.app')

@section('title', 'Detalle Paciente')

@section('content')
<div class="container-fluid py-4">
    <!-- Perfil Encabezado -->
    <div class="card border-0 shadow-sm rounded-4 mb-4">
        <div class="card-body p-4">
            <div class="d-flex align-items-center">
                <div class="bg-info rounded-circle me-4 d-flex align-items-center justify-content-center text-white" style="width: 80px; height: 80px; font-size: 2rem;">
                    JM
                </div>
                <div class="flex-grow-1">
                    <h2 class="fw-bold text-dark mb-1">Juan Martínez</h2>
                    <div class="d-flex flex-wrap gap-3">
                        <span class="badge bg-light text-muted fw-normal"><i class="bi bi-card-text me-1 text-info"></i> 402-0000000-1</span>
                        <span class="badge bg-light text-muted fw-normal"><i class="bi bi-telephone me-1 text-info"></i> 809-555-0123</span>
                        <span class="badge bg-light text-muted fw-normal"><i class="bi bi-envelope me-1 text-info"></i> juan.m@email.com</span>
                        <span class="badge bg-light text-muted fw-normal"><i class="bi bi-calendar-event me-1 text-info"></i> 28 años</span>
                    </div>
                </div>
                <button class="btn btn-outline-info rounded-pill px-4">Editar Perfil</button>
            </div>
        </div>
    </div>

    <!-- Pestañas de Información -->
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-white border-0 p-0">
            <ul class="nav nav-tabs nav-tabs-custom px-4" id="pacienteTab" role="tablist">
                <li class="nav-item">
                    <button class="nav-link active border-0 py-3 fw-bold" data-bs-toggle="tab" data-bs-target="#info">Información General</button>
                </li>
                <li class="nav-item">
                    <button class="nav-link border-0 py-3 fw-bold" data-bs-toggle="tab" data-bs-target="#historia">Alergias y Antecedentes</button>
                </li>
                <li class="nav-item">
                    <button class="nav-link border-0 py-3 fw-bold" data-bs-toggle="tab" data-bs-target="#citas">Citas</button>
                </li>
            </ul>
        </div>
        <div class="tab-content p-4">
            <!-- Pestaña Info General -->
            <div class="tab-pane fade show active" id="info">
                <div class="row">
                    <div class="col-md-6 mb-4">
                        <label class="text-muted small fw-bold">Nombre Completo</label>
                        <p class="fw-semibold">Juan Martínez Espinal</p>
                    </div>
                    <!-- Más detalles aquí... -->
                </div>
            </div>
            <!-- Pestaña Alergias -->
            <div class="tab-pane fade" id="historia">
                <div class="p-3 bg-danger bg-opacity-10 rounded-3 mb-3 border-start border-danger border-4">
                    <h6 class="text-danger fw-bold"><i class="bi bi-exclamation-triangle me-2"></i>Alergias</h6>
                    <p class="mb-0">Alergia severa a la Penicilina.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .nav-tabs-custom .nav-link { color: #64748b; border-bottom: 3px solid transparent !important; }
    .nav-tabs-custom .nav-link.active { color: #0ea5e9; border-bottom: 3px solid #0ea5e9 !important; }
</style>
@endsection