<div class="table-responsive">

    <table class="table table-hover align-middle mb-0">

        <thead class="table-light">

            <tr>

                <th class="px-4 py-3 text-muted fw-semibold small">
                    Factura
                </th>

                <th class="px-4 py-3 text-muted fw-semibold small">
                    Cuotas
                </th>

                <th class="px-4 py-3 text-muted fw-semibold small">
                    Fecha
                </th>

                <th class="px-4 py-3 text-muted fw-semibold small">
                    Monto
                </th>

                <th class="px-4 py-3 text-muted fw-semibold small">
                    Motivo
                </th>

            </tr>

        </thead>

        <tbody>

            @forelse ($pagos as $grupo)
                <tr>
                    <td class="px-4">

                        <a href="{{ route('facturacion.show', $grupo->pago->idFactura) }}?return={{ urlencode(request()->fullUrl()) }}"
                            class="text-decoration-none fw-medium">

                            FAC-{{ str_pad($grupo->pago->idFactura, 6, '0', STR_PAD_LEFT) }}

                        </a>

                    </td>

                    <td class="px-4 fw-medium">

                        @php
                            $numeros = $grupo->cuotas->pluck('numeroCuota')->implode(', ');
                        @endphp

                        {{ $grupo->cuotas->count() > 1 ? 'Cuotas' : 'Cuota' }}
                        {{ $numeros }}

                    </td>

                    <td class="px-4 text-muted">

                        {{ \Carbon\Carbon::parse($grupo->fechaRealizacion)->format('d/m/Y') }}

                    </td>

                    <td class="px-4 fw-semibold">

                        RD$ {{ number_format($grupo->montoTotal, 2) }}

                    </td>

                    <td class="px-4 text-muted" style="max-width: 300px;">

                        <span title="{{ $grupo->pago->observacion }}">
                            {{ \Illuminate\Support\Str::limit($grupo->pago->observacion, 50) }}
                        </span>

                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="5" class="text-center py-5 text-muted">

                        <i class="bi bi-inbox fs-1 d-block mb-2"></i>

                        No hay recibos anulados.

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
