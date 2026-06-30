<div class="table-responsive">

    <table class="table table-hover align-middle mb-0">

        <thead class="table-light">

            <tr>

                <th class="px-4 py-3 text-muted fw-semibold small">
                    Nombre
                </th>

                <th class="px-4 py-3 text-muted fw-semibold small">
                    Correo
                </th>

                <th class="px-4 py-3 text-muted fw-semibold small">
                    Teléfono
                </th>

                <th class="px-4 py-3 text-muted fw-semibold small">
                    Estado
                </th>

                <th class="px-4 py-3 text-muted fw-semibold small text-center">
                    Acciones
                </th>

            </tr>

        </thead>

        <tbody>

            @forelse ($proveedores as $proveedor)
                <tr>

                    <td class="px-4 fw-medium">
                        {{ $proveedor->nombre }}
                    </td>

                    <td class="px-4 text-muted">
                        {{ $proveedor->correo }}
                    </td>

                    <td class="px-4 text-muted">
                        {{ $proveedor->telefono }}
                    </td>

                    <td class="px-4">

                        @if (!$proveedor->trashed())
                            <span class="badge bg-success-subtle text-success rounded-pill px-3 py-2">

                                Activado

                            </span>
                        @else
                            <span class="badge bg-danger-subtle text-danger rounded-pill px-3 py-2">

                                Desactivado

                            </span>
                        @endif

                    </td>

                    <td class="px-4">

                        <div class="d-flex justify-content-center gap-2">

                            <!-- editar -->
                            <a href="{{ route('proveedores.edit', $proveedor->idProveedor) }}"
                                class="btn btn-sm btn-warning rounded-pill px-3 text-white">

                                <i class="bi bi-pencil"></i>

                            </a>

                            <!-- activar/desactivar -->
                            @if (!$proveedor->trashed())
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn btn-sm btn-danger rounded-pill px-3"
                                    title="Desactivar" data-bs-toggle="modal" data-bs-target="#modalEliminarProveedor"
                                    data-id="{{ $proveedor->idProveedor }}" data-nombre="{{ $proveedor->nombre }}">

                                    <i class="bi bi-x-octagon"></i>

                                </button>
                            @else
                                @csrf
                                @method('PUT')

                                <button type="submit" class="btn btn-sm btn-success rounded-pill px-3" title="Activar"
                                    data-bs-toggle="modal" data-bs-target="#modalActivarProveedor"
                                    data-id="{{ $proveedor->idProveedor }}" data-nombre="{{ $proveedor->nombre }}">

                                    <i class="bi bi-patch-check"></i>

                                </button>
                            @endif

                        </div>

                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="6" class="text-center py-5 text-muted">

                        <i class="bi bi-inbox fs-1 d-block mb-2"></i>

                        No hay proveedores registrados.

                    </td>

                </tr>
            @endforelse

        </tbody>

    </table>

    @include('proveedores.partials.modal-eliminar')

    @include('proveedores.partials.modal-activar')

</div>

<!-- footer -->
<div class="d-flex align-items-center justify-content-between px-4 py-3 border-top">

    <small class="text-muted">

        Mostrando
        {{ $proveedores->firstItem() ?? 0 }}
        -
        {{ $proveedores->lastItem() ?? 0 }}
        de
        {{ $proveedores->total() }}
        resultados

    </small>

    <div class="d-flex align-items-center">
        <small class="text-muted" style="margin-right: 5px;">Filas</small>
        <form method="GET" action="{{ route('proveedores.index') }}" class="m-0 me-4">

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
            {{ $proveedores->links() }}
        </div>

    </div>

</div>
