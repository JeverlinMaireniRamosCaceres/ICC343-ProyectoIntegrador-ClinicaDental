@extends('layouts.app')

@section('title', 'Nuevo Paciente')

@section('content')

<div class="container-fluid py-4 px-5">

    <!-- HEADER -->
    <div class="d-flex align-items-center mb-4">
        <a href="{{ route('pacientes.index') }}" class="btn btn-light btn-sm rounded-pill me-3">
            <i class="bi bi-arrow-left"></i>
        </a>

        <div>
            <h2 class="fw-bold text-dark mb-1">
                <i class="bi bi-person-plus me-2 text-primary"></i>
                Nuevo paciente
            </h2>
        </div>
    </div>

    <!-- CARD PRINCIPAL -->
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">

            <form>

                <!-- DATOS PERSONALES -->
                <h6 class="text-primary text-uppercase fw-bold mb-3 small" style="letter-spacing: 1px;">
                    Datos Personales
                </h6>

                <div class="row g-3 mb-4">
                    <div class="col-md-4">
                        <label class="form-label text-muted small fw-bold">Cédula</label>
                        <input type="text" class="form-control rounded-3 border-secondary-subtle bg-white" placeholder="000-0000000-0">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label text-muted small fw-bold">Nombre</label>
                        <input type="text" class="form-control rounded-3 border-secondary-subtle bg-white">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label text-muted small fw-bold">Apellido</label>
                        <input type="text" class="form-control rounded-3 border-secondary-subtle bg-white">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label text-muted small fw-bold">Fecha de nacimiento</label>
                        <input 
                            type="text" 
                            id="fechaNacimiento"
                            name="fechaNacimiento"
                            class="form-control rounded-3 border-secondary-subtle bg-white"
                            placeholder="dd/mm/aaaa"
                        >
                    </div>

                    <div class="col-md-4">
                        <label class="form-label text-muted small fw-bold">Teléfono</label>
                        <input type="text" class="form-control rounded-3 border-secondary-subtle bg-white">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label text-muted small fw-bold">Correo</label>
                        <input type="email" class="form-control rounded-3 border-secondary-subtle bg-white">
                    </div>
                </div>

                <!-- INFORMACION CLINICA -->
                <h6 class="text-primary text-uppercase fw-bold mb-3 small" style="letter-spacing: 1px;">
                    Información Clínica
                </h6>

                <div class="row g-3 mb-4">
                    <!-- ALERGIAS -->
                        <div class="col-md-6">
                            <label class="form-label text-muted small fw-bold">Alergias</label>

                            <div class="border rounded-3 p-3 bg-white">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="alergias[]" value="1" id="alergia1">
                                    <label class="form-check-label" for="alergia1">Penicilina</label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="alergias[]" value="2" id="alergia2">
                                    <label class="form-check-label" for="alergia2">Látex</label>
                                </div>

                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="alergias[]" value="3" id="alergia3">
                                    <label class="form-check-label" for="alergia3">Anestesia</label>
                                </div>
                            </div>
                        </div>

                    <div class="col-md-6">
                        <label class="form-label text-muted small fw-bold">Antecedentes médicos</label>
                        <textarea class="form-control rounded-3 border-secondary-subtle bg-white"
                            rows="5"
                            placeholder="Diabetes, Hipertensión..."></textarea>
                    </div>
                </div>

                <!-- BOTONES -->
                <div class="d-flex justify-content-end gap-2 border-top pt-3">
                    <a href="{{ route('pacientes.index') }}" class="btn btn-light rounded-pill px-4 py-2">
                        Cancelar
                    </a>

                    <button type="submit" class="btn btn-primary text-white rounded-pill px-4 py-2 shadow-sm">
                        <i class="bi bi-save me-2"></i>Guardar
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>

@endsection

<script>
    document.addEventListener('DOMContentLoaded', function () {
        flatpickr("#fechaNacimiento", {
            dateFormat: "d/m/Y",
            allowInput: true,
            maxDate: "today"
        });
    });
</script>