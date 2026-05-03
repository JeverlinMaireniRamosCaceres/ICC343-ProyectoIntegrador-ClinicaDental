<div class="modal fade" id="modalCitasDia" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow rounded-4">

            <div class="modal-header border-0 pb-0">
                <div>
                    <h5 class="fw-bold mb-0">Citas del día</h5>
                    <small class="text-muted" id="modalCitasDiaFecha">
                        Sábado, 02 mayo 2026
                    </small>
                </div>

                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body pt-4">

                <div class="d-flex flex-column gap-3">

                    <!-- Cita 1 -->
                    <div class="border rounded-4 p-3 d-flex justify-content-between align-items-center">
                        <div>
                            <div class="fw-bold">09:00 AM</div>
                            <div class="fw-semibold">Ana Martínez</div>
                            <small class="text-muted">Dr. Juan Pérez</small>
                        </div>

                        <div class="d-flex align-items-center gap-2">
                            <span class="badge bg-warning-subtle text-warning rounded-pill px-3">
                                Pendiente
                            </span>

                            <a href="{{ route('citas.edit', 1) }}"
                               class="btn btn-sm btn-warning rounded-pill px-3 text-white">
                                <i class="bi bi-pencil"></i>
                            </a>

                            <button type="button" class="btn btn-sm btn-danger rounded-pill px-3">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Cita 2 -->
                    <div class="border rounded-4 p-3 d-flex justify-content-between align-items-center">
                        <div>
                            <div class="fw-bold">10:30 AM</div>
                            <div class="fw-semibold">Carlos Gómez</div>
                            <small class="text-muted">Dra. Laura Gómez</small>
                        </div>

                        <div class="d-flex align-items-center gap-2">
                            <span class="badge bg-success-subtle text-success rounded-pill px-3">
                                Confirmada
                            </span>

                            <a href="{{ route('citas.edit', 2) }}"
                               class="btn btn-sm btn-warning rounded-pill px-3 text-white">
                                <i class="bi bi-pencil"></i>
                            </a>

                            <button type="button" class="btn btn-sm btn-danger rounded-pill px-3">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </div>

                </div>

            </div>

        </div>
    </div>
</div>