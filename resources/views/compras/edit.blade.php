@extends('layouts.app')

@section('title', 'Editar Compra')

@section('content')
    <div class="container py-4">

        <div class="d-flex align-items-center gap-3 mb-4">
            <a href="{{ route('compras.index') }}" class="btn btn-sm btn-light rounded-pill px-3">
                <i class="bi bi-arrow-left"></i>
            </a>
            <h2 class="fw-semibold mb-0">Editar Compra</h2>
        </div>

        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-body p-4">

                <form action="{{ route('compras.update', 1) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label text-muted fw-semibold small">Proveedor</label>
                        <select name="idProveedor" class="form-select">

                            <option value="1" selected>Dental Depot</option>
                            <option value="2">Odonto Supply</option>
                            <option value="3">Medident SRL</option>

                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-muted fw-semibold small">Fecha</label>
                        <input type="date" name="fecha" class="form-control" value="2026-05-01">
                    </div>

                    <div class="mb-4">
                        <label class="form-label text-muted fw-semibold small">Estado</label>
                        <select name="estado" class="form-select">

                            <option value="Pendiente">Pendiente</option>
                            <option value="Completada" selected>Completada</option>
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
                                                value="Guantes Latex" readonly data-bs-toggle="modal"
                                                data-bs-target="#modalProductos">
                                        </td>

                                        <td>
                                            <input type="number" class="form-control form-control-sm" value="2">
                                        </td>

                                        <td>
                                            <input type="number" class="form-control form-control-sm" value="500">
                                        </td>

                                        <td>
                                            <input type="number" class="form-control form-control-sm" value="1000"
                                                readonly>
                                        </td>

                                        <td>
                                            <input type="date" class="form-control form-control-sm" value="2026-12-01">
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
                            <input type="number" name="monto" class="form-control border-start-0" value="3100">
                        </div>
                    </div>

                    <div class="d-flex gap-2 justify-content-end">
                        <a href="{{ route('compras.index') }}" class="btn btn-light rounded-pill px-4">
                            Cancelar
                        </a>
                        <button type="submit" class="btn btn-primary rounded-pill px-4">
                            <i class="bi bi-arrow-clockwise"></i> Actualizar
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

                <div class="modal-body">

                    <div class="mb-3">
                        <input type="text" class="form-control" placeholder="Buscar producto...">
                    </div>

                    <div class="table-responsive">

                        <table class="table table-hover align-middle">

                            <thead class="table-light">
                                <tr>
                                    <th>ID</th>
                                    <th>Producto</th>
                                    <th>Precio</th>
                                    <th></th>
                                </tr>
                            </thead>

                            <tbody>

                                <tr>
                                    <td>1</td>
                                    <td>Guantes Latex</td>
                                    <td>RD$ 500.00</td>
                                    <td>
                                        <button class="btn btn-sm btn-primary">
                                            Seleccionar
                                        </button>
                                    </td>
                                </tr>

                                <tr>
                                    <td>2</td>
                                    <td>Mascarillas</td>
                                    <td>RD$ 300.00</td>
                                    <td>
                                        <button class="btn btn-sm btn-primary">
                                            Seleccionar
                                        </button>
                                    </td>
                                </tr>

                                <tr>
                                    <td>3</td>
                                    <td>Anestesia</td>
                                    <td>RD$ 1200.00</td>
                                    <td>
                                        <button class="btn btn-sm btn-primary">
                                            Seleccionar
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

        btnAgregarFila.addEventListener('click', () => {

            let fila = `
                <tr>

                    <td>
                        <input type="text" class = "form-control form-control-sm producto-input" placeholder = "Buscar producto..." readonly data-bs-toggle = "modal" data-bs-target = "#modalProductos">
                    </td>

                    <td>
                        <input type = "number" class = "form-control form-control-sm" value = "1">
                    </td>

                    <td>
                        <input type = "number" class = "form-control form-control-sm" value="0">
                    </td>

                    <td>
                        <input type = "number" class = "form-control form-control-sm" value = "0" readonly>
                    </td>

                    <td>
                        <input type = "date" class="form-control form-control-sm">
                    </td>

                    <td class="text-center">
                        <button type = "button" class = "btn btn-sm btn-danger btnEliminarFila">
                            <i class = "bi bi-trash"></i>
                        </button>
                    </td>

                </tr>
                `;

            detalleBody.insertAdjacentHTML('beforeend', fila);

        });

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
