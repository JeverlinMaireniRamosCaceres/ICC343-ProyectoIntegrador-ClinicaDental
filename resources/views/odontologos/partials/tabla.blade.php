<div class="table-responsive">

    <table class="table table-hover-custom align-middle mb-0">

        <thead class="table-light">

            <tr>
                <th class="px-4 py-3 text-muted fw-semibold small">Nombre</th>
                <th class="px-4 py-3 text-muted fw-semibold small">Teléfono</th>
                <th class="px-4 py-3 text-muted fw-semibold small text-center">Especialidad</th>
                <th class="px-4 py-3 text-muted fw-semibold small text-center">Estado</th>
                <th class="px-4 py-3 text-muted fw-semibold small">Acciones</th>
            </tr>

        </thead>

        <tbody>

            @forelse ($odontologos as $odontologo)
                <tr>

                    <td class="px-4 fw-semibold">
                        {{ $odontologo->persona->nombre . ' ' . $odontologo->persona->apellido }}
                    </td>

                    <td class="px-4">
                        {{ $odontologo->persona->telefono }}
                    </td>


                    <td class="px-4 text-center">
                        @if ($odontologo->especialidades->count() > 0)
                            <span class="badge rounded-pill px-3 py-2 fw-semibold" style="background-color:#EDE9FE; color:#6D28D9;">
                                {{ $odontologo->especialidades->first()->nombre }}

                                @if ($odontologo->especialidades->count() > 1)
                                        +{{ $odontologo->especialidades->count() - 1 }}
                                @endif
                            </span>
                        @else
                            <div class="text-center text-muted fw-semibold">
                                —
                            </div>
                        @endif
                    </td>

                    <td class="px-4 text-center">
                        @if ($odontologo->deleted_at)
                            <span class="badge rounded-pill px-3 py-2 text-danger bg-danger-subtle">Inactivo</span>
                        @else
                            <span class="badge rounded-pill px-3 py-2 text-success bg-success-subtle">Activo</span>
                        @endif
                    </td>

                    <td class="px-4">

                        <div class="d-flex gap-2">

                            <a href="{{ route('odontologos.show', $odontologo->idOdontologo) }}"
                                class="btn btn-sm btn-secondary rounded-pill px-3" title="Ver detalle">
                                <i class="bi bi-eye-fill"></i>
                            </a>

                            @if (!$odontologo->trashed())
                                <a href="{{ route('odontologos.edit', $odontologo->idOdontologo) }}"
                                    class="btn btn-sm btn-warning rounded-pill px-3 text-white" title="Editar">

                                    <i class="bi bi-pencil"></i>

                                </a>
                                <button type="button" class="btn btn-sm btn-danger rounded-pill px-3"
                                    data-bs-toggle="modal" data-bs-target="#modalEliminarOdontologo"
                                    data-id="{{ $odontologo->idOdontologo }}"
                                    data-nombre="{{ $odontologo->persona->nombre }}" title="Desactivar">

                                    <i class="bi bi-ban"></i>

                                </button>
                            @else
                                <button type="button" class="btn btn-sm btn-success rounded-pill px-3"
                                    data-bs-toggle="modal" data-bs-target="#modalActivarOdontologo"
                                    data-id="{{ $odontologo->idOdontologo }}"
                                    data-nombre="{{ $odontologo->persona->nombre }}" title="Activar">

                                    <i class="bi bi-check-lg"></i>

                                </button>
                            @endif

                        </div>

                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="5" class="text-center text-muted py-5">
                        No se encontraron odontólogos.
                    </td>

                </tr>
            @endforelse

        </tbody>

    </table>

</div>

<!-- paginacion -->
<div class="d-flex justify-content-between align-items-center px-4 py-3 border-top">

    <span class="text-muted small">
        Mostrando {{ $odontologos->firstItem() ?? 0 }}
        - {{ $odontologos->lastItem() ?? 0 }}
        de {{ $odontologos->total() }} resultados
    </span>

    <div class="d-flex align-items-center">
        <small class="text-muted" style="margin-right: 5px;">Filas</small>
        <form method="GET" action="{{ route('odontologos.index') }}" class="m-0 me-4">

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
            {{ $odontologos->links() }}
        </div>

    </div>

</div>
