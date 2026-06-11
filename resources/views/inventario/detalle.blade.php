@extends('layouts.app')

@section('title', 'Detalle de producto')

@section('content')
<div class="container-fluid py-4 px-5">

    <!-- header -->
    <div class="d-flex align-items-center gap-3 mb-4">
        <a href="{{ route('inventario.index') }}"
            class="btn btn-sm rounded-circle"
            style="width:34px;height:34px;background:#f1f5f9;color:#64748b;border:none;">
            <i class="bi bi-arrow-left"></i>
        </a>
        <div>
            <h2 class="fw-bold text-dark mb-0">{{ $producto->nombre }}</h2>
        </div>
    </div>

    <!-- datos generales -->
    <div class="row g-3 mb-4">

        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body d-flex align-items-center gap-3 p-4">
                    <div class="inv-metric-icon bg-info bg-opacity-10 text-info">
                        <i class="bi bi-box-seam fs-4"></i>
                    </div>
                    <div>
                        <p class="text-muted small mb-0">Stock actual</p>
                        <h4 class="fw-bold mb-0
                            @if($producto->stockActual <= 0) text-danger
                            @elseif($producto->stockActual <= $producto->stockMinimo) text-warning
                            @else text-success
                            @endif">
                            {{ $producto->stockActual }}
                        </h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body d-flex align-items-center gap-3 p-4">
                    <div class="inv-metric-icon bg-info bg-opacity-10 text-info">
                        <i class="bi bi-arrow-down-circle fs-4"></i>
                    </div>
                    <div>
                        <p class="text-muted small mb-0">Stock mínimo</p>
                        <h4 class="fw-bold mb-0">{{ $producto->stockMinimo }}</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body d-flex align-items-center gap-3 p-4">
                    <div class="inv-metric-icon bg-info bg-opacity-10 text-info">
                        <i class="bi bi-rulers fs-4"></i>
                    </div>
                    <div>
                        <p class="text-muted small mb-0">Unidad de medida</p>
                        <h4 class="fw-bold mb-0">{{ $producto->unidadMedida }}</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body d-flex align-items-center gap-3 p-4">
                    <div class="inv-metric-icon bg-info bg-opacity-10 text-info">
                        <i class="bi bi-layers fs-4"></i>
                    </div>
                    <div>
                        <p class="text-muted small mb-0">Total lotes</p>
                        <h4 class="fw-bold mb-0">{{ $producto->detallesCompra->count() }}</h4>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- descripcion -->
    @if($producto->descripcion)
        <div class="card border-0 shadow-sm rounded-4 mb-4">
            <div class="card-body p-4">
                <p class="text-muted small fw-semibold mb-1 text-uppercase"
                    style="letter-spacing:.05em; font-size:11px;">Descripción</p>
                <p class="mb-0">{{ $producto->descripcion }}</p>
            </div>
        </div>
    @endif

    <!-- tabla con lotes -->
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-0">

            <div class="px-4 py-3 border-bottom">
                <h6 class="fw-semibold mb-0">Historial de lotes</h6>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="px-4 py-3 text-muted fw-semibold small">Compra</th>
                            <th class="px-4 py-3 text-muted fw-semibold small">Proveedor</th>
                            <th class="px-4 py-3 text-muted fw-semibold small">Fecha compra</th>
                            <th class="px-4 py-3 text-muted fw-semibold small">Cantidad</th>
                            <th class="px-4 py-3 text-muted fw-semibold small">Costo total</th>
                            <th class="px-4 py-3 text-muted fw-semibold small">Vencimiento</th>
                            <th class="px-4 py-3 text-muted fw-semibold small">Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($producto->detallesCompra as $lote)
                            @php
                                $vencido = false;
                                $proximoVencer = false;

                                if ($lote->fechaVencimiento) {
                                    $dias = now()->diffInDays(
                                        \Carbon\Carbon::parse($lote->fechaVencimiento), false
                                    );
                                    $vencido       = $dias < 0;
                                    $proximoVencer = $dias >= 0 && $dias <= 30;
                                }
                            @endphp
                            <tr>
                                <td class="px-4 text-muted small">
                                    #{{ str_pad($lote->idCompras, 4, '0', STR_PAD_LEFT) }}
                                </td>
                                <td class="px-4 fw-medium">
                                    {{ $lote->compra->proveedor->nombre ?? '—' }}
                                </td>
                                <td class="px-4 text-muted small">
                                    {{ \Carbon\Carbon::parse($lote->compra->fecha)->format('d/m/Y') ?? '—' }}
                                </td>
                                <td class="px-4 fw-semibold">
                                    {{ $lote->cantidad }}
                                </td>
                                <td class="px-4 text-muted">
                                    RD$ {{ number_format($lote->costoTotal, 2) }}
                                </td>
                                <td class="px-4">
                                    @if($lote->fechaVencimiento)
                                        @if($vencido)
                                            <span class="text-danger fw-semibold">
                                                <i class="bi bi-x-circle me-1" style="font-size:12px;"></i>
                                                {{ \Carbon\Carbon::parse($lote->fechaVencimiento)->format('d/m/Y') }}
                                            </span>
                                        @elseif($proximoVencer)
                                            <span style="border-bottom:2px dashed #e03131; padding-bottom:1px;">
                                                {{ \Carbon\Carbon::parse($lote->fechaVencimiento)->format('d/m/Y') }}
                                            </span>
                                        @else
                                            <span class="text-muted">
                                                {{ \Carbon\Carbon::parse($lote->fechaVencimiento)->format('d/m/Y') }}
                                            </span>
                                        @endif
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </td>
                                <td class="px-4">
                                    @if($vencido)
                                        <span class="badge bg-danger-subtle text-danger rounded-pill px-3 py-2">
                                            Vencido
                                        </span>
                                    @elseif($proximoVencer)
                                        <span class="badge rounded-pill px-3 py-2"
                                            style="background:#fff0e6;color:#c2510a;">
                                            Por vencer
                                        </span>
                                    @elseif($lote->fechaVencimiento)
                                        <span class="badge bg-success-subtle text-success rounded-pill px-3 py-2">
                                            Vigente
                                        </span>
                                    @else
                                        <span class="badge bg-secondary-subtle text-secondary rounded-pill px-3 py-2">
                                            Sin fecha
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">
                                    <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                                    No hay lotes registrados para este producto.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>

</div>
@endsection