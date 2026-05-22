@extends('layouts.app')

@section('title', 'Nueva alergia')

@section('content')
    <div class="container py-4">

        <div class="d-flex align-items-center gap-3 mb-4">

            <a href="{{ route('alergias.index') }}" class="btn btn-sm btn-light rounded-pill px-3">
                <i class="bi bi-arrow-left"></i>
            </a>

            <h2 class="fw-semibold mb-0">
                Nueva alergia
            </h2>

        </div>

        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-body p-4">

                <form action="{{ route('alergias.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="nombre" class="form-label text-muted fw-semibold small">Nombre</label>
                        <input type="text" name="nombre" id="nombre"
                            class="form-control @error('nombre') is-invalid @enderror" value="{{ old('nombre') }}"
                            placeholder="Ej: Ibuprofeno">
                        @error('nombre')
                            <div class="invalid-feedback ps-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2 justify-content-end">
                        <a href="{{ route('alergias.index') }}" class="btn btn-light rounded-pill px-4">
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
@endsection
