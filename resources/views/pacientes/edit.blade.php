@extends('layouts.app')

@section('title', 'Editar Paciente')

@section('content')

<div class="container-fluid py-4 px-5">

    <!-- Header -->
    <div class="d-flex align-items-center mb-4">
        <a href="{{ route('pacientes.index') }}" class="btn btn-light btn-sm rounded-pill me-3">
            <i class="bi bi-arrow-left"></i>
        </a>

        <div>
            <h2 class="fw-bold text-dark mb-1">
                <i class="bi bi-pencil-fill me-2 text-primary"></i>
                Editar Paciente
            </h2>
            <p class="text-muted small mb-0">
                Modifica los datos del paciente.
            </p>
        </div>
    </div>

    <!-- Card -->
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">

            <form action="{{ route('pacientes.update', 1) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- DATOS PERSONALES -->
                <h6 class="text-primary text-uppercase fw-bold mb-3 small" style="letter-spacing: 1px;">
                    Datos Personales
                </h6>

                <div class="row g-3 mb-4">

                    <div class="col-md-4">
                        <label class="form-label text-muted small fw-bold">Cédula</label>
                        <input type="text" name="cedula"
                               class="form-control rounded-3 border-secondary-subtle bg-white"
                               value="402-0000000-1">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label text-muted small fw-bold">Nombre</label>
                        <input type="text" name="nombre"
                               class="form-control rounded-3 border-secondary-subtle bg-white"
                               value="Juan">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label text-muted small fw-bold">Apellido</label>
                        <input type="text" name="apellido"
                               class="form-control rounded-3 border-secondary-subtle bg-white"
                               value="Martínez">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label text-muted small fw-bold">Fecha de nacimiento</label>
                        <input type="text" name="fecha_nacimiento"
                               class="form-control rounded-3 border-secondary-subtle bg-white"
                               value="01/05/1998">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label text-muted small fw-bold">Teléfono</label>
                        <input type="text" name="telefono"
                               class="form-control rounded-3 border-secondary-subtle bg-white"
                               value="809-555-0123">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label text-muted small fw-bold">Correo</label>
                        <input type="email" name="correo"
                               class="form-control rounded-3 border-secondary-subtle bg-white"
                               value="juan@email.com">
                    </div>

                </div>

                <!-- INFO CLINICA -->
                <h6 class="text-primary text-uppercase fw-bold mb-3 small" style="letter-spacing: 1px;">
                    Información Clínica
                </h6>

                <div class="row g-3 mb-4">

                    <div class="col-md-6">
                        <label class="form-label text-muted small fw-bold">Alergias</label>

                        <div class="border rounded-3 p-3 bg-white">

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="alergias[]" value="1" id="alergia1" checked>
                                <label class="form-check-label" for="alergia1">Penicilina</label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="alergias[]" value="2" id="alergia2">
                                <label class="form-check-label" for="alergia2">Látex</label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="alergias[]" value="3" id="alergia3" checked>
                                <label class="form-check-label" for="alergia3">Anestesia</label>
                            </div>

                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label text-muted small fw-bold">Antecedentes médicos</label>
                        <textarea name="antecedentes"
                                  class="form-control rounded-3 border-secondary-subtle bg-white"
                                  rows="5">Diabetes, Hipertensión</textarea>
                    </div>

                </div>

                <!-- BOTONES -->
                <div class="d-flex justify-content-end gap-2 border-top pt-3">

                    <a href="{{ route('pacientes.index') }}" class="btn btn-light rounded-pill px-4 py-2">
                        Cancelar
                    </a>

                    <button type="submit" class="btn btn-primary text-white rounded-pill px-4 py-2 shadow-sm">
                        <i class="bi bi-save me-2"></i>Actualizar
                    </button>

                </div>

            </form>

        </div>
    </div>

</div>

@endsection