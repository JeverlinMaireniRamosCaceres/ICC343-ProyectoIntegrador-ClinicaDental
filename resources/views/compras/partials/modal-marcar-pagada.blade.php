<!-- modal marcar compra pagada -->

<div class="modal fade" id="modalMarcarPagada" tabindex="-1" aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content border-0 shadow rounded-4">

            <div class="modal-header border-0 pb-0">

                <div class="d-flex align-items-center gap-2">

                    <div class="rounded-circle bg-success bg-opacity-10 d-flex align-items-center justify-content-center"
                        style="width: 42px; height: 42px;">

                        <i class="bi bi-check-circle text-success"></i>

                    </div>

                    <div>
                        <h5 class="fw-bold mb-0">Marcar compra como pagada</h5>
                    </div>

                </div>

                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>

            </div>

            <div class="modal-body pt-3">

                <p class="mb-0">
                    ¿Estás seguro de que deseas marcar esta compra como pagada?
                </p>

            </div>

            <div class="modal-footer border-0 pt-0">

                <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">

                    Cancelar

                </button>

                <form id="formMarcarPagada" method="POST">

                    @csrf
                    @method('PATCH')

                    <input type="hidden" name="return_url" value="{{ url()->full() }}">

                    <button type="submit" class="btn btn-success rounded-pill px-4">

                        Confirmar

                    </button>

                </form>

            </div>

        </div>

    </div>

</div>
