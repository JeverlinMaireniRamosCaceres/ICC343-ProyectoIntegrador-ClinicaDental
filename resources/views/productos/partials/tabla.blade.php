<div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
            <tr>
                <th class="px-4 py-3 text-muted fw-semibold small">Nombre</th>
                <th class="px-4 py-3 text-muted fw-semibold small">Descripción</th>
                <th class="px-4 py-3 text-muted fw-semibold small">Stock mínimo</th>
                <th class="px-4 py-3 text-muted fw-semibold small">Unidad</th>
                <th class="px-4 py-3 text-muted fw-semibold small text-center">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($productos as $producto)
                <tr>
                    <td class="px-4 fw-medium">{{ $producto->nombre }}</td>
                    <td class="px-4 text-muted">{{ $producto->descripcion ?? 'Sin descripción' }}</td>
                    <td class="px-4 text-muted">{{ $producto->stockMinimo }}</td>
                    <td class="px-4 text-muted">{{ $producto->unidadMedida }}</td>
                    <td class="px-4">
                        <div class="d-flex gap-2 justify-content-center">
                            <a href="{{ route('productos.edit', $producto->idProducto) }}"
                                class="btn btn-sm btn-warning rounded-pill px-3 d-flex align-items-center justify-content-center text-white"
                                style="height: 32px;" title="Editar">
                                <i class="bi bi-pencil-fill small"></i>
                            </a>
                            <button type="button"
                                class="btn btn-sm btn-danger rounded-pill px-3 d-flex align-items-center justify-content-center"
                                style="height: 32px;" title="Eliminar" data-bs-toggle="modal"
                                data-bs-target="#modalEliminar" data-id="{{ $producto->idProducto }}"
                                data-nombre="{{ $producto->nombre }}">
                                <i class="bi bi-trash3-fill small"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center text-muted py-5">
                        No se encontraron productos registrados.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="d-flex align-items-center justify-content-between px-4 py-3 border-top">
    <span class="text-muted small">
        Mostrando {{ $productos->firstItem() ?? 0 }}–{{ $productos->lastItem() ?? 0 }} de {{ $productos->total() }}
        resultados
    </span>
    <div class="d-flex align-items-center">
        <small class="text-muted" style="margin-right: 5px;">Filas</small>
        <form method="GET" action="{{ route('productos.index') }}" class="m-0 me-4">

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
            {{ $productos->links() }}
        </div>

    </div>
</div>
