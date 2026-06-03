<!-- MODAL Proveedores -->

    <div class="modal fade" id="modalProveedores" tabindex="-1">

        <div class="modal-dialog modal-lg modal-dialog-centered">

            <div class="modal-content border-0 shadow rounded-3">

                <div class="modal-header">
                    <h5 class="modal-title fw-semibold">
                        Seleccionar proveedor
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
                        <input type="text" id="buscarProveedor" class="border-0 bg-transparent p-0 w-100"
                            style="outline: none; font-size: 14px;" placeholder="Buscar proveedor...">
                    </div>

                    <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                        <table class="table table-hover align-middle mb-0">

                            <thead class="table-light sticky-top">
                                <tr>
                                    <th class="px-3 py-3 text-muted fw-semibold small">Proveedor</th>
                                    <th class="px-3 py-3"></th>
                                </tr>
                            </thead>

                            <tbody id="tablaProveedores">
                                @foreach ($proveedores as $proveedor)
                                    <tr>
                                        <td class="fw-medium">{{ $proveedor->nombre }}</td>
                                        <td class="text-end">
                                            <button type="button"
                                                class="btn btn-sm btn-primary rounded-pill px-3 btnSeleccionarProveedor"
                                                style="width: 50px; height: 38px;"
                                                data-id="{{ $proveedor->idProveedor }}"
                                                data-nombre="{{ $proveedor->nombre }}">

                                                <i class="bi bi-check-lg"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach

                                <tr id="sinResultados" style="display: none;">
                                    <td colspan="2" class="text-center text-muted py-4">
                                        No se encontraron proveedores.
                                    </td>
                                </tr>
                            </tbody>

                        </table>
                    </div>

                </div>

            </div>

        </div>

    </div>
