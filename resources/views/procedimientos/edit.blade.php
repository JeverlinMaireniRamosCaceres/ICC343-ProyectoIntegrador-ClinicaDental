@extends('layouts.app')

@section('title', 'Editar Procedimiento')

@section('content')
    <div class="container py-4">

        <div class="d-flex align-items-center gap-3 mb-4">
            <a href="{{ route('procedimientos.index') }}" class="btn btn-sm btn-light rounded-pill px-3">
                <i class="bi bi-arrow-left"></i>
            </a>
            <h2 class="fw-semibold mb-0">Editar procedimiento</h2>
        </div>

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">

                <form action="{{ route('procedimientos.update', $procedimiento->idProcedimiento) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="nombre" class="form-label text-muted fw-semibold small">Nombre</label>
                        <input type="text" name="nombre" id="nombre"
                            class="form-control @error('nombre') is-invalid @enderror"
                            value="{{ old('nombre', $procedimiento->nombre) }}" placeholder="Ej: Limpieza dental">
                        @error('nombre')
                            <div class="invalid-feedback ps-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="precio" class="form-label text-muted fw-semibold small">Precio</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted">RD$</span>
                            <input type="number" name="precio" id="precio"
                                class="form-control border-start-0 @error('precio') is-invalid @enderror"
                                value="{{ old('precio', $procedimiento->precio) }}" placeholder="0.00" step="0.01"
                                min="0">
                            @error('precio')
                                <div class="invalid-feedback ps-2">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="border-top pt-4 mt-2 mb-4">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <h5 class="fw-semibold mb-0">Insumos</h5>
                                <p class="text-muted small mb-0">
                                    Asigna los materiales que se gastan al realizar este procedimiento.
                                </p>
                            </div>

                            <button type="button" id="btnAgregarFila"
                                class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                <i class="bi bi-plus-lg"></i> Agregar Producto
                            </button>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 50%;">Producto</th>
                                        <th style="width: 20%;" class="text-center">Cantidad</th>
                                        <th style="width: 20%;" class="text-center">Ud. Medida</th>
                                        <th style="width: 10%;" class="text-center">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody id="detalleBody">
                                    @if ($procedimiento->productos->isEmpty())
                                        <tr id="filaVaciaInsumos">
                                            <td colspan="4" class="text-center text-muted py-4">
                                                No se han agregado productos a este procedimiento.
                                            </td>
                                        </tr>
                                    @else
                                        @foreach ($procedimiento->productos as $item)
                                            <tr>
                                                <td>
                                                    <input type="text"
                                                        class="form-control form-control-sm producto-input"
                                                        value="{{ $item->producto->nombre }}" readonly
                                                        data-bs-toggle="modal" data-bs-target="#modalProductos">

                                                    <input type="hidden" name="idProducto[]" class="id-producto"
                                                        value="{{ $item->idProducto }}">

                                                    <input type="hidden" name="nombreProducto[]" class="nombre-producto"
                                                        value="{{ $item->producto->nombre }}">

                                                    <input type="hidden" name="unidadProducto[]" class="unidad-hidden"
                                                        value="{{ $item->producto->unidadMedida }}">
                                                </td>

                                                <td>
                                                    <input type="number"
                                                        class="form-control form-control-sm cantidad text-center"
                                                        min="1" step="1" value="{{ $item->cantidad }}"
                                                        name="cantidad[]" required>
                                                </td>

                                                <td class="unidad-producto text-center text-muted small">
                                                    {{ $item->producto->unidadMedida }}
                                                </td>

                                                <td class="text-center">
                                                    <button type="button"
                                                        class="btn btn-sm btn-danger rounded-pill px-3 btnEliminarFila"
                                                        title="Eliminar">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="d-flex gap-2 justify-content-end">
                        <a href="{{ route('procedimientos.index') }}" class="btn btn-light rounded-pill px-4">Cancelar</a>
                        <button type="submit" class="btn rounded-pill px-4 text-white" style="background-color: #0ea5e9;">
                            <i class="bi bi-arrow-clockwise"></i> Actualizar
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    @include('procedimientos.partials.modal-productos')

    <script>
        const productosOld = @json(old('idProducto', []));
        const nombresOld = @json(old('nombreProducto', []));
        const unidadesOld = @json(old('unidadProducto', []));
        const cantidadesOld = @json(old('cantidad', []));
    </script>

    <script src="{{ asset('js/nuevo-procedimiento.js?v=' . time()) }}"></script>

@endsection
