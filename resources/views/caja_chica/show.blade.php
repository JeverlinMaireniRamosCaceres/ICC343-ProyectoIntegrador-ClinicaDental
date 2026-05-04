@extends('layouts.app')

@section('title', 'Detalle Caja')

@section('content')
    <div class="container py-4">
        <div class="d-flex align-items-center gap-3 mb-4">
            <a href="{{ route('caja-chica.index') }}" class="btn btn-sm btn-light rounded-pill px-3"><i
                    class="bi bi-arrow-left"></i></a>
            <h2 class="fw-semibold mb-0">Detalle de Caja</h2>
        </div>

        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-body p-4">

                <div class="row mb-4">
                    <div class="col-md-3"><label class="text-muted small fw-semibold">ID Caja</label>
                        <div class="fw-medium">1</div>
                    </div>
                    <div class="col-md-3"><label class="text-muted small fw-semibold">Fecha</label>
                        <div class="fw-medium">03/05/2026</div>
                    </div>
                    <div class="col-md-3"><label class="text-muted small fw-semibold">Hora Apertura</label>
                        <div class="fw-medium">08:00 AM</div>
                    </div>
                    <div class="col-md-3"><label class="text-muted small fw-semibold">Estado</label>
                        <div><span class="badge bg-success">Abierta</span></div>
                    </div>
                </div>

                <div class="d-flex gap-2 mb-4">
                    <button class="btn btn-danger rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#modalEgreso"><i
                            class="bi bi-arrow-down-circle"></i> Nuevo Egreso</button>
                    <button class="btn btn-secondary rounded-pill px-4" data-bs-toggle="modal"
                        data-bs-target="#modalCerrarCaja"><i class="bi bi-lock-fill"></i> Cerrar caja</button>
                </div>

                <div class="mb-4">
                    <label class="form-label text-muted fw-semibold small">Movimientos</label>
                    <div class="table-responsive">
                        <table class="table table-bordered align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="small text-muted">Hora</th>
                                    <th class="small text-muted">Tipo</th>
                                    <th class="small text-muted">Monto</th>
                                    <th class="small text-muted">Descripción</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>09:00 AM</td>
                                    <td><span class="badge bg-success">Ingreso</span></td>
                                    <td class="text-success fw-semibold">+ RD$ 1,000</td>
                                    <td>Pago en efectivo</td>
                                </tr>
                                <tr>
                                    <td>10:30 AM</td>
                                    <td><span class="badge bg-danger">Egreso</span></td>
                                    <td class="text-danger fw-semibold">- RD$ 500</td>
                                    <td>Compra de materiales</td>
                                </tr>
                                <tr>
                                    <td>12:00 PM</td>
                                    <td><span class="badge bg-success">Ingreso</span></td>
                                    <td class="text-success fw-semibold">+ RD$ 700</td>
                                    <td>Consulta pagada</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="d-flex justify-content-end">
                    <div style="width:300px;">
                        <div class="d-flex justify-content-between border-top pt-3">
                            <span class="fw-semibold">Saldo actual</span>
                            <span class="fw-bold" style="color: #0ea5e9">RD$ 3,200.00</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="modal fade" id="modalEgreso" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-3 border-0 shadow">
                <div class="modal-header border-0">
                    <h5 class="modal-title fw-semibold">Nuevo Egreso</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label class="form-label small text-muted fw-semibold">Monto</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 text-muted">RD$</span>
                                <input type="number" class="form-control border-start-0" placeholder="0.00" step="0.01"
                                    min="0">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small text-muted fw-semibold">Descripción</label>
                            <input type="text" class="form-control" placeholder="Ej: Compra materiales">
                        </div>
                    </form>
                </div>
                <div class="modal-footer border-0">
                    <button class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancelar</button>
                    <button class="btn btn-danger rounded-pill px-4"><i class="bi bi-check-lg"></i> Guardar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalCerrarCaja" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow rounded-3">
                <div class="modal-header border-0 pb-0">
                    <div class="d-flex align-items-center gap-2">
                        <div class="rounded-circle bg-secondary bg-opacity-10 d-flex align-items-center justify-content-center"
                            style="width:40px;height:40px;">
                            <i class="bi bi-lock-fill text-secondary" style="font-size:16px;"></i>
                        </div>
                        <h5 class="modal-title fw-semibold mb-0">Cerrar caja</h5>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body pt-3">

                    <div class="mb-3">
                        <label class="form-label small text-muted fw-semibold">Monto contado</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted">RD$</span>
                            <input type="number" class="form-control border-start-0" placeholder="0.00" step="0.01"
                                min="0">
                        </div>
                    </div>

                    <div class="bg-light rounded-3 p-3">
                        <div class="d-flex justify-content-between">
                            <span class="small text-muted">Saldo sistema</span>
                            <span class="fw-semibold">RD$ 3,200.00</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="small text-muted">Diferencia</span>
                            <span class="fw-bold text-danger">RD$ 0.00</span>
                        </div>
                    </div>

                </div>

                <div class="modal-footer border-0 pt-0">
                    <button class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Cancelar</button>
                    <button class="btn btn-secondary rounded-pill px-4"><i class="bi bi-lock-fill me-1"></i> Confirmar
                        cierre</button>
                </div>

            </div>
        </div>
    </div>

@endsection
