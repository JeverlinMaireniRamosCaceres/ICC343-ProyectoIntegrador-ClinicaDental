<!-- modal anular factura -->

<div class="modal fade" id="modalAnularFactura" tabindex="-1" aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content border-0 shadow rounded-4">

            <div class="modal-header border-0 pb-0">

                <div class="d-flex align-items-center gap-2">

                    <div class="rounded-circle bg-danger bg-opacity-10 d-flex align-items-center justify-content-center"
                        style="width: 42px; height: 42px;">

                        <i class="bi bi-x-octagon text-danger"></i>

                    </div>

                    <div>
                        <h5 class="fw-bold mb-0">Anular factura</h5>
                    </div>

                </div>

                <button type="button" class="btn-close" data-bs-dismiss="modal">
                </button>

            </div>

            <div class="modal-body pt-3">

                <p class="mb-3">
                    ¿Está seguro de que desea anular esta factura?
                </p>

                <div class="mb-0">

                    <label for="motivoAnulacion" class="form-label fw-semibold">
                        Motivo de la anulación
                    </label>

                    <textarea class="form-control" id="motivoAnulacion" name="motivo" rows="3"
                        placeholder="Ingrese el motivo de la anulación..." required></textarea>

                </div>

            </div>

            <div class="modal-footer border-0 pt-0">

                <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">

                    Cancelar

                </button>

                <form id="formAnularFactura" method="POST">

                    @csrf
                    @method('PATCH')

                    <button type="submit" class="btn btn-danger rounded-pill px-4">

                        Anular

                    </button>

                </form>

            </div>

        </div>

    </div>

</div>
