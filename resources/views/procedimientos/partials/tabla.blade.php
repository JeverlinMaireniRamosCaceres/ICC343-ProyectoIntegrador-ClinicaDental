<div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
            <tr>
                <th class="px-4 py-3 text-muted fw-semibold small">Nombre</th>
                <th class="px-4 py-3 text-muted fw-semibold small">Precio</th>
                <th class="px-4 py-3 text-muted fw-semibold small">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($procedimientos as $procedimiento)
                <tr>
                    <td class="px-4 fw-medium">{{ $procedimiento->nombre }}</td>
                    <td class="px-4 fw-semibold">
                        RD$ {{ number_format($procedimiento->precio, 2) }}
                    </td>
                    <td class="px-4">
                        <div class="d-flex gap-2">
                            <a href="{{ route('procedimientos.show', $procedimiento->idProcedimiento) }}"
                                class="btn btn-sm btn-secondary rounded-pill px-3" title="Ver">
                                <i class="bi bi-eye-fill"></i>
                            </a>

                            <a href="{{ route('procedimientos.edit', $procedimiento->idProcedimiento) }}"
                                class="btn btn-sm btn-warning rounded-pill px-3" style="color:white;" title="Editar">
                                <i class="bi bi-pencil-fill"></i>
                            </a>

                            <button type="button" class="btn btn-sm btn-danger rounded-pill px-3" title="Eliminar"
                                data-bs-toggle="modal" data-bs-target="#modalEliminarProcedimiento"
                                data-id="{{ $procedimiento->idProcedimiento }}"
                                data-nombre="{{ $procedimiento->nombre }}">
                                <i class="bi bi-trash3-fill"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center text-muted py-5">
                        No se encontraron procedimientos.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="d-flex align-items-center justify-content-between px-4 py-3 border-top">
    <small class="text-muted">
        Mostrando {{ $procedimientos->firstItem() }}–{{ $procedimientos->lastItem() }}
        de {{ $procedimientos->total() }} resultados
    </small>
    <div class="d-flex align-items-center">
        <small class="text-muted" style="margin-right: 5px;">Filas</small>
        <form method="GET" action="{{ route('procedimientos.index') }}" class="m-0 me-4">

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
            {{ $procedimientos->links() }}
        </div>

    </div>
</div>
