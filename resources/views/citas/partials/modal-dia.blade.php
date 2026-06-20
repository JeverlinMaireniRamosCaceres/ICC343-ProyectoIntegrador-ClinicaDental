<div class="modal fade" id="modalCitasDia" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow rounded-4">

            <div class="modal-header border-0 pb-0 align-items-start">
                <div>
                    <h5 class="fw-bold mb-1">Citas del día</h5>
                    <small class="text-muted" id="modalCitasDiaFecha">
                        Viernes, 01 mayo 2026
                    </small>
                </div>

                <button type="button"
                    class="btn btn-light rounded-circle d-flex align-items-center justify-content-center"
                    style="width: 36px; height: 36px;" data-bs-dismiss="modal">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>

            <div class="modal-body pt-4">
                <div id="modalCitasDiaContenido" class="d-flex flex-column gap-3">
                    <div class="text-center py-4 text-muted">
                        <div class="spinner-border spinner-border-sm me-2"></div>
                        Cargando citas...
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>


<!-- Modal confirmar eliminación -->
<div class="modal fade" id="modalEliminarCita" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow rounded-4">

            <div class="modal-header border-0 pb-0">
                <div class="d-flex align-items-center gap-2">
                    <div class="rounded-circle bg-danger bg-opacity-10 d-flex align-items-center justify-content-center"
                        style="width: 42px; height: 42px;">
                        <i class="bi bi-x-lg text-danger"></i>
                    </div>

                    <div>
                        <h5 class="fw-bold mb-0">Cancelar cita</h5>
                        <small class="text-muted">Esta acción no se puede deshacer</small>
                    </div>
                </div>

                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body pt-3">
                <p class="mb-0">
                    ¿Estás seguro de que deseas cancelar la cita de
                    <strong id="nombreCitaEliminar">esta persona</strong>?
                </p>
            </div>

            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">
                    Cancelar
                </button>

                <form id="formEliminarCita" action="{{ route('citas.destroy', 1) }}" method="POST">
                    @csrf
                    @method('DELETE')

                    <button type="submit" class="btn btn-danger rounded-pill px-4">
                        Confirmar cancelación
                    </button>
                </form>
            </div>

        </div>
    </div>
</div>