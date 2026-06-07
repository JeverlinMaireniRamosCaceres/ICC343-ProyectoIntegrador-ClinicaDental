@extends('layouts.app')

@section('title', 'Detalle de caja')

@section('content')
    <div class="container py-4">

        <div class="d-flex align-items-center gap-3 mb-4">

            <a href="{{ route('caja-chica.index') }}" class="btn btn-sm btn-light rounded-pill px-3">
                <i class="bi bi-arrow-left"></i>
            </a>

            <h2 class="fw-semibold mb-0">
                Detalle de caja
            </h2>

        </div>

        <div class="card border-0 shadow-sm rounded-4">

            <div class="card-body p-4">

                <h3 class="fw-bold mb-1">
                    Fecha: {{ \Carbon\Carbon::parse($caja->fecha)->format('d/m/Y') }}
                </h3>

                <div class="d-flex align-items-center gap-3 mb-4">

                    @if ($caja->estado === 'Abierta')
                        <span class="badge rounded-pill px-3 py-2 text-success bg-success-subtle">
                            Abierta
                        </span>
                    @else
                        <span class="badge rounded-pill px-3 py-2 text-secondary bg-secondary-subtle">
                            Cerrada
                        </span>
                    @endif

                </div>

                <hr>

                <div class="row g-4 mb-4">

                    <div class="col-md-4">

                        <label class="text-muted small fw-semibold">
                            Hora de apertura
                        </label>

                        <div class="fw-medium">
                            {{ \Carbon\Carbon::parse($caja->horaApertura)->format('h:i A') }}
                        </div>

                    </div>

                    <div class="col-md-4">

                        <label class="text-muted small fw-semibold">
                            Hora de cierre
                        </label>

                        <div class="fw-medium">

                            @if ($caja->horaCierre)
                                {{ \Carbon\Carbon::parse($caja->horaCierre)->format('h:i A') }}
                            @else
                                -
                            @endif

                        </div>

                    </div>

                    <div class="col-md-4">

                        @if ($caja->estado === 'Abierta')
                            <div class="d-flex justify-content-end align-items-end h-100 gap-2">

                                <button class="btn btn-danger rounded-pill px-4" data-bs-toggle="modal"
                                    data-bs-target="#modalEgreso">

                                    <i class="bi bi-arrow-down-circle"></i>
                                    Nuevo egreso

                                </button>

                                <button class="btn btn-secondary rounded-pill px-4" data-bs-toggle="modal"
                                    data-bs-target="#modalCerrarCaja">

                                    <i class="bi bi-lock-fill"></i>
                                    Cerrar caja

                                </button>

                            </div>
                        @endif

                    </div>

                </div>

                <hr>

                <label class="form-label text-muted fw-semibold small">
                    Movimientos
                </label>

                <div class="table-responsive mb-4">

                    <table class="table table-hover align-middle">

                        <thead class="table-light">

                            <tr>
                                <th style="width: 15%;">Hora</th>
                                <th style="width: 15%;">Tipo</th>
                                <th style="width: 50%;">Descripción</th>
                                <th style="width: 20%;" class="text-end">Monto</th>
                            </tr>

                        </thead>

                        <tbody>

                            @forelse ($caja->movimientos as $movimiento)
                                <tr>

                                    <td>
                                        {{ \Carbon\Carbon::parse($movimiento->hora)->format('h:i A') }}
                                    </td>

                                    <td>

                                        @if ($movimiento->tipo === 'Egreso')
                                            <span class="badge bg-danger-subtle text-danger">
                                                Egreso
                                            </span>
                                        @elseif ($movimiento->tipo === 'Ingreso')
                                            <span class="badge bg-success-subtle text-success">
                                                Ingreso
                                            </span>
                                        @else
                                            <span class="badge bg-secondary-subtle text-secondary">
                                                {{ $movimiento->tipo }}
                                            </span>
                                        @endif

                                    </td>

                                    <td>
                                        {{ $movimiento->descripcion ?? '-' }}
                                    </td>

                                    <td class="text-end fw-semibold">

                                        @if ($movimiento->tipo === 'Egreso')
                                            <span class="text-danger">
                                                - RD$ {{ number_format($movimiento->monto, 2) }}
                                            </span>
                                        @else
                                            <span class="text-success">
                                                + RD$ {{ number_format($movimiento->monto, 2) }}
                                            </span>
                                        @endif

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="4" class="text-center text-muted py-4">
                                        No hay movimientos registrados.
                                    </td>

                                </tr>
                            @endforelse

                        </tbody>

                    </table>

                </div>

                <div class="mt-3 mb-3">

                    <div class="card-body">

                        <h6 class="fw-semibold mb-3">
                            Resumen de caja
                        </h6>

                        <div class="d-flex justify-content-between mb-2">

                            <span>Saldo inicial</span>

                            <span>
                                RD$ {{ number_format($caja->saldoInicial, 2) }}
                            </span>

                        </div>

                        <div class="d-flex justify-content-between mb-2">

                            <span>Saldo actual</span>

                            <span>
                                RD$ {{ number_format($caja->monto, 2) }}
                            </span>

                        </div>

                        @if ($caja->estado === 'Cerrada')
                            <div class="d-flex justify-content-between mb-2">

                                <span>Diferencia</span>

                                <span class="{{ $caja->diferencia < 0 ? 'text-danger' : 'text-success' }}">

                                    RD$ {{ number_format($caja->diferencia, 2) }}

                                </span>

                            </div>
                        @endif

                        <hr>

                        <div class="d-flex justify-content-between fw-bold fs-5">

                            <span>Total en caja</span>

                            <span>
                                RD$ {{ number_format($caja->monto, 2) }}
                            </span>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        @include('caja_chica.partials.modal-registrar-egreso')
        @include('caja_chica.partials.modal-cerrar-caja')

        <script src="{{ asset('js/caja-chica.js') }}"></script>

    </div>
@endsection
