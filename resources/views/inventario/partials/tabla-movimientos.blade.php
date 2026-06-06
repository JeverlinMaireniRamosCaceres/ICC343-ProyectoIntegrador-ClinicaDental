<div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
            <tr>
                <th class="px-4 py-3 text-muted fw-semibold small">Fecha</th>
                <th class="px-4 py-3 text-muted fw-semibold small">Producto</th>
                <th class="px-4 py-3 text-muted fw-semibold small">Tipo</th>
                <th class="px-4 py-3 text-muted fw-semibold small">Cantidad</th>
                <th class="px-4 py-3 text-muted fw-semibold small">Origen</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($movimientosPag as $mov)
                <tr>
                    <td class="px-4 text-muted small">
                        {{ \Carbon\Carbon::parse($mov['fecha'])->format('d/m/Y H:i') }}
                    </td>
                    <td class="px-4 fw-medium">{{ $mov['producto'] }}</td>
                    <td class="px-4">
                        @if ($mov['tipo'] === 'ENTRADA')
                            <div class="d-flex align-items-center gap-2">
                                <span style="width:8px;height:8px;border-radius:50%;background:#2f9e44;display:inline-block;"></span>
                                <span class="text-muted small">Entrada</span>
                            </div>
                        @else
                            <div class="d-flex align-items-center gap-2">
                                <span style="width:8px;height:8px;border-radius:50%;background:#e03131;display:inline-block;"></span>
                                <span class="text-muted small">Salida</span>
                            </div>
                        @endif
                    </td>
                    <td class="px-4">
                        @if ($mov['tipo'] === 'ENTRADA')
                            <span class="fw-semibold" style="color:#2f9e44;">+{{ $mov['cantidad'] }}</span>
                        @else
                            <span class="fw-semibold" style="color:#e03131;">-{{ $mov['cantidad'] }}</span>
                        @endif
                    </td>
                    <td class="px-4 text-muted small">{{ $mov['motivo'] }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center py-5 text-muted">
                        <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                        No hay movimientos registrados.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="d-flex justify-content-between align-items-center px-4 py-3 border-top">
    <small class="text-muted">
        Mostrando {{ $movimientosPag->firstItem() ?? 0 }}–{{ $movimientosPag->lastItem() ?? 0 }}
        de {{ $movimientosPag->total() }} resultados
    </small>
    <nav>{{ $movimientosPag->links() }}</nav>
</div>