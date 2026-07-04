@extends('layouts.app')

@section('title', 'Detalle Factura')

@section('content')

    <div class="container py-4">

        {{-- HEADER --}}
        <div class="d-flex justify-content-between align-items-center mb-4">

            <div class="d-flex align-items-center gap-3">

                <a href="{{ route('facturacion.index') }}" class="btn btn-light rounded-pill px-3">

                    <i class="bi bi-arrow-left"></i>

                </a>

                <div>

                    <h2 class="fw-bold mb-1">

                        FAC-{{ str_pad($factura->idFactura, 6, '0', STR_PAD_LEFT) }}

                    </h2>

                </div>

            </div>

            <div class="d-flex gap-2">

                <a href="{{ route('facturacion.pdf', $factura) }}" class="btn btn-light rounded-pill px-4" target="_blank"
                    title="Imprimir factura">
                    <i class="bi bi-printer-fill text-secondary"></i>
                </a>

                @if (!$factura->tiene_pagos_realizados && $factura->estado !== 'Anulada')
                    <button class="btn btn-danger rounded-pill px-4">

                        <i class="bi bi-x-circle me-2"></i>

                        Anular

                    </button>
                @endif

            </div>

        </div>

        <div class="row g-4">

            {{-- IZQUIERDA --}}
            <div class="col-lg-8">

                {{-- INFORMACIÓN --}}
                <div class="card border-0 shadow-sm rounded-4 mb-4">

                    <div class="card-body p-4">

                        <h5 class="fw-semibold mb-1">

                            Información de la factura

                        </h5>

                        <hr>

                        <div class="row g-4">

                            <div class="col-md-6">

                                <small class="text-muted d-block">
                                    Paciente
                                </small>

                                <span class="fw-medium">

                                    {{ $factura->consulta->paciente->persona->nombre }}
                                    {{ $factura->consulta->paciente->persona->apellido }}

                                </span>

                            </div>

                            <div class="col-md-6">

                                <small class="text-muted d-block">
                                    Odontólogo
                                </small>

                                <span class="fw-medium">

                                    {{ $factura->consulta->odontologo->persona->nombre }}
                                    {{ $factura->consulta->odontologo->persona->apellido }}

                                </span>

                            </div>

                            <div class="col-md-6">

                                <small class="text-muted d-block">
                                    Cédula
                                </small>

                                <span class="fw-medium">

                                    {{ $factura->consulta->paciente->persona->cedula ?? 'Sin cédula' }}

                                </span>

                            </div>

                            <div class="col-md-6">

                                <small class="text-muted d-block">
                                    Fecha de factura
                                </small>

                                <span class="fw-medium">

                                    {{ $factura->created_at->format('d/m/Y') }}

                                </span>

                            </div>

                            <div class="col-md-6">

                                <small class="text-muted d-block">
                                    Teléfono
                                </small>

                                <span class="fw-medium">

                                    {{ $factura->consulta->paciente->persona->telefono ?? 'No registrado' }}

                                </span>

                            </div>

                            <div class="col-md-6">

                                <small class="text-muted d-block">
                                    Fecha de consulta
                                </small>

                                <span class="fw-medium">

                                    {{ \Carbon\Carbon::parse($factura->consulta->fecha)->format('d/m/Y') }}

                                </span>

                            </div>

                        </div>

                    </div>

                </div>

                {{-- PROCEDIMIENTOS --}}
                <div class="card border-0 shadow-sm rounded-4">

                    <div class="card-body p-0">

                        <div class="p-4 border-bottom">

                            <h5 class="fw-semibold mb-0">

                                Procedimientos

                            </h5>

                        </div>

                        <div class="table-responsive">

                            <table class="table table-hover-custom align-middle mb-0">

                                <thead class="table-light">

                                    <tr>

                                        <th class="px-4 py-3">
                                            Procedimiento
                                        </th>

                                        <th class="px-4 py-3 text-center">
                                            Cantidad
                                        </th>

                                        <th class="px-4 py-3 text-end">
                                            Precio
                                        </th>

                                        <th class="px-4 py-3 text-end">
                                            Subtotal
                                        </th>

                                    </tr>

                                </thead>

                                <tbody>

                                    @foreach ($factura->consulta->detalles as $detalle)
                                        <tr>

                                            <td class="px-4">

                                                {{ $detalle->procedimiento->nombre }}

                                            </td>

                                            <td class="px-4 text-center">

                                                {{ $detalle->cantidadProcedimiento }}

                                            </td>

                                            <td class="px-4 text-end">

                                                RD$ {{ number_format($detalle->procedimiento->precio, 2) }}

                                            </td>

                                            <td class="px-4 text-end fw-semibold">

                                                RD$ {{ number_format($detalle->subtotal, 2) }}

                                            </td>

                                        </tr>
                                    @endforeach

                                </tbody>

                            </table>

                        </div>

                    </div>

                </div>

                {{-- CRONOGRAMA DE PAGOS --}}
                <div class="card border-0 shadow-sm rounded-4 mt-4">

                    <div class="card-body p-0">

                        <div class="p-4 border-bottom">

                            <h5 class="fw-semibold mb-0">
                                Cronograma de pagos
                            </h5>

                        </div>

                        <div class="table-responsive">

                            <table class="table table-hover-custom align-middle mb-0">

                                <thead class="table-light">

                                    <tr>

                                        <th class="px-4 py-3">
                                            Cuota
                                        </th>

                                        <th class="px-4 py-3">
                                            Vencimiento
                                        </th>

                                        <th class="px-4 py-3 text-end">
                                            Monto
                                        </th>

                                        <th class="px-4 py-3 text-center">
                                            Estado
                                        </th>

                                        <th class="px-4 py-3">
                                            Recibo
                                        </th>

                                    </tr>

                                </thead>

                                <tbody>

                                    @forelse ($factura->pagos as $pago)
                                        <tr>

                                            <td class="px-4">

                                                {{ $pago->numeroCuota }}

                                            </td>

                                            <td class="px-4">

                                                {{ \Carbon\Carbon::parse($pago->fechaVencimiento)->format('d/m/Y') }}

                                            </td>

                                            <td class="px-4 text-end fw-semibold">

                                                RD$ {{ number_format($pago->monto, 2) }}

                                            </td>

                                            <td class="px-4 text-center">

                                                @if ($pago->estado === 'Pagado')
                                                    <span
                                                        class="badge rounded-pill px-3 py-2 text-success bg-success-subtle">
                                                        Pagada
                                                    </span>
                                                @else
                                                    <span class="badge rounded-pill px-3 py-2"
                                                        style="background-color: #FFE5B4; color: #D97706;">
                                                        Pendiente
                                                    </span>
                                                @endif

                                            </td>

                                            <td class="px-4">

                                                @if ($pago->estado === 'Pagado')
                                                   

                                                    <a href="{{ route('pagos.pdf', $pago) }}" target="_blank"
                                                        class="btn btn-sm btn-light border rounded-pill px-3"
                                                        title="Imprimir recibo">

                                                        <i class="bi bi-file-earmark-pdf-fill text-danger"></i>


                                                    </a>
                                                @else
                                                    <span class="text-muted">

                                                    </span>
                                                @endif

                                            </td>

                                        </tr>

                                    @empty

                                        <tr>

                                            <td colspan="5" class="text-center py-5 text-muted">

                                                No hay pagos registrados.

                                            </td>

                                        </tr>
                                    @endforelse

                                </tbody>

                            </table>

                        </div>

                    </div>

                </div>

            </div>
            {{-- DERECHA --}}
            <div class="col-lg-4">

                <div class="card border-0 shadow-sm rounded-4 sticky-top" style="top: 20px;">

                    <div class="card-body p-4">

                        <h5 class="fw-semibold mb-4">

                            Resumen

                        </h5>

                        {{-- ESTADO --}}
                        <div class="mb-4">

                            <small class="text-muted d-block mb-1">

                                Estado

                            </small>

                            @php
                                if ($factura->estado === 'Anulada') {
                                    $badge = 'text-danger bg-danger-subtle';
                                    $style = '';
                                    $estado = 'Anulada';
                                } elseif ($factura->estado === 'Pagada') {
                                    $badge = 'text-success bg-success-subtle';
                                    $style = '';
                                    $estado = 'Pagada';
                                } elseif ($factura->estado === 'Parcial') {
                                    $badge = '';
                                    $style = 'background-color: #EDE9FE; color: #7C3AED;';
                                    $estado = 'Parcial';
                                } else {
                                    $badge = '';
                                    $style = 'background-color: #FFE5B4; color: #D97706;';
                                    $estado = 'Pendiente';
                                }
                            @endphp

                            <span class="badge rounded-pill px-3 py-2 {{ $badge }}" style="{{ $style }}">
                                {{ $estado }}
                            </span>

                        </div>

                        <div class="d-flex justify-content-between mb-3">

                            <span class="text-muted">

                                Subtotal

                            </span>

                            <span class="fw-medium">

                                @php
                                    $subtotal = $factura->consulta->detalles->sum('subtotal');
                                @endphp

                                RD$ {{ number_format($subtotal, 2) }}

                            </span>

                        </div>

                        <div class="d-flex justify-content-between mb-3">

                            <span class="text-muted">

                                Descuento

                            </span>

                            <span class="fw-medium text-danger">

                                - RD$ {{ number_format($factura->montoDescuento, 2) }}

                            </span>

                        </div>

                        <hr>

                        <div class="d-flex justify-content-between mb-3">

                            <span class="fw-semibold">

                                Total

                            </span>

                            <span class="fw-bold fs-5">

                                RD$ {{ number_format($factura->total, 2) }}

                            </span>

                        </div>

                        <div class="d-flex justify-content-between mb-3">

                            <span class="text-muted">

                                Pagado

                            </span>

                            <span class="fw-medium text-success">

                                RD$ {{ number_format($factura->total_pagado, 2) }}

                            </span>

                        </div>

                        <div class="d-flex justify-content-between mb-4">

                            <span class="text-muted">

                                Balance pendiente

                            </span>

                            <span class="fw-bold" style="color:#D97706;">

                                RD$ {{ number_format($factura->saldo_pendiente, 2) }}

                            </span>

                        </div>

                        <hr>

                        <div class="d-flex justify-content-between mb-3">

                            @if ($factura->cantidadCuotas > 1)
                                <span class="text-muted">

                                    Cuotas

                                </span>

                                <span class="fw-medium">

                                    {{ $factura->cantidadCuotas }}

                                </span>
                            @endif

                        </div>


                        @if ($factura->estado !== 'Anulada' && $factura->saldo_pendiente > 0)
                            <button class="btn btn-success w-100 rounded-pill py-3" data-bs-toggle="modal"
                                data-bs-target="#modalPago">

                                Registrar pago

                            </button>
                        @endif

                    </div>

                </div>

            </div>

        </div>


    </div>

    @include('pagos.partials.modal-registrar-pago')

@endsection
