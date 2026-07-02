<!-- tabla con historial de facturas -->
<div class="table-responsive">

    <table class="table table-hover-custom align-middle mb-0">

        <thead class="table-light">
            <tr>
                <th class="ps-4" style="width: 15%;">N.º Factura</th>
                <th style="width: 15%;">Fecha</th>
                <th style="width: 25%;">Paciente</th>
                <th style="width: 15%;">Total</th>
                <th class="text-center" style="width: 15%;">Estado</th>
                <th class="text-center" style="width: 18%;">Acciones</th>
            </tr>
        </thead>

        <tbody>

            @forelse ($facturas as $factura)
                <tr>

                    <td class="ps-4 fw-semibold">
                        FAC-{{ str_pad($factura->idFactura, 6, '0', STR_PAD_LEFT) }}
                    </td>

                    <td>
                        {{ $factura->created_at->format('d/m/Y') }}
                    </td>

                    <td>
                        {{ $factura->consulta->paciente->persona->nombre }}
                        {{ $factura->consulta->paciente->persona->apellido }}
                    </td>

                    <td>
                        RD${{ number_format($factura->total, 2) }}
                    </td>

                    <td class="text-center">
                        @if ($factura->estado === 'Pagada')
                            <span class="badge rounded-pill px-3 py-2 text-success bg-success-subtle">
                                Pagada
                            </span>
                        @elseif ($factura->estado === 'Pendiente')
                            <span class="badge rounded-pill px-3 py-2"
                                style="background-color: #FFE5B4; color: #D97706;">
                                Pendiente
                            </span>
                        @elseif ($factura->estado === 'Parcial')
                            <span class="badge rounded-pill px-3 py-2"
                                style="background-color: #EDE9FE; color: #7C3AED;">
                                Parcial
                            </span>
                        @elseif ($factura->estado === 'Anulada')
                            <span class="badge rounded-pill px-3 py-2 text-danger bg-danger-subtle">
                                Anulada
                            </span>
                        @endif
                    </td>

                    <td class="text-center pe-4">

                        <div class="d-flex gap-2">

                            <a href="{{ route('facturacion.show', $factura->idFactura) }}"
                                class="btn btn-sm btn-secondary rounded-pill px-3" title="Ver detalle">
                                <i class="bi bi-eye-fill"></i>
                            </a>

                            @if (in_array($factura->estado, ['Pendiente', 'Parcial']))
                                <a href="#" class="btn btn-sm btn-success rounded-pill px-3"
                                    title="Registrar pago">
                                    <i class="bi bi-cash-stack"></i>
                                </a>
                            @endif

                            @if ($factura->estado === 'Pendiente')
                                <button type="button" class="btn btn-sm btn-danger rounded-pill px-3 btnAnularFactura"
                                    data-bs-toggle="modal" data-bs-target="#modalAnularFactura"
                                    data-id="{{ $factura->idFactura }}" title="Anular factura">
                                    <i class="bi bi-x-octagon"></i>
                                </button>
                            @endif

                        </div>

                    </td>

                </tr>

            @empty
                <tr>
                    <td colspan="6" class="text-center py-4">
                        No se encontraron facturas.
                    </td>
                </tr>
            @endforelse

        </tbody>

    </table>

</div>

<!-- paginación -->
<div class="d-flex justify-content-between align-items-center p-4 border-top">

    <span class="text-muted small">
        Mostrando {{ $facturas->firstItem() ?? 0 }}
        - {{ $facturas->lastItem() ?? 0 }}
        de {{ $facturas->total() }} resultados
    </span>

    <div class="d-flex align-items-center">

        <small class="text-muted me-1">Filas</small>

        <form method="GET" action="{{ route('facturacion.index') }}" class="m-0 me-4">

            <input type="hidden" name="buscar" value="{{ request('buscar') }}">

            <select name="porPagina" id="porPagina" class="form-select form-select-sm"
                style="width: 65px; height: 33px; min-height: 33px; padding-right: 1.5rem;">

                <option value="10" {{ $porPagina == 10 ? 'selected' : '' }}>10</option>
                <option value="25" {{ $porPagina == 25 ? 'selected' : '' }}>25</option>
                <option value="50" {{ $porPagina == 50 ? 'selected' : '' }}>50</option>
                <option value="100" {{ $porPagina == 100 ? 'selected' : '' }}>100</option>

            </select>

        </form>

        <div class="pagination-wrapper pt-3">
            {{ $facturas->links() }}
        </div>

    </div>

</div>
