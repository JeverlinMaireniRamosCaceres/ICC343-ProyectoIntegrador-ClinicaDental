@if ($movimientos->count() > 0)
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th class="px-3 py-3 text-muted fw-semibold small">Fecha</th>
                    <th class="px-3 py-3 text-muted fw-semibold small">Tipo</th>
                    <th class="px-3 py-3 text-muted fw-semibold small">Cantidad</th>
                    <th class="px-3 py-3 text-muted fw-semibold small">Origen</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($movimientos as $mov)
                    <tr>
                        <td class="px-3 text-muted small">
                            {{ \Carbon\Carbon::parse($mov->fecha)->format('d/m/Y H:i') }}
                        </td>
                        <td class="px-3">
                            @if ($mov->tipo == 'ENTRADA')
                                <span class="badge bg-success-subtle text-success rounded-pill px-3 py-2">
                                    <i class="bi bi-arrow-down-circle me-1"></i> Entrada
                                </span>
                            @else
                                <span class="badge bg-danger-subtle text-danger rounded-pill px-3 py-2">
                                    <i class="bi bi-arrow-up-circle me-1"></i> Salida
                                </span>
                            @endif
                        </td>
                        <td class="px-3 fw-semibold
                            {{ $mov->tipo == 'ENTRADA' ? 'text-success' : 'text-danger' }}">
                            {{ $mov->tipo == 'ENTRADA' ? '+' : '-' }}{{ $mov->cantidad }}
                        </td>
                        <td class="px-3 text-muted small">{{ $mov->motivo }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@else
    <div class="text-center py-5 text-muted">
        <i class="bi bi-inbox fs-1 d-block mb-2"></i>
        No hay movimientos registrados para este producto.
    </div>
@endif