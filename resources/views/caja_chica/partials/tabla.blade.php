<div class="table-responsive">

    <table class="table table-hover-custom align-middle mb-0">

        <thead class="table-light">

            <tr>
                <th class="ps-5">Fecha</th>
                <th>Hora Apertura</th>
                <th>Monto Inicial</th>
                <th>Saldo</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>

        </thead>

        <tbody>

            @forelse ($cajas as $caja)
                <tr>

                    <td class="ps-5">
                        {{ $caja->fecha->format('d/m/Y') }}
                    </td>

                    <td>
                        {{ $caja->horaApertura->format('h:i A') }}
                    </td>

                    <td>
                        RD${{ number_format($caja->saldoInicial, 2) }}
                    </td>

                    <td>
                        RD${{ number_format($caja->monto, 2) }}
                    </td>

                    <td>
                        @if ($caja->estado === 'Abierta')
                            <span class="badge rounded-pill px-3 py-2 text-success bg-success-subtle">Abierta</span>
                        @else
                            <span class="badge rounded-pill px-3 py-2 text-secondary bg-secondary-subtle">Cerrada</span>
                        @endif
                    </td>

                    <td class="text-center pe-4">

                        <div class="d-flex gap-2">

                            <div class="d-flex gap-2">
                                <a href="{{ route('caja-chica.show', 1) }}"
                                    class="btn btn-sm btn-secondary rounded-pill px-3">
                                    <i class="bi bi-eye-fill"></i>
                                </a>
                                @if ($caja->estado === 'Abierta')
                                    <button class="btn btn-sm btn-danger rounded-pill px-3 btnCerrarCaja"
                                        data-bs-toggle="modal" data-bs-target="#modalCerrarCaja"
                                        data-id="{{ $caja->idCajaChica }}" data-monto="{{ $caja->monto }}">
                                        <i class="bi bi-lock-fill"></i>
                                    </button>
                                @endif
                            </div>

                        </div>

                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="6" class="text-center py-4">
                        No se encontraron cajas.
                    </td>

                </tr>
            @endforelse

        </tbody>

    </table>

</div>

<!-- paginacion -->
<div class="d-flex justify-content-between align-items-center px-4 py-3 border-top">

    <span class="text-muted small">
        Mostrando {{ $cajas->firstItem() ?? 0 }}
        - {{ $cajas->lastItem() ?? 0 }}
        de {{ $cajas->total() }} resultados
    </span>

    {{ $cajas->links() }}

</div>
