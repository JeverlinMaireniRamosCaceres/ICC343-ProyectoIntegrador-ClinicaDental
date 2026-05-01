@extends('layouts.app')

@section('title', 'Editar Procedimiento')

@section('content')
<div class="container py-4">

    <div class="d-flex align-items-center gap-3 mb-4">
        <a href="{{ route('procedimientos.index') }}"
           class="btn btn-sm btn-light rounded-pill px-3">
            <i class="bi bi-arrow-left"></i>
        </a>
        <h2 class="fw-semibold mb-0">Editar Procedimiento</h2>
    </div>

    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-body p-4">

            <form action="{{ route('procedimientos.update', $procedimiento->idProcedimiento) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="nombre" class="form-label text-muted fw-semibold small">Nombre</label>
                    <input type="text" name="nombre" id="nombre"
                           class="form-control @error('nombre') is-invalid @enderror"
                           value="{{ old('nombre', $procedimiento->nombre) }}"
                           placeholder="Ej: Limpieza dental">
                    @error('nombre')
                        <div class="invalid-feedback ps-2">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="precio" class="form-label text-muted fw-semibold small">Precio</label>
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0 text-muted">
                            RD$
                        </span>
                        <input type="number" name="precio" id="precio"
                               class="form-control border-start-0 @error('precio') is-invalid @enderror"
                               value="{{ old('precio', $procedimiento->precio) }}"
                               placeholder="0.00"
                               step="0.01" min="0">
                        @error('precio')
                            <div class="invalid-feedback ps-2">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="d-flex gap-2 justify-coFntent-end">
                    <a href="{{ route('procedimientos.index') }}"
                       class="btn btn-light rounded-pill px-4">
                        Cancelar
                    </a>
                    <button type="submit" class="btn btn-primary rounded-pill px-4">
                        <i class="bi bi-arrow-clockwise"></i> Guardar Cambios
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>
@endsection
