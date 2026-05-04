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

                            <button type="button"
                                    class="btn btn-sm btn-danger rounded-pill px-3 btn-eliminar-cita"
                                    data-id="1"
                                    data-nombre="Ana Martínez">
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

                            <button type="button"
                                    class="btn btn-sm btn-danger rounded-pill px-3 btn-eliminar-cita"
                                    data-id="2"
                                    data-nombre="Carlos Gómez">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>


<!-- Modal confirmar eliminación -->
<div class="modal fade" id="modalEliminarCita" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow rounded-4">

            <div class="modal-header border-0 pb-0">
                <div class="d-flex align-items-center gap-2">
                    <div class="rounded-circle bg-danger bg-opacity-10 d-flex align-items-center justify-content-center"
                         style="width: 42px; height: 42px;">
                        <i class="bi bi-trash3-fill text-danger"></i>
                    </div>

                    <div>
                        <h5 class="fw-bold mb-0">Eliminar cita</h5>
                    </div>
                </div>

                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body pt-3">
                <p class="mb-0">
                    ¿Estás seguro de que deseas eliminar la cita de
                    <strong id="nombreCitaEliminar">esta persona</strong>?
                </p>
            </div>

            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">
                    Cancelar
                </button>

                <form id="formEliminarCita" action="{{ route('citas.destroy', 1) }}" method="POST">
                    @csrf
                    @method('DELETE')

                    <button type="submit" class="btn btn-danger rounded-pill px-4">
                        Eliminar
                    </button>
                </form>
            </div>

        </div>
    </div>
</div>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        const modalEliminarCitaElement = document.getElementById('modalEliminarCita');
        const modalEliminarCita = new bootstrap.Modal(modalEliminarCitaElement, {
            backdrop: true,
            keyboard: true
        });

        document.querySelectorAll('.btn-eliminar-cita').forEach(function (button) {
            button.addEventListener('click', function () {
                const id = this.getAttribute('data-id');
                const nombre = this.getAttribute('data-nombre');

                document.getElementById('nombreCitaEliminar').textContent = nombre;

                const form = document.getElementById('formEliminarCita');
                form.action = `/citas/${id}`;

                modalEliminarCita.show();

                setTimeout(function () {
                    const backdrops = document.querySelectorAll('.modal-backdrop');
                    const lastBackdrop = backdrops[backdrops.length - 1];

                    if (lastBackdrop) {
                        lastBackdrop.classList.add('backdrop-eliminar-cita');
                    }
                }, 10);
            });
        });

        modalEliminarCitaElement.addEventListener('hidden.bs.modal', function () {
            const modalCitasDia = document.getElementById('modalCitasDia');

            if (modalCitasDia && modalCitasDia.classList.contains('show')) {
                document.body.classList.add('modal-open');
            }
        });
    });
</script>