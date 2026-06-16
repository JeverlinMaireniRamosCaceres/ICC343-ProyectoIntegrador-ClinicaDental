
<!-- Modal eliminar procedimiento -->
<div class="modal fade" id="modalEliminarProcedimiento" tabindex="-1" aria-labelledby="modalEliminarProcedimientoLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow rounded-4">

            <div class="modal-header border-0 pb-0">
                <div class="d-flex align-items-center gap-2">
                    <div class="rounded-circle bg-danger bg-opacity-10 d-flex align-items-center justify-content-center"
                         style="width: 42px; height: 42px;">
                        <i class="bi bi-ban text-danger"></i>
                    </div>

                    <div>
                        <h5 class="modal-title fw-bold mb-0" id="modalEliminarOdontologoLabel">
                            Eliminar procedimiento
                        </h5>
                    </div>
                </div>

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>

            <div class="modal-body pt-3">
                <p class="mb-0">
                    ¿Estás seguro de que deseas eliminar
                    <strong id="nombreProcedimientoEliminar">este procedimiento</strong>?
                </p>
            </div>

            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">
                    Cancelar
                </button>

                <form id="formEliminarProcedimiento" method="POST">
                    @csrf
                    @method('DELETE')

                    <button type="submit" class="btn btn-danger rounded-pill px-4">
                        Eliminar
                    </button>
                </form>
            </div>

        </div>
    </div>

</div>
