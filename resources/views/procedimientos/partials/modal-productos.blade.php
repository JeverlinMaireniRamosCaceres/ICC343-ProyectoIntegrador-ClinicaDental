<div class="modal fade" id="modalProductos" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow rounded-4">
            <div class="modal-header border-bottom-0 pb-0">
                <h5 class="modal-title fw-bold">Buscar producto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body p-4 d-flex flex-column" style="height: 500px;">
                <div class="d-flex align-items-center gap-2 px-3 py-2 bg-light rounded-pill border border-transparent mb-3"
                    style="transition: border-color 0.2s;"
                    id="contenedorBuscadorModal">
                    <i class="bi bi-search text-muted" style="font-size: 14px;"></i>
                    <input type="text" id="buscarProductoModal" class="border-0 bg-transparent p-0 w-100"
                        style="outline: none; font-size: 14px;" placeholder="Buscar producto por nombre...">
                </div>

                <div class="table-responsive flex-grow-1" style="overflow-y: auto;">
                    <table class="table table-hover align-middle mb-0" id="tablaProductosModal">
                        <tbody id="cuerpoProductosModal">
                            @foreach ($productos as $producto)
                                <tr>
                                    <td class="fw-medium px-3">{{ $producto->nombre }}</td>
                                    <td class="text-secondary small">{{ $producto->unidadMedida }}</td>
                                    <td class="text-end px-3">
                                        <button type="button"
                                            class="btn btn-sm btn-primary rounded-pill px-3 btnSeleccionarProducto"
                                            style="width: 50px; height: 38px;" 
                                            data-id="{{ $producto->idProducto }}"
                                            data-nombre="{{ $producto->nombre }}"
                                            data-unidad="{{ $producto->unidadMedida }}">
                                            <i class="bi bi-circle"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach

                            <tr id="sinResultadosProductosModal" style="display: none;">
                                <td colspan="3" class="text-center text-muted py-5">
                                    <i class="bi bi-box-seam d-block fs-3 mb-2"></i>
                                    No se encontraron productos coincidentes.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>