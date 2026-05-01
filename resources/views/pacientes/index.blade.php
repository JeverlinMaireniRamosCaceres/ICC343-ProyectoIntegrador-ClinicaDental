@extends('layouts.app')

@section('title', 'Pacientes')

@section('content')
<div class="container-fluid py-4">
    <!-- Encabezado de Módulo -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold text-dark mb-1">Pacientes</h2>
            <p class="text-muted small">Listado y gestión de la base de datos de pacientes.</p>
        </div>
        <a href="{{ route('pacientes.create') }}" class="btn btn-info text-white px-4 py-2 rounded-pill shadow-sm">
            <i class="bi bi-plus-lg me-2"></i>Nuevo Paciente
        </a>
    </div>

    <!-- Barra de Búsqueda y Filtros -->
    <div class="card border-0 shadow-sm mb-4 rounded-4">
        <div class="card-body p-3">
            <div class="row g-3">
                <div class="col-md-6">
                    <div class="input-group border rounded-pill px-3 bg-light">
                        <span class="input-group-text bg-transparent border-0"><i class="bi bi-search text-muted"></i></span>
                        <input type="text" class="form-control bg-transparent border-0" placeholder="Buscar por nombre, cédula o teléfono...">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla de Pacientes -->
    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4 border-0 text-muted small text-uppercase py-3">Nombre Completo</th>
                        <th class="border-0 text-muted small text-uppercase">Cédula</th>
                        <th class="border-0 text-muted small text-uppercase">Teléfono</th>
                        <th class="border-0 text-muted small text-uppercase">Correo</th>
                        <th class="border-0 text-muted small text-uppercase">Edad</th>
                        <th class="border-0 text-muted small text-uppercase pe-4 text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="ps-4 py-3">
                            <div class="d-flex align-items-center">
                                <div class="bg-info bg-opacity-10 text-info rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                    <span class="fw-bold">JM</span>
                                </div>
                                <span class="fw-semibold text-dark">Juan Martínez</span>
                            </div>
                        </td>
                        <td>402-0000000-1</td>
                        <td>809-555-0123</td>
                        <td class="text-muted">juan.m@email.com</td>
                        <td>28 años</td>
                        <td class="pe-4 text-end">
                            <div class="btn-group">
                                <a href="{{ route('pacientes.show', 1) }}" class="btn btn-light btn-sm rounded-pill me-1 text-secondary">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('pacientes.edit', 1) }}" class="btn btn-light btn-sm rounded-pill me-1 text-primary">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-light btn-sm rounded-pill text-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                            </div>
                        </td>
                    </tr>
                    <!-- Más filas... -->
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection