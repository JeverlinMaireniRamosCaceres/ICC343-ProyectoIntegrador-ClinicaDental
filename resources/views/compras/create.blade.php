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

                <form action="{{ route('compras.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label text-muted fw-semibold small">
                            Proveedor
                        </label>

                        <div class="position-relative">
                            <input type="text" id="nombreProveedor" name="nombreProveedor"
                                value="{{ old('nombreProveedor') }}" class="form-control" readonly data-bs-toggle="modal"
                                data-bs-target="#modalProveedores">

                            <i class="bi bi-search position-absolute top-50 end-0 translate-middle-y me-3 text-muted"></i>
                        </div>

                        <input type="hidden" name="idProveedor" id="idProveedor" value="{{ old('idProveedor') }}">

                        @error('idProveedor')
                            <div class="text-danger small mt-1">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-muted fw-semibold small">Fecha</label>
                        <input type="date" name="fecha" class="form-control @error('fecha') is-invalid @enderror"
                            value="{{ old('fecha', now()->format('Y-m-d')) }}">

                        @error('fecha')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label text-muted fw-semibold small">Estado</label>
                        <select name="estado" class="form-select @error('estado') is-invalid @enderror">
                            <option value="Pendiente" {{ old('estado') == 'Pendiente' ? 'selected' : '' }}>
                                Pendiente
                            </option>

                            <option value="Pagada" {{ old('estado') == 'Pagada' ? 'selected' : '' }}>
                                Pagada
                            </option>
                        </select>

                        @error('estado')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
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
                                        <th style="width: 30%;">Producto</th>
                                        <th style="width: 10%;">Cantidad</th>
                                        <th style="width: 15%;">Ud. Medida</th>
                                        <th style="width: 15%;">Costo Total</th>
                                        <th style="width: 15%;">Fecha Vencimiento</th>
                                        <th style="width: 5%;">Acciones</th>
                                    </tr>
                                </thead>

                                <tbody id="detalleBody">

                                    <tr>

                                        <td>
                                            <input type="text" class="form-control form-control-sm producto-input"
                                                placeholder="Buscar producto..." readonly data-bs-toggle="modal"
                                                data-bs-target="#modalProductos">

                                            <input type="hidden" name="idProducto[]" class="id-producto">
                                        </td>

                                        <td>
                                            <input type="number" class="form-control form-control-sm cantidad"
                                                min="1" step="1" value="1" name="cantidad[]">
                                        </td>

                                        <td class="unidad-producto text-center text-muted">
                                            -
                                        </td>

                                        <td>
                                            <input type="number" class="form-control form-control-sm costo-total"
                                                min="0" step="0.01" value="0" name="costoTotal[]">
                                        </td>

                                        <td>
                                            <input type="date" class="form-control form-control-sm"
                                                name="fechaVencimiento[]">
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

                            @error('idProducto')
                                <div class="text-danger small mt-2">
                                    {{ $message }}
                                </div>
                            @enderror

                            @if ($errors->has('costoTotal.0'))
                                <div class="text-danger small mt-2">
                                    {{ $errors->first('costoTotal.0') }}
                                </div>
                            @endif
                        </div>



                    </div>

                    <div class="form-check mb-3">
                        <input class="form-check-input" type="checkbox" name="aplicarItbis" id="aplicarItbis">

                        <label class="form-check-label" for="aplicarItbis">
                            Aplicar ITBIS (18%)
                        </label>
                    </div>

                    <div class="mt-3 mb-3">
                        <div class="card-body">

                            <h6 class="fw-semibold mb-3">
                                Resumen de compra
                            </h6>

                            <div class="d-flex justify-content-between mb-2">
                                <span>Subtotal</span>
                                <span id="lblSubtotal">RD$ 0.00</span>
                            </div>

                            <div class="d-flex justify-content-between mb-2">
                                <span>ITBIS</span>
                                <span id="lblItbis">RD$ 0.00</span>
                            </div>

                            <hr>

                            <div class="d-flex justify-content-between fw-bold fs-5">
                                <span>Total</span>
                                <span id="lblTotal">RD$ 0.00</span>
                            </div>

                        </div>
                    </div>

                    <div class="d-flex gap-2 justify-content-end">
                        <a href="{{ route('compras.index') }}" class="btn btn-light rounded-pill px-4">
                            Cancelar
                        </a>
                        <button type="submit" class="btn rounded-pill px-4 text-white" style="background-color: #0ea5e9;">
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

                                                <i class="bi bi-check-lg"></i>
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

    <script src="{{ asset('js/nueva-compra.js') }}"></script>

@endsection
