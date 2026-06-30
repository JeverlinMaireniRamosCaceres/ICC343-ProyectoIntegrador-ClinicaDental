<div class="table-responsive">

    <table class="table table-hover-custom align-middle mb-0">

        <thead class="table-light">

            <tr>
                <th class="px-4 py-3 text-muted fw-semibold small">ID</th>
                <th class="px-4 py-3 text-muted fw-semibold small">Nombre</th>
                <th class="px-4 py-3 text-muted fw-semibold small text-center">Acciones</th>
            </tr>

        </thead>

        <tbody>

            @forelse ($especialidades as $especialidad)
                <tr>

                    <td class="px-4 fw-semibold">
                        {{ $especialidad->idEspecialidad }}
                    </td>

                    <td class="px-4">
                        {{ $especialidad->nombre }}
                    </td>

                    <td class="px-4 text-center">

                        <div class="d-flex justify-content-center gap-2">

                            <a href="{{ route('especialidades.edit', $especialidad->idEspecialidad) }}"
                                class="btn btn-sm btn-warning rounded-pill px-3 text-white">

                                <i class="bi bi-pencil"></i>

                            </a>

                            <button type="button" class="btn btn-sm btn-danger rounded-pill px-3"
                                data-bs-toggle="modal" data-bs-target="#modalEliminarEspecialidad"
                                data-id="{{ $especialidad->idEspecialidad }}" data-nombre="{{ $especialidad->nombre }}">

                                <i class="bi bi-trash"></i>

                            </button>

                        </div>

                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="3" class="text-center text-muted py-5">
                        No se encontraron especialidades.
                    </td>

                </tr>
            @endforelse

        </tbody>

    </table>

</div>

<!-- paginacion -->
<div class="d-flex justify-content-between align-items-center px-4 py-3 border-top">

    <span class="text-muted small">
        Mostrando {{ $especialidades->firstItem() ?? 0 }}
        - {{ $especialidades->lastItem() ?? 0 }}
        de {{ $especialidades->total() }} resultados
    </span>

    <div class="d-flex align-items-center">
        <small class="text-muted" style="margin-right: 5px;">Filas</small>
        <form method="GET" action="{{ route('especialidades.index') }}" class="m-0 me-4">

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
            {{ $especialidades->links() }}
        </div>

    </div>

</div>
