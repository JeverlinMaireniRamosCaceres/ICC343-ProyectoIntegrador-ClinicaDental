@extends('layouts.app')

@section('title', 'Editar Alergia')

@section('content')

<div class="container-fluid py-4 px-5">

    <div class="d-flex align-items-center mb-4">
        <a href="{{ route('alergias.index') }}" class="btn btn-light btn-sm rounded-pill me-3">
            <i class="bi bi-arrow-left"></i>
        </a>

        <div>
            <h2 class="fw-bold text-dark mb-1">
                <i class="bi bi-shield-exclamation me-2 text-primary"></i>
                Editar Alergia
            </h2>
            <p class="text-muted small mb-0">
                Modifica los detalles de la sustancia o condición médica.
            </p>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">

            <form action="{{ route('alergias.update', $alergia->idAlergia) }}" method="POST">
                @csrf
                @method('PUT')

                <h6 class="text-primary text-uppercase fw-bold mb-3 small" style="letter-spacing: 1px;">
                    Información Clínica del Parámetro
                </h6>

                <div class="row g-3 mb-4">
                    <div class="col-md-3">
                        <label class="form-label text-muted small fw-bold">ID Registro</label>
                        <input type="text" class="form-control bg-light border-0 text-muted rounded-3" 
                            value="#{{ $alergia->idAlergia }}" readonly>
                    </div>

                    <div class="col-md-9">
                        <label class="form-label text-muted small fw-bold">Nombre de la Alergia / Condición</label>
                        <input type="text" name="nombre"
                            class="form-control rounded-3 border-secondary-subtle bg-white @error('nombre') is-invalid @enderror"
                            value="{{ old('nombre', $alergia->nombre) }}" 
                            placeholder="Ej. Penicilina, Látex, etc."
                            required>
                        
                        @error('nombre')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 border-top pt-3">
                    <a href="{{ route('alergias.index') }}" class="btn btn-light rounded-pill px-4 py-2">
                        Cancelar
                    </a>

                    <button type="submit" class="btn btn-primary text-white rounded-pill px-4 py-2 shadow-sm">
                        <i class="bi bi-save me-2"></i>Actualizar Alergia
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>

@endsection