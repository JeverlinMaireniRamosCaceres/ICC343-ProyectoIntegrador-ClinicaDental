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

                {{ $alergias->links() }}
            </div>

            </div>
