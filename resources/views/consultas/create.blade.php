@extends('layouts.app')

@section('title', 'Nueva consulta')

@section('content')

    <div class="container-fluid py-4 px-5 consulta-page">

        <!-- Header -->
        <div class="d-flex align-items-center gap-3 mb-4">

            <a href="{{ route('consultas.index') }}" class="btn btn-sm btn-light rounded-pill px-3">
                <i class="bi bi-arrow-left"></i>
            </a>

            <div>
                <h2 class="fw-bold text-dark mb-0">Nueva consulta</h2>
            </div>

        </div>

        <form action="{{ route('consultas.store') }}" method="POST">
            @csrf

            <div class="card border-0 shadow-sm rounded-4">

                <!-- Tabs -->
                <div class="card-header bg-white border-0 p-0">
                    <ul class="nav consulta-tabs px-4" role="tablist">

                        <li class="nav-item">
                            <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#datosGenerales"
                                type="button">
                                <i class="bi bi-person-lines-fill me-2"></i>
                                Datos generales
                            </button>
                        </li>

                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#evaluacionClinica" type="button">
                                <i class="bi bi-clipboard2-pulse me-2"></i>
                                Evaluación
                            </button>
                        </li>

                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#procedimientos" type="button">
                                <i class="bi bi-clipboard2-plus me-2"></i>
                                Procedimientos
                            </button>
                        </li>

                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tratamiento" type="button">
                                <i class="bi bi-activity me-2"></i>
                                Tratamiento
                            </button>
                        </li>

                        <li class="nav-item">
                            <button class="nav-link" data-bs-toggle="tab" data-bs-target="#resumen" type="button">
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

                                <button type="button" class="btn btn-outline-primary rounded-pill px-4"
                                    data-bs-toggle="modal" data-bs-target="#modalCrearPaciente">
                                    <i class="bi bi-plus-lg me-1"></i>
                                    Crear paciente
                                </button>
                            </div>

                            <div class="row g-3">

                                <!-- buscador paciente -->
                                <div class="col-md-6">
                                    <label class="form-label">Paciente</label>

                                    <div class="position-relative">
                                        <input type="text" id="paciente_nombre" class="form-control pe-5"
                                            placeholder="Buscar paciente..." autocomplete="off">

                                        <i
                                            class="bi bi-search position-absolute top-50 end-0 translate-middle-y me-3 text-muted"></i>
                                    </div>

                                    <div id="resultadosPacientes" class="list-group mt-1 shadow-sm position-absolute w-100"
                                        style="z-index: 9999;"></div>

                                    <input type="hidden" name="idPaciente" id="paciente_id">
                                </div>

                                <!-- odontologo fijo desde sesion -->
                                <div class="col-md-6">
                                    <label class="form-label">Odontólogo</label>

                                    <input type="text" class="form-control"
                                        value="{{ $odontologo->persona->nombre }} {{ $odontologo->persona->apellido }}"
                                        readonly>

                                    <input type="hidden" name="idOdontologo" value="{{ $odontologo->idOdontologo }}">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Fecha</label>

                                    <input type="date" name="fecha" class="form-control consulta-input consulta-readonly"
                                        value="{{ now()->format('Y-m-d') }}" readonly>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Estado</label>
                                    <input type="text" name="estado" class="form-control consulta-input consulta-readonly"
                                        value="Registrada" readonly>
                                </div>

                                <div class="col-12" id="contenedorAlergias" style="display:none;">
                                    <label class="form-label">Alergias del paciente</label>
                                    <div id="listaAlergias" class="d-flex flex-wrap gap-2 p-3 rounded-4"
                                        style="background:#fdecea; border: 1px solid #f5c2c7; min-height: 48px;">
                                    </div>
                                </div>

                                <!-- antecedentes del paciente -->
                                <div class="col-12" id="contenedorAntecedentes" style="display:none;">
                                    <label class="form-label">Antecedentes médicos</label>
                                    <div id="textoAntecedentes" class="p-3 rounded-4"
                                        style="background:#f8fafc; border:1px solid #e2e8f0; font-size:13.5px; min-height:48px;">
                                    </div>
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
                                    <textarea name="motivo" rows="3" class="form-control consulta-input consulta-textarea"
                                        placeholder="Describe el motivo principal de la consulta"></textarea>
                                </div>

                                <div class="col-12">
                                    <label class="form-label">Diagnóstico</label>
                                    <textarea name="diagnostico" rows="4"
                                        class="form-control consulta-input consulta-textarea"
                                        placeholder="Describe el diagnóstico clínico"></textarea>
                                </div>

                                <div class="col-12">
                                    <label class="form-label">Receta / indicaciones</label>
                                    <textarea name="receta" rows="4" class="form-control consulta-input consulta-textarea"
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

                                <button type="button" class="btn btn-medical-primary rounded-pill px-4 shadow-sm"
                                    data-bs-toggle="modal" data-bs-target="#modalAgregarProcedimiento">
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

                                    <tbody id="cuerpoTablaProc">
                                        <tr id="filaVaciaProc">
                                            <td colspan="5" class="text-center py-4 text-muted">
                                                <i class="bi bi-clipboard2-x fs-3 d-block mb-2"></i>
                                                No hay procedimientos agregados.
                                            </td>
                                        </tr>
                                    </tbody>

                                </table>
                            </div>

                            <!-- total de procedimientos -->
                            <div class="d-flex justify-content-end mt-3">
                                <div class="d-flex align-items-center gap-3 px-4 py-3 rounded-4"
                                    style="background:#f8fafc; border: 1px solid #e2e8f0;">
                                    <span class="text-muted fw-semibold">Total:</span>
                                    <span class="fw-bold fs-5 text-primary" id="totalProcedimientos">RD$ 0.00</span>
                                </div>
                            </div>

                        </div>

                        <!-- tab tratamiento -->
                        <div class="tab-pane fade" id="tratamiento">

                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div>
                                    <h5 class="consulta-section-title mb-1">Tratamiento</h5>
                                </div>
                                <button type="button" class="btn btn-outline-primary rounded-pill px-4"
                                    data-bs-toggle="modal" data-bs-target="#modalCrearTratamiento">
                                    <i class="bi bi-plus-lg me-1"></i>
                                    Crear tratamiento
                                </button>
                            </div>

                            <!-- estado inicial sin paciente -->
                            <div id="tratamientoSinPaciente" class="consulta-empty-state rounded-4 p-4 text-center">
                                <div class="rounded-circle bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center mx-auto mb-3"
                                    style="width: 56px; height: 56px;">
                                    <i class="bi bi-person fs-4"></i>
                                </div>
                                <h6 class="fw-bold mb-1">Selecciona un paciente primero</h6>
                                <p class="text-muted mb-0">Los tratamientos aparecerán aquí una vez selecciones el paciente.
                                </p>
                            </div>

                            <!-- tratamientos del paciente -->
                            <div id="tratamientoContenido" style="display:none;">

                                <!-- sin tratamientos -->
                                <div id="tratamientoVacio" class="consulta-empty-state rounded-4 p-4 text-center"
                                    style="display:none;">
                                    <div class="rounded-circle bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center mx-auto mb-3"
                                        style="width: 56px; height: 56px;">
                                        <i class="bi bi-clipboard2-pulse fs-4"></i>
                                    </div>
                                    <h6 class="fw-bold mb-1">No hay tratamientos activos</h6>
                                    <p class="text-muted mb-0">Puedes crear un tratamiento nuevo para este paciente.</p>
                                </div>

                                <!-- lista de tratamientos -->
                                <div id="listaTratamientos" class="d-flex flex-column gap-2"></div>

                                <input type="hidden" name="idTratamiento" id="tratamiento_id">

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

                                    <button type="submit" class="btn btn-primary w-100 rounded-pill py-2">
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

    <script src="{{ asset('js/consulta.js') }}"></script>
    @include('consultas.partials.modal-agregar-procedimiento')
    @include('consultas.partials.modal-create-tratamiento')
@endsection