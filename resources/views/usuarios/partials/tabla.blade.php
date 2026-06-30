<div class="table-responsive">

    <table class="table table-hover-custom align-middle mb-0">

        <thead class="table-light">

            <tr>
                <th class="px-4 py-3 text-muted fw-semibold small">ID</th>
                <th class="px-4 py-3 text-muted fw-semibold small">Usuario</th>
                <th class="px-4 py-3 text-muted fw-semibold small">Rol</th>
                <th class="px-4 py-3 text-muted fw-semibold small">Estado</th>
                <th class="px-4 py-3 text-muted fw-semibold small text-center">Acciones</th>
            </tr>

        </thead>

        <tbody>

            @forelse ($usuarios as $usuario)
                <tr>

                    <td class="px-4 fw-semibold">
                        {{ $usuario->idUsuario }}
                    </td>

                    <td class="px-4">
                        {{ $usuario->username }}
                    </td>

                    <td class="px-4">
                        {{ $usuario->rol->nombre }}
                    </td>

                    <td class="px-4">
                        @if ($usuario->deleted_at)
                            <span class="badge rounded-pill px-3 py-2 text-danger bg-danger-subtle">Inactivo</span>
                        @else
                            <span class="badge rounded-pill px-3 py-2 text-success bg-success-subtle">Activo</span>
                        @endif
                    </td>

                    <td class="px-4 text-center">

                        <div class="d-flex justify-content-center gap-2">

                            <a href="{{ route('usuarios.edit', $usuario->idUsuario) }}"
                                class="btn btn-sm btn-warning rounded-pill px-3 text-white" title="Editar">

                                <i class="bi bi-pencil"></i>

                            </a>

                            @if (!$usuario->trashed())
                                <button type="button" class="btn btn-sm btn-danger rounded-pill px-3"
                                    data-bs-toggle="modal" data-bs-target="#modalEliminarUsuario"
                                    data-id="{{ $usuario->idUsuario }}" data-nombre="{{ $usuario->username }}"
                                    title="Dar de baja">

                                    <i class="bi bi-ban"></i>

                                </button>
                            @else
                                <button type="button" class="btn btn-sm btn-success rounded-pill px-3"
                                    data-bs-toggle="modal" data-bs-target="#modalActivarUsuario"
                                    data-id="{{ $usuario->idUsuario }}" data-nombre="{{ $usuario->username }}"
                                    title="Activar">

                                    <i class="bi bi-check-lg"></i>

                                </button>
                            @endif

                        </div>

                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="5" class="text-center text-muted py-5">
                        No se encontraron usuarios.
                    </td>

                </tr>
            @endforelse

        </tbody>

    </table>

</div>

<!-- paginacion -->
<div class="d-flex justify-content-between align-items-center px-4 py-3 border-top">

    <span class="text-muted small">
        Mostrando {{ $usuarios->firstItem() ?? 0 }}
        - {{ $usuarios->lastItem() ?? 0 }}
        de {{ $usuarios->total() }} resultados
    </span>

    <div class="d-flex align-items-center">
        <small class="text-muted" style="margin-right: 5px;">Filas</small>
        <form method="GET" action="{{ route('usuarios.index') }}" class="m-0 me-4">

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
            {{ $usuarios->links() }}
        </div>

    </div>
</div>
