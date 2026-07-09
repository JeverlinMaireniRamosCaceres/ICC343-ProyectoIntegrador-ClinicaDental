<div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
            <tr>
                <th class="px-4 py-3 text-muted fw-semibold small">Factura</th>
                <th class="px-4 py-3 text-muted fw-semibold small">Cuota</th>
                <th class="px-4 py-3 text-muted fw-semibold small">Paciente</th>
                <th class="px-4 py-3 text-muted fw-semibold small">Vencimiento</th>
                <th class="px-4 py-3 text-muted fw-semibold small">Monto</th>
                <th class="px-4 py-3 text-muted fw-semibold small text-center">Acciones</th>
            </tr>
        </thead>

        <tbody>

            @forelse ($pagos as $pago)
                <tr>

                    <td class="px-4 fw-medium">
                        FAC-{{ str_pad($pago->idFactura, 6, '0', STR_PAD_LEFT) }}
                    </td>

                    <td class="px-4 fw-medium">
                        Cuota {{ $pago->numeroCuota }}
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
                        <div class="d-flex justify-content-center gap-2">

                            <a href="{{ route('facturacion.show', $pago->idFactura) }}?return={{ urlencode(request()->fullUrl()) }}"
                                class="btn btn-sm btn-secondary rounded-pill px-3" title="Ver factura">
                                <i class="bi bi-receipt"></i>
                            </a>

                        </div>
                    </td>

                </tr>

            @empty

                <tr>
                    <td colspan="7" class="text-center py-5 text-muted">
                        <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                        No hay cuotas pendientes.
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
