<div class="modal fade" id="modalPago" tabindex="-1" aria-hidden="true">

    <div class="modal-dialog modal-xl modal-dialog-centered modal-pago">
        <form action="{{ route('pagos.store') }}" method="POST" class="modal-content border-0 rounded-4">

            @csrf

            <input type="hidden" name="idFactura" value="{{ $factura->idFactura }}">

            <div class="modal-header border-0 px-4 pt-4 pb-3">

                <div>

                    <h5 class="modal-title fw-semibold mb-1">
                        Registrar pago
                    </h5>

                    <small class="text-muted">
                        Seleccione una o varias cuotas pendientes.
                    </small>

                </div>

                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>

            </div>

            <div class="modal-body px-4 pt-2">

                {{-- MÉTODO DE PAGO --}}
                <div class="mb-4">

                    <label class="form-label mb-2">

                        Método de pago

                    </label>

                    <div class="row g-2">

                        @foreach ($metodosPago as $index => $metodo)
                            <div class="col-md-4">

                                <input type="radio" class="d-none metodo-radio" id="metodo{{ $metodo->idMetodoPago }}"
                                    name="idMetodoPago" value="{{ $metodo->idMetodoPago }}"
                                    {{ $index === 0 ? 'checked' : '' }} required>

                                <label for="metodo{{ $metodo->idMetodoPago }}"
                                    class="card metodo-card {{ $index === 0 ? 'selected' : '' }}">

                                    <div class="card-body d-flex align-items-center">

                                        <div class="me-2">

                                            @switch($metodo->descripcion)
                                                @case('Efectivo')
                                                    <i class="bi bi-cash-stack fs-4 text-success"></i>
                                                @break

                                                @case('Tarjeta')
                                                    <i class="bi bi-credit-card fs-4 text-primary"></i>
                                                @break

                                                @case('Transferencia')
                                                    <i class="bi bi-bank fs-4 text-info"></i>
                                                @break

                                                @default
                                                    <i class="bi bi-wallet2 fs-4 text-secondary"></i>
                                            @endswitch

                                        </div>

                                        <div class="flex-grow-1">

                                            <div class="fw-semibold small">

                                                {{ $metodo->descripcion }}

                                            </div>

                                        </div>

                                        <i class="bi bi-check-circle-fill check-icon text-primary"></i>

                                    </div>

                                </label>

                            </div>
                        @endforeach

                    </div>

                </div>

                <div class="row g-4">

                    {{-- IZQUIERDA --}}
                    <div class="col-lg-7">

                        <label class="form-label mb-2">

                            Cuotas pendientes

                        </label>

                        <div class="border rounded-4 overflow-auto" style="max-height:330px;">
                            @forelse($factura->pagos->where('estado','Pendiente')->sortBy('fechaVencimiento') as $index => $pago)
                                <label
                                    class="cuota-item d-flex justify-content-between align-items-center p-3 border-bottom">

                                    <div class="d-flex align-items-center gap-3">

                                        <input class="form-check-input cuota-check" type="checkbox" name="pagos[]"
                                            value="{{ $pago->idPago }}" data-monto="{{ $pago->monto }}"
                                            {{ $index === 0 ? 'checked' : '' }}>

                                        <div>

                                            <div class="fw-semibold">

                                                Cuota #{{ $pago->numeroCuota }}

                                                @if ($index === 0)
                                                    <span class="badge bg-primary-subtle text-primary rounded-pill ms-2"
                                                        style="font-size:.7rem;">
                                                        Próxima
                                                    </span>
                                                @endif

                                            </div>

                                            <small class="text-muted">

                                                Vence:
                                                {{ \Carbon\Carbon::parse($pago->fechaVencimiento)->format('d/m/Y') }}

                                            </small>

                                        </div>

                                    </div>

                                    <div class="text-end">

                                        <div class="fw-bold">

                                            RD$ {{ number_format($pago->monto, 2) }}

                                        </div>

                                    </div>

                                </label>

                            @empty

                                <div class="text-center py-5 text-muted">

                                    No hay cuotas pendientes.

                                </div>
                            @endforelse

                        </div>

                    </div>

                    {{-- DERECHA --}}
                    <div class="col-lg-5">

                        <div class="card border-0 bg-light rounded-4 h-100">

                            <div class="card-body">

                                <small class="text-muted d-block mb-1">

                                    Resumen del pago

                                </small>

                                <h2 class="fw-bold mb-4" id="totalSeleccionado">

                                    RD$ 0.00

                                </h2>

                                {{-- REFERENCIA --}}
                                <div class="mb-3 d-none" id="grupoReferencia">

                                    <label class="form-label">

                                        Referencia

                                    </label>

                                    <input type="text" id="referenciaPago" name="referenciaPago"
                                        class="form-control rounded-3" maxlength="100"
                                        placeholder="Número de autorización o transferencia">

                                </div>

                                {{-- EFECTIVO --}}
                                <div id="grupoEfectivo" class="d-none">

                                    <div class="mb-3">

                                        <label class="form-label">

                                            Monto recibido

                                        </label>

                                        <input type="number" id="montoRecibido" class="form-control rounded-3"
                                            min="0" step="0.01" placeholder="0.00">

                                    </div>

                                    <hr>

                                    <div class="d-flex justify-content-between align-items-center mb-1">

                                        <span class="text-muted">

                                            Cambio

                                        </span>

                                        <span id="cambioPago" class="fw-bold fs-4 text-success">

                                            RD$ 0.00

                                        </span>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                    {{-- OBSERVACIÓN --}}
                    <div class="mt-4">

                        <label class="form-label">

                            Observación

                        </label>

                        <textarea name="observacion" rows="2" class="form-control rounded-3" placeholder="Opcional"></textarea>

                    </div>

                </div>

            </div>

            <div class="modal-footer border-0 px-4 pb-4">

                <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">

                    Cancelar

                </button>

                <button type="submit" class="btn btn-success rounded-pill px-4" id="btnConfirmarPago">

                    <i class="bi bi-check-circle me-2"></i>

                    Confirmar pago

                </button>

            </div>

        </form>

    </div>

