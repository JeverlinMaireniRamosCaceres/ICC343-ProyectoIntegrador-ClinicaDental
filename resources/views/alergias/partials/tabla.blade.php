            <div class="table-responsive">
                <table class="table table-hover-custom align-middle mb-0">

                    <thead class="table-light">
                        <tr>
                            <th class="px-4 py-3 text-muted fw-semibold small">ID</th>
                            <th class="px-4 py-3 text-muted fw-semibold small">Nombre</th>
                            <th class="px-4 py-3 text-muted fw-semibold small text-center">Acciones</th>
                        </tr>
                    </thead>

                    <tbody id="tablaAlergias">

                        @foreach ($alergias as $alergia)
                            <tr>
                                <td class="px-4 fw-semibold">{{ $alergia->idAlergia }}</td>
                                <td class="px-4 nombre-alergia">{{ $alergia->nombre }}</td>
                                <td class="px-4 text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="{{ route('alergias.edit', $alergia->idAlergia) }}"
                                            class="btn btn-sm btn-warning rounded-pill px-3 text-white">
                                            <i class="bi bi-pencil"></i>
                                        </a>

                                        <button type="button"
                                            class="btnEliminarAlergia btn btn-sm btn-danger rounded-pill px-3"
                                            data-bs-toggle="modal" data-bs-target="#modalEliminarAlergia"
                                            data-id="{{ $alergia->idAlergia }}" data-nombre="{{ $alergia->nombre }}">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>


            <!-- paginacion -->
            <div class="d-flex justify-content-between align-items-center px-4 py-3 border-top">
                <span class="text-muted small">
                    Mostrando {{ $alergias->firstItem() ?? 0 }} - {{ $alergias->lastItem() ?? 0 }}
                    de {{ $alergias->total() }} resultados
                </span>

                <div class="d-flex align-items-center">
                    <small class="text-muted" style="margin-right: 5px;">Filas</small>
                    <form method="GET" action="{{ route('alergias.index') }}" class="m-0 me-4">

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
                        {{ $alergias->links() }}
                    </div>

                </div>
            </div>

            </div>
