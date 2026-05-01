@extends('layouts.app')

@section('title', 'Nuevo Paciente')

@section('content')

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <div class="card border-0 shadow-lg rounded-4">
                <div class="card-body p-5">
                    <h3 class="fw-bold text-dark mb-4"><i class="bi bi-person-plus me-2 text-info"></i>Nuevo Paciente</h3>
                    
                    <form>
                        <!-- Sección: Datos Personales -->
                        <h6 class="text-info text-uppercase fw-bold mb-3 small" style="letter-spacing: 1px;">Datos Personales</h6>
                        <div class="row g-3 mb-4">
                            <div class="col-md-4">
                                <label class="form-label text-muted small fw-bold">Cédula</label>
                                <input type="text" class="form-control rounded-3 border-light bg-light" placeholder="000-0000000-0">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label text-muted small fw-bold">Nombre</label>
                                <input type="text" class="form-control rounded-3 border-light bg-light">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label text-muted small fw-bold">Apellido</label>
                                <input type="text" class="form-control rounded-3 border-light bg-light">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label text-muted small fw-bold">Fecha de Nacimiento</label>
                                <input type="date" class="form-control rounded-3 border-light bg-light">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label text-muted small fw-bold">Teléfono</label>
                                <input type="text" class="form-control rounded-3 border-light bg-light">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label text-muted small fw-bold">Correo</label>
                                <input type="email" class="form-control rounded-3 border-light bg-light">
                            </div>
                        </div>

                        <!-- Sección: Información Clínica -->
                        <h6 class="text-info text-uppercase fw-bold mb-3 small" style="letter-spacing: 1px;">Información Clínica</h6>
                        <div class="row g-3 mb-5">
                            <div class="col-md-6">
                                <label class="form-label text-muted small fw-bold">Alergias</label>
                                <textarea class="form-control rounded-3 border-light bg-light" rows="3" placeholder="Ninguna / Penicilina..."></textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label text-muted small fw-bold">Antecedentes Médicos</label>
                                <textarea class="form-control rounded-3 border-light bg-light" rows="3" placeholder="Diabetes, Hipertensión..."></textarea>
                            </div>
                        </div>

                        <!-- Botones de Acción -->
                        <div class="d-flex justify-content-end gap-2 border-top pt-4">
                            <button type="button" class="btn btn-light rounded-pill px-4 py-2">Cancelar</button>
                            <button type="submit" class="btn btn-info text-white rounded-pill px-4 py-2 shadow-sm">
                                <i class="bi bi-save me-2"></i>Guardar Paciente
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection