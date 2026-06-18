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
                            <select name="idOdontologo" class="form-select border-secondary-subtle bg-white">
                                <option selected disabled>Seleccionar odontólogo</option>
                                @foreach($odontologos as $odontologo)
                                    <option value="{{ $odontologo->idOdontologo }}">
                                        {{ $odontologo->persona->nombre }} {{ $odontologo->persona->apellido }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Nombre de la persona</label>
                            <input type="text" name="nombrePersona"
                                class="form-control border-secondary-subtle bg-white" placeholder="Ej: Ana Martínez">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Teléfono</label>
                            <input type="text" name="telefono" class="form-control border-secondary-subtle bg-white"
                                placeholder="Ej: 809-555-1234">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Correo</label>
                            <input type="email" name="correo" class="form-control border-secondary-subtle bg-white"
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