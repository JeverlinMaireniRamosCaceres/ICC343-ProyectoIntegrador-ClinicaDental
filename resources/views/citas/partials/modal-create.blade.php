<div class="modal fade" id="modalNuevaCita" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow rounded-4">

            <div class="modal-header border-0 pb-0">
                <div>
                    <h5 class="fw-bold mb-0">Registrar cita</h5>
                    <small class="text-muted">Completa los datos de la persona</small>
                </div>

                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ route('citas.store') }}" method="POST">
                @csrf

                <div class="modal-body pt-4">

                    <!-- Resumen precargado -->
                    <div class="appointment-summary rounded-4 p-3 mb-4">

                        <div class="row g-3">

                            <div class="col-md-6">
                                <small class="text-muted d-block">Fecha</small>
                                <span class="fw-semibold" id="modalFechaTexto">-</span>
                                <input type="hidden" name="fecha" id="modalFechaInput">
                            </div>

                            <div class="col-md-6">
                                <small class="text-muted d-block">Hora</small>
                                <span class="fw-semibold" id="modalHoraTexto">-</span>
                                <input type="hidden" name="hora" id="modalHoraInput">
                            </div>

                            <div class="col-md-8">
                                <small class="text-muted d-block">Odontólogo</small>
                                <span class="fw-semibold" id="modalOdontologoTexto">-</span>
                                <input type="hidden" name="idOdontologo" id="modalOdontologoInput">
                            </div>

                            <div class="col-md-4">
                                <small class="text-muted d-block">Estado</small>
                                <span class="badge bg-warning-subtle text-warning rounded-pill">
                                    Pendiente
                                </span>
                                <input type="hidden" name="estado" value="Pendiente">
                            </div>

                        </div>

                    </div>

                    <!-- Datos del paciente/persona -->
                    <div class="row g-3">

                        <div class="col-12">
                            <label class="form-label">Nombre de la persona</label>
                            <input type="text"
                                   name="nombrePersona"
                                   class="form-control border-secondary-subtle bg-white"
                                   placeholder="Ej: Ana Martínez">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Teléfono</label>
                            <input type="text"
                                   name="telefono"
                                   class="form-control border-secondary-subtle bg-white"
                                   placeholder="Ej: 809-555-1234">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Correo</label>
                            <input type="email"
                                   name="correo"
                                   class="form-control border-secondary-subtle bg-white"
                                   placeholder="Ej: paciente@email.com">
                        </div>

                    </div>

                </div>

                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">
                        Cancelar
                    </button>

                    <button type="submit" class="btn btn-primary rounded-pill px-4">
                        Guardar cita
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>