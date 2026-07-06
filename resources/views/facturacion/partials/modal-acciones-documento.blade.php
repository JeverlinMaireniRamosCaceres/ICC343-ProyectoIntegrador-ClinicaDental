<div class="modal fade" id="modalDocumento" tabindex="-1" aria-labelledby="tituloModalDocumento" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm-max">
        <div class="modal-content border-0 rounded-4 overflow-hidden" style="box-shadow: 0 20px 60px rgba(0,0,0,0.2);">

            <div class="d-flex justify-content-between align-items-start px-3 pt-3">
                <div class="d-flex align-items-center justify-content-center rounded-3"
                    style="width: 40px; height: 40px; background-color: #eff6ff;">
                    <i class="bi bi-file-earmark-check" style="font-size: 1.1rem; color: #0ea5e9;"></i>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>

            <div class="px-3 pt-2">
                <h6 class="fw-semibold mb-1" id="tituloModalDocumento" style="font-size: 1rem; color: #0f172a;">
                    <span id="numeroFacturaModal">
                        FAC-{{ str_pad($factura->idFactura, 6, '0', STR_PAD_LEFT) }}
                    </span> generada correctamente
                </h6>
                <p class="mb-0" id="mensajeModalDocumento"
                    style="font-size: 0.845rem; color: #64748b; line-height: 1.5;">
                    Se registró correctamente por <span id="totalFacturaModal">
                        RD$ {{ number_format($factura->total, 2) }}
                    </span>. Elige qué hacer a continuación.
                </p>
            </div>

            <div class="px-2 pt-3 pb-1" style="margin-bottom: 20px;">
                <button type="button"
                    class="btn w-100 d-flex align-items-center gap-3 text-start border-0 rounded-3 py-2 px-2 mb-1"
                    id="btnDocumentoImprimir" data-url="{{ route('facturacion.pdf', $factura) }}"
                    style="background: transparent;" onmouseover="this.style.background='#f8fafc'"
                    onmouseout="this.style.background='transparent'">
                    <div class="d-flex align-items-center justify-content-center rounded-3 flex-shrink-0"
                        style="width: 34px; height: 34px; background-color: #f1f5f9;">
                        <i class="bi bi-printer" style="font-size: 1rem; color: #334155;"></i>
                    </div>
                    <div class="flex-grow-1">
                        <div class="fw-semibold" style="font-size: 0.875rem; color: #1e293b;">Imprimir factura</div>
                    </div>
                    <i class="bi bi-chevron-right" style="font-size: 0.9rem; color: #cbd5e1;"></i>
                </button>

                <button type="button"
                    class="btn w-100 d-flex align-items-center gap-3 text-start border-0 rounded-3 py-2 px-2"
                    id="btnDocumentoCorreo" data-correo="{{ $factura->consulta->paciente->persona->correo ?? '' }}"
                    style="background: transparent;" onmouseover="this.style.background='#f8fafc'"
                    onmouseout="this.style.background='transparent'">
                    <div class="d-flex align-items-center justify-content-center rounded-3 flex-shrink-0"
                        style="width: 34px; height: 34px; background-color: #f1f5f9;">
                        <i class="bi bi-envelope" style="font-size: 1rem; color: #334155;"></i>
                    </div>
                    <div class="flex-grow-1">
                        <div class="fw-semibold" style="font-size: 0.875rem; color: #1e293b;">Enviar por correo</div>
                    </div>
                    <i class="bi bi-chevron-right" style="font-size: 0.9rem; color: #cbd5e1;"></i>
                </button>
            </div>

        </div>
    </div>
</div>
