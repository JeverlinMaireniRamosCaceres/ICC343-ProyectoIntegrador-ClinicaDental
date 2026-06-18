<div class="modal fade" id="modalEliminarPaciente" tabindex="-1" aria-labelledby="modalEliminarPacienteLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow rounded-3">

            <div class="modal-header border-0 pb-0">
                <div class="d-flex align-items-center gap-2">
                    <div class="rounded-circle bg-danger bg-opacity-10 d-flex align-items-center justify-content-center"
                         style="width: 40px; height: 40px;">
                        <i class="bi bi-trash3-fill text-danger" style="font-size: 16px;"></i>
                    </div>

                    <h5 class="modal-title fw-semibold mb-0" id="modalEliminarPacienteLabel">
                        Eliminar paciente
                    </h5>
                </div>

                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>

            <div class="modal-body pt-3">
                <p class="text-muted mb-0">
                    ¿Estás seguro de que deseas eliminar <strong id="modalNombrePaciente">este paciente</strong>?
                </p>
            </div>

            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">
                    Cancelar
                </button>

                <form id="formEliminarPaciente" method="POST" action="{{ route('pacientes.destroy', 1) }}">
                    @csrf
                    @method('DELETE')

                    <button type="submit" class="btn btn-danger rounded-pill px-4">
                        <i class="bi bi-trash3-fill me-1"></i> Eliminar
                    </button>
                </form>
            </div>

        </div>
    </div>
</div>
