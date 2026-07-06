@php
    $esRecibo = session('tipoDocumento') === 'recibo';

    $rutaCorreo = $esRecibo ? route('pagos.correo', session('idPago')) : route('facturacion.correo', $factura);
@endphp

<div class="modal fade" id="modalEnviarCorreo" tabindex="-1" aria-labelledby="tituloModalCorreo" aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered modal-sm-max">

        <div class="modal-content border-0 rounded-4 overflow-hidden" style="box-shadow: 0 20px 60px rgba(0,0,0,0.2);">

            <form id="formEnviarCorreo" method="POST" action="{{ $rutaCorreo }}">

                @csrf

                <div class="d-flex justify-content-between align-items-start px-3 pt-3">

                    <div class="d-flex align-items-center justify-content-center rounded-3"
                        style="width: 40px; height: 40px; background-color: #eff6ff;">

                        <i class="bi bi-envelope" style="font-size: 1.1rem; color: #0ea5e9;"></i>

                    </div>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>

                </div>

                <div class="px-3 pt-2">

                    <h6 class="fw-semibold mb-1" id="tituloModalCorreo" style="font-size:1rem; color:#0f172a;">

                        {{ $esRecibo ? 'Enviar recibo por correo' : 'Enviar factura por correo' }}

                    </h6>

                    <p class="mb-3" style="font-size:.845rem;color:#64748b;">

                        Confirme el correo al que desea enviar
                        {{ $esRecibo ? 'el recibo' : 'la factura' }}.

                    </p>

                    <div class="mb-3">

                        <label class="form-label fw-semibold">

                            Correo electrónico

                        </label>

                        <input type="email" class="form-control rounded-3" id="correoDocumento" name="correo"
                            required>

                    </div>

                </div>

                <div class="px-3 pb-3 d-flex justify-content-end gap-2">

                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">

                        Cancelar

                    </button>

                    <button type="submit" class="btn btn-medical-primary rounded-pill px-4" id="btnEnviarCorreo">

                        Enviar

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>
