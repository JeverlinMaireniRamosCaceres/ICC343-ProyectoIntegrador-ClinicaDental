<div class="modal fade" id="modalCrearTratamiento" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow rounded-4">

            <div class="modal-header border-0 pb-0">
                <h5 class="fw-bold mb-0">Crear tratamiento</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body pt-4">
                <div class="row g-3">

                    <!-- paciente / readonly, se llena automatico -->
                    <div class="col-12">
                        <label class="form-label">Paciente</label>
                        <input type="text" id="tratamientoPacienteNombre" class="form-control consulta-readonly"
                            readonly placeholder="Selecciona un paciente primero">
                    </div>

                    <!-- nombre del tratamiento -->
                    <div class="col-12">
                        <label class="form-label">Nombre del tratamiento</label>
                        <input type="text" id="tratamientoNombre" class="form-control consulta-input"
                            placeholder="Ej: Ortodoncia, Implante, Blanqueamiento...">
                    </div>

                    <!-- fecha de inicio -->
                    <div class="col-md-6">
                        <label class="form-label">Fecha de inicio</label>
                        <input type="date" id="tratamientoFechaInicio" class="form-control consulta-input"
                            value="{{ now()->format('Y-m-d') }}">
                    </div>

                    <!-- estado -->
                    <div class="col-md-6">
                        <label class="form-label">Estado</label>
                        <select id="tratamientoEstado" class="form-select consulta-input">
                            <option value="Activo">Activo</option>
                            <option value="En proceso">En proceso</option>
                            <option value="Finalizado">Finalizado</option>
                        </select>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mt-4 mb-2">
                        <h6 class="mb-0">Procedimientos planificados</h6>
                        <button type="button" class="btn btn-outline-primary btn-sm rounded-pill px-3"
                            onclick="abrirAgregarProcedimiento('planTratamiento')">
                            <i class="bi bi-plus-lg me-1"></i> Agregar procedimiento
                        </button>
                    </div>

                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead>
                                <tr>
                                    <th>Procedimiento</th>
                                    <th>Cantidad</th>
                                    <th>Observación</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="cuerpoPlanTratamiento">
                                <tr id="filaVaciaPlan">
                                    <td colspan="4" class="text-center text-muted">
                                        No hay procedimientos agregados.
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <div class="d-flex justify-content-end mt-3">
                            <h5 class="mb-0">
                                Total estimado:
                                <span id="totalPlanTratamiento" class="text-primary fw-bold">
                                    RD$ 0.00
                                </span>
                            </h5>
                        </div>

                    </div>

                </div>
            </div>

            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn rounded-pill px-4 text-white" style="background-color: #0ea5e9;" id="btnGuardarTratamiento">
                    Guardar tratamiento
                </button>
            </div>

        </div>
    </div>
</div>