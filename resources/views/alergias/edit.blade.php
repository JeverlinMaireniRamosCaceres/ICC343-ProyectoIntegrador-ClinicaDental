@extends('layouts.app')

@section('title', 'Editar Alergia')

@section('content')

    <div class="container-fluid py-4 px-5">


        <div class="d-flex align-items-center gap-3 mb-4">

            <a href="{{ route('alergias.index') }}" class="btn btn-sm btn-light rounded-pill px-3">
                <i class="bi bi-arrow-left"></i>
            </a>

            <h2 class="fw-semibold mb-0">
                Editar alergia
            </h2>

        </div>

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">

                <form action="{{ route('alergias.update', $alergia->idAlergia) }}" method="POST">
                    @csrf
                    @method('PUT')


                    <div class="mb-3">
                        <label class="form-label text-muted small fw-bold">Nombre</label>
                        <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror"
                            value="{{ old('nombre', $alergia->nombre) }}" placeholder="Ej. Penicilina, Látex, etc."
                            required>

                        @error('nombre')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-end gap-2 pt-3">
                        <a href="{{ route('alergias.index') }}" class="btn btn-light rounded-pill px-4 py-2">
                            Cancelar
                        </a>

                        <button type="submit" class="btn btn-primary rounded-pill px-4" style="background-color: #0ea5e9;">

                            <i class="bi bi-arrow-clockwise"></i>
                            Actualizar

                        </button>
                    </div>

                </form>

            </div>
        </div>

    </div>

@endsection
