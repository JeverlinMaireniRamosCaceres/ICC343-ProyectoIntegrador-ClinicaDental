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
    {{ $procedimientos->links() }}
</div>
