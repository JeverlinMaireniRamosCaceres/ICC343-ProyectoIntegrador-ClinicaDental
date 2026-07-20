<!-- MODAL PRODUCTOS -->

<div class="modal fade" id="modalProductos" tabindex="-1">

    <div class="modal-dialog modal-lg modal-dialog-centered">

        <div class="modal-content border-0 shadow rounded-3">

            <div class="modal-header">
                <h5 class="modal-title fw-semibold">
                    Buscar producto
                </h5>

                <button type="button" class="btn-close" data-bs-dismiss="modal">
                </button>
            </div>

            <div class="modal-body p-4 d-flex flex-column" style="height: 550px;">

                <div class="d-flex align-items-center gap-2 px-3 py-2 bg-light rounded-pill border border-transparent mb-3"
                    style="transition: border-color 0.2s;"
                    onfocusin="this.style.background='#fff'; this.style.borderColor='#2563EB';"
                    onfocusout="this.style.background=''; this.style.borderColor='transparent';">
                    <i class="bi bi-search text-secondary" style="font-size: 14px;"></i>
                    <input type="text" id="buscarProducto" class="border-0 bg-transparent p-0 w-100"
                        style="outline: none; font-size: 14px;" placeholder="Buscar producto...">
                </div>

                <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light sticky-top">
                            <tr>
                                <th class="px-3 py-3 text-muted fw-semibold small">Producto</th>
                                <th class="px-3 py-3"></th>
                            </tr>
                        </thead>
                        <tbody id="tablaProductos">
                            @foreach ($productos as $producto)
                                <tr>
                                    <td class="fw-medium">{{ $producto->nombre }}</td>
                                    <td class="text-end">
                                        <button type="button"
                                            class="btn btn-sm btn-primary rounded-pill px-3 btnSeleccionarProducto"
                                            style="width: 50px; height: 38px;" data-id="{{ $producto->idProducto }}"
                                            data-nombre="{{ $producto->nombre }}"
                                            data-unidad="{{ $producto->unidadMedida }}">

                                            <i class="bi bi-circle"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach

                            <tr id="sinResultadosProductos" style="display: none;">
                                <td colspan="2" class="text-center text-muted py-4">
                                    No se encontraron productos.
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>

        </div>

    </div>

</div>
