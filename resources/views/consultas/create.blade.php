@extends('layouts.app')

@section('title', 'Nueva consulta')

@section('content')

<div class="container-fluid py-4 px-5 consulta-page">

    <!-- Header -->
    <div class="d-flex align-items-center gap-3 mb-4">

        <a href="{{ route('consultas.index') }}"
           class="btn btn-light rounded-circle shadow-sm d-flex align-items-center justify-content-center"
           style="width: 42px; height: 42px;">
            <i class="bi bi-arrow-left"></i>
        </a>

        <div>
            <h2 class="fw-bold text-dark mb-0">Nueva consulta</h2>
            <small class="text-muted">
                Registra la información clínica de la atención odontológica
            </small>
        </div>

    </div>

    <form action="{{ route('consultas.store') }}" method="POST">
        @csrf

        <div class="card border-0 shadow-sm rounded-4">

            <!-- Tabs -->
            <div class="card-header bg-white border-0 p-0">
                <ul class="nav consulta-tabs px-4" role="tablist">

                    <li class="nav-item">
                        <button class="nav-link active"
                                data-bs-toggle="tab"
                                data-bs-target="#datosGenerales"
                                type="button">
                            <i class="bi bi-person-lines-fill me-2"></i>
                            Datos generales
                        </button>
                    </li>

                    <li class="nav-item">
                        <button class="nav-link"
                                data-bs-toggle="tab"
                                data-bs-target="#evaluacionClinica"
                                type="button">
                            <i class="bi bi-clipboard2-pulse me-2"></i>
                            Evaluación
                        </button>
                    </li>

                    <li class="nav-item">
                        <button class="nav-link"
                                data-bs-toggle="tab"
                                data-bs-target="#procedimientos"
                                type="button">
                            <i class="bi bi-clipboard2-plus me-2"></i>
                            Procedimientos
                        </button>
                    </li>

                    <li class="nav-item">
                        <button class="nav-link"
                                data-bs-toggle="tab"
                                data-bs-target="#tratamiento"
                                type="button">
                            <i class="bi bi-activity me-2"></i>
                            Tratamiento
                        </button>
                    </li>

                    <li class="nav-item">
                        <button class="nav-link"
                                data-bs-toggle="tab"
                                data-bs-target="#resumen"
                                type="button">
                            <i class="bi bi-check2-circle me-2"></i>
                            Resumen
                        </button>
                    </li>

                </ul>
            </div>

            <div class="card-body p-4">

                <div class="tab-content">

                    <!-- tab datos generales -->
                    <div class="tab-pane fade show active" id="datosGenerales">

                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div>
                                <h5 class="consulta-section-title mb-1">Datos generales</h5>
                            </div>

                            <button type="button"
                                    class="btn btn-outline-primary rounded-pill px-4"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modalCrearPaciente">
                                <i class="bi bi-plus-lg me-1"></i>
                                Crear paciente
                            </button>
                        </div>

                        <div class="row g-3">

                            <div class="col-md-6">
                                <label class="form-label">Paciente</label>
                                <div class="position-relative">
                                    <input type="text"
                                           class="form-control consulta-input pe-5"
                                           placeholder="Buscar paciente...">
                                    <i class="bi bi-search position-absolute top-50 end-0 translate-middle-y me-3 text-muted"></i>
                                </div>
                                <input type="hidden" name="idPaciente">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Odontólogo</label>
                                <div class="position-relative">
                                    <input type="text"
                                           class="form-control consulta-input pe-5"
                                           placeholder="Buscar odontólogo...">
                                    <i class="bi bi-search position-absolute top-50 end-0 translate-middle-y me-3 text-muted"></i>
                                </div>
                                <input type="hidden" name="idOdontologo">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Fecha</label>

                                <input type="date"
                                    name="fecha"
                                    class="form-control consulta-input consulta-readonly"
                                    value="{{ now()->format('Y-m-d') }}"
                                    readonly>
                            </div>

                            <div class="col-md-6">
                                <label class="form-label">Estado</label>
                                <input type="text"
                                       name="estado"
                                       class="form-control consulta-input consulta-readonly"
                                       value="Registrada"
                                       readonly>
                            </div>

                        </div>

                    </div>

                    <!-- tab evaluacion clinica -->
                    <div class="tab-pane fade" id="evaluacionClinica">

                        <div class="mb-4">
                            <h5 class="consulta-section-title mb-1">Evaluación clínica</h5>
                        </div>

                        <div class="row g-3">

                            <div class="col-12">
                                <label class="form-label">Motivo de consulta</label>
                                <textarea name="motivo"
                                          rows="3"
                                          class="form-control consulta-input consulta-textarea"
                                          placeholder="Describe el motivo principal de la consulta"></textarea>
                            </div>

                            <div class="col-12">
                                <label class="form-label">Diagnóstico</label>
                                <textarea name="diagnostico"
                                          rows="4"
                                          class="form-control consulta-input consulta-textarea"
                                          placeholder="Describe el diagnóstico clínico"></textarea>
                            </div>

                            <div class="col-12">
                                <label class="form-label">Receta / indicaciones</label>
                                <textarea name="receta"
                                          rows="4"
                                          class="form-control consulta-input consulta-textarea"
                                          placeholder="Medicamentos, recomendaciones o indicaciones"></textarea>
                            </div>

                        </div>

                    </div>

                    <!-- tab procedimientos -->
                    <div class="tab-pane fade" id="procedimientos">

                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div>
                                <h5 class="consulta-section-title mb-1">Procedimientos realizados</h5>
                            </div>

                            <button type="button" class="btn btn-primary rounded-pill px-4">
                                <i class="bi bi-plus-lg me-1"></i>
                                Agregar procedimiento
                            </button>
                        </div>

                        <div class="table-responsive">
                            <table class="table align-middle mb-0 consulta-table">

                                <thead>
                                    <tr>
                                        <th>Procedimiento</th>
                                        <th>Cantidad</th>
                                        <th>Precio</th>
                                        <th>Subtotal</th>
                                        <th class="text-center">Acción</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <tr>
                                        <td>Limpieza dental</td>

                                        <td width="130">
                                            <input type="number"
                                                   class="form-control consulta-input"
                                                   value="1">
                                        </td>

                                        <td>RD$ 1,500.00</td>

                                        <td class="fw-semibold">RD$ 1,500.00</td>

                                        <td class="text-center">
                                            <button type="button"
                                                    class="btn btn-sm btn-danger rounded-pill px-3">
                                                <i class="bi bi-x-lg"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>

                            </table>
                        </div>

                    </div>

                    <!-- tab tratamiento -->
                    <div class="tab-pane fade" id="tratamiento">

                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div>
                                <h5 class="consulta-section-title mb-1">Tratamiento</h5>
                            </div>

                            <button type="button"
                                    class="btn btn-outline-primary rounded-pill px-4"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modalCrearTratamiento">
                                <i class="bi bi-plus-lg me-1"></i>
                                Crear tratamiento
                            </button>
                        </div>

                        <div class="consulta-empty-state rounded-4 p-4 text-center">
                            <div class="rounded-circle bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center mx-auto mb-3"
                                 style="width: 56px; height: 56px;">
                                <i class="bi bi-clipboard2-pulse fs-4"></i>
                            </div>

                            <h6 class="fw-bold mb-1">No hay tratamiento asociado</h6>
                            <p class="text-muted mb-0">
                                Puedes crear un tratamiento si la consulta requiere seguimiento.
                            </p>
                        </div>

                    </div>

                    <!-- tab resumen -->
                    <div class="tab-pane fade" id="resumen">

                        <div class="mb-4">
                            <h5 class="consulta-section-title mb-1">Resumen de la consulta</h5>
                        </div>

                        <div class="row g-4">

                            <div class="col-lg-8">

                                <div class="consulta-summary rounded-4 p-4">

                                    <div class="row g-3">

                                        <div class="col-md-6">
                                            <small class="text-muted d-block">Paciente</small>
                                            <span class="fw-semibold">Ana Martínez</span>
                                        </div>

                                        <div class="col-md-6">
                                            <small class="text-muted d-block">Odontólogo</small>
                                            <span class="fw-semibold">Dr. Juan Pérez</span>
                                        </div>

                                        <div class="col-md-6">
                                            <small class="text-muted d-block">Fecha</small>
                                            <span class="fw-semibold">10/05/2026</span>
                                        </div>

                                        <div class="col-md-6">
                                            <small class="text-muted d-block">Estado</small>
                                            <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-2">
                                                Registrada
                                            </span>
                                        </div>

                                        <div class="col-md-6">
                                            <small class="text-muted d-block">Procedimientos</small>
                                            <span class="fw-semibold">1</span>
                                        </div>

                                        <div class="col-md-6">
                                            <small class="text-muted d-block">Total consulta</small>
                                            <span class="fw-bold text-primary">RD$ 1,500.00</span>
                                        </div>

                                    </div>

                                </div>

                            </div>

                            <div class="col-lg-4">

                                <div class="consulta-alert rounded-4 small p-3 mb-3">
                                    Revisa la información antes de guardar.
                                    Las consultas registradas no podrán editarse posteriormente.
                                </div>

                                <button type="submit"
                                        class="btn btn-primary w-100 rounded-pill py-2">
                                    Guardar consulta
                                </button>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </form>

</div>

@endsection