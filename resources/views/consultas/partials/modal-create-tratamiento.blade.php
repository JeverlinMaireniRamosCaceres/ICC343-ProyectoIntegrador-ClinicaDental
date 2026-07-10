<div class="modal fade" id="modalCrearTratamiento" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
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

                    <h6 class="mt-4">Procedimientos planificados</h6>

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
                    </div>

                    <button type="button" class="btn btn-outline-primary rounded-pill"
                        onclick="abrirAgregarProcedimiento('planTratamiento')">

                        Agregar procedimiento

                    </button>

                </div>
            </div>

            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary rounded-pill px-4" id="btnGuardarTratamiento">
                    Guardar tratamiento
                </button>
            </div>

        </div>
    </div>
</div>