@extends('layouts.app')

@section('title', 'Editar cita')

@section('content')
    <div class="container-fluid py-4 px-5">

        <!-- Header -->
        <div class="d-flex align-items-center mb-4">
            <a href="{{ route('citas.index') }}" class="btn btn-light btn-sm rounded-pill me-3">
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
                            <select name="idOdontologo" class="form-select border-secondary-subtle bg-white">
                                @foreach($odontologos as $o)
                                    <option value="{{ $o->idOdontologo }}" {{ $cita->idOdontologo == $o->idOdontologo ? 'selected' : '' }}>
                                        {{ $o->persona->nombre }} {{ $o->persona->apellido }}
                                    </option>
                                @endforeach
                            </select>
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
                            <input type="text" name="telefono" class="form-control border-secondary-subtle bg-white"
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

                <button type="submit" class="btn btn-primary rounded-pill px-4">
                    Actualizar
                </button>
            </div>

        </form>

    </div>
@endsection