@extends('layouts.app')

@section('title', 'Nuevo Producto')

@section('content')
    <div class="container py-4">

        <div class="d-flex align-items-center gap-3 mb-4">
            <a href="{{ route('productos.index') }}" class="btn btn-sm btn-light rounded-pill px-3">
                <i class="bi bi-arrow-left"></i>
            </a>

            <h2 class="fw-semibold mb-0">
                Nuevo producto
            </h2>
        </div>

        <div class="card border-0 shadow-sm rounded-3">

            <div class="card-body p-4">

                <form action="{{ route('productos.store') }}" method="POST">

                    @csrf

                    <!-- NOMBRE -->
                    <div class="mb-3">
                        <label class="form-label text-muted fw-semibold small">
                            Nombre del producto
                        </label>
                        <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror"
                            value="{{ old('nombre') }}" placeholder="Ej: Guantes Latex">
                        @error('nombre')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- DESCRIPCION -->
                    <div class="mb-3">
                        <label class="form-label text-muted fw-semibold small">
                            Descripción
                        </label>
                        <textarea name="descripcion" class="form-control @error('descripcion') is-invalid @enderror" rows="3"
                            placeholder="Ej: Caja de guantes desechables">{{ old('descripcion') }}</textarea>
                        @error('descripcion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-muted fw-semibold small">
                            Stock mínimo
                        </label>
                        <input type="number" name="stockMinimo"
                            class="form-control @error('stockMinimo') is-invalid @enderror" value="{{ old('stockMinimo') }}"
                            placeholder="0" min="0">
                        @error('stockMinimo')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- UNIDAD MEDIDA -->
                    <div class="mb-4">
                        <label class="form-label text-muted fw-semibold small">
                            Unidad de medida
                        </label>
                        <select name="unidadMedida" class="form-select @error('unidadMedida') is-invalid @enderror">
                            <option value="">
                                Seleccionar unidad
                            </option>
                            @foreach (['Unidades', 'Cajas', 'Paquetes', 'Frascos'] as $unidad)
                                <option value="{{ $unidad }}" {{ old('unidadMedida') == $unidad ? 'selected' : '' }}>
                                    {{ $unidad }}
                                </option>
                            @endforeach
                        </select>
                        @error('unidadMedida')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- BOTONES PARA GUARDAR O CANCELAR -->
                    <div class="d-flex gap-2 justify-content-end">
                        <a href="{{ route('productos.index') }}" class="btn btn-light rounded-pill px-4">
                            Cancelar
                        </a>
                        <button type="submit" class="btn btn-primary rounded-pill px-4" style="background-color: #0ea5e9;">
                            <i class="bi bi-floppy"></i>
                            Guardar
                        </button>
                    </div>

                </form>

            </div>

        </div>

    </div>
@endsection
