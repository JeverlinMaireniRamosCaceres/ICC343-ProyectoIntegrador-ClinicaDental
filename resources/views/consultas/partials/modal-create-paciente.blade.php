<!-- MODAL CREAR PACIENTE -->
<div class="modal fade" id="modalCrearPaciente" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow rounded-4">

            <div class="modal-header border-0 pb-0">
                <div>
                    <h5 class="fw-bold mb-0">Crear paciente</h5>
                </div>

                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body pt-4">

                <div class="row g-3">

                    <div class="col-md-6">
                        <label class="form-label">Nombre</label>
                        <input type="text" class="form-control consulta-input" placeholder="Ej: Ana">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Apellido</label>
                        <input type="text" class="form-control consulta-input" placeholder="Ej: Martínez">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Cédula</label>
                        <input type="text" class="form-control consulta-input" placeholder="Ej: 001-1234567-8">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Fecha de nacimiento</label>
                        <input type="date" class="form-control consulta-input">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Teléfono</label>
                        <input type="text" class="form-control consulta-input" placeholder="Ej: 809-555-1234">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Correo</label>
                        <input type="email" class="form-control consulta-input" placeholder="Ej: paciente@email.com">
                    </div>

                </div>

            </div>

            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">
                    Cancelar
                </button>

                <button type="button" class="btn btn-primary rounded-pill px-4">
                    Guardar paciente
                </button>
            </div>

        </div>
    </div>
</div>
