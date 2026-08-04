<div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
            <tr>
                <th class="px-4 py-3 text-muted fw-semibold small">Factura</th>
                <th class="px-4 py-3 text-muted fw-semibold small">Cuotas</th>
                <th class="px-4 py-3 text-muted fw-semibold small">Paciente</th>
                <th class="px-4 py-3 text-muted fw-semibold small">Fecha</th>
                <th class="px-4 py-3 text-muted fw-semibold small">Monto</th>
                <th class="px-4 py-3 text-muted fw-semibold small text-center">Acciones</th>
            </tr>
        </thead>

        <tbody>

            @forelse ($pagos as $grupo)
                <tr>

                    <td class="px-4 fw-medium">
                        FAC-{{ str_pad($grupo->pago->idFactura, 6, '0', STR_PAD_LEFT) }}
                    </td>

                    <td class="px-4 fw-medium">

                        @php
                            $numeros = $grupo->cuotas->pluck('numeroCuota')->implode(', ');
                        @endphp

                        {{ $grupo->cuotas->count() > 1 ? 'Cuotas' : 'Cuota' }}
                        {{ $numeros }}

                    </td>

                    <td class="px-4">
                        {{ $grupo->pago->factura->consulta->paciente->persona->nombre }}
                        {{ $grupo->pago->factura->consulta->paciente->persona->apellido }}
                    </td>

                    <td class="px-4 text-muted">
                        {{ \Carbon\Carbon::parse($grupo->fechaRealizacion)->format('d/m/Y') }}
                    </td>

                    <td class="px-4 fw-semibold">
                        RD$ {{ number_format($grupo->montoTotal, 2) }}
                    </td>

                    <td class="px-4">
                        <div class="d-flex justify-content-center gap-2">

                            <a href="{{ route('pagos.pdf', $grupo->pago) }}"
                                class="btn btn-sm btn-secondary rounded-pill px-3" target="_blank"
                                title="Imprimir recibo">
                                <i class="bi bi-file-earmark-pdf-fill"></i>
                            </a>

                            <button type="button" class="btn btn-sm btn-danger rounded-pill px-3 btnAnularPago"
                                data-bs-toggle="modal" data-bs-target="#modalAnularPago"
                                data-codigo="{{ $grupo->codigoRecibo }}" title="Anular recibo">
                                <i class="bi bi-x-octagon"></i>
                            </button>

                        </div>
                    </td>

                </tr>

            @empty

                <tr>
                    <td colspan="7" class="text-center py-5 text-muted">
                        <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                        No hay recibos registrados.
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
