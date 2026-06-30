@extends('layouts.app')

@section('title', 'Nueva consulta')

@section('content')

    <div class="container-fluid py-4 px-3 consulta-page">

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

            <div class="accordion d-flex flex-column gap-3" id="consultaAccordion">

                <!-- 1. Datos generales -->
                <div class="accordion-item border-0 shadow-sm rounded-4 overflow-hidden">
                    <h2 class="accordion-header">
                        <button class="accordion-button rounded-4 fw-semibold" type="button" data-bs-toggle="collapse"
                            data-bs-target="#secDatosGenerales">
                            <i class="bi bi-person-lines-fill me-2 text-primary"></i>
                            Datos generales
                        </button>
                    </h2>
                    <div id="secDatosGenerales" class="accordion-collapse collapse show"
                        data-bs-parent="#consultaAccordion">
                        <div class="accordion-body px-3 py-3">

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
                    </div>
                </div>

                <!-- 2. Evaluación clínica -->
                <div class="accordion-item border-0 shadow-sm rounded-4 overflow-hidden">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed rounded-4 fw-semibold" type="button"
                            data-bs-toggle="collapse" data-bs-target="#secEvaluacion">
                            <i class="bi bi-clipboard2-pulse me-2 text-primary"></i>
                            Evaluación clínica
                        </button>
                    </h2>
                    <div id="secEvaluacion" class="accordion-collapse collapse" data-bs-parent="#consultaAccordion">
                        <div class="accordion-body px-3 py-3">

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
                    </div>
                </div>

                <!-- 3. Tratamiento -->
                <div class="accordion-item border-0 shadow-sm rounded-4 overflow-hidden">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed rounded-4 fw-semibold" type="button"
                            data-bs-toggle="collapse" data-bs-target="#secTratamiento">
                            <i class="bi bi-activity me-2 text-primary"></i>
                            Tratamiento
                        </button>
                    </h2>
                    <div id="secTratamiento" class="accordion-collapse collapse" data-bs-parent="#consultaAccordion">
                        <div class="accordion-body px-3 py-3">

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
                                <p class="text-muted mb-0">Los tratamientos aparecerán aquí una vez
                                    selecciones el paciente.
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
                                    <p class="text-muted mb-0">Puedes crear un tratamiento nuevo para este
                                        paciente.</p>
                                </div>

                                <!-- lista de tratamientos -->
                                <div id="listaTratamientos" class="d-flex flex-column gap-2"></div>

                                <input type="hidden" name="idTratamiento" id="tratamiento_id">

                            </div>

                        </div>
                    </div>
                </div>

                <!-- 4. Procedimientos -->
                <div class="accordion-item border-0 shadow-sm rounded-4 overflow-hidden">
                    <h2 class="accordion-header">
                        <button class="accordion-button collapsed rounded-4 fw-semibold" type="button"
                            data-bs-toggle="collapse" data-bs-target="#secProcedimientos">
                            <i class="bi bi-clipboard2-plus me-2 text-primary"></i>
                            Procedimientos
                        </button>
                    </h2>
                    <div id="secProcedimientos" class="accordion-collapse collapse" data-bs-parent="#consultaAccordion">
                        <div class="accordion-body px-3 py-3">

                            <div class="mb-4">
                                <h5 class="consulta-section-title mb-1">Procedimientos</h5>
                            </div>

                            <!-- toggle para elegir tipo -->
                            <div class="d-flex gap-2 mb-4">
                                <button type="button" id="btnTipoIndependiente"
                                    class="btn btn-sm rounded-pill px-4 btn-tipo-proc active" data-tipo="independiente">
                                    <i class="bi bi-file-medical me-1"></i>
                                    De esta consulta
                                </button>
                                <button type="button" id="btnTipoTratamiento"
                                    class="btn btn-sm rounded-pill px-4 btn-tipo-proc" data-tipo="tratamiento">
                                    <i class="bi bi-activity me-1"></i>
                                    Del tratamiento
                                </button>
                            </div>

                            <!-- tabla procedimientos independientes -->
                            <div id="seccionProcIndependientes">
                                <p class="text-muted small mb-2">
                                    Procedimientos realizados solo en esta consulta.
                                </p>
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
                                <div class="d-flex justify-content-between align-items-center mt-3">
                                    <button type="button" class="btn btn-medical-primary rounded-pill px-4 shadow-sm"
                                        data-bs-toggle="modal" data-bs-target="#modalAgregarProcedimiento"
                                        data-destino="independiente">
                                        <i class="bi bi-plus-lg me-1"></i>
                                        Agregar procedimiento
                                    </button>
                                    <div class="d-flex align-items-center gap-3 px-4 py-3 rounded-4"
                                        style="background:#f8fafc; border:1px solid #e2e8f0;">
                                        <span class="text-muted fw-semibold">Total:</span>
                                        <span class="fw-bold fs-5 text-primary" id="totalProcedimientos">RD$ 0.00</span>
                                    </div>
                                </div>
                            </div>

                            <!-- tabla procedimientos del tratamiento -->
                            <div id="seccionProcTratamiento" style="display:none;">

                                <div id="procTratSinTratamiento" class="consulta-empty-state rounded-4 p-4 text-center">
                                    <i class="bi bi-activity fs-1 d-block mb-2 text-muted"></i>
                                    <h6 class="fw-bold mb-1">Sin tratamiento seleccionado</h6>
                                    <p class="text-muted mb-0">Selecciona o crea un tratamiento en la sección de
                                        Tratamiento.</p>
                                </div>

                                <div id="procTratConTratamiento" style="display:none;">
                                    <p class="text-muted small mb-2">
                                        Procedimientos realizados en esta consulta que forman parte del tratamiento.
                                    </p>
                                    <div class="table-responsive">
                                        <table class="table align-middle mb-0 consulta-table">
                                            <thead>
                                                <tr>
                                                    <th>Procedimiento</th>
                                                    <th>Cantidad</th>
                                                    <th>Precio</th>
                                                    <th>Subtotal</th>
                                                    <th>Observación</th>
                                                    <th class="text-center">Acción</th>
                                                </tr>
                                            </thead>
                                            <tbody id="cuerpoProcTratamiento">
                                                <tr id="filaVaciaTrat">
                                                    <td colspan="6" class="text-center py-4 text-muted">
                                                        <i class="bi bi-clipboard2-x fs-3 d-block mb-2"></i>
                                                        No hay procedimientos del tratamiento.
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>

                                        <div class="d-flex justify-content-end mt-3">
                                            <div class="d-flex align-items-center gap-3 px-4 py-3 rounded-4"
                                                style="background:#f8fafc; border:1px solid #e2e8f0;">
                                                <span class="text-muted fw-semibold">Total tratamiento:</span>
                                                <span class="fw-bold fs-5 text-primary" id="totalProcTratamiento">RD$
                                                    0.00</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mt-3">
                                        <button type="button" class="btn btn-outline-primary rounded-pill px-4"
                                            data-bs-toggle="modal" data-bs-target="#modalAgregarProcedimiento"
                                            data-destino="tratamiento">
                                            <i class="bi bi-plus-lg me-1"></i>
                                            Agregar al tratamiento
                                        </button>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>



            </div>

            <!-- botón guardar + resumen inline -->
            <div class="card border-0 shadow-sm rounded-4 mt-4 bg-white">
                <div class="card-body p-4">
                    <div class="row align-items-center g-4">

                        <div class="col-lg-8">
                            <div class="row row-cols-2 row-cols-md-4 g-3 border-end border-light-subtlepe-3">
                                <div>
                                    <small class="text-muted d-block text-uppercase tracking-wider fw-semibold"
                                        style="font-size: 0.75rem;">Paciente</small>
                                    <span class="fw-bold text-dark" id="resumenPaciente">—</span>
                                </div>
                                <div>
                                    <small class="text-muted d-block text-uppercase tracking-wider fw-semibold"
                                        style="font-size: 0.75rem;">Odontólogo</small>
                                    <span class="fw-semibold text-dark">{{ $odontologo->persona->nombre }}
                                        {{ $odontologo->persona->apellido }}</span>
                                </div>
                                <div>
                                    <small class="text-muted d-block text-uppercase tracking-wider fw-semibold"
                                        style="font-size: 0.75rem;">Procedimientos</small>
                                    <span class="badge bg-light text-primary rounded-pill fw-bold px-3 py-2 mt-1"
                                        id="resumenProcedimientos" style="font-size: 0.9rem;">0</span>
                                </div>
                                <div>
                                    <small class="text-muted d-block text-uppercase tracking-wider fw-semibold"
                                        style="font-size: 0.75rem;">Total a pagar</small>
                                    <span class="fw-extrabold fs-5 text-primary d-block" id="resumenTotal">RD$
                                        0.00</span>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 d-flex flex-column justify-content-center text-lg-end">
                            <div class="text-muted small mb-2 d-flex align-items-center justify-content-lg-end gap-1">
                                <i class="bi bi-info-circle text-warning"></i> Revisa la información antes de guardar.
                            </div>
                            <button type="submit"
                                class="btn btn-primary w-100 rounded-pill py-2.5 fw-semibold shadow-sm transition-all">
                                <i class="bi bi-check-circle me-1"></i> Guardar consulta
                            </button>
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