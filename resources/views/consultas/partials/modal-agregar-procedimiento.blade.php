<div class="modal fade" id="modalAgregarProcedimiento" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow rounded-4">

            <div class="modal-header border-0 pb-0">
                <h5 class="fw-bold mb-0">Agregar procedimiento</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body px-4 py-3">

                <!-- buscador -->
                <div class="position-relative mb-3">
                    <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                    <input type="text" id="buscarProcedimiento"
                        class="form-control rounded-pill ps-5 search-input"
                        placeholder="Buscar procedimiento...">
                </div>

                <!-- lista de procedimientos -->
                <div class="list-group" id="listaProcedimientos">
                    @foreach($procedimientos as $proc)
                        <button type="button"
                            class="list-group-item list-group-item-action d-flex justify-content-between align-items-center item-procedimiento"
                            data-id="{{ $proc->idProcedimiento }}"
                            data-nombre="{{ $proc->nombre }}"
                            data-precio="{{ $proc->precio }}">
                            <span class="fw-medium">{{ $proc->nombre }}</span>
                            <span class="text-muted small">RD$ {{ number_format($proc->precio, 2) }}</span>
                        </button>
                    @endforeach
                </div>

            </div>

        </div>
    </div>
</div>