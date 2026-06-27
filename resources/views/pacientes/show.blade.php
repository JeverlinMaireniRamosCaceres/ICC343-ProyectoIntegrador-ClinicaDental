@extends('layouts.app')

@section('title', 'Detalle Paciente')

@section('content')
    <div class="container-fluid py-2 px-2">

        <div class="d-flex align-items-center mb-4">
            <a href="{{ request('return', route('pacientes.index')) }}" class="btn btn-sm btn-light rounded-pill px-3"
                class="btn btn-sm btn-light rounded-pill px-3">
                <i class="bi bi-arrow-left"></i>
            </a>

            <h2 class="fw-bold text-dark mb-0 ms-3">
                Detalle del paciente
            </h2>
        </div>

        {{-- Perfil --}}
        <div class="card border-0 shadow-sm rounded-4 mb-4">

            <div class="card-body p-4">

                <div class="d-flex align-items-center">

                    @php
                        $nombreCompleto = $paciente->persona->nombre . ' ' . $paciente->persona->apellido;
                    @endphp

                    <div class="me-4">

                        <img src="https://ui-avatars.com/api/?name={{ urlencode($nombreCompleto) }}&background=0ea5e9&color=fff&size=128"
                            class="rounded-circle shadow-sm" width="80" height="80" alt="Avatar">

                    </div>

                    <div>

                        <h3 class="fw-bold mb-1">
                            {{ $nombreCompleto }}
                        </h3>

                        <span class="text-muted">
                            Edad:
                            @php
                                $edad = \Carbon\Carbon::parse($paciente->persona->fechaNacimiento)->age;
                            @endphp

                            {{ $edad }} años

                        </span>

                    </div>

                </div>

            </div>

        </div>

        {{-- Tabs --}}
        <div class="card border-0 shadow-sm rounded-4">

            <div class="card-header bg-white border-0 p-0 rounded-4">

                <ul class="nav patient-tabs px-4" id="pacienteTab" role="tablist">

                    <li class="nav-item">
                        <button class="nav-link active" data-bs-toggle="tab" data-bs-target="#info" type="button">
                            Información general
                        </button>
                    </li>

                    <li class="nav-item">
                        <button class="nav-link" data-bs-toggle="tab" data-bs-target="#historial" type="button">
                            Historial clínico
                        </button>
                    </li>

                </ul>

            </div>

            <div class="tab-content p-4">

                {{-- INFORMACIÓN --}}
                <div class="tab-pane fade show active" id="info">

                    <div class="row g-4 mb-4">

                        <div class="col-md-4">
                            <span class="text-muted small fw-bold">
                                Nombre completo
                            </span>

                            <p class="fw-semibold mb-0">
                                {{ $nombreCompleto }}
                            </p>
                        </div>

                        <div class="col-md-4">
                            <span class="text-muted small fw-bold">
                                Cédula
                            </span>

                            <p class="fw-semibold mb-0">
                                {{ $paciente->persona->cedula ?: 'No registrada' }}
                            </p>
                        </div>

                        <div class="col-md-4">
                            <span class="text-muted small fw-bold">
                                Teléfono
                            </span>

                            <p class="fw-semibold mb-0">
                                {{ $paciente->persona->telefono }}
                            </p>
                        </div>

                        <div class="col-md-4">
                            <span class="text-muted small fw-bold">
                                Correo electrónico
                            </span>

                            <p class="fw-semibold mb-0">
                                {{ $paciente->persona->correo ?: 'No registrado' }}
                            </p>
                        </div>

                        <div class="col-md-4">
                            <span class="text-muted small fw-bold">
                                Fecha de nacimiento
                            </span>

                            <p class="fw-semibold mb-0">
                                {{ \Carbon\Carbon::parse($paciente->persona->fechaNacimiento)->format('d/m/Y') }}
                            </p>
                        </div>

                        <div class="col-md-4">
                            <span class="text-muted small fw-bold">
                                Sexo
                            </span>

                            <p class="fw-semibold mb-0">
                                {{ $paciente->persona->sexo }}
                            </p>
                        </div>

                    </div>

                    <hr>

                    <div class="row g-4 mt-1">

                        {{-- Alergias --}}
                        <div class="col-md-6">

                            <div
                                class="border rounded-4 p-4 h-100 {{ $paciente->alergias->count() ? 'border-danger bg-danger bg-opacity-10' : 'bg-white' }}">

                                <h6 class="fw-bold mb-3 {{ $paciente->alergias->count() ? 'text-danger' : 'text-dark' }}">

                                    <i class="bi bi-exclamation-triangle me-2"></i>
                                    Alergias

                                </h6>

                                @if ($paciente->alergias->count())

                                    <ul class="mb-0">

                                        @foreach ($paciente->alergias as $alergia)
                                            <li>{{ $alergia->nombre }}</li>
                                        @endforeach

                                    </ul>
                                @else
                                    <p class="text-muted mb-0">
                                        No hay alergias registradas.
                                    </p>

                                @endif

                            </div>

                        </div>

                        {{-- ANTECEDENTES --}}
                        <div class="col-md-6">

                            <div class="border rounded-4 p-4 h-100 bg-white">

                                <h6 class="fw-bold mb-3">

                                    <i class="bi bi-file-medical me-2"></i>
                                    Antecedentes médicos

                                </h6>

                                <p class="text-muted mb-0">

                                    {{ $paciente->antecedentes ?: 'No hay antecedentes registrados.' }}

                                </p>

                            </div>

                        </div>

                    </div>

                </div>

                {{-- Historial Clínico --}}
                <div class="tab-pane fade" id="historial">

                    <div class="row g-4">

                        {{-- Columna izquierda: filtros + consultas --}}
                        <div class="col-lg-7 col-xl-8">

                            {{-- Filtros --}}
                            <div class="border rounded-4 p-3 mb-3 bg-light bg-opacity-50">

                                {{-- Buscador --}}
                                <div class="position-relative mb-3">

                                    <i
                                        class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>

                                    <input type="text" id="filtroBusqueda" class="form-control ps-5"
                                        placeholder="Buscar por motivo o diagnóstico...">

                                </div>

                                {{-- Filtros secundarios --}}
                                <div class="row g-2 align-items-end">

                                    <div class="col-md-5">

                                        <label class="form-label small fw-bold text-muted mb-1">
                                            Doctor
                                        </label>

                                        <select id="filtroDoctor" class="form-select form-select-sm">

                                            <option value="">
                                                Todos
                                            </option>

                                            @foreach ($doctores as $doctor)
                                                <option value="{{ $doctor }}">
                                                    {{ $doctor }}
                                                </option>
                                            @endforeach

                                        </select>

                                    </div>

                                    <div class="col-md-2">

                                        <label class="form-label small fw-bold text-muted mb-1">
                                            Desde
                                        </label>

                                        <input type="date" id="filtroDesde" class="form-control form-control-sm">

                                    </div>

                                    <div class="col-md-2">

                                        <label class="form-label small fw-bold text-muted mb-1">
                                            Hasta
                                        </label>

                                        <input type="date" id="filtroHasta" class="form-control form-control-sm">

                                    </div>

                                    <div class="col-md-2">

                                        <label class="form-label small fw-bold text-muted mb-1">
                                            Mostrar
                                        </label>

                                        <select id="porPagina" class="form-select form-select-sm">

                                            <option value="10" {{ $porPagina == 10 ? 'selected' : '' }}>
                                                10
                                            </option>

                                            <option value="15" {{ $porPagina == 15 ? 'selected' : '' }}>
                                                15
                                            </option>

                                            <option value="20" {{ $porPagina == 20 ? 'selected' : '' }}>
                                                20
                                            </option>

                                            <option value="20" {{ $porPagina == 20 ? 'selected' : '' }}>
                                                25
                                            </option>

                                        </select>

                                    </div>

                                    <div class="col-md-1 d-flex align-items-end">

                                        <button type="button" id="filtroLimpiar"
                                            class="btn bg-white border w-100 form-control form-control-sm d-flex align-items-center justify-content-center"
                                            title="Limpiar filtros">

                                            <i class="bi bi-arrow-counterclockwise"></i>

                                        </button>

                                    </div>

                                </div>

                            </div>

                            <div id="contenedorConsultas">
                                @include('pacientes.partials.consultas')
                            </div>

                        </div>

                        {{-- Barra lateral: Tratamientos --}}
                        <div class="col-lg-5 col-xl-4">
                            <div class="border rounded-4 p-3 sticky-top" style="top: 1rem; background-color: #f8fafc;">


                                <div class="d-flex align-items-center justify-content-between mb-3">
                                    <h6 class="fw-bold mb-0">
                                        Tratamientos
                                    </h6>
                                    <span class="badge rounded-pill  bg-opacity-10  px-2"
                                        style="background-color: rgba(14,165,233,0.1); color: #0ea5e9;">
                                        {{ $paciente->tratamientos->count() }}
                                    </span>
                                </div>

                                <div class="d-flex flex-column gap-2">

                                    @if ($paciente->tratamientos->count())

                                        @foreach ($paciente->tratamientos as $tratamiento)
                                            <a href="{{ route('tratamientos.show', $tratamiento->idTratamiento) }}"
                                                class="text-decoration-none text-dark d-block tratamiento-link">

                                                <div class="card mb-2 shadow-sm">

                                                    <div class="card-body">

                                                        <div class="d-flex justify-content-between align-items-start mb-3">

                                                            <span class="fw-semibold">
                                                                {{ $tratamiento->nombre }}
                                                            </span>

                                                            @if ($tratamiento->estado == 'Completado')
                                                                <span
                                                                    class="badge rounded-pill px-2 py-1 text-success bg-success-subtle">
                                                                    {{ $tratamiento->estado }}
                                                                </span>
                                                            @elseif ($tratamiento->estado == 'En Proceso')
                                                                <span
                                                                    class="badge rounded-pill px-2 py-1 bg-warning-subtle"
                                                                    style="color: rgb(181, 151, 43)">
                                                                    {{ $tratamiento->estado }}
                                                                </span>
                                                            @else
                                                                <span
                                                                    class="badge rounded-pill px-2 py-1 text-secondary bg-secondary-subtle">
                                                                    {{ $tratamiento->estado }}
                                                                </span>
                                                            @endif

                                                        </div>

                                                        <div class="text-muted small">

                                                            <i class="bi bi-calendar-event me-1"></i>

                                                            Fecha de inicio:
                                                            {{ \Carbon\Carbon::parse($tratamiento->fechaInicio)->format('d/m/Y') }}

                                                        </div>

                                                    </div>

                                                </div>

                                            </a>
                                        @endforeach
                                    @else
                                        <div class="text-center py-4">

                                            <i class="bi bi-clipboard2-x text-muted fs-1"></i>

                                            <p class="text-muted mb-0 mt-2">
                                                No hay tratamientos registrados.
                                            </p>

                                        </div>

                                    @endif

                                </div>

                            </div>
                        </div>

                    </div>

                </div>

            </div>

        </div>
    </div>

    <div class="modal fade" id="modalDetalleTratamiento" tabindex="-1" aria-hidden="true">

        <div class="modal-dialog modal-lg modal-dialog-centered">

            <div class="modal-content" id="contenidoModalTratamiento">

                <div class="text-center p-5">

                    <div class="spinner-border"></div>

                </div>

            </div>

        </div>

    </div>

    <script src="{{ asset('js/pacientes-show.js') }}"></script>

@endsection
