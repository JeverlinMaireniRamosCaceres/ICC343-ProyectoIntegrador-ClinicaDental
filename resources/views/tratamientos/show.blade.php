@extends('layouts.app')

@section('title', 'Detalle Tratamiento')

@section('content')
    <div class="container py-4">

        <div class="d-flex align-items-center gap-3 mb-4">

            <a href="{{ request('return', route('tratamientos.index')) }}" class="btn btn-sm btn-light rounded-pill px-3">
                <i class="bi bi-arrow-left"></i>
            </a>

            <h2 class="fw-semibold mb-0">
                Detalle del tratamiento
            </h2>

        </div>

        <div class="card border-0 shadow-sm rounded-4">

            <div class="card-body p-4">

                <h3 class="fw-bold mb-1">
                    {{ $tratamiento->nombre }}
                </h3>

                <div class="d-flex align-items-center gap-3 mb-4">

                    <span class="text-muted">
                        Paciente:
                        {{ $tratamiento->paciente->persona->nombre }}
                        {{ $tratamiento->paciente->persona->apellido }}
                    </span>
                    <span class="text-muted">
                        Iniciado:
                        {{ \Carbon\Carbon::parse($tratamiento->fechaInicio)->format('d/m/Y') }}
                    </span>

                    @if ($tratamiento->estado == 'Completado')
                        <span class="badge rounded-pill px-3 py-2 text-success bg-success-subtle">
                            {{ $tratamiento->estado }}
                        </span>
                    @elseif ($tratamiento->estado == 'En Proceso')
                        <span class="badge rounded-pill px-3 py-2" style="background-color:#FFE5B4;color:#D97706;">
                            {{ $tratamiento->estado }}
                        </span>
                    @else
                        <span class="badge rounded-pill px-3 py-2 text-secondary bg-secondary-subtle">
                            {{ $tratamiento->estado }}
                        </span>
                    @endif

                </div>

                <hr>

                <div class="table-responsive mb-4">

                    <table class="table align-middle">

                        <thead class="table-light">

                            <tr>
                                <th>Procedimiento</th>
                                <th>Cantidad</th>
                                <th>Precio Unitario</th>
                                <th>Subtotal</th>
                                <th>Estado</th>
                                <th class="text-center">Observación</th>
                            </tr>

                        </thead>

                        <tbody>

                            @php
                                $total = 0;
                            @endphp

                            @forelse ($tratamiento->detalles as $detalle)
                                @php
                                    $subtotal = $detalle->cantidadProcedimiento * $detalle->procedimiento->precio;
                                    $total += $subtotal;
                                @endphp

                                <tr>

                                    <td>

                                        <div class="fw-semibold">
                                            {{ $detalle->procedimiento->nombre }}
                                        </div>

                                    </td>

                                    <td>
                                        {{ $detalle->cantidadProcedimiento }}
                                    </td>

                                    <td>
                                        RD$ {{ number_format($detalle->procedimiento->precio, 2) }}
                                    </td>

                                    <td>
                                        RD$ {{ number_format($subtotal, 2) }}
                                    </td>

                                    <td>

                                        @if ($detalle->estado == 'Completado')
                                            <span class="badge rounded-pill text-success bg-success-subtle">
                                                {{ $detalle->estado }}
                                            </span>
                                        @elseif ($detalle->estado == 'En Proceso')
                                            <span class="badge rounded-pill"
                                                style="background-color:#FFE5B4;color:#D97706;">
                                                {{ $detalle->estado }}
                                            </span>
                                        @else
                                            <span class="badge rounded-pill text-secondary bg-secondary-subtle">
                                                {{ $detalle->estado }}
                                            </span>
                                        @endif

                                    </td>

                                    <td>

                                        @if ($detalle->observacion)
                                            <div class="text-center">
                                                <button type="button"
                                                    class="btn btn-sm btn-secondary rounded-pill px-3 btnObservacion"
                                                    data-bs-toggle="modal" data-bs-target="#modalObservacion"
                                                    data-procedimiento="{{ $detalle->procedimiento->nombre }}"
                                                    data-observacion="{{ $detalle->observacion }}">
                                                    <i class="bi bi-eye"></i>
                                                </button>
                                            </div>
                                        @else
                                            <span class="text-muted">
                                                -
                                            </span>
                                        @endif

                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="6" class="text-center py-4 text-muted">
                                        No hay procedimientos registrados para este tratamiento.
                                    </td>
                                </tr>
                            @endforelse

                        </tbody>

                    </table>

                </div>

                <hr>

                <div class="mt-3 mb-3">

                    <div class="d-flex justify-content-between fw-bold fs-5">

                        <span>Total</span>

                        <span>
                            RD$ {{ number_format($total ?? 0, 2) }}
                        </span>

                    </div>

                </div>

            </div>

        </div>

    </div>

    @include('tratamientos.partials.modal-observacion-procedimiento')

@endsection

@section('scripts')

    <script>
        document.querySelectorAll('.btnObservacion').forEach(btn => {

            btn.addEventListener('click', function() {

                document.getElementById('procedimientoObservacion').textContent =
                    this.dataset.procedimiento;

                document.getElementById('textoObservacion').textContent =
                    this.dataset.observacion;

            });

        });
    </script>

@endsection
