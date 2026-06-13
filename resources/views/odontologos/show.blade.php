@extends('layouts.app')

@section('title', 'Detalle odontólogo')

@section('content')
    <div class="container py-4">

        <div class="d-flex align-items-center gap-3 mb-4">
            <a href="{{ route('odontologos.index') }}" class="btn btn-sm btn-light rounded-pill px-3">
                <i class="bi bi-arrow-left"></i>
            </a>

            <h2 class="fw-semibold mb-0">Detalle del odontólogo</h2>
        </div>

        {{-- Perfil --}}
        <div class="card border-0 shadow-sm rounded-3 mb-4">
            <div class="card-body p-4">

                <div class="d-flex align-items-center">

                    @php
                        $nombreCompleto = $odontologo->persona->nombre . ' ' . $odontologo->persona->apellido;
                    @endphp

                    <div class="me-4">

                        <img src="https://ui-avatars.com/api/?name={{ urlencode($nombreCompleto) }}&background=0ea5e9&color=fff&size=128"
                            class="rounded-circle shadow-sm" width="80" height="80" alt="Avatar">

                    </div>

                    <div>

                        <h3 class="fw-bold mb-1">
                            {{ $odontologo->persona->sexo === 'Femenino' ? 'Dra.' : 'Dr.' }}
                            {{ $odontologo->persona->nombre }}
                            {{ $odontologo->persona->apellido }}
                        </h3>

                        <p class="text-muted mb-2">
                            Exequátur: {{ $odontologo->exequatur }}
                        </p>

                        <div class="d-flex flex-wrap gap-2">

                            @foreach ($odontologo->especialidades as $especialidad)
                                <span class="badge rounded-pill px-3 py-2" style="background-color:#EDE9FE; color:#6D28D9;">
                                    {{ $especialidad->nombre }}
                                </span>
                            @endforeach

                        </div>

                    </div>

                </div>

            </div>
        </div>

        {{-- Datos personales --}}
        <div class="card border-0 shadow-sm rounded-3 mb-4">

            <div class="card-body p-4">

                <h5 class="fw-semibold mb-4">
                    Datos personales
                </h5>

                <div class="row g-4">

                    <div class="col-md-4">
                        <span class="text-muted small fw-semibold">
                            Nombre
                        </span>

                        <p class="mb-0 fw-medium">
                            {{ $odontologo->persona->nombre }}
                        </p>
                    </div>

                    <div class="col-md-4">
                        <span class="text-muted small fw-semibold">
                            Apellido
                        </span>

                        <p class="mb-0 fw-medium">
                            {{ $odontologo->persona->apellido }}
                        </p>
                    </div>

                    <div class="col-md-4">
                        <span class="text-muted small fw-semibold">
                            Cédula
                        </span>

                        <p class="mb-0 fw-medium">
                            {{ $odontologo->persona->cedula }}
                        </p>
                    </div>

                    <div class="col-md-4">
                        <span class="text-muted small fw-semibold">
                            Sexo
                        </span>

                        <p class="mb-0 fw-medium">
                            {{ $odontologo->persona->sexo }}
                        </p>
                    </div>

                    <div class="col-md-4">
                        <span class="text-muted small fw-semibold">
                            Fecha de nacimiento
                        </span>

                        <p class="mb-0 fw-medium">
                            {{ \Carbon\Carbon::parse($odontologo->persona->fechaNacimiento)->format('d/m/Y') }}
                        </p>
                    </div>

                    <div class="col-md-4">
                        <span class="text-muted small fw-semibold">
                            Edad
                        </span>
                        <p class="mb-0 fw-medium">
                            {{ \Carbon\Carbon::parse($odontologo->persona->fechaNacimiento)->age }} años
                        </p>
                    </div>

                </div>

            </div>

        </div>

        {{-- Contacto --}}
        <div class="card border-0 shadow-sm rounded-3 mb-4">

            <div class="card-body p-4">

                <h5 class="fw-semibold mb-4">
                    Información de contacto
                </h5>

                <div class="row g-4">

                    <div class="col-md-6">
                        <span class="text-muted small fw-semibold">
                            Teléfono
                        </span>

                        <p class="mb-0 fw-medium">
                            {{ $odontologo->persona->telefono }}
                        </p>
                    </div>

                    <div class="col-md-6">
                        <span class="text-muted small fw-semibold">
                            Correo electrónico
                        </span>

                        <p class="mb-0 fw-medium">
                            {{ $odontologo->persona->correo ?: 'No registrado' }}
                        </p>
                    </div>

                </div>

            </div>

        </div>

        {{-- Profesional --}}
        <div class="card border-0 shadow-sm rounded-3">

            <div class="card-body p-4">

                <h5 class="fw-semibold mb-4">
                    Información profesional
                </h5>

                <div class="row g-4">

                    <div class="col-md-4">
                        <span class="text-muted small fw-semibold">
                            Exequátur
                        </span>

                        <p class="mb-0 fw-medium">
                            {{ $odontologo->exequatur }}
                        </p>
                    </div>

                    <div class="col-12">

                        <span class="text-muted small fw-semibold">
                            Especialidades
                        </span>

                        <div class="mt-2 d-flex flex-wrap gap-2">

                            @foreach ($odontologo->especialidades as $especialidad)
                                <span class="badge rounded-pill px-3 py-2" style="background-color:#EDE9FE; color:#6D28D9;">
                                    {{ $especialidad->nombre }}
                                </span>
                            @endforeach

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>
@endsection
