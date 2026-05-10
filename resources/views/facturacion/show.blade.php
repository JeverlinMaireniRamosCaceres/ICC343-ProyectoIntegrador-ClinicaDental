{{-- resources/views/facturacion/show.blade.php --}}

@extends('layouts.app')

@section('title', 'Detalle Factura')

@section('content')

    <div class="container py-4">

        {{-- HEADER --}}
        <div class="d-flex align-items-center justify-content-between mb-4">

            <div>

                <h2 class="fw-semibold mb-1">
                    Factura #00015
                </h2>

            </div>

            <div class="d-flex gap-2">

                {{-- IMPRIMIR --}}
                <button class="btn btn-light rounded-pill px-4">

                    <i class="bi bi-printer me-2"></i>

                    Imprimir

                </button>

                {{-- ANULAR --}}
                <button class="btn btn-danger rounded-pill px-4">

                    <i class="bi bi-x-circle me-2"></i>

                    Anular

                </button>

            </div>

        </div>

        <div class="row g-4">

            {{-- LEFT --}}
            <div class="col-lg-8">

                {{-- PACIENTE --}}
                <div class="card border-0 shadow-sm rounded-4 mb-4">

                    <div class="card-body p-4">

                        <div class="d-flex align-items-center justify-content-between mb-4">

                            <div>

                                <h5 class="fw-semibold mb-1">
                                    Juan Pérez
                                </h5>

                                <small class="text-muted">
                                    Información del paciente
                                </small>

                            </div>

                        </div>

                        <div class="row g-4">

                            <div class="col-md-4">

                                <small class="text-muted d-block mb-1">
                                    Cédula
                                </small>

                                <div class="fw-medium">
                                    001-1234567-8
                                </div>

                            </div>

                            <div class="col-md-4">

                                <small class="text-muted d-block mb-1">
                                    Teléfono
                                </small>

                                <div class="fw-medium">
                                    809-555-1234
                                </div>

                            </div>

                            <div class="col-md-4">

                                <small class="text-muted d-block mb-1">
                                    Fecha Factura
                                </small>

                                <div class="fw-medium">
                                    09/05/2026
                                </div>

                            </div>

                        </div>

                    </div>

                </div>

                {{-- TABS --}}
                <div class="card border-0 shadow-sm rounded-4">

                    {{-- NAV --}}
                    <div class="border-bottom px-4 pt-4">

                        <ul class="nav nav-pills gap-2 mb-4">

                            {{-- PROCEDIMIENTOS --}}
                            <li class="nav-item">

                                <button class="nav-link active rounded-pill px-4" data-bs-toggle="tab"
                                    data-bs-target="#procedimientos">

                                    Procedimientos

                                </button>

                            </li>

                            {{-- CUOTAS --}}
                            <li class="nav-item">

                                <button class="nav-link rounded-pill px-4" data-bs-toggle="tab" data-bs-target="#cuotas">

                                    Cuotas

                                </button>

                            </li>

                        </ul>

                    </div>

                    {{-- TAB CONTENT --}}
                    <div class="tab-content">

                        {{-- PROCEDIMIENTOS --}}
                        <div class="tab-pane fade show active" id="procedimientos">

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

                        {{-- CUOTAS --}}
                        <div class="tab-pane fade" id="cuotas">

                            <div class="px-3 pb-3">

                                <div class="table-responsive">

                                    <table class="table table-hover align-middle mb-0">

                                        <thead class="table-light">

                                            <tr>

                                                <th class="px-4 py-3 text-muted fw-semibold small">
                                                    #
                                                </th>

                                                <th class="px-4 py-3 text-muted fw-semibold small">
                                                    Vencimiento
                                                </th>

                                                <th class="px-4 py-3 text-muted fw-semibold small">
                                                    Monto
                                                </th>

                                                <th class="px-4 py-3 text-muted fw-semibold small">
                                                    Estado
                                                </th>

                                                <th class="px-4 py-3 text-muted fw-semibold small">
                                                    Pago
                                                </th>

                                            </tr>

                                        </thead>

                                        <tbody>

                                            {{-- CUOTA PAGADA --}}
                                            <tr>

                                                <td class="px-4">
                                                    1
                                                </td>

                                                <td class="px-4">
                                                    15/05/2026
                                                </td>

                                                <td class="px-4">
                                                    RD$ 2,000
                                                </td>

                                                <td class="px-4">

                                                    <span class="badge rounded-pill text-bg-success">
                                                        PAGADA
                                                    </span>

                                                </td>

                                                <td class="px-4">

                                                    <small class="text-muted">
                                                        Efectivo · 09/05/2026
                                                    </small>

                                                </td>

                                            </tr>

                                            {{-- CUOTA PENDIENTE --}}
                                            <tr>

                                                <td class="px-4">
                                                    2
                                                </td>

                                                <td class="px-4">
                                                    15/06/2026
                                                </td>

                                                <td class="px-4">
                                                    RD$ 2,000
                                                </td>

                                                <td class="px-4">

                                                    <span class="badge rounded-pill text-bg-warning">
                                                        PENDIENTE
                                                    </span>

                                                </td>

                                                <td class="px-4 text-muted">
                                                    -
                                                </td>

                                            </tr>

                                            {{-- CUOTA PENDIENTE --}}
                                            <tr>

                                                <td class="px-4">
                                                    3
                                                </td>

                                                <td class="px-4">
                                                    15/07/2026
                                                </td>

                                                <td class="px-4">
                                                    RD$ 2,000
                                                </td>

                                                <td class="px-4">

                                                    <span class="badge rounded-pill text-bg-warning">
                                                        PENDIENTE
                                                    </span>

                                                </td>

                                                <td class="px-4 text-muted">
                                                    -
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

            {{-- RIGHT --}}
            <div class="col-lg-4">

                <div class="card border-0 shadow-sm rounded-4 sticky-top" style="top: 20px;">

                    <div class="card-body p-4">

                        <h5 class="fw-semibold mb-4">
                            Resumen Financiero
                        </h5>

                        {{-- ESTADO --}}
                        <div class="mb-4">

                            <small class="text-muted d-block mb-1">
                                Estado Factura
                            </small>

                            <span class="badge rounded-pill text-bg-warning">
                                PARCIAL
                            </span>

                        </div>

                        {{-- TOTALES --}}
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

                        <div class="d-flex justify-content-between mb-3">

                            <span class="fw-semibold">
                                Total
                            </span>

                            <span class="fw-bold fs-5">
                                RD$ 6,000
                            </span>

                        </div>

                        <div class="d-flex justify-content-between mb-3">

                            <span class="text-muted">
                                Pagado
                            </span>

                            <span class="fw-medium text-success">
                                RD$ 2,000
                            </span>

                        </div>

                        <div class="d-flex justify-content-between mb-4">

                            <span class="text-muted">
                                Balance Pendiente
                            </span>

                            <span class="fw-bold text-warning">
                                RD$ 4,000
                            </span>

                        </div>

                        <hr>

                        {{-- CUOTAS --}}
                        <div class="d-flex justify-content-between mb-3">

                            <span class="text-muted">
                                Cuotas
                            </span>

                            <span class="fw-medium">
                                3
                            </span>

                        </div>

                        <div class="d-flex justify-content-between mb-4">

                            <span class="text-muted">
                                Monto por cuota
                            </span>

                            <span class="fw-medium">
                                RD$ 2,000
                            </span>

                        </div>

                        {{-- BUTTON --}}
                        <button class="btn btn-success w-100 rounded-pill py-3" data-bs-toggle="modal"
                            data-bs-target="#modalPago">

                            Registrar Pago

                        </button>

                    </div>

                </div>

            </div>

        </div>

    </div>

    {{-- MODAL REGISTRAR PAGO --}}
    <div class="modal fade" id="modalPago" tabindex="-1" aria-hidden="true">

        <div class="modal-dialog modal-lg modal-dialog-centered">

            <div class="modal-content border-0 rounded-4">

                {{-- HEADER --}}
                <div class="modal-header border-0 px-4 pt-4">

                    <div>

                        <h5 class="modal-title fw-semibold mb-1">
                            Registrar Pago
                        </h5>

                        <small class="text-muted">
                            Seleccione una o varias cuotas
                        </small>

                    </div>

                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>

                </div>

                {{-- BODY --}}
                <div class="modal-body px-4 pb-4">

                    {{-- METODO --}}
                    <div class="mb-4">

                        <label class="form-label text-muted small">
                            Método de Pago
                        </label>

                        <select class="form-select rounded-3">

                            <option>Efectivo</option>
                            <option>Transferencia</option>
                            <option>Tarjeta</option>

                        </select>

                    </div>

                    {{-- REFERENCIA --}}
                    <div class="mb-4">

                        <label class="form-label text-muted small">
                            Referencia
                        </label>

                        <input type="text" class="form-control rounded-3" placeholder="Opcional">

                    </div>

                    {{-- CUOTAS --}}
                    <div class="mb-4">

                        <label class="form-label text-muted small mb-3">
                            Cuotas Pendientes
                        </label>

                        <div class="border rounded-4 overflow-hidden">

                            {{-- CUOTA 2 --}}
                            <label class="d-flex align-items-center justify-content-between p-3 border-bottom">

                                <div class="d-flex align-items-center gap-3">

                                    <input type="checkbox" class="form-check-input">

                                    <div>

                                        <div class="fw-medium">
                                            Cuota #2
                                        </div>

                                        <small class="text-muted">
                                            Vence: 15/06/2026
                                        </small>

                                    </div>

                                </div>

                                <div class="fw-semibold">
                                    RD$ 2,000
                                </div>

                            </label>

                            {{-- CUOTA 3 --}}
                            <label class="d-flex align-items-center justify-content-between p-3">

                                <div class="d-flex align-items-center gap-3">

                                    <input type="checkbox" class="form-check-input">

                                    <div>

                                        <div class="fw-medium">
                                            Cuota #3
                                        </div>

                                        <small class="text-muted">
                                            Vence: 15/07/2026
                                        </small>

                                    </div>

                                </div>

                                <div class="fw-semibold">
                                    RD$ 2,000
                                </div>

                            </label>

                        </div>

                    </div>

                    {{-- TOTAL --}}
                    <div class="bg-light rounded-4 p-4">

                        <div class="d-flex align-items-center justify-content-between">

                            <div>

                                <small class="text-muted d-block mb-1">
                                    Total Seleccionado
                                </small>

                                <h4 class="fw-bold mb-0">
                                    RD$ 4,000
                                </h4>

                            </div>

                            <span class="badge rounded-pill text-bg-primary px-3 py-2">
                                2 Cuotas
                            </span>

                        </div>

                    </div>

                </div>

                {{-- FOOTER --}}
                <div class="modal-footer border-0 px-4 pb-4">

                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">

                        Cancelar

                    </button>

                    <button class="btn btn-success rounded-pill px-4">

                        Confirmar Pago

                    </button>

                </div>

            </div>

        </div>

    </div>

@endsection
