<!-- MODAL CREAR TRATAMIENTO -->
<div class="modal fade" id="modalCrearTratamiento" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow rounded-4">

            <div class="modal-header border-0 pb-0">
                <div>
                    <h5 class="fw-bold mb-0">Crear tratamiento</h5>

                </div>

                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body pt-4">

                <div class="row g-3">

                    <div class="col-md-6">
                        <label class="form-label">Procedimiento</label>
                        <input type="text"
                               class="form-control consulta-input"
                               placeholder="Buscar procedimiento...">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Cantidad</label>
                        <input type="number"
                               class="form-control consulta-input"
                               value="1">
                    </div>

                    <div class="col-12">
                        <label class="form-label">Observación</label>
                        <textarea rows="4"
                                  class="form-control consulta-input consulta-textarea"
                                  placeholder="Describe observaciones o seguimiento del tratamiento"></textarea>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Estado</label>
                        <select class="form-select consulta-input">
                            <option>En proceso</option>
                            <option>Pendiente</option>
                            <option>Finalizado</option>
                        </select>
                    </div>

                </div>

            </div>

            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">
                    Cancelar
                </button>

                <button type="button" class="btn btn-primary rounded-pill px-4">
                    Guardar tratamiento
                </button>
            </div>

        </div>
    </div>
</div>