</div>

<style>
    .metodo-card {
        cursor: pointer;
        border: 2px solid #e9ecef;
        border-radius: 1rem;
        transition: all .2s ease;
        user-select: none;
    }

    .metodo-card:hover {
        border-color: #0ea5e9;
        transform: translateY(-2px);
        box-shadow: 0 .2rem .6rem rgba(0, 0, 0, .08);
    }

    .metodo-card.selected {
        border-color: #0ea5e9;
        background: rgba(14, 165, 233, .06);
        box-shadow: 0 .2rem .6rem rgba(14, 165, 233, .15);
    }

    .metodo-card .card-body {
        min-height: 60px;
        padding: .75rem .9rem;
    }

    .metodo-card .fw-semibold {
        font-size: .9rem;
    }

    .check-icon {
        opacity: 0;
        transform: scale(.8);
        transition: all .2s ease;
    }

    .metodo-card.selected .check-icon {
        opacity: 1;
        transform: scale(1);
    }

    .cuota-item {
        cursor: pointer;
        transition: background .2s ease;
    }

    .cuota-item:hover {
        background: rgba(0, 0, 0, .03);
    }

    .modal-body .form-control {
        padding-top: .45rem;
        padding-bottom: .45rem;
    }

    .modal-body .form-label {
        margin-bottom: .35rem;
        font-weight: 500;
    }

    #montoRecibido {
        font-weight: 600;
    }

    #cambioPago {
        transition: .2s;
    }

    #btnConfirmarPago:disabled {
        opacity: .6;
        cursor: not-allowed;
    }

    .modal-dialog {
        max-height: calc(100vh - 2rem);
    }

    .modal-content {
        max-height: calc(100vh - 2rem);
        overflow: hidden;
    }

    .modal-body {
        overflow-y: auto;
    }

    .modal-pago {
        max-width: 1000px !important;
        width: 1000px !important;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', () => {

        const radios = document.querySelectorAll('.metodo-radio');
        const cards = document.querySelectorAll('.metodo-card');

        const grupoReferencia = document.getElementById('grupoReferencia');
        const referencia = document.getElementById('referenciaPago');

        const grupoEfectivo = document.getElementById('grupoEfectivo');
        const montoRecibido = document.getElementById('montoRecibido');
        const cambioPago = document.getElementById('cambioPago');

        const total = document.getElementById('totalSeleccionado');

        const checks = document.querySelectorAll('.cuota-check');

        const btnConfirmar = document.getElementById('btnConfirmarPago');

        // La primera cuota (la más próxima) es obligatoria: evita confirmar un pago de RD$0
        if (checks.length > 0) {

            const primeraCuota = checks[0];

            primeraCuota.checked = true;

            primeraCuota.title = 'Esta cuota es obligatoria';

            primeraCuota.addEventListener('click', (e) => {

                e.preventDefault();

            });

            primeraCuota.closest('.cuota-item').style.cursor = 'not-allowed';

        }

        function obtenerTotalSeleccionado() {

            let monto = 0;

            checks.forEach(check => {

                if (check.checked) {

                    monto += Number(check.dataset.monto);

                }

            });

            return monto;

        }

        function actualizarResumen() {

            const monto = obtenerTotalSeleccionado();

            total.textContent =
                'RD$ ' +
                monto.toLocaleString('en-US', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });

            calcularCambio();

        }

        function actualizarMetodoPago() {

            const radio = document.querySelector('.metodo-radio:checked');

            if (!radio) return;

            cards.forEach(card => card.classList.remove('selected'));

            radio.nextElementSibling.classList.add('selected');

            const nombre = radio.nextElementSibling
                .querySelector('.fw-semibold')
                .textContent
                .trim();

            if (nombre === 'Efectivo') {

                grupoReferencia.classList.add('d-none');
                referencia.required = false;
                referencia.value = '';

                grupoEfectivo.classList.remove('d-none');

                montoRecibido.required = true;

                setTimeout(() => {

                    montoRecibido.focus();
                    montoRecibido.select();

                }, 100);

            } else {

                grupoEfectivo.classList.add('d-none');
                montoRecibido.required = false;
                montoRecibido.value = '';

                grupoReferencia.classList.remove('d-none');
                referencia.required = true;

            }

            calcularCambio();

        }

        function calcularCambio() {

            if (grupoEfectivo.classList.contains('d-none')) {

                btnConfirmar.disabled = false;

                return;

            }

            const totalPago = obtenerTotalSeleccionado();

            const recibido = Number(montoRecibido.value) || 0;

            const diferencia = recibido - totalPago;

            if (diferencia >= 0) {

                cambioPago.classList.remove('text-danger');
                cambioPago.classList.add('text-success');

                cambioPago.textContent =
                    'RD$ ' +
                    diferencia.toLocaleString('en-US', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    });

                btnConfirmar.disabled = false;

            } else {

                cambioPago.classList.remove('text-success');
                cambioPago.classList.add('text-danger');

                cambioPago.textContent =
                    'Faltan RD$ ' +
                    Math.abs(diferencia).toLocaleString('en-US', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    });

                btnConfirmar.disabled = true;

            }

        }

        radios.forEach(radio => {

            radio.addEventListener('change', actualizarMetodoPago);

        });

        checks.forEach(check => {

            check.addEventListener('change', actualizarResumen);

        });

        montoRecibido.addEventListener('input', calcularCambio);

        actualizarResumen();

        actualizarMetodoPago();

    });
</script>
