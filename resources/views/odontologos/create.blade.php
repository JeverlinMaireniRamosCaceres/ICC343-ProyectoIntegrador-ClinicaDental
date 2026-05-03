@extends('layouts.app')

@section('title', 'Nuevo Odontólogo')

@section('content')
<div class="container-fluid py-4 px-5">

    <!-- Header -->
    <div class="d-flex align-items-center mb-4">
        <a href="{{ route('odontologos.index') }}" class="btn btn-light btn-sm rounded-pill me-3">
            <i class="bi bi-arrow-left"></i>
        </a>

        <h2 class="fw-bold text-dark mb-0">Nuevo odontólogo</h2>
    </div>

    <form action="{{ route('odontologos.store') }}" method="POST">
        @csrf

        <!-- Datos personales -->
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-body p-4">

                <h5 class="fw-bold mb-4">
                    <i class="bi bi-person me-2 text-primary"></i>
                    Datos personales
                </h5>

                <div class="row g-3">

                    <div class="col-md-6">
                        <label class="form-label">Nombre</label>
                        <input type="text"
                               name="nombre"
                               class="form-control border-secondary-subtle bg-white"
                               placeholder="Ej: Juan">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Apellido</label>
                        <input type="text"
                               name="apellido"
                               class="form-control border-secondary-subtle bg-white"
                               placeholder="Ej: Pérez">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Cédula</label>
                        <input type="text"
                               name="cedula"
                               class="form-control border-secondary-subtle bg-white"
                               placeholder="Ej: 001-1234567-8">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Fecha de nacimiento</label>
                        <input type="date"
                               name="fechaNacimiento"
                               class="form-control border-secondary-subtle bg-white">
                    </div>

                </div>

            </div>
        </div>

        <!-- Contacto -->
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-body p-4">

                <h5 class="fw-bold mb-4">
                    <i class="bi bi-telephone me-2 text-primary"></i>
                    Información de contacto
                </h5>

                <div class="row g-3">

                    <div class="col-md-6">
                        <label class="form-label">Teléfono</label>
                        <input type="text"
                               name="telefono"
                               class="form-control border-secondary-subtle bg-white"
                               placeholder="Ej: 809-555-1234">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Correo electrónico</label>
                        <input type="email"
                               name="correo"
                               class="form-control border-secondary-subtle bg-white"
                               placeholder="Ej: odontologo@clinica.com">
                    </div>

                </div>

            </div>
        </div>

        <!-- Información profesional -->
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-body p-4">

                <h5 class="fw-bold mb-4">
                    <i class="bi bi-award me-2 text-primary"></i>
                    Información profesional
                </h5>

                <div class="row g-3">

                    <div class="col-md-6">
                        <label class="form-label">Exequatur</label>
                        <input type="text"
                               name="exequatur"
                               class="form-control border-secondary-subtle bg-white"
                               placeholder="Ej: 12345">
                    </div>

                    <div class="col-12">
                        <label class="form-label">Especialidades</label>

                        <div class="row g-2">

                            <div class="col-md-4">
                                <div class="form-check border rounded-3 p-3 ps-5 bg-white">
                                    <input class="form-check-input" type="checkbox" name="especialidades[]" value="Odontología general" id="general">
                                    <label class="form-check-label" for="general">
                                        Odontología general
                                    </label>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-check border rounded-3 p-3 ps-5 bg-white">
                                    <input class="form-check-input" type="checkbox" name="especialidades[]" value="Ortodoncia" id="ortodoncia">
                                    <label class="form-check-label" for="ortodoncia">
                                        Ortodoncia
                                    </label>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-check border rounded-3 p-3 ps-5 bg-white">
                                    <input class="form-check-input" type="checkbox" name="especialidades[]" value="Endodoncia" id="endodoncia">
                                    <label class="form-check-label" for="endodoncia">
                                        Endodoncia
                                    </label>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-check border rounded-3 p-3 ps-5 bg-white">
                                    <input class="form-check-input" type="checkbox" name="especialidades[]" value="Periodoncia" id="periodoncia">
                                    <label class="form-check-label" for="periodoncia">
                                        Periodoncia
                                    </label>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-check border rounded-3 p-3 ps-5 bg-white">
                                    <input class="form-check-input" type="checkbox" name="especialidades[]" value="Cirugía oral" id="cirugia">
                                    <label class="form-check-label" for="cirugia">
                                        Cirugía oral
                                    </label>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-check border rounded-3 p-3 ps-5 bg-white">
                                    <input class="form-check-input" type="checkbox" name="especialidades[]" value="Odontopediatría" id="odontopediatria">
                                    <label class="form-check-label" for="odontopediatria">
                                        Odontopediatría
                                    </label>
                                </div>
                            </div>

                        </div>

                    </div>

                </div>

            </div>
        </div>

        <!-- Botones -->
        <div class="d-flex justify-content-end gap-2">
            <a href="{{ route('odontologos.index') }}" class="btn btn-light rounded-pill px-4">
                Cancelar
            </a>

            <button type="submit" class="btn btn-primary rounded-pill px-4">
                Guardar
            </button>
        </div>

    </form>

</div>
@endsection