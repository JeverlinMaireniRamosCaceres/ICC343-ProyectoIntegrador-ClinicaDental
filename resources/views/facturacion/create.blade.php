@extends('layouts.app')

@section('title', 'Facturar')

@section('content')

<div class="container py-4">

    {{-- HEADER --}}
    <div class="d-flex align-items-center justify-content-between mb-4">

        <div>

            <h2 class="fw-semibold mb-1">
                Nueva Factura
            </h2>

            <p class="text-muted mb-0">
                Generar factura desde consultas pendientes
            </p>

        </div>

        <button class="btn btn-primary rounded-pill px-4 d-flex align-items-center gap-2"
                data-bs-toggle="modal"
                data-bs-target="#modalPaciente">

            <i class="bi bi-person-plus"></i>

            Seleccionar Paciente

        </button>

    </div>

    <div class="row g-4">

        {{-- LEFT --}}
        <div class="col-lg-8">

            {{-- PACIENTE --}}
            <div class="card border-0 shadow-sm rounded-4 mb-4">

                <div class="card-body p-4">

                    <div class="d-flex align-items-center justify-content-between mb-4">

                        <h5 class="fw-semibold mb-0">
                            Paciente Seleccionado
                        </h5>

                        <button class="btn btn-light btn-sm rounded-pill px-3"
                                data-bs-toggle="modal"
                                data-bs-target="#modalPaciente">

                            Cambiar

                        </button>

                    </div>

                    <div class="row g-4">

                        <div class="col-md-6">

                            <small class="text-muted d-block">
                                Nombre
                            </small>

                            <span class="fw-medium">
                                Juan Pérez
                            </span>

                        </div>

                        <div class="col-md-6">

                            <small class="text-muted d-block">
                                Cédula
                            </small>

                            <span class="fw-medium">
                                001-1234567-8
                            </span>

                        </div>

                        <div class="col-md-6">

                            <small class="text-muted d-block">
                                Teléfono
                            </small>

                            <span class="fw-medium">
                                809-555-1234
                            </span>

                        </div>

                        <div class="col-md-6">

                            <small class="text-muted d-block">
                                Balance Pendiente
                            </small>

                            <span class="fw-semibold text-danger">
                                RD$ 4,000
                            </span>

                        </div>

                    </div>

                </div>

            </div>

            {{-- CONSULTAS --}}
            <div class="card border-0 shadow-sm rounded-4 mb-4">

                <div class="card-body p-0">

                    <div class="p-4 border-bottom">

                        <h5 class="fw-semibold mb-0">
                            Consultas Pendientes
                        </h5>

                    </div>

                    <div class="px-3 pb-3">

                        <div class="table-responsive">

                            <table class="table table-hover align-middle mb-0">

                                <thead class="table-light">

                                    <tr>

                                        <th class="px-4 py-3 text-muted fw-semibold small">
                                            Fecha
                                        </th>

                                        <th class="px-4 py-3 text-muted fw-semibold small">
                                            Odontólogo
                                        </th>

                                        <th class="px-4 py-3 text-muted fw-semibold small">
                                            Motivo
                                        </th>

                                        <th class="px-4 py-3 text-muted fw-semibold small">
                                            Estado
                                        </th>

                                        <th class="px-4 py-3 text-muted fw-semibold small">
                                            Acción
                                        </th>

                                    </tr>

                                </thead>

                                <tbody>

                                    <tr>

                                        <td class="px-4">
                                            09/05/2026
                                        </td>

                                        <td class="px-4">
                                            Dr. García
                                        </td>

                                        <td class="px-4">
                                            Dolor Dental
                                        </td>

                                        <td class="px-4">

                                            <span class="badge rounded-pill text-bg-warning">
                                                Pendiente
                                            </span>

                                        </td>

                                        <td class="px-4">

                                            <button class="btn btn-sm btn-primary rounded-pill px-3">

                                                Seleccionar

                                            </button>

                                        </td>

                                    </tr>

                                </tbody>

                            </table>

                        </div>

                    </div>

                </div>

            </div>

            {{-- PROCEDIMIENTOS --}}
            <div class="card border-0 shadow-sm rounded-4">

                <div class="card-body p-0">

                    <div class="p-4 border-bottom">

                        <h5 class="fw-semibold mb-1">
                            Procedimientos
                        </h5>

                        <small class="text-muted">
                            Cargados automáticamente desde la consulta seleccionada
                        </small>

                    </div>

                    <div class="px-3 pb-3">

                        <div class="table-responsive">

                            <table class="table table-hover align-middle mb-0">

                                <thead class="table-light">

                                    <tr>

                                        <th class="px-4 py-3 text-muted fw-semibold small">
                                            Procedimiento
                                        </th>

                                        <th class="px-4 py-3 text-muted fw-semibold small">
                                            Cantidad
                                        </th>

                                        <th class="px-4 py-3 text-muted fw-semibold small">
                                            Precio
                                        </th>

                                        <th class="px-4 py-3 text-muted fw-semibold small">
                                            Subtotal
                                        </th>

                                    </tr>

                                </thead>

                                <tbody>

                                    <tr>

                                        <td class="px-4">
                                            Limpieza Dental
                                        </td>

                                        <td class="px-4">
                                            1
                                        </td>

                                        <td class="px-4">
                                            RD$ 1,500
                                        </td>

                                        <td class="px-4 fw-medium">
                                            RD$ 1,500
                                        </td>

                                    </tr>

                                    <tr>

                                        <td class="px-4">
                                            Resina
                                        </td>

                                        <td class="px-4">
                                            2
                                        </td>

                                        <td class="px-4">
                                            RD$ 2,500
                                        </td>

                                        <td class="px-4 fw-medium">
                                            RD$ 5,000
                                        </td>

                                    </tr>

                                </tbody>

                            </table>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        {{-- RIGHT --}}
        <div class="col-lg-4">

            {{-- CONFIGURACION --}}
            <div class="card border-0 shadow-sm rounded-4 mb-4">

                <div class="card-body p-4">

                    <h5 class="fw-semibold mb-4">
                        Configuración Factura
                    </h5>

                    {{-- TIPO DESCUENTO --}}
                    <div class="mb-4">

                        <label class="form-label text-muted small">
                            Tipo de descuento
                        </label>

                        <select class="form-select rounded-3">

                            <option>Sin descuento</option>
                            <option>Monto</option>
                            <option>Porcentaje</option>

                        </select>

                    </div>

                    {{-- VALOR DESCUENTO --}}
                    <div class="mb-4">

                        <label class="form-label text-muted small">
                            Valor descuento
                        </label>

                        <input type="number"
                               class="form-control rounded-3"
                               placeholder="0">

                    </div>

                    {{-- CUOTAS --}}
                    <div class="mb-4">

                        <label class="form-label text-muted small">
                            Cantidad de cuotas
                        </label>

                        <input type="number"
                               class="form-control rounded-3"
                               value="3">

                    </div>

                    {{-- MONTO CUOTA --}}
                    <div>

                        <label class="form-label text-muted small">
                            Monto por cuota
                        </label>

                        <div class="form-control rounded-3 bg-light">

                            RD$ 2,000

                        </div>

                    </div>

                </div>

            </div>

            {{-- RESUMEN --}}
            <div class="card border-0 shadow-sm rounded-4">

                <div class="card-body p-4">

                    <h5 class="fw-semibold mb-4">
                        Resumen
                    </h5>

                    <div class="d-flex justify-content-between mb-3">

                        <span class="text-muted">
                            Subtotal
                        </span>

                        <span class="fw-medium">
                            RD$ 6,500
                        </span>

                    </div>

                    <div class="d-flex justify-content-between mb-3">

                        <span class="text-muted">
                            Descuento
                        </span>

                        <span class="fw-medium text-danger">
                            - RD$ 500
                        </span>

                    </div>

                    <hr>

                    <div class="d-flex justify-content-between mb-4">

                        <span class="fw-semibold">
                            Total
                        </span>

                        <span class="fw-bold fs-4">
                            RD$ 6,000
                        </span>

                    </div>

                    <button class="btn btn-primary w-100 rounded-pill py-3">

                        Generar Factura

                    </button>

                </div>

            </div>

        </div>

    </div>

</div>

{{-- MODAL PACIENTE --}}
<div class="modal fade"
     id="modalPaciente"
     tabindex="-1"
     aria-hidden="true">

    <div class="modal-dialog modal-lg modal-dialog-centered">

        <div class="modal-content border-0 rounded-4">

            {{-- HEADER --}}
            <div class="modal-header border-0 px-4 pt-4">

                <h5 class="modal-title fw-semibold">
                    Buscar Paciente
                </h5>

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                </button>

            </div>

            {{-- BODY --}}
            <div class="modal-body px-4 pb-4">

                {{-- SEARCH --}}
                <div class="mb-4">

                    <div class="d-flex align-items-center gap-2 px-3 py-2 bg-light rounded-pill border border-transparent"
                         style="transition: border-color 0.2s;"
                         onfocusin="this.style.background='#fff'; this.style.borderColor='#2563EB';"
                         onfocusout="this.style.background=''; this.style.borderColor='transparent';">

                        <i class="bi bi-search text-secondary"
                           style="font-size: 14px;">
                        </i>

                        <input type="text"
                               class="border-0 bg-transparent p-0 w-100"
                               style="outline: none; font-size: 14px;"
                               placeholder="Buscar paciente...">

                    </div>

                </div>

                {{-- TABLE --}}
                <div class="px-3 pb-3">

                    <div class="table-responsive">

                        <table class="table table-hover align-middle mb-0">

                            <thead class="table-light">

                                <tr>

                                    <th class="px-4 py-3 text-muted fw-semibold small">
                                        Nombre
                                    </th>

                                    <th class="px-4 py-3 text-muted fw-semibold small">
                                        Cédula
                                    </th>

                                    <th class="px-4 py-3 text-muted fw-semibold small">
                                        Teléfono
                                    </th>

                                    <th class="px-4 py-3 text-muted fw-semibold small">
                                        Acción
                                    </th>

                                </tr>

                            </thead>

                            <tbody>

                                <tr>

                                    <td class="px-4 fw-medium">
                                        Juan Pérez
                                    </td>

                                    <td class="px-4 text-muted">
                                        001-1234567-8
                                    </td>

                                    <td class="px-4 text-muted">
                                        809-555-1234
                                    </td>

                                    <td class="px-4">

                                        <button class="btn btn-primary btn-sm rounded-pill px-3">

                                            Seleccionar

                                        </button>

                                    </td>

                                </tr>

                                <tr>

                                    <td class="px-4 fw-medium">
                                        María López
                                    </td>

                                    <td class="px-4 text-muted">
                                        402-9876543-1
                                    </td>

                                    <td class="px-4 text-muted">
                                        829-555-7890
                                    </td>

                                    <td class="px-4">

                                        <button class="btn btn-primary btn-sm rounded-pill px-3">

                                            Seleccionar

                                        </button>

                                    </td>

                                </tr>

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection
