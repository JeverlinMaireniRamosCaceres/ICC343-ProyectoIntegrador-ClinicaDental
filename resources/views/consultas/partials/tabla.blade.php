<div class="table-responsive">
    <table class="table align-middle mb-0">
        <thead class="table-light">
            <tr>
                <th class="px-4 py-3 text-muted fw-semibold small">Paciente</th>
                <th class="px-4 py-3 text-muted fw-semibold small">Teléfono</th>
                <th class="px-4 py-3 text-muted fw-semibold small">Odontólogo</th>
                <th class="px-4 py-3 text-muted fw-semibold small">Fecha</th>
                <th class="px-4 py-3 text-muted fw-semibold small">Motivo</th>
                <th class="px-4 py-3 text-muted fw-semibold small">Estado</th>
                <th class="px-4 py-3 text-muted fw-semibold small text-center">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse($consultas as $consulta)
                <tr>
                    <td class="px-4 fw-semibold">
                        {{ $consulta->paciente->persona->nombre ?? '—' }}
                        {{ $consulta->paciente->persona->apellido ?? '' }}
                    </td>
                    <td class="px-4 text-muted small">
                        {{ $consulta->paciente->persona->telefono ?? '—' }}
                    </td>
                    <td class="px-4 text-muted">
                        {{ $consulta->odontologo->persona->nombre ?? '—' }}
                        {{ $consulta->odontologo->persona->apellido ?? '' }}
                    </td>
                    <td class="px-4 text-muted">
                        {{ \Carbon\Carbon::parse($consulta->fecha)->format('d/m/Y') }}
                    </td>
                    <td class="px-4 text-muted">
                        {{ $consulta->motivo ?? '—' }}
                    </td>
                    <td class="px-4">
                        @if ($consulta->estado == 'Finalizada')
                            <span class="badge rounded-pill px-3 py-2 text-success bg-success-subtle">
                                Finalizada
                            </span>
                        @elseif($consulta->estado == 'En proceso')
                            <span class="badge rounded-pill px-3 py-2 text-warning bg-warning-subtle">
                                En proceso
                            </span>
                        @else
                            <span class="badge rounded-pill px-3 py-2 text-primary bg-primary-subtle">
                                Registrada
                            </span>
                        @endif
                    </td>
                    <td class="px-4 text-center">
                        <a href="{{ route('consultas.show', $consulta->idConsulta) }}?return={{ urlencode(request()->fullUrl()) }}"
                            class="btn btn-sm rounded-circle"
                            style="width:34px;height:34px;background:#e8f4fd;color:#0ea5e9;border:none;">
                            <i class="bi bi-eye"></i>
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center py-5 text-muted">
                        <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                        No hay consultas registradas.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="d-flex justify-content-between align-items-center px-4 py-3 border-top">

    <small class="text-muted">
        Mostrando {{ $consultas->firstItem() ?? 0 }}–{{ $consultas->lastItem() ?? 0 }}
        de {{ $consultas->total() }} resultados
    </small>

    <div class="d-flex align-items-center">

        <small class="text-muted me-2">Filas</small>

        <form method="GET" action="{{ route('consultas.index') }}" class="m-0 me-4">

            <input type="hidden" name="buscar" value="{{ request('buscar') }}">

            <select name="porPagina" id="porPagina" class="form-select form-select-sm"
                style="width:65px;height:33px;min-height:33px;padding-right:1.5rem;">

                <option value="10" {{ $porPagina == 10 ? 'selected' : '' }}>10</option>
                <option value="25" {{ $porPagina == 25 ? 'selected' : '' }}>25</option>
                <option value="50" {{ $porPagina == 50 ? 'selected' : '' }}>50</option>
                <option value="100" {{ $porPagina == 100 ? 'selected' : '' }}>100</option>

            </select>

        </form>

        <div class="pagination-wrapper pt-3">
            {{ $consultas->links() }}
        </div>

    </div>

</div>
