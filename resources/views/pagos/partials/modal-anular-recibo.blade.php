<div class="modal fade" id="modalAnularPago" tabindex="-1">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content border-0 shadow rounded-4">

            <div class="modal-header border-0 pb-0">

                <div class="d-flex align-items-center gap-2">

                    <div class="rounded-circle bg-danger bg-opacity-10 d-flex align-items-center justify-content-center"
                        style="width:40px;height:40px;">

                        <i class="bi bi-x-octagon text-danger" style="font-size:16px;"></i>

                    </div>

                    <h5 class="modal-title fw-semibold mb-0">
                        Anular recibo
                    </h5>

                </div>

                <button type="button" class="btn-close" data-bs-dismiss="modal">
                </button>

            </div>

            <div class="modal-body pt-3">

                <div class="alert alert-warning border-0 rounded-3 py-2 mb-3">

                    <div class="d-flex align-items-start gap-2">

                        <i class="bi bi-exclamation-triangle-fill text-warning fs-5"></i>

                        <div class="small">

                            Se anularán todas las cuotas asociadas a este recibo y estas volverán a quedar pendientes
                            para que puedan ser cobradas otra vez.

                        </div>

                    </div>

                </div>

                <form id="formAnularPago" method="POST">

                    @csrf
                    @method('PATCH')

                    <input type="hidden" name="return" value="{{ url()->full() }}">

                    <div class="mb-3">

                        <label class="form-label small text-muted fw-semibold">
                            Motivo de la anulación
                        </label>

                        <textarea name="observacion" id="observacionAnulacion" class="form-control" rows="4"
                            placeholder="Escriba el motivo de la anulación..." required></textarea>

                        @error('observacion')
                            <div class="text-danger small mt-1">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                </form>

            </div>

            <div class="modal-footer border-0 pt-0">

                <button class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">

                    Cancelar

                </button>

                <button type="submit" form="formAnularPago" class="btn btn-danger rounded-pill px-4">

                    <i class="bi bi-x-octagon me-1"></i>

                    Anular recibo

                </button>

            </div>

        </div>

    </div>

</div>
