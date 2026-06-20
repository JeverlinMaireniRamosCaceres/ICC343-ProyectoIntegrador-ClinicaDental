@extends('layouts.app')

@section('title', 'Consultas')

@section('content')

<div class="container-fluid py-2 px-2">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="fw-bold text-dark mb-1">Consultas</h2>
        </div>

        <a href="{{ route('consultas.create') }}"
           class="btn btn-primary rounded-pill px-4 shadow-sm">
            <i class="bi bi-plus-lg me-1"></i>
            Nueva consulta
        </a>

    </div>

    <!-- Tabla -->
    <div class="card border-0 shadow-sm rounded-4">

        <div class="card-body p-0">

            <div class="p-4 border-bottom">

                <div class="position-relative" style="max-width: 350px;">

                    <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>

                    <input type="text"
                           class="form-control rounded-pill ps-5 border-0 bg-light"
                           placeholder="Buscar consulta...">

                </div>

            </div>

            <!-- tabla con consultas -->
            <div class="table-responsive">

                <table class="table align-middle mb-0">

                    <thead class="table-light">
                        <tr>
                            <th class="ps-4">ID</th>
                            <th>Paciente</th>
                            <th>Odontólogo</th>
                            <th>Fecha</th>
                            <th>Motivo</th>
                            <th>Estado</th>
                            <th class="text-center pe-4">Acciones</th>
                        </tr>
                    </thead>

                    <tbody>

                        <!-- Consulta ejemplo 1 -->
                        <tr>

                            <td class="ps-4 fw-semibold">1</td>

                            <td>
                                <div class="fw-semibold text-dark">
                                    Ana Martínez
                                </div>

                                <small class="text-muted">
                                    809-555-1234
                                </small>
                            </td>

                            <td>
                                Dr. Juan Pérez
                            </td>

                            <td>
                                10/05/2026
                            </td>

                            <td>
                                Dolor dental
                            </td>

                            <td>
                                <span class="badge rounded-pill px-3 py-2 text-success bg-success-subtle">
                                    Finalizada
                                </span>
                            </td>

                            <td class="text-center pe-4">

                                <a href="#"
                                   class="btn btn-sm btn-secondary rounded-pill px-3">
                                    <i class="bi bi-eye"></i>
                                </a>

                            </td>

                        </tr>

                        <!-- Consulta ejemplo 2 -->
                        <tr>

                            <td class="ps-4 fw-semibold">2</td>

                            <td>
                                <div class="fw-semibold text-dark">
                                    Carlos Gómez
                                </div>

                                <small class="text-muted">
                                    809-888-4567
                                </small>
                            </td>

                            <td>
                                Dra. Laura Gómez
                            </td>

                            <td>
                                09/05/2026
                            </td>

                            <td>
                                Limpieza general
                            </td>

                            <td>
                                <span class="badge rounded-pill px-3 py-2 text-primary bg-primary-subtle">
                                    Registrada
                                </span>
                            </td>

                            <td class="text-center pe-4">

                                <a href="#"
                                   class="btn btn-sm btn-secondary rounded-pill px-3">
                                    <i class="bi bi-eye"></i>
                                </a>

                            </td>

                        </tr>

                        <!-- Consulta ejemplo 3 -->
                        <tr>

                            <td class="ps-4 fw-semibold">3</td>

                            <td>
                                <div class="fw-semibold text-dark">
                                    María Rodríguez
                                </div>

                                <small class="text-muted">
                                    829-222-1111
                                </small>
                            </td>

                            <td>
                                Dr. Carlos Ramírez
                            </td>

                            <td>
                                08/05/2026
                            </td>

                            <td>
                                Evaluación ortodoncia
                            </td>

                            <td>
                                <span class="badge rounded-pill px-3 py-2 text-warning bg-warning-subtle">
                                    En proceso
                                </span>
                            </td>

                            <td class="text-center pe-4">

                                <a href="#"
                                   class="btn btn-sm btn-secondary rounded-pill px-3">
                                    <i class="bi bi-eye"></i>
                                </a>

                            </td>

                        </tr>

                    </tbody>

                </table>

            </div>

            <!-- paginacion -->
            <div class="d-flex justify-content-between align-items-center p-4 border-top">

                <span class="text-muted small">
                    Mostrando 1–3 de 3 resultados
                </span>

                <nav>
                    <ul class="pagination pagination-sm mb-0">

                        <li class="page-item disabled">
                            <a class="page-link" href="#">
                                ‹
                            </a>
                        </li>

                        <li class="page-item active">
                            <a class="page-link" href="#">
                                1
                            </a>
                        </li>

                        <li class="page-item disabled">
                            <a class="page-link" href="#">
                                ›
                            </a>
                        </li>

                    </ul>
                </nav>

            </div>

        </div>

    </div>

</div>

@include('consultas.partials.modal-create-paciente')
@include('consultas.partials.modal-create-tratamiento')

@endsection