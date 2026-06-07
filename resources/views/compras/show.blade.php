@extends('layouts.app')

@section('title', 'Detalle Compra')

@section('content')
    <div class="container py-4">

        <div class="d-flex align-items-center gap-3 mb-4">

            <a href="{{ route('compras.index') }}" class="btn btn-sm btn-light rounded-pill px-3">
                <i class="bi bi-arrow-left"></i>
            </a>

            <h2 class="fw-semibold mb-0">
                Detalle de compra
            </h2>

        </div>

        <div class="card border-0 shadow-sm rounded-4">

            <div class="card-body p-4">

                <h3 class="fw-bold mb-1">
                    {{ $compra->proveedor->nombre }}
                </h3>

                <div class="d-flex align-items-center gap-3 mb-4">

                    <span class="text-muted">
                        Compra realizada el {{ $compra->fecha->format('d/m/Y') }}
                    </span>

                    @if ($compra->estado === 'Pagada')
                        <span class="badge rounded-pill px-3 py-2 text-success bg-success-subtle">
                            Pagada
                        </span>
                    @elseif ($compra->estado === 'Pendiente')
                        <span class="badge rounded-pill px-3 py-2" style="background-color: #FFE5B4; color: #D97706;">
                            Pendiente
                        </span>
                    @elseif ($compra->estado === 'Anulada')
                        <span class="badge rounded-pill px-3 py-2 text-danger bg-danger-subtle">
                            Anulada
                        </span>
                    @endif

                </div>

                <hr>

                <div class="table-responsive mb-4">

                    <table class="table align-middle">

                        <thead class="table-light">

                            <tr>
                                <th>Producto</th>
                                <th>Cantidad</th>
                                <th>Ud. Medida</th>
                                <th>Costo Total</th>
                                <th>Fecha Vencimiento</th>
                            </tr>

                        </thead>

                        <tbody>

                            @foreach ($compra->detalles as $detalle)
                                <tr>

                                    <td>
                                        {{ $detalle->producto->nombre }}
                                    </td>

                                    <td>
                                        {{ $detalle->cantidad }}
                                    </td>

                                    <td>
                                        {{ $detalle->producto->unidadMedida }}
                                    </td>

                                    <td>
                                        RD$
                                        {{ number_format($detalle->costoTotal, 2) }}
                                    </td>

                                    <td>

                                        @if ($detalle->fechaVencimiento)
                                            {{ \Carbon\Carbon::parse($detalle->fechaVencimiento)->format('d/m/Y') }}
                                        @else
                                            -
                                        @endif

                                    </td>

                                </tr>
                            @endforeach

                        </tbody>

                    </table>

                </div>

                @php

                    $subtotal = $compra->monto;

                    $itbis = $compra->aplicaItbis ? $subtotal * 0.18 : 0;

                    $total = $subtotal + $itbis;

                @endphp

                <div class="mt-3 mb-3">

                    <div class="card-body">

                        <h6 class="fw-semibold mb-3">
                            Resumen de compra
                        </h6>

                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal</span>
                            <span id="lblSubtotal">
                                RD$ {{ number_format($subtotal, 2) }}
                            </span>
                        </div>

                        <div class="d-flex justify-content-between mb-2">
                            <span>ITBIS</span>
                            <span id="lblItbis">RD$ {{ number_format($itbis, 2) }}</span>
                        </div>

                        <hr>

                        <div class="d-flex justify-content-between fw-bold fs-5">
                            <span>Total</span>
                            <span id="lblTotal">
                                RD$ {{ number_format($total, 2) }}
                            </span>
                        </div>

                    </div>

                </div>


            </div>

        </div>

    </div>
@endsection
