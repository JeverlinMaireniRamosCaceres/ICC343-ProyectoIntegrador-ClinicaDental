<div class="table-responsive">
    <table class="table table-hover align-middle mb-0" id="tablaInventario">

        <thead class="table-light">
            <tr>
                <th class="px-4 py-3 text-muted fw-semibold small">Producto</th>
                <th class="px-4 py-3 text-muted fw-semibold small">Descripción</th>
                <th class="px-4 py-3 text-muted fw-semibold small">Stock actual</th>
                <th class="px-4 py-3 text-muted fw-semibold small">Stock mín.</th>
                <th class="px-4 py-3 text-muted fw-semibold small">Unidad</th>
                <th class="px-4 py-3 text-muted fw-semibold small">Vencimiento</th>
                <th class="px-4 py-3 text-muted fw-semibold small">Estado</th>
                <th class="px-4 py-3 text-muted fw-semibold small text-center">Acciones</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($productos as $producto)
                @php
                    $vencimiento = null;
                    $proximoVencer = false;

                    
                    if ($producto->detallesCompra && $producto->detallesCompra->count() > 0) {
                        $vencimiento = $producto->detallesCompra
                            ->whereNotNull('fechaVencimiento')
                            ->where('fechaVencimiento', '>=', now())
                            ->sortBy('fechaVencimiento')
                            ->first();

                        if ($vencimiento) {
                            $diasRestantes = now()->diffInDays(\Carbon\Carbon::parse($vencimiento->fechaVencimiento), false);
                            $proximoVencer = $diasRestantes <= 30;
                        }
                    }
                @endphp

                <tr>
                    <td class="px-4 fw-medium">{{ $producto->nombre }}</td>

                    <td class="px-4 text-muted" style="max-width: 200px;">
                        <span class="d-inline-block text-truncate" style="max-width: 180px;"
                            title="{{ $producto->descripcion }}">
                            {{ $producto->descripcion ?? '—' }}
                        </span>
                    </td>

                    <td class="px-4">
                        <span class="fw-semibold
                            @if ($producto->stockActual == 0) text-danger
                            @elseif ($producto->stockActual <= $producto->stockMinimo) text-warning
                            @else text-success
                            @endif">
                            {{ $producto->stockActual }}
                        </span>
                    </td>

                    <td class="px-4 text-muted">{{ $producto->stockMinimo }}</td>

                    <td class="px-4 text-muted">{{ $producto->unidadMedida }}</td>

                    <td class="px-4">
                        @if ($vencimiento)
                            <span class="{{ $proximoVencer ? 'text-danger fw-semibold' : 'text-muted' }}">
                                @if ($proximoVencer)
                                    <i class="bi bi-clock-fill me-1" style="font-size: 12px;"></i>
                                @endif
                                {{ \Carbon\Carbon::parse($vencimiento->fechaVencimiento)->format('d/m/Y') }}
                            </span>
                        @else
                            <span class="text-muted">—</span>
                        @endif
                    </td>

                    <td class="px-4">
                        @if ($producto->stockActual == 0)
                            <span class="badge bg-danger-subtle text-danger rounded-pill px-3 py-2">
                                Sin stock
                            </span>
                        @elseif ($producto->stockActual <= $producto->stockMinimo)
                            <span class="badge bg-warning-subtle text-warning rounded-pill px-3 py-2">
                                Stock bajo
                            </span>
                        @else
                            <span class="badge bg-success-subtle text-success rounded-pill px-3 py-2">
                                Normal
                            </span>
                        @endif
                    </td>

                    <td class="px-4">
                        <div class="d-flex justify-content-center gap-2">
                            <button type="button"
                                class="btn btn-sm btn-outline-info rounded-pill px-3 btnVerMovimientos"
                                title="Ver movimientos"
                                data-id="{{ $producto->idProducto }}"
                                data-nombre="{{ $producto->nombre }}">
                                <i class="bi bi-arrows-exchange"></i>
                            </button>
                        </div>
                    </td>

                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center py-5 text-muted">
                        <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                        No se encontraron productos.
                    </td>
                </tr>
            @endforelse
        </tbody>

    </table>
</div>

<!-- paginacion -->
<div class="d-flex align-items-center justify-content-between px-4 py-3 border-top">
    <small class="text-muted">
        Mostrando {{ $productos->firstItem() ?? 0 }}–{{ $productos->lastItem() ?? 0 }}
        de {{ $productos->total() }} resultados
    </small>
    <div>
        {{ $productos->links() }}
    </div>
</div>