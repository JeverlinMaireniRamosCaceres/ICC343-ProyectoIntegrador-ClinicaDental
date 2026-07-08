<div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
            <tr>
                <th class="px-4 py-3 text-muted fw-semibold small">Cuota</th>
                <th class="px-4 py-3 text-muted fw-semibold small">Factura</th>
                <th class="px-4 py-3 text-muted fw-semibold small">Paciente</th>
                <th class="px-4 py-3 text-muted fw-semibold small">Vencimiento</th>
                <th class="px-4 py-3 text-muted fw-semibold small">Monto</th>
                <th class="px-4 py-3 text-muted fw-semibold small">Estado</th>
                <th class="px-4 py-3 text-muted fw-semibold small text-center">Acciones</th>
            </tr>
        </thead>

        <tbody>

            @forelse ($pagos as $pago)
                <tr>

                    <td class="px-4 fw-medium">
                        Cuota #{{ $pago->numeroCuota }}
                    </td>

                    <td class="px-4">
                        <a href="{{ route('facturacion.show', $pago->idFactura) }}"
                            class="text-decoration-none fw-medium">
                            FAC-{{ str_pad($pago->idFactura, 6, '0', STR_PAD_LEFT) }}
                        </a>
                    </td>

                    <td class="px-4">
                        {{ $pago->factura->consulta->paciente->persona->nombre }}
                        {{ $pago->factura->consulta->paciente->persona->apellido }}
                    </td>

                    <td class="px-4 text-muted">
                        {{ \Carbon\Carbon::parse($pago->fechaVencimiento)->format('d/m/Y') }}
                    </td>

                    <td class="px-4 fw-semibold">
                        RD$ {{ number_format($pago->monto, 2) }}
                    </td>

                    <td class="px-4">
                        <span class="badge rounded-pill px-3 py-2 text-danger bg-danger-subtle">
                            Vencido
                        </span>
                    </td>

                    <td class="px-4">
                        <div class="d-flex justify-content-start gap-2">
                            <a href="{{ route('facturacion.show', $pago->idFactura) }}"
                                class="btn btn-sm btn-secondary rounded-pill px-3" title="Ver factura">
                                <i class="bi bi-eye-fill"></i>
                            </a>
                        </div>
                    </td>

                </tr>

            @empty

                <tr>
                    <td colspan="7" class="text-center py-5 text-muted">
                        <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                        No hay cuotas vencidas.
                    </td>
                </tr>
            @endforelse

        </tbody>
    </table>
</div>

@include('pagos.partials.paginacion', [
    'pagos' => $pagos,
    'porPagina' => $porPagina,
    'vista' => $vista,
])
