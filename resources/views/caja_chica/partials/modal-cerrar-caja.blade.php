<div class="modal fade" id="modalCerrarCaja" tabindex="-1">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content border-0 shadow rounded-3">

            <div class="modal-header border-0 pb-0">

                <div class="d-flex align-items-center gap-2">

                    <div class="rounded-circle bg-secondary bg-opacity-10 d-flex align-items-center justify-content-center"
                        style="width:40px;height:40px;">

                        <i class="bi bi-lock-fill text-secondary" style="font-size:16px;"></i>

                    </div>

                    <h5 class="modal-title fw-semibold mb-0">
                        Cerrar caja
                    </h5>

                </div>

                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>

            </div>

            <div class="modal-body pt-3">

                <form id="formCerrarCaja" method="POST" action="{{ route('caja-chica.cerrar', $caja->idCajaChica) }}">

                    @csrf

                    <div class="mb-3">

                        <label class="form-label small text-muted fw-semibold">
                            Monto contado
                        </label>

                        <div class="input-group">

                            <span class="input-group-text bg-light border-end-0 text-muted">
                                RD$
                            </span>

                            <input type="number" name="montoContado" id="montoContado"
                                class="form-control border-start-0" placeholder="0.00" step="0.01" min="0"
                                value="{{ old('montoContado') }}">

                        </div>

                        @error('montoContado')
                            <div class="text-danger small mt-1">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>

                </form>

                <div class="bg-light rounded-3 p-3">

                    <div class="d-flex justify-content-between">

                        <span class="small text-muted">
                            Saldo sistema
                        </span>

                        <span class="fw-semibold" id="saldoSistema" data-saldo="{{ $caja->monto }}">
                            RD$ {{ number_format($caja->monto, 2) }}
                        </span>

                    </div>

                    <div class="d-flex justify-content-between">

                        <span class="small text-muted">
                            Diferencia
                        </span>

                        <span class="fw-bold" id="diferenciaCaja">
                            RD$ 0.00
                        </span>

                    </div>

                </div>

            </div>

            <div class="modal-footer border-0 pt-0">

                <button class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">

                    Cancelar

                </button>

                <button type="submit" form="formCerrarCaja" class="btn btn-secondary rounded-pill px-4"
                    id="btnConfirmarCierre" disabled>

                    <i class="bi bi-lock-fill me-1"></i>

                    Confirmar cierre

                </button>

            </div>

        </div>

    </div>

</div>
