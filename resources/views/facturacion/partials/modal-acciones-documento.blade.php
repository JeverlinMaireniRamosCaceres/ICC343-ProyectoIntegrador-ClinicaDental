@php
    $esRecibo = session('tipoDocumento') === 'recibo';

    $titulo = $esRecibo
        ? 'REC-' . str_pad(session('idPago'), 6, '0', STR_PAD_LEFT) . ' generado correctamente'
        : 'FAC-' . str_pad($factura->idFactura, 6, '0', STR_PAD_LEFT) . ' generada correctamente';

    $mensaje = $esRecibo
        ? 'Se registró un pago por RD$ ' .
            number_format(session('montoRecibo'), 2) .
            '. Elige qué hacer a continuación.'
        : 'Se registró correctamente por RD$ ' .
            number_format($factura->total, 2) .
            '. Elige qué hacer a continuación.';

    $textoImprimir = $esRecibo ? 'Imprimir recibo' : 'Imprimir factura';
    $textoCorreo = $esRecibo ? 'Enviar recibo por correo' : 'Enviar factura por correo';
    $textoPdf = $esRecibo ? 'Ver recibo PDF' : 'Ver factura PDF';

    $urlPdf = $esRecibo ? route('pagos.pdf', session('idPago')) : route('facturacion.pdf', $factura);
@endphp

<div class="modal fade" id="modalDocumento" tabindex="-1" aria-labelledby="tituloModalDocumento" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm-max">

        <div class="modal-content border-0 rounded-4 overflow-hidden" style="box-shadow: 0 20px 60px rgba(0,0,0,.2);">

            <div class="d-flex justify-content-between align-items-start px-3 pt-3">

                <div class="d-flex align-items-center justify-content-center rounded-3"
                    style="width:40px;height:40px;background:#eff6ff;">
                    <i class="bi bi-file-earmark-check" style="font-size:1.1rem;color:#0ea5e9;"></i>
                </div>

                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>

            </div>

            <div class="px-3 pt-2">

                <h6 class="fw-semibold mb-1" id="tituloModalDocumento" style="font-size:1rem;color:#0f172a;">

                    {{ $titulo }}

                </h6>

                <p class="mb-0" style="font-size:.845rem;color:#64748b;line-height:1.5;">

                    {{ $mensaje }}

                </p>

            </div>

            <div class="px-2 pt-3 pb-1" style="margin-bottom:20px;">

                {{-- Imprimir --}}
                <button type="button"
                    class="btn w-100 d-flex align-items-center gap-3 text-start border-0 rounded-3 py-2 px-2 mb-1"
                    id="btnDocumentoImprimir" data-url="{{ $urlPdf }}" style="background:transparent;"
                    onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='transparent'">

                    <div class="d-flex align-items-center justify-content-center rounded-3 flex-shrink-0"
                        style="width:34px;height:34px;background:#f1f5f9;">

                        <i class="bi bi-printer" style="font-size:1rem;color:#334155;"></i>

                    </div>

                    <div class="flex-grow-1">

                        <div class="fw-semibold" style="font-size:.875rem;color:#1e293b;">

                            {{ $textoImprimir }}

                        </div>

                    </div>

                    <i class="bi bi-chevron-right" style="font-size:.9rem;color:#cbd5e1;"></i>

                </button>

                {{-- Correo --}}
                <button type="button"
                    class="btn w-100 d-flex align-items-center gap-3 text-start border-0 rounded-3 py-2 px-2 mb-1"
                    id="btnDocumentoCorreo" data-correo="{{ $factura->consulta->paciente->persona->correo ?? '' }}"
                    style="background:transparent;" onmouseover="this.style.background='#f8fafc'"
                    onmouseout="this.style.background='transparent'">

                    <div class="d-flex align-items-center justify-content-center rounded-3 flex-shrink-0"
                        style="width:34px;height:34px;background:#f1f5f9;">

                        <i class="bi bi-envelope" style="font-size:1rem;color:#334155;"></i>

                    </div>

                    <div class="flex-grow-1">

                        <div class="fw-semibold" style="font-size:.875rem;color:#1e293b;">

                            {{ $textoCorreo }}

                        </div>

                    </div>

                    <i class="bi bi-chevron-right" style="font-size:.9rem;color:#cbd5e1;"></i>

                </button>


            </div>

        </div>

    </div>
</div>
