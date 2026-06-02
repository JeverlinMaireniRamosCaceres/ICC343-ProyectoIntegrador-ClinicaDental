@extends('layouts.app')

@section('title', 'Nueva compra')

@section('content')
    <div class="container py-4">

        <div class="d-flex align-items-center gap-3 mb-4">
            <a href="{{ route('compras.index') }}" class="btn btn-sm btn-light rounded-pill px-3">
                <i class="bi bi-arrow-left"></i>
            </a>
            <h2 class="fw-semibold mb-0">Nueva compra</h2>
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
                        <button type="submit" class="btn rounded-pill px-4 text-white"
                            style="background-color: #0ea5e9;">
                            <i class="bi bi-floppy"></i> Guardar
                        </button>
                    </div>

                </form>

            </div>
        </div>

    </div>

    @include('compras.partials.modal-proveedores')

    @include('compras.partials.modal-productos')

    <script src="{{ asset('js/nueva-compra.js') }}"></script>

@endsection
