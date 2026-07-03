@extends('layouts.app')

@section('title', 'Detalle de consulta')

@section('content')
    <div class="container-fluid py-4 px-5">

        <!-- header -->
        <div class="d-flex align-items-center gap-3 mb-4">
            <a href="{{ route('consultas.index') }}" class="btn btn-sm btn-light rounded-pill px-3">
                <i class="bi bi-arrow-left"></i>
            </a>

            <h2 class="fw-semibold mb-0">Detalle de consulta</h2>
        </div>


        <div class="row g-4">

            <!-- columna izquierda -->
            <div class="col-lg-8 d-flex flex-column gap-4">

                <!-- datos generales -->
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4">
                        <h6 class="fw-semibold mb-3 text-muted text-uppercase"
                            style="font-size:11px; letter-spacing:.05em;">
                            <i class="bi bi-person-lines-fill me-1"></i> Datos generales
                        </h6>
                        <div class="row g-3">

                            <div class="col-md-6">
                                <small class="text-muted d-block">Paciente</small>
                                <span class="fw-semibold">
                                    {{ $consulta->paciente->persona->nombre }}
                                    {{ $consulta->paciente->persona->apellido }}
                                </span>
                            </div>

                            <div class="col-md-6">
                                <small class="text-muted d-block">Teléfono</small>
                                <span class="fw-semibold">
                                    {{ $consulta->paciente->persona->telefono ?? '—' }}
                                </span>
                            </div>

                            <div class="col-md-6">
                                <small class="text-muted d-block">Odontólogo</small>
                                <span class="fw-semibold">
                                    {{ $consulta->odontologo->persona->nombre }}
                                    {{ $consulta->odontologo->persona->apellido }}
                                </span>
                            </div>

                            <div class="col-md-6">
                                <small class="text-muted d-block">Fecha de la consulta</small>
                                <span class="fw-semibold">
                                    {{ \Carbon\Carbon::parse($consulta->fecha)->format('d/m/Y') }}
                                </span>
                            </div>

                        </div>

                        <!-- alergias -->
                        @if($consulta->paciente->alergias->count() > 0)
                            <hr class="my-3">
                            <small class="text-muted d-block mb-2">Alergias del paciente</small>
                            <div class="d-flex flex-wrap gap-2">
                                @foreach($consulta->paciente->alergias as $alergia)
                                    <span class="badge rounded-pill px-3 py-2"
                                        style="background:#fee2e2; color:#991b1b; font-size:12px;">
                                        <i class="bi bi-exclamation-triangle-fill me-1"></i>
                                        {{ $alergia->nombre }}
                                    </span>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>

                <!-- evaluacion clinica -->
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4">
                        <h6 class="fw-semibold mb-3 text-muted text-uppercase"
                            style="font-size:11px; letter-spacing:.05em;">
                            <i class="bi bi-clipboard2-pulse me-1"></i> Evaluación clínica
                        </h6>
                        <div class="d-flex flex-column gap-3">
                            <div>
                                <small class="text-muted d-block mb-1">Motivo de consulta</small>
                                <p class="mb-0">{{ $consulta->motivo ?? '—' }}</p>
                            </div>
                            <div>
                                <small class="text-muted d-block mb-1">Diagnóstico</small>
                                <p class="mb-0">{{ $consulta->diagnostico ?? '—' }}</p>
                            </div>
                            <div>
                                <small class="text-muted d-block mb-1">Receta / indicaciones</small>
                                <p class="mb-0">{{ $consulta->receta ?? '—' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- procedimientos independientes -->
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-0">
                        <div class="px-4 py-3 border-bottom">
                            <h6 class="fw-semibold mb-0 text-muted text-uppercase"
                                style="font-size:11px; letter-spacing:.05em;">
                                <i class="bi bi-clipboard2-plus me-1"></i> Procedimientos de la consulta
                            </h6>
                        </div>
                        <div class="table-responsive">
                            <table class="table align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="px-4 py-3 text-muted fw-semibold small">Procedimiento</th>
                                        <th class="px-4 py-3 text-muted fw-semibold small">Cantidad</th>
                                        <th class="px-4 py-3 text-muted fw-semibold small">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($consulta->detalles as $detalle)
                                        <tr>
                                            <td class="px-4 fw-medium">
                                                {{ $detalle->procedimiento->nombre ?? '—' }}
                                            </td>
                                            <td class="px-4 text-muted">
                                                {{ $detalle->cantidadProcedimiento }}
                                            </td>
                                            <td class="px-4 fw-semibold">
                                                RD$ {{ number_format($detalle->subtotal, 2) }}
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center py-4 text-muted">
                                                No hay procedimientos registrados.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- procedimientos del tratamiento -->
                @if($detallesTratamiento->count() > 0)
                    <div class="card border-0 shadow-sm rounded-4">
                        <div class="card-body p-0">
                            <div class="px-4 py-3 border-bottom">
                                <h6 class="fw-semibold mb-0 text-muted text-uppercase"
                                    style="font-size:11px; letter-spacing:.05em;">
                                    <i class="bi bi-activity me-1"></i> Procedimientos del tratamiento
                                </h6>
                            </div>
                            <div class="table-responsive">
                                <table class="table align-middle mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="px-4 py-3 text-muted fw-semibold small">Procedimiento</th>
                                            <th class="px-4 py-3 text-muted fw-semibold small">Tratamiento</th>
                                            <th class="px-4 py-3 text-muted fw-semibold small">Cantidad</th>
                                            <th class="px-4 py-3 text-muted fw-semibold small">Observación</th>
                                            <th class="px-4 py-3 text-muted fw-semibold small">Estado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($detallesTratamiento as $detalle)
                                            <tr>
                                                <td class="px-4 fw-medium">
                                                    {{ $detalle->procedimiento->nombre ?? '—' }}
                                                </td>
                                                <td class="px-4 text-muted">
                                                    {{ $detalle->tratamiento->nombre ?? '—' }}
                                                </td>
                                                <td class="px-4 text-muted">
                                                    {{ $detalle->cantidadProcedimiento }}
                                                </td>
                                                <td class="px-4 text-muted">
                                                    {{ $detalle->observacion ?? '—' }}
                                                </td>
                                                <td class="px-4">
                                                    <span class="badge rounded-pill px-3 py-2 bg-warning-subtle text-warning">
                                                        {{ $detalle->estado }}
                                                    </span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endif

            </div>

            <!-- columna derecha -->
            <div class="col-lg-4 d-flex flex-column gap-4">

                <!-- resumen -->
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4">
                        <h6 class="fw-semibold mb-3 text-muted text-uppercase"
                            style="font-size:11px; letter-spacing:.05em;">
                            <i class="bi bi-receipt me-1"></i> Resumen
                        </h6>
                        <div class="d-flex flex-column gap-2">

                            <div class="d-flex justify-content-between">
                                <span class="text-muted small fw-semibold">
                                    Procedimientos
                                </span>
                            </div>

                            <div class="d-flex justify-content-between ps-3">
                                <span class="text-muted small">
                                    Independientes
                                </span>
                                <span class="fw-semibold">
                                    {{ $consulta->detalles->count() }}
                                </span>
                            </div>

                            <div class="d-flex justify-content-between ps-3">
                                <span class="text-muted small">
                                    Del tratamiento
                                </span>
                                <span class="fw-semibold">
                                    {{ $detallesTratamiento->count() }}
                                </span>
                            </div>

                            <hr class="my-2">

                            <div class="d-flex justify-content-between">
                                <span class="text-muted small">
                                    Subtotal independientes
                                </span>
                                <span class="fw-semibold">
                                    RD$
                                    {{ number_format($consulta->detalles->sum('subtotal'), 2) }}
                                </span>
                            </div>

                            <div class="d-flex justify-content-between">
                                <span class="text-muted small">
                                    Subtotal tratamiento
                                </span>
                                <span class="fw-semibold">
                                    RD$
                                    {{ number_format($subtotalTratamiento, 2) }}
                                </span>
                            </div>

                            <hr class="my-1">

                            <div class="d-flex justify-content-between">
                                <span class="fw-semibold">
                                    Total
                                </span>
                                <span class="fw-bold text-primary fs-5">
                                    RD$
                                    {{ number_format($consulta->detalles->sum('subtotal') + $subtotalTratamiento, 2) }}
                                </span>
                            </div>

                        </div>
                    </div>
                </div>

                <!-- antecedentes -->
                @if($consulta->paciente->antecedentes)
                    <div class="card border-0 shadow-sm rounded-4">
                        <div class="card-body p-4">
                            <h6 class="fw-semibold mb-3 text-muted text-uppercase"
                                style="font-size:11px; letter-spacing:.05em;">
                                <i class="bi bi-file-medical me-1"></i> Antecedentes médicos
                            </h6>
                            <p class="mb-0 small">{{ $consulta->paciente->antecedentes }}</p>
                        </div>
                    </div>
                @endif

            </div>

        </div>

    </div>
@endsection