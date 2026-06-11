<div class="table-responsive">
    <table class="table table-hover align-middle mb-0" id="tablaProductos">
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

            @forelse($productos as $producto)

                @php

                    $proximoVencimiento =
                        $producto->detallesCompra
                            ->whereNotNull('fechaVencimiento')
                            ->sortBy('fechaVencimiento')
                            ->first();

                @endphp

                <tr>

                    <td class="px-4 fw-medium">
                        {{ $producto->nombre }}
                    </td>

                    <td class="px-4 text-muted">
                        {{ $producto->descripcion }}
                    </td>

                    <td class="px-4">

                        @php

                            if ($producto->stockActual <= 0) {
                                $color = '#e03131';
                            } elseif ($producto->stockActual <= $producto->stockMinimo) {
                                $color = '#c2510a';
                            } else {
                                $color = '#2f9e44';
                            }

                        @endphp

                        <div class="d-flex align-items-center gap-2">

                            <span class="fw-semibold">
                                {{ $producto->stockActual }}
                            </span>

                            <span style="
                                                width:8px;
                                                height:8px;
                                                border-radius:50%;
                                                background:{{ $color }};
                                                display:inline-block;
                                            ">
                            </span>

                        </div>

                    </td>

                    <td class="px-4">
                        {{ $producto->stockMinimo }}
                    </td>

                    <td class="px-4">
                        {{ $producto->unidadMedida }}
                    </td>

                    <td class="px-4">

                        @if($proximoVencimiento)

                            @php

                                $diasRestantes = now()->diffInDays(
                                    \Carbon\Carbon::parse($proximoVencimiento->fechaVencimiento),
                                    false
                                );
                                $vencePronto = $diasRestantes >= 0 && $diasRestantes <= 30;

                            @endphp

                            @if($vencePronto)

                                <span style="
                                                        border-bottom:2px dashed #e03131;
                                                        padding-bottom:1px;
                                                    ">
                                    {{ \Carbon\Carbon::parse($proximoVencimiento->fechaVencimiento)->format('d/m/Y') }}
                                </span>

                            @else

                                {{ \Carbon\Carbon::parse($proximoVencimiento->fechaVencimiento)->format('d/m/Y') }}

                            @endif

                        @else

                            <span class="text-muted">N/A</span>

                        @endif

                    </td>

                    @php

                        if ($producto->stockActual <= 0) {
                            $estado = 'sin_stock';
                        } elseif ($producto->stockActual <= $producto->stockMinimo) {
                            $estado = 'bajo';
                        } else {
                            $estado = 'normal';
                        }

                    @endphp

                    <td class="px-4">

                        @if($estado == 'normal')

                            <span class="badge bg-success-subtle text-success rounded-pill px-3 py-2">
                                Normal
                            </span>

                        @elseif($estado == 'bajo')

                            <span class="badge rounded-pill px-3 py-2" style="background:#fff0e6;color:#c2510a;">
                                Stock bajo
                            </span>

                        @else

                            <span class="badge bg-danger-subtle text-danger rounded-pill px-3 py-2">
                                Sin stock
                            </span>

                        @endif

                    </td>

                    <td class="px-4 text-center">

                        <a href="{{ route('inventario.detalle', $producto->idProducto) }}" class="btn btn-sm rounded-circle"
                            style="width:34px;height:34px;background:#e8f4fd;color:#0ea5e9;border:none;">
                            <i class="bi bi-eye"></i>
                        </a>

                    </td>

                </tr>

            @empty

                <tr>
                    <td colspan="8" class="text-center py-4">
                        Ese producto no existe en el inventario o no coincide con la búsqueda.
                    </td>
                </tr>

            @endforelse

        </tbody>
    </table>

    <!-- paginacion -->
    <div class="d-flex justify-content-between align-items-center px-4 py-3 border-top">

        <small class="text-muted">
            Mostrando
            {{ $productos->firstItem() }}
            -
            {{ $productos->lastItem() }}
            de
            {{ $productos->total() }}
            resultados
        </small>

        {{ $productos->links() }}

    </div>

</div>