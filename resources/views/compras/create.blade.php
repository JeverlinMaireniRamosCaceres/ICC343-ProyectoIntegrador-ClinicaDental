@extends('layouts.app')

@section('title', 'Nueva Compra')

@section('content')
    <div class="container py-4">

        <div class="d-flex align-items-center gap-3 mb-4">
            <a href="{{ route('compras.index') }}" class="btn btn-sm btn-light rounded-pill px-3">
                <i class="bi bi-arrow-left"></i>
            </a>
            <h2 class="fw-semibold mb-0">Nueva Compra</h2>
        </div>

        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-body p-4">

                <form action="#" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label text-muted fw-semibold small">Proveedor</label>
                        <select name="idProveedor" class="form-select">
                            <option selected disabled>Seleccione un proveedor</option>
                            <option value="1">Dental Depot</option>
                            <option value="2">Odonto Supply</option>
                            <option value="3">Medident SRL</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-muted fw-semibold small">Fecha</label>
                        <input type="date" name="fecha" class="form-control">
                    </div>

                    <div class="mb-4">
                        <label class="form-label text-muted fw-semibold small">Estado</label>
                        <select name="estado" class="form-select">
                            <option value="Pendiente">Pendiente</option>
                            <option value="Completada">Completada</option>
                            <option value="Cancelada">Cancelada</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="form-label text-muted fw-semibold small">Detalle de compra</label>

                        <div class="table-responsive">
                            <table class="table table-bordered align-middle mb-0">

                                <thead class="table-light">
                                    <tr>
                                        <th class="small text-muted">Producto</th>
                                        <th class="small text-muted">Cantidad</th>
                                        <th class="small text-muted">Precio Unitario</th>
                                        <th class="small text-muted">Subtotal</th>
                                        <th class="small text-muted">Fecha Vencimiento</th>
                                        <th class="small text-muted text-center">Acciones</th>
                                    </tr>
                                </thead>

                                <tbody id="detalleBody">

                                    <tr>

                                        <td>
                                            <input type="text" class="form-control form-control-sm producto-input"
                                                placeholder="Buscar producto..." readonly data-bs-toggle="modal"
                                                data-bs-target="#modalProductos">
                                        </td>

                                        <td>
                                            <input type="number" class="form-control form-control-sm" value="1">
                                        </td>

                                        <td>
                                            <input type="number" class="form-control form-control-sm" value="0">
                                        </td>

                                        <td>
                                            <input type="number" class="form-control form-control-sm" value="0"
                                                readonly>
                                        </td>

                                        <td>
                                            <input type="date" class="form-control form-control-sm">
                                        </td>

                                        <td class="text-center">
                                            <button type="button" class="btn btn-sm btn-danger btnEliminarFila">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </td>

                                    </tr>

                                </tbody>

                            </table>
                        </div>

                        <div class="mt-2">
                            <button type="button" class="btn btn-sm btn-outline-primary px-3" id="btnAgregarFila">
                                <i class="bi bi-plus-lg"></i> Agregar producto
                            </button>
                        </div>

                    </div>

                    <div class="mb-4">
                        <label class="form-label text-muted fw-semibold small">Monto total</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted">
                                RD$
                            </span>
                            <input type="number" name="monto" class="form-control border-start-0" placeholder="0.00"
                                step="0.01" min="0" readonly>
                        </div>
                    </div>

                    <div class="d-flex gap-2 justify-content-end">
                        <a href="{{ route('compras.index') }}" class="btn btn-light rounded-pill px-4">
                            Cancelar
                        </a>
                        <button type="submit" class="btn btn-primary rounded-pill px-4">
                            <i class="bi bi-floppy"></i> Guardar
                        </button>
                    </div>

                </form>

            </div>
        </div>

    </div>

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

                <div class="modal-body p-4">

                    <div class="d-flex align-items-center gap-2 px-3 py-2 bg-light rounded-pill border border-transparent mb-3"
                        style="transition: border-color 0.2s;"
                        onfocusin="this.style.background='#fff'; this.style.borderColor='#2563EB';"
                        onfocusout="this.style.background=''; this.style.borderColor='transparent';">
                        <i class="bi bi-search text-secondary" style="font-size: 14px;"></i>
                        <input type="text" class="border-0 bg-transparent p-0 w-100"
                            style="outline: none; font-size: 14px;" placeholder="Buscar producto...">
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="px-3 py-3 text-muted fw-semibold small">ID</th>
                                    <th class="px-3 py-3 text-muted fw-semibold small">Producto</th>
                                    <th class="px-3 py-3"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="px-3 text-muted">1</td>
                                    <td class="px-3 fw-medium">Guantes Latex</td>
                                    <td class="px-3 text-end">
                                        <button class="btn btn-sm btn-primary rounded-pill px-3">
                                            <i class="bi bi-check2 me-1"></i> Seleccionar
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-3 text-muted">2</td>
                                    <td class="px-3 fw-medium">Mascarillas</td>
                                    <td class="px-3 text-end">
                                        <button class="btn btn-sm btn-primary rounded-pill px-3">
                                            <i class="bi bi-check2 me-1"></i> Seleccionar
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-3 text-muted">3</td>
                                    <td class="px-3 fw-medium">Anestesia</td>
                                    <td class="px-3 text-end">
                                        <button class="btn btn-sm btn-primary rounded-pill px-3">
                                            <i class="bi bi-check2 me-1"></i> Seleccionar
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>

            </div>

        </div>

    </div>

@endsection

@section('scripts')

    <script>
        const detalleBody = document.getElementById('detalleBody');
        const btnAgregarFila = document.getElementById('btnAgregarFila');

        // AGREGAR FILA

        btnAgregarFila.addEventListener('click', () => {

            let fila = `
                <tr>

                    <td>
                        <input type="text"
                        class="form-control form-control-sm producto-input"
                        placeholder="Buscar producto..."
                        readonly
                        data-bs-toggle="modal"
                        data-bs-target="#modalProductos">
                    </td>

                <td>
                    <input type="number"
                    class="form-control form-control-sm"
                    value="1">
                </td>

                <td>
                    <input type="number"
                    class="form-control form-control-sm"
                    value="0">
                </td>

                <td>
                    <input type="number"
                    class="form-control form-control-sm"
                    value="0"
                    readonly>
                </td>

                <td>
                    <input type="date"
                    class="form-control form-control-sm">
                </td>

                <td class="text-center">
                    <button type="button"
                    class="btn btn-sm btn-danger btnEliminarFila">
                    <i class="bi bi-trash"></i>
                    </button>
                </td>

                </tr>
            `;

            detalleBody.insertAdjacentHTML('beforeend', fila);

        });

        // ELIMINAR FILA

        detalleBody.addEventListener('click', function(e) {

            if (e.target.closest('.btnEliminarFila')) {

                const fila = e.target.closest('tr');

                if (detalleBody.rows.length > 1) {

                    fila.remove();

                }

            }

        });
    </script>

@endsection
