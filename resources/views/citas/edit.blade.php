@extends('layouts.app')

@section('title', 'Editar cita')

@section('content')
    <div class="container-fluid py-4 px-5">

        @error('hora')
            <div class="alert alert-danger rounded-3 py-2 px-3 mt-2" style="font-size:13px;">
                <i class="bi bi-exclamation-circle me-1"></i>
                {{ $message }}
            </div>
        @enderror

        <!-- Header -->
        <div class="d-flex align-items-center mb-4">

            <a href="{{ route('citas.index') }}" class="btn btn-sm btn-light rounded-pill px-3 me-2">
                <i class="bi bi-arrow-left"></i>
            </a>

            <div>
                <h2 class="fw-bold text-dark mb-1">Editar cita</h2>
            </div>
        </div>

        <form action="{{ route('citas.update', $cita->idCita) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Resumen de cita -->
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4">

                    <h5 class="fw-bold mb-4">
                        <i class="bi bi-calendar-check me-2 text-primary"></i>
                        Información de la cita
                    </h5>

                    <div class="row g-3">

                        <div class="col-md-4">
                            <label class="form-label">Fecha</label>
                            <input type="date" name="fecha" class="form-control border-secondary-subtle bg-white"
                                value="{{ $cita->fecha }}">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Hora</label>
                            <input type="time" name="hora" class="form-control border-secondary-subtle bg-white"
                                value="{{ $cita->hora }}">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Odontólogo</label>

                            <div class="position-relative">
                                <input type="text" id="odontologo_nombre" class="form-control"
                                    value="{{ $cita->odontologo->persona->nombre }} {{ $cita->odontologo->persona->apellido }}">

                                <i
                                    class="bi bi-search position-absolute top-50 end-0 translate-middle-y me-3 text-muted"></i>
                            </div>

                            <div id="resultadosOdontologos" class="list-group mt-1 shadow-sm">
                            </div>

                            <input type="hidden" name="idOdontologo" id="odontologo_id" value="{{ $cita->idOdontologo }}">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Estado</label>
                            <select name="estado" class="form-select border-secondary-subtle bg-white">
                                @foreach(['Pendiente', 'Confirmada', 'Completada', 'Cancelada'] as $estado)
                                    <option value="{{ $estado }}" {{ $cita->estado == $estado ? 'selected' : '' }}>
                                        {{ $estado }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                    </div>

                </div>
            </div>

            <!-- Datos de la persona -->
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-body p-4">

                    <h5 class="fw-bold mb-4">
                        <i class="bi bi-person me-2 text-primary"></i>
                        Datos de la persona
                    </h5>

                    <div class="row g-3">

                        <div class="col-md-6">
                            <label class="form-label">Nombre de la persona</label>
                            <input type="text" name="nombrePersona" class="form-control border-secondary-subtle bg-white"
                                value="{{ $cita->nombrePersona }}">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Teléfono</label>
                            <input type="text" name="telefono"
                                class="form-control border-secondary-subtle bg-white mask-telefono-rd"
                                value="{{ $cita->telefono }}">
                        </div>

                        <div class="col-12">
                            <label class="form-label">Correo</label>
                            <input type="email" name="correo" class="form-control border-secondary-subtle bg-white"
                                value="{{ $cita->correo }}">
                        </div>

                    </div>

                </div>
            </div>

            <!-- Botones -->
            <div class="d-flex justify-content-end gap-2">
                <a href="{{ route('citas.index') }}" class="btn btn-light rounded-pill px-4">
                    Cancelar
                </a>

                <button type="submit" class="btn rounded-pill px-4 text-white" style="background-color: #0ea5e9;">
                    <i class="bi bi-arrow-clockwise"></i>
                    Actualizar
                </button>

            </div>

        </form>

    </div>

    @section('scripts')
        <script src="{{ asset('js/citas.js') }}"></script>
    @endsection

@endsection