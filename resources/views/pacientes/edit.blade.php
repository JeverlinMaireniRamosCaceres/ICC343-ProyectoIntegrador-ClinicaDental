@extends('layouts.app')

@section('title', 'Editar paciente')

@section('content')
    <div class="container-fluid px-2 py-2">

        <div class="d-flex align-items-center gap-3 mb-4">
            <a href="{{ route('pacientes.index') }}" class="btn btn-sm btn-light rounded-pill px-3">
                <i class="bi bi-arrow-left"></i>
            </a>

            <h2 class="fw-semibold mb-0">
                Editar paciente
            </h2>
        </div>

        <form action="{{ route('pacientes.update', $paciente->idPaciente) }}" method="POST">
            @csrf
            @method('PUT')

            {{-- DATOS PERSONALES --}}
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4">

                    <h5 class="fw-semibold mb-3">
                        Datos personales
                    </h5>

                    <div class="row g-3">

                        <div class="col-md-6">
                            <label class="form-label text-muted fw-semibold small">
                                Nombre
                            </label>

                            <input type="text" name="nombre" id="nombre"
                                class="form-control @error('nombre') is-invalid @enderror"
                                value="{{ old('nombre', $paciente->persona->nombre) }}"
                                placeholder="Ej: Juan">

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
                                class="form-control @error('apellido') is-invalid @enderror"
                                value="{{ old('apellido', $paciente->persona->apellido) }}"
                                id="apellido" placeholder="Ej: Pérez">

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
                                value="{{ old('cedula', $paciente->persona->cedula) }}"
                                placeholder="001-1234567-8" id="cedula">

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
                                value="{{ old('fechaNacimiento', $paciente->persona->fechaNacimiento) }}"
                                id="fechaNacimiento">

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

                            <select name="sexo" id="sexo"
                                class="form-select @error('sexo') is-invalid @enderror">

                                <option value="">Seleccionar</option>

                                <option value="Masculino"
                                    {{ old('sexo', $paciente->persona->sexo) == 'Masculino' ? 'selected' : '' }}>
                                    Masculino
                                </option>

                                <option value="Femenino"
                                    {{ old('sexo', $paciente->persona->sexo) == 'Femenino' ? 'selected' : '' }}>
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

            {{-- INFORMACIÓN DE CONTACTO --}}
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

                            <input type="text" name="telefono" id="telefono"
                                class="form-control mask-telefono-rd @error('telefono') is-invalid @enderror"
                                value="{{ old('telefono', $paciente->persona->telefono) }}"
                                placeholder="809-555-1234">

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

                            <input type="email" name="correo" id="correo"
                                class="form-control @error('correo') is-invalid @enderror"
                                value="{{ old('correo', $paciente->persona->correo) }}"
                                placeholder="paciente@mail.com">

                            @error('correo')
                                <div class="invalid-feedback ps-2">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                    </div>

                </div>
            </div>

            {{-- INFORMACIÓN CLÍNICA --}}
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4">

                    <h5 class="fw-semibold mb-3">
                        Información clínica
                    </h5>

                    <div class="row g-4">

                        {{-- Alergias --}}
                        <div class="col-md-6">

                            <label class="form-label text-muted fw-semibold small">
                                Alergias
                            </label>

                            <div class="row g-2">

                                @foreach ($alergias as $alergia)
                                    <div class="col-md-6">

                                        <label for="alergia{{ $alergia->idAlergia }}"
                                            class="border rounded p-3 d-block h-100">

                                            <div class="form-check m-0">

                                                <input class="form-check-input" type="checkbox"
                                                    name="alergias[]"
                                                    value="{{ $alergia->idAlergia }}"
                                                    id="alergia{{ $alergia->idAlergia }}"
                                                    @checked(
                                                        in_array(
                                                            $alergia->idAlergia,
                                                            old(
                                                                'alergias',
                                                                $paciente->alergias->pluck('idAlergia')->toArray()
                                                            )
                                                        )
                                                    )>

                                                <span class="form-check-label fw-medium">
                                                    {{ $alergia->nombre }}
                                                </span>

                                            </div>

                                        </label>

                                    </div>
                                @endforeach

                                @error('alergias')
                                    <div class="text-danger small mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>

                        </div>

                        {{-- Antecedentes médicos --}}
                        <div class="col-md-6">

                            <label class="form-label text-muted fw-semibold small">
                                Antecedentes médicos
                            </label>

                            <textarea name="antecedentesMedicos" class="form-control" rows="8"
                                placeholder="Diabetes, hipertensión, enfermedades cardíacas, etc.">{{ old('antecedentesMedicos', $paciente->antecedentes) }}</textarea>

                            @error('antecedentesMedicos')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                    </div>

                </div>
            </div>

            <div class="d-flex gap-2 justify-content-end mt-4">

                <a href="{{ route('pacientes.index') }}" class="btn btn-light rounded-pill px-4">
                    Cancelar
                </a>

                <button type="submit" class="btn rounded-pill px-4 text-white"
                    style="background-color: #0ea5e9;">
                    <i class="bi bi-floppy"></i>
                    Actualizar
                </button>

            </div>

        </form>

    </div>
@endsection
