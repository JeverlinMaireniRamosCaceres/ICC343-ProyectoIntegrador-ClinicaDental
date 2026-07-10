<div class="modal fade" id="modalNuevaCita" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow rounded-4">

            <div class="modal-header border-0 pb-0">
                <div>
                    <h5 class="fw-bold mb-0">Registrar cita</h5>
                </div>

                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ route('citas.store') }}" method="POST">
                @csrf

                <div class="modal-body pt-4">

                    <div class="appointment-summary rounded-4 p-3 mb-4">

                        @if ($errors->has('hora'))
                            <div class="alert alert-danger rounded-3 py-2 px-3 mb-3" style="font-size:13px;">
                                <i class="bi bi-exclamation-circle me-1"></i>
                                {{ $errors->first('hora') }}
                            </div>
                        @endif

                        <div class="row g-3">

                            <div class="col-md-6">
                                <small class="text-muted d-block">Fecha seleccionada</small>
                                <span class="fw-semibold" id="modalFechaTexto">-</span>
                                <input type="hidden" name="fecha" id="modalFechaInput">
                            </div>

                            <div class="col-md-6">
                                <small class="text-muted d-block">Estado</small>
                                <span class="badge bg-warning-subtle text-warning rounded-pill px-3 py-2">
                                    Pendiente
                                </span>
                                <input type="hidden" name="estado" value="Pendiente">
                            </div>

                        </div>
                    </div>

                    <div class="row g-3">

                        <div class="col-md-6">
                            <label class="form-label">Hora</label>
                            <input type="time" name="hora" class="form-control border-secondary-subtle bg-white">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Odontólogo</label>

                            <div class="position-relative">
                                <input type="text" id="odontologo_nombre" class="form-control pe-5"
                                    placeholder="Buscar odontólogo..." autocomplete="off">

                                <i
                                    class="bi bi-search position-absolute top-50 end-0 translate-middle-y me-3 text-muted"></i>
                            </div>

                            <div id="resultadosOdontologos" class="list-group mt-1 shadow-sm">
                            </div>

                            <input type="hidden" name="idOdontologo" id="odontologo_id">
                        </div>

                        <div class="col-12">
                            <label class="form-label">Nombre de la persona</label>
                            <input type="text" name="nombrePersona"
                                class="form-control border-secondary-subtle bg-white" placeholder="Ej: Ana Martínez">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Teléfono</label>
                            <input type="text" name="telefono"
                                class="form-control border-secondary-subtle bg-white mask-telefono-rd"
                                placeholder="Ej: 809-555-1234">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Correo</label>
                            <input type="email" name="correo" class="form-control border-secondary-subtle bg-white"
                                placeholder="Ej: paciente@email.com">
                        </div>

                        <div class="col-12">
                            <label class="form-label">¿Por dónde desea recibir el recordatorio?</label>
                            <div class="d-flex gap-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="medioRecordatorio"
                                        id="medioCorreo" value="correo" checked>
                                    <label class="form-check-label" for="medioCorreo">Correo</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="medioRecordatorio"
                                        id="medioWhatsapp" value="whatsapp">
                                    <label class="form-check-label" for="medioWhatsapp">WhatsApp</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="medioRecordatorio"
                                        id="medioAmbos" value="ambos">
                                    <label class="form-check-label" for="medioAmbos">Ambos</label>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

                <div class="modal-footer border-0 pt-0">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">
                        Cancelar
                    </button>

                    <button type="submit" class="btn rounded-pill px-4 text-white" style="background-color: #0ea5e9;">
                        <i class="bi bi-floppy"></i>
                        Guardar
                    </button>

                </div>

            </form>

        </div>
    </div>
</div>