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
                        <label class="form-label text-muted fw-semibold small">
                            Proveedor
                        </label>

                        <div class="position-relative">
                            <input type="text" id="nombreProveedor" class="form-control"
                                placeholder="Buscar proveedor..." readonly data-bs-toggle="modal"
                                data-bs-target="#modalProveedores">

                            <i class="bi bi-search position-absolute top-50 end-0 translate-middle-y me-3 text-muted"></i>
                        </div>

                        <input type="hidden" name="idProveedor" id="idProveedor">
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-muted fw-semibold small">Fecha</label>
                        <input type="date" name="fecha" class="form-control" value="{{ now()->format('Y-m-d') }}">
                    </div>

                    <div class="mb-4">
                        <label class="form-label text-muted fw-semibold small">Estado</label>
                        <select name="estado" class="form-select">
                            <option value="Pendiente">Pendiente</option>
                            <option value="Completada">Pagada</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="form-label text-muted fw-semibold small">Detalle de compra</label>

                        <div class="mb-2 d-flex justify-content-end">
                            <button type="button" class="btn btn-sm btn-outline-primary rounded-pill px-3"
                                id="btnAgregarFila">
                                <i class="bi bi-plus-lg"></i> Agregar producto
                            </button>
                        </div>

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

                                            <input type="hidden" class="id-producto">
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
                                            <button type="button"
                                                class="btn btn-sm btn-danger rounded-pill px-3 btnEliminarFila">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </td>

                                    </tr>

                                </tbody>

                            </table>
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
                                                style="width: 50px; height: 38px;" data-id="{{ $proveedor->idProveedor }}"
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
                        <input type="text" id="buscarProducto" class="border-0 bg-transparent p-0 w-100"
                            style="outline: none; font-size: 14px;" placeholder="Buscar producto...">
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="px-3 py-3 text-muted fw-semibold small">Producto</th>
                                    <th class="px-3 py-3"></th>
                                </tr>
                            </thead>
                            <tbody id="tablaProductos">
                                {{-- @foreach ($productos as $producto)
                                    <tr>
                                        <td class="fw-medium">{{ $producto->nombre }}</td>
                                        <td class="text-end">
                                            <button
                                                type="button"
                                                class="btn btn-sm btn-primary rounded-pill px-3 btnSeleccionarProducto"
                                                style="width: 50px; height: 38px;"
                                                data-id="{{ $producto->idProducto }}"
                                                data-nombre="{{ $producto->nombre }}">

                                                <i class="bi bi-check-lg"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach --}}

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

                        <input type="hidden" class="id-producto">
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
                    class="btn btn-sm btn-danger rounded-pill px-3 btnEliminarFila">
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

        // BUSCAR PROVEEDOR

        const buscarProveedor = document.getElementById('buscarProveedor');

        buscarProveedor.addEventListener('keyup', function() {

            const texto = this.value.toLowerCase();

            const filas = document.querySelectorAll('#tablaProveedores tr:not(#sinResultados)');

            let encontrados = 0;

            filas.forEach(fila => {

                const nombre = fila.children[0]
                    .textContent
                    .toLowerCase();

                if (nombre.includes(texto)) {

                    fila.style.display = '';
                    encontrados++;

                } else {

                    fila.style.display = 'none';

                }

            });

            document.getElementById('sinResultados').style.display =
                encontrados === 0 ? '' : 'none';

        });

        // SELECCIONAR PROVEEDOR

        document.addEventListener('click', function(e) {

            const btn = e.target.closest('.btnSeleccionarProveedor');

            if (!btn) return;

            document.getElementById('idProveedor').value =
                btn.dataset.id;

            document.getElementById('nombreProveedor').value =
                btn.dataset.nombre;

            bootstrap.Modal.getInstance(
                document.getElementById('modalProveedores')
            ).hide();

        });

        const modalProveedores = document.getElementById('modalProveedores');

        // AL MOSTRAR EL MODAL, ACTUALIZAR ESTILO DE LOS BOTONES
        modalProveedores.addEventListener('show.bs.modal', function() {

            const idSeleccionado =
                document.getElementById('idProveedor').value;

            document.querySelectorAll('.btnSeleccionarProveedor')
                .forEach(btn => {

                    if (btn.dataset.id === idSeleccionado) {

                        btn.classList.remove('btn-primary');
                        btn.classList.add('btn-success');

                        btn.innerHTML =
                            '<i class="bi bi-check-circle-fill"></i>';

                    } else {

                        btn.classList.remove('btn-success');
                        btn.classList.add('btn-primary');


                        btn.innerHTML =
                            '<i class="bi bi-check-lg"></i>';

                    }

                });

        });

        // BUSCAR PRODUCTO

        const buscarProducto = document.getElementById('buscarProducto');

        buscarProducto.addEventListener('keyup', function() {

            const texto = this.value.toLowerCase();

            const filas = document.querySelectorAll('#tablaProductos tr:not(#sinResultadosProductos)');

            let encontrados = 0;

            filas.forEach(fila => {

                const nombre = fila.children[0]
                    .textContent
                    .toLowerCase();

                if (nombre.includes(texto)) {

                    fila.style.display = '';
                    encontrados++;

                } else {

                    fila.style.display = 'none';

                }

            });

            document.getElementById('sinResultadosProductos').style.display =
                encontrados === 0 ? '' : 'none';

        });

        let filaProductoActual = null;
        document.addEventListener('click', function(e) {

            const input = e.target.closest('.producto-input');

            if (!input) return;

            filaProductoActual = input;

        });

        document.addEventListener('click', function(e) {

            const btn = e.target.closest('.btnSeleccionarProducto');

            if (!btn) return;

            if (filaProductoActual) {

                filaProductoActual.value =
                    btn.dataset.nombre;

                filaProductoActual
                    .closest('td')
                    .querySelector('.id-producto')
                    .value = btn.dataset.id;

            }

            bootstrap.Modal.getInstance(
                document.getElementById('modalProductos')
            ).hide();

        });
    </script>

@endsection
