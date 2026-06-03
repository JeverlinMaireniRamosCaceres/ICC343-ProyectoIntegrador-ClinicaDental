<!-- tabla con consultas -->
<div class="table-responsive">

    <table class="table table-hover-custom align-middle mb-0">

        <thead class="table-light">
            <tr>
                <th class="ps-5">Proveedor</th>
                <th>Fecha</th>
                <th>Monto</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody>

            @forelse ($compras as $compra)
                <tr>
                    <td class="ps-5">
                        <div class="fw-semibold text-dark">
                            {{ $compra->proveedor->nombre }}
                        </div>

                        <small class="text-muted">
                            {{ $compra->proveedor->telefono }}
                        </small>
                    </td>

                    <td>
                        {{ $compra->fecha->format('d/m/Y') }}
                    </td>

                    <td>
                        RD${{ number_format($compra->monto, 2) }}
                    </td>

                    <td>
                        @if ($compra->estado === 'Pagada')
                            <span class="badge rounded-pill px-3 py-2 text-success bg-success-subtle">
                                Pagada
                            </span>
                        @elseif ($compra->estado === 'Pendiente')
                            <span class="badge rounded-pill px-3 py-2" style="background-color: #FFE5B4; color: #D97706;">
                                Pendiente
                            </span>
                        @elseif ($compra->estado === 'Anulada')
                            <span class="badge rounded-pill px-3 py-2 text-danger bg-danger-subtle">
                                Anulada
                            </span>
                        @endif
                    </td>

                    <td class="text-center pe-4">

                        <div class="d-flex gap-2">

                            <a href="{{ route('compras.show', $compra->idCompras) }}"
                                class="btn btn-sm btn-secondary rounded-pill px-3" title="Ver">
                                <i class="bi bi-eye-fill"></i>
                            </a>

                            @if ($compra->estado !== 'Anulada')
                            <a href="{{ route('compras.edit', $compra->idCompras) }}"
                                class="btn btn-sm btn-warning rounded-pill px-3" style="color:white;" title="Editar">
                                <i class="bi bi-pencil-fill"></i>
                            </a>
                                <button type="button" class="btn btn-sm btn-danger rounded-pill px-3 btnAnularCompra"
                                    data-bs-toggle="modal" data-bs-target="#modalAnularCompra"
                                    data-id="{{ $compra->idCompras }}" title="Anular">

                                    <i class="bi bi-x-octagon"></i>
                                </button>
                            @endif

                        </div>

                    </td>

                </tr>

            @empty
                <tr>
                    <td colspan="5" class="text-center py-4">
                        No se encontraron compras.
                    </td>
                </tr>
            @endforelse

        </tbody>

    </table>

    @include('compras.partials.modal-anular')

</div>

<!-- paginacion -->
<div class="d-flex justify-content-between align-items-center p-4 border-top">

    <span class="text-muted small">
        Mostrando {{ $compras->firstItem() ?? 0 }}
        - {{ $compras->lastItem() ?? 0 }}
        de {{ $compras->total() }} resultados
    </span>

    {{ $compras->links() }}

</div>
