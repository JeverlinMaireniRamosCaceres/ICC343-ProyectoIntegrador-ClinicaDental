@extends('layouts.app')

@section('title', 'Nuevo odontólogo')

@section('content')
    <div class="container py-4">

        <div class="d-flex align-items-center gap-3 mb-4">
            <a href="{{ route('odontologos.index') }}" class="btn btn-sm btn-light rounded-pill px-3">
                <i class="bi bi-arrow-left"></i>
            </a>
            <h2 class="fw-semibold mb-0">Nuevo odontólogo</h2>
        </div>

        <form action="{{ route('odontologos.store') }}" method="POST">
            @csrf

            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4">
                    {{-- Datos personales --}}
                    <h5 class="fw-semibold mb-3">Datos personales</h5>

                    <div class="row g-3">

                        <div class="col-md-6">
                            <label class="form-label text-muted fw-semibold small">
                                Nombre
                            </label>

                            <input type="text" name="nombre" class="form-control @error('nombre') is-invalid @enderror"
                                value="{{ old('nombre') }}" placeholder="Ej: Juan">

                            @error('nombre')
                                <div class="invalid-feedback ps-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label text-muted fw-semibold small">
                                Apellido
                            </label>

                            <input type="text" name="apellido"
                                class="form-control @error('apellido') is-invalid @enderror" value="{{ old('apellido') }}"
                                placeholder="Ej: Pérez">

                            @error('apellido')
                                <div class="invalid-feedback ps-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label text-muted fw-semibold small">
                                Cédula
                            </label>

                            <input type="text" name="cedula"
                                class="form-control mask-cedula @error('cedula') is-invalid @enderror"
                                value="{{ old('cedula') }}" placeholder="001-1234567-8">

                            @error('cedula')
                                <div class="invalid-feedback ps-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label text-muted fw-semibold small">
                                Fecha de nacimiento
                            </label>

                            <input type="date" name="fechaNacimiento"
                                class="form-control @error('fechaNacimiento') is-invalid @enderror"
                                value="{{ old('fechaNacimiento') }}">

                            @error('fechaNacimiento')
                                <div class="invalid-feedback ps-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label text-muted fw-semibold small">
                                Sexo
                            </label>

                            <select name="sexo" class="form-select @error('sexo') is-invalid @enderror">

                                <option value="">Seleccionar</option>

                                <option value="Masculino" {{ old('sexo') == 'Masculino' ? 'selected' : '' }}>
                                    Masculino
                                </option>

                                <option value="Femenino" {{ old('sexo') == 'Femenino' ? 'selected' : '' }}>
                                    Femenino
                                </option>

                            </select>

                            @error('sexo')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                    </div>
                </div>
            </div>

            {{-- Contacto --}}
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4">

                    <h5 class="fw-semibold mb-3">
                        Información de contacto
                    </h5>

                    <div class="row g-3">

                        <div class="col-md-6">
                            <label class="form-label text-muted fw-semibold small">
                                Teléfono
                            </label>

                            <input type="text" name="telefono"
                                class="form-control mask-telefono-rd @error('telefono') is-invalid @enderror"
                                value="{{ old('telefono') }}" placeholder="809-555-1234">

                            @error('telefono')
                                <div class="invalid-feedback ps-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label text-muted fw-semibold small">
                                Correo electrónico
                            </label>

                            <input type="email" name="correo" class="form-control @error('correo') is-invalid @enderror"
                                value="{{ old('correo') }}" placeholder="odontologo@clinica.com">

                            @error('correo')
                                <div class="invalid-feedback ps-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                    </div>

                </div>
            </div>

            {{-- Profesional --}}
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4">

                    <h5 class="fw-semibold mb-3">
                        Información profesional
                    </h5>

                    <div class="row g-3">

                        <div class="col-md-6">
                            <label class="form-label text-muted fw-semibold small">
                                Exequátur
                            </label>

                            <input type="text" name="exequatur"
                                class="form-control @error('exequatur') is-invalid @enderror"
                                value="{{ old('exequatur') }}" placeholder="12345">

                            @error('exequatur')
                                <div class="invalid-feedback ps-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-12">

                            <label class="form-label text-muted fw-semibold small">
                                Especialidades
                            </label>

                            <div class="row g-2">

                                @foreach ($especialidades as $especialidad)
                                    <div class="col-md-4">

                                        <label for="especialidad{{ $especialidad->idEspecialidad }}"
                                            class="border rounded p-3 d-block">

                                            <div class="form-check m-0">

                                                <input class="form-check-input" type="checkbox" name="especialidades[]"
                                                    value="{{ $especialidad->idEspecialidad }}"
                                                    id="especialidad{{ $especialidad->idEspecialidad }}"
                                                    @checked(in_array($especialidad->idEspecialidad, old('especialidades', [])))>

                                                <span class="form-check-label fw-medium">
                                                    {{ $especialidad->nombre }}
                                                </span>

                                            </div>

                                        </label>

                                    </div>
                                @endforeach

                            </div>

                            @error('especialidades')
                                <div class="text-danger small mt-2">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                    </div>

                </div>
            </div>

            <div class="d-flex gap-2 justify-content-end mt-4">

                <a href="{{ route('odontologos.index') }}" class="btn btn-light rounded-pill px-4">
                    Cancelar
                </a>

                <button type="submit" class="btn rounded-pill px-4 text-white" style="background-color: #0ea5e9;">
                    <i class="bi bi-floppy"></i>
                    Guardar
                </button>

            </div>

        </form>
    </div>
@endsection
