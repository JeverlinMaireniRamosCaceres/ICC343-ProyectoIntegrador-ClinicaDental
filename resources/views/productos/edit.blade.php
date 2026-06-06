@extends('layouts.app')

@section('title', 'Editar Producto')

@section('content')
<div class="container py-4">

    <div class="d-flex align-items-center gap-3 mb-4">
        <a href="{{ route('productos.index') }}"
           class="btn btn-sm btn-light rounded-pill px-3">
            <i class="bi bi-arrow-left"></i>
        </a>
        <h2 class="fw-semibold mb-0">
            Editar Producto
        </h2>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show shadow-sm rounded-4 border-0 mb-4" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> Por favor, corrige los errores del formulario.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-body p-4">

            <form action="{{ route('productos.update', $producto->idProducto) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label text-muted fw-semibold small">
                        Nombre
                    </label>
                    <input type="text"
                           name="nombre"
                           class="form-control @error('nombre') is-invalid @enderror"
                           value="{{ old('nombre', $producto->nombre) }}">
                    @error('nombre')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label text-muted fw-semibold small">
                        Descripción
                    </label>
                    <textarea name="descripcion"
                              class="form-control @error('descripcion') is-invalid @enderror"
                              rows="3"
                              placeholder="Ej: Caja de guantes desechables">{{ old('descripcion', $producto->descripcion) }}</textarea>
                    @error('descripcion')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label text-muted fw-semibold small">
                        Stock Mínimo
                    </label>
                    <input type="number"
                           name="stockMinimo"
                           class="form-control @error('stockMinimo') is-invalid @enderror"
                           value="{{ old('stockMinimo', $producto->stockMinimo) }}"
                           min="0">
                    @error('stockMinimo')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label class="form-label text-muted fw-semibold small">
                        Unidad de Medida
                    </label>
                    <select name="unidadMedida"
                            class="form-select @error('unidadMedida') is-invalid @enderror">
                        <option value="Unidades" {{ old('unidadMedida', $producto->unidadMedida) == 'Unidades' ? 'selected' : '' }}>
                            Unidades
                        </option>
                        <option value="Cajas" {{ old('unidadMedida', $producto->unidadMedida) == 'Cajas' ? 'selected' : '' }}>
                            Cajas
                        </option>
                        <option value="Paquetes" {{ old('unidadMedida', $producto->unidadMedida) == 'Paquetes' ? 'selected' : '' }}>
                            Paquetes
                        </option>
                        <option value="Frascos" {{ old('unidadMedida', $producto->unidadMedida) == 'Frascos' ? 'selected' : '' }}>
                            Frascos
                        </option>
                    </select>
                    @error('unidadMedida')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex gap-2 justify-content-end">
                    <a href="{{ route('productos.index') }}"
                       class="btn btn-light rounded-pill px-4">
                        Cancelar
                    </a>
                    <button type="submit"
                            class="btn btn-primary rounded-pill px-4"
                            style="background-color: #0ea5e9;">
                        <i class="bi bi-arrow-clockwise"></i>
                        Actualizar
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection