<div class="d-flex align-items-center justify-content-between px-4 py-3 border-top">
    <small class="text-muted">
        Mostrando {{ $pagos->firstItem() ?? 0 }} - {{ $pagos->lastItem() ?? 0 }} de {{ $pagos->total() }} resultados
    </small>

    <div class="d-flex align-items-center">
        <small class="text-muted me-2">Filas</small>

        <form method="GET" action="{{ route('pagos.index') }}" class="m-0 me-4">
            <input type="hidden" name="vista" value="{{ $vista }}">
            <input type="hidden" name="buscar" value="{{ request('buscar') }}">
            <select id="porPagina" name="porPagina" class="form-select form-select-sm"
                style="width:65px;height:33px;min-height:33px;padding-right:1.5rem;">
                <option value="10" {{ $porPagina == 10 ? 'selected' : '' }}>10</option>
                <option value="25" {{ $porPagina == 25 ? 'selected' : '' }}>25</option>
                <option value="50" {{ $porPagina == 50 ? 'selected' : '' }}>50</option>
                <option value="100" {{ $porPagina == 100 ? 'selected' : '' }}>100</option>
            </select>
        </form>

        <div class="pagination-wrapper pt-3">
            {{ $pagos->links() }}
        </div>
    </div>
</div>
