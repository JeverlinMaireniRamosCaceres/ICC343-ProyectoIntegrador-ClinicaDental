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

    {{ $especialidades->links() }}

</div>
