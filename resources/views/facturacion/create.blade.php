@extends('layouts.app')

@section('title', 'Facturar')

@section('content')

    <div class="container py-4">

        <form action="{{ route('facturacion.store') }}" method="POST">

            @csrf

            <input type="hidden" name="return" value="{{ $return }}">

            <input type="hidden" name="idConsulta" value="{{ $consulta?->idConsulta }}">

            {{-- HEADER --}}
            <div class="d-flex justify-content-between align-items-center mb-4">

                <div class="d-flex align-items-center gap-3">

                    <a href="{{ $return }}" class="btn btn-light rounded-pill px-3">

                        <i class="bi bi-arrow-left"></i>

                    </a>

                    <h2 class="fw-bold mb-0">
                        Nueva factura
                    </h2>

                </div>

                @if ($consulta)
                    <button type="button" class="btn btn-outline-primary rounded-pill px-4 d-flex align-items-center gap-2"
                        data-bs-toggle="modal" data-bs-target="#modalConsultas">

                        <i class="bi bi-arrow-repeat"></i>

                        Cambiar consulta

                    </button>
                @endif

            </div>

            <div class="row g-4">

                {{-- IZQUIERDA --}}
                <div class="col-lg-8">

                    {{-- INFORMACIÓN DE LA CONSULTA --}}
                    <div class="card border-0 shadow-sm rounded-4 mb-4">

                        <div class="card-body p-4">

                            <h5 class="fw-semibold mb-1">
                                Información de la consulta
                            </h5>

                            <hr>

                            @if ($consulta)
                                <div class="row g-4">

                                    <div class="col-md-6">

                                        <small class="text-muted d-block">
                                            Paciente
                                        </small>

                                        <span class="fw-medium">
                                            {{ $consulta->paciente->persona->nombre }}
                                            {{ $consulta->paciente->persona->apellido }}
                                        </span>

                                    </div>

                                    <div class="col-md-6">

                                        <small class="text-muted d-block">
                                            Odontólogo
                                        </small>

                                        <span class="fw-medium">
                                            {{ $consulta->odontologo->persona->nombre }}
                                            {{ $consulta->odontologo->persona->apellido }}
                                        </span>

                                    </div>

                                    <div class="col-md-6">

                                        <small class="text-muted d-block">
                                            Cédula
                                        </small>

                                        <span class="fw-medium">
                                            {{ $consulta->paciente->persona->cedula ?? 'Sin cédula' }}
                                        </span>

                                    </div>

                                    <div class="col-md-6">

                                        <small class="text-muted d-block">
                                            Fecha
                                        </small>

                                        <span class="fw-medium">
                                            {{ \Carbon\Carbon::parse($consulta->fecha)->format('d/m/Y') }}
                                        </span>

                                    </div>

                                    <div class="col-md-6">

                                        <small class="text-muted d-block">
                                            Teléfono
                                        </small>

                                        <span class="fw-medium">
                                            {{ $consulta->paciente->persona->telefono ?? 'No registrado' }}
                                        </span>

                                    </div>

                                    <div class="col-md-6">

                                        <small class="text-muted d-block">
                                            Estado
                                        </small>

                                        <span class="badge rounded-pill bg-success-subtle text-success">

                                            {{ $consulta->estado }}

                                        </span>

                                    </div>

                                </div>
                            @else
                                <div class="text-center py-5 text-muted">

                                    No se ha seleccionado ninguna consulta.

                                </div>
                            @endif

                        </div>

                    </div>
                    {{-- PROCEDIMIENTOS --}}
                    <div class="card border-0 shadow-sm rounded-4">

                        <div class="card-body p-0">

                            <div class="p-4 border-bottom d-flex justify-content-between align-items-center">

                                <div>

                                    <h5 class="fw-semibold mb-1">
                                        Procedimientos
                                    </h5>

                                </div>

                                @if ($consulta)
                                    <span class="badge rounded-pill bg-primary-subtle text-primary px-3 py-2">
                                        {{ $consulta->detalles->count() }}
                                    </span>
                                @endif

                            </div>

                            <div class="table-responsive">

                                <table class="table table-hover-custom align-middle mb-0">

                                    <thead class="table-light">

                                        <tr>

                                            <th class="px-4 py-3 text-muted fw-semibold small">
                                                Procedimiento
                                            </th>

                                            <th class="px-4 py-3 text-muted fw-semibold small text-center">
                                                Cantidad
                                            </th>

                                            <th class="px-4 py-3 text-muted fw-semibold small text-end">
                                                Precio
                                            </th>

                                            <th class="px-4 py-3 text-muted fw-semibold small text-end">
                                                Subtotal
                                            </th>

                                        </tr>

                                    </thead>

                                    <tbody>

                                        @forelse($consulta?->detalles ?? [] as $detalle)
                                            <tr>

                                                <td class="px-4 fw-medium">

                                                    {{ $detalle->procedimiento->nombre }}

                                                </td>

                                                <td class="px-4 text-center">

                                                    {{ $detalle->cantidadProcedimiento }}

                                                </td>

                                                <td class="px-4 text-end">

                                                    RD$ {{ number_format($detalle->procedimiento->precio, 2) }}

                                                </td>

                                                <td class="px-4 text-end fw-semibold">

                                                    RD$ {{ number_format($detalle->subtotal, 2) }}

                                                </td>

                                            </tr>

                                        @empty

                                            <tr>

                                                <td colspan="4" class="text-center py-5 text-muted">

                                                    <i class="bi bi-clipboard-x fs-2 d-block mb-2"></i>

                                                    No hay procedimientos registrados para esta consulta.

                                                </td>

                                            </tr>
                                        @endforelse

                                    </tbody>

                                </table>

                            </div>

                        </div>

                    </div>

                    @rol('Administrador')
                        {{-- CRONOGRAMA DE PAGOS --}}
                        <div class="card border-0 shadow-sm rounded-4 mt-4" id="cardCronograma">

                            <div class="card-body p-4">

                                <div class="d-flex justify-content-between align-items-center mb-4">

                                    <h5 class="fw-semibold mb-0">
                                        Cronograma de pagos
                                    </h5>

                                </div>

                                <div class="table-responsive">

                                    <table class="table table-hover-custom align-middle mb-0">

                                        <thead class="table-light">

                                            <tr>

                                                <th style="width:10%">
                                                    Cuota
                                                </th>

                                                <th style="width:35%">
                                                    Fecha de vencimiento
                                                </th>

                                                <th class="text-end">
                                                    Monto
                                                </th>

                                            </tr>

                                        </thead>

                                        <tbody id="tablaCuotas">

                                        </tbody>

                                    </table>

                                </div>

                            </div>

                        </div>
                    @endrol

                </div>

                @php
                    $subtotal = $consulta ? $consulta->detalles->sum('subtotal') : 0;
                @endphp

                {{-- DERECHA --}}
                <div class="col-lg-4">

                    @rol('Administrador')
                        {{-- Descuentos --}}
                        <div class="card border-0 shadow-sm rounded-4 mb-4">

                            <div class="card-body p-4">

                                <h5 class="fw-semibold mb-4">
                                    Descuento
                                </h5>

                                <div class="mb-3">

                                    <label class="form-label text-muted small">
                                        Tipo de descuento
                                    </label>

                                    <select class="form-select rounded-3" id="tipoDescuento" name="tipoDescuento">

                                        <option value="">Sin descuento</option>
                                        <option value="Monto">Monto fijo</option>
                                        <option value="Porcentaje">Porcentaje</option>

                                    </select>

                                </div>

                                <div>

                                    <label class="form-label text-muted small">
                                        Valor del descuento
                                    </label>

                                    <input type="number" class="form-control rounded-3" id="valorDescuento"
                                        name="valorDescuento" value="0" min="0" disabled>

                                </div>

                            </div>

                        </div>

                        <div class="card border-0 shadow-sm rounded-4 mb-4">

                            <div class="card-body p-4">

                                <h5 class="fw-semibold mb-4">
                                    Cuotas
                                </h5>

                                <div class="mb-4">

                                    <label class="form-label text-muted small">
                                        Cantidad de cuotas
                                    </label>

                                    <input type="number" class="form-control rounded-3" id="cantidadCuotas"
                                        name="cantidadCuotas" value="1" min="1">

                                </div>

                            </div>

                        </div>
                    @endrol

                    <div class="card border-0 shadow-sm rounded-4">

                        <div class="card-body p-4">

                            <h5 class="fw-semibold mb-4">
                                Resumen de la factura
                            </h5>

                            <div class="d-flex justify-content-between mb-3">

                                <span class="text-muted">
                                    Subtotal
                                </span>

                                <span id="subtotalFactura" class="fw-medium">

                                    RD$ {{ number_format($subtotal, 2) }}

                                </span>

                            </div>

                            <div class="d-flex justify-content-between mb-3">

                                <span class="text-muted">
                                    Descuento
                                </span>

                                <span id="descuentoFactura" class="fw-medium text-danger">

                                    RD$ 0.00

                                </span>

                            </div>

                            <hr>

                            <div class="d-flex justify-content-between align-items-center mb-2">

                                <span class="fw-semibold">
                                    Total
                                </span>

                                <span id="totalFactura" class="fw-bold fs-3">

                                    RD$ {{ number_format($subtotal, 2) }}

                                </span>

                            </div>

                            @rol('Administrador')
                                <div class="d-flex justify-content-between align-items-center mb-4">

                                    <span class="text-muted">
                                        Monto por cuota
                                    </span>

                                    <span id="montoCuota" class="fw-semibold">

                                        RD$ {{ number_format($subtotal, 2) }}

                                    </span>

                                </div>
                            @endrol

                            <button type="submit" class="btn btn-medical-primary w-100 rounded-pill py-3"
                                {{ !$consulta ? 'disabled' : '' }}>

                                <i class="bi bi-receipt me-2"></i>

                                Generar factura

                            </button>

                        </div>

                    </div>


                </div>


            </div>



        </form>

        @include('facturacion.partials.modal-seleccionar-consulta')

        <script>
            document.addEventListener('DOMContentLoaded', function() {

                const modalElement = document.getElementById('modalConsultas');

                if (!modalElement) return;

                const params = new URLSearchParams(window.location.search);

                const abrir =
                    {{ $consulta ? 'false' : 'true' }} ||
                    params.get('modal') === '1';

                if (abrir) {

                    const modal = new bootstrap.Modal(modalElement, {
                        backdrop: 'static',
                        keyboard: false
                    });

                    modal.show();

                }

            });
        </script>

        @rol('Administrador')
            <script>
                document.addEventListener('DOMContentLoaded', () => {

                    const subtotal = {{ $subtotal }};

                    const tipo = document.getElementById('tipoDescuento');
                    const valor = document.getElementById('valorDescuento');
                    const cuotas = document.getElementById('cantidadCuotas');

                    const descuentoLbl = document.getElementById('descuentoFactura');
                    const totalLbl = document.getElementById('totalFactura');
                    const cuotaLbl = document.getElementById('montoCuota');

                    const tablaCuotas = document.getElementById('tablaCuotas');
                    const cardCronograma = document.getElementById('cardCronograma');
                    const partes = '{{ $consulta?->fecha }}'.split('-');
                    const fechaFactura = new Date(
                        parseInt(partes[0]),
                        parseInt(partes[1]) - 1,
                        parseInt(partes[2])
                    );

                    function recalcular() {

                        if (tipo.value === '') {
                            valor.disabled = true;
                            valor.value = 0;
                        } else {
                            valor.disabled = false;
                        }

                        let descuento = 0;

                        if (tipo.value === 'Monto') {

                            descuento = parseFloat(valor.value) || 0;

                        } else if (tipo.value === 'Porcentaje') {

                            descuento = subtotal * ((parseFloat(valor.value) || 0) / 100);

                        }

                        descuento = Math.min(descuento, subtotal);

                        const total = subtotal - descuento;

                        const nCuotas = Math.max(parseInt(cuotas.value) || 1, 1);
                        if (nCuotas === 1) {

                            cardCronograma.style.display = 'none';

                        } else {

                            cardCronograma.style.display = '';

                        }

                        const montoCuota = total / nCuotas;

                        tablaCuotas.innerHTML = '';

                        for (let i = 0; i < nCuotas; i++) {

                            const fecha = new Date(fechaFactura);

                            fecha.setMonth(fecha.getMonth() + i);

                            const yyyy = fecha.getFullYear();
                            const mm = String(fecha.getMonth() + 1).padStart(2, '0');
                            const dd = String(fecha.getDate()).padStart(2, '0');

                            tablaCuotas.innerHTML += `
                            <tr>

                                <td>
                                    ${i + 1}
                                </td>

                                <td>
                                    <input
                                        type="date"
                                        name="fechasVencimiento[]"
                                        class="form-control form-control-sm rounded-3 fecha-cuota"
                                        data-indice="${i}"
                                        value="${yyyy}-${mm}-${dd}">
                                </td>

                                <td class="text-end fw-semibold">
                                    RD$ ${montoCuota.toLocaleString('en-US', {
                                        minimumFractionDigits: 2,
                                        maximumFractionDigits: 2
                                    })}
                                </td>

                            </tr>
                        `;
                        }

                        document.querySelectorAll('.fecha-cuota').forEach(input => {

                            input.addEventListener('change', function() {

                                const indice = parseInt(this.dataset.indice);

                                const partes = this.value.split('-');

                                const fechaBase = new Date(
                                    parseInt(partes[0]),
                                    parseInt(partes[1]) - 1,
                                    parseInt(partes[2])
                                );

                                document.querySelectorAll('.fecha-cuota').forEach((fechaInput, i) => {

                                    const nuevaFecha = new Date(fechaBase);

                                    nuevaFecha.setMonth(fechaBase.getMonth() + (i - indice));

                                    const yyyy = nuevaFecha.getFullYear();
                                    const mm = String(nuevaFecha.getMonth() + 1).padStart(2, '0');
                                    const dd = String(nuevaFecha.getDate()).padStart(2, '0');

                                    fechaInput.value = `${yyyy}-${mm}-${dd}`;

                                });

                            });

                        });

                        descuentoLbl.textContent =
                            'RD$ ' + descuento.toLocaleString('en-US', {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            });

                        totalLbl.textContent =
                            'RD$ ' + total.toLocaleString('en-US', {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            });

                        cuotaLbl.textContent =
                            'RD$ ' + montoCuota.toLocaleString('en-US', {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            });

                    }

                    tipo.addEventListener('change', recalcular);
                    valor.addEventListener('input', recalcular);
                    cuotas.addEventListener('input', recalcular);

                    recalcular();

                });
            </script>
        @endrol

    @endsection
