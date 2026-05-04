@extends('layouts.app')

@section('title', 'Caja Chica')

@section('content')
    <div class="container py-4">

        <div class="d-flex align-items-center justify-content-between mb-4">
            <h2 class="fw-semibold mb-0">Caja Chica</h2>

            <div class="d-flex align-items-center gap-2">

                <form>
                    <div class="d-flex align-items-center gap-2 px-3 py-2 bg-light rounded-pill border border-transparent"
                        style="width:280px;transition:border-color .2s;"
                        onfocusin="this.style.background='#fff';this.style.borderColor='#2563EB';"
                        onfocusout="this.style.background='';this.style.borderColor='transparent';">
                        <i class="bi bi-search text-secondary" style="font-size:14px;"></i>
                        <input type="text" class="border-0 bg-transparent p-0 w-100" style="outline:none;font-size:14px;"
                            placeholder="Buscar caja...">
                    </div>
                </form>

                <a href="{{ route('caja-chica.create') }}"
                    class="btn btn-primary d-flex align-items-center gap-2 rounded-pill px-4">
                    <i class="bi bi-cash-coin"></i> Abrir caja
                </a>

            </div>
        </div>

        <div class="card border-0 shadow-sm rounded-3">
            <div class="table-responsive">

                <table class="table table-hover align-middle mb-0">

                    <thead class="table-light">
                        <tr>
                            <th class="px-4 py-3 text-muted fw-semibold small">ID</th>
                            <th class="px-4 py-3 text-muted fw-semibold small">Fecha</th>
                            <th class="px-4 py-3 text-muted fw-semibold small">Hora Apertura</th>
                            <th class="px-4 py-3 text-muted fw-semibold small">Monto Inicial</th>
                            <th class="px-4 py-3 text-muted fw-semibold small">Saldo</th>
                            <th class="px-4 py-3 text-muted fw-semibold small">Estado</th>
                            <th class="px-4 py-3 text-muted fw-semibold small">Acciones</th>
                        </tr>
                    </thead>

                    <tbody>

                        <tr>
                            <td class="px-4 text-muted">1</td>
                            <td class="px-4">03/05/2026</td>
                            <td class="px-4">08:00 AM</td>
                            <td class="px-4 fw-semibold">RD$ 5,000</td>
                            <td class="px-4 fw-bold text-primary">RD$ 3,200</td>
                            <td class="px-4"><span class="badge bg-success">Abierta</span></td>
                            <td class="px-4">
                                <div class="d-flex gap-2">
                                    <a href="{{ route('caja-chica.show', 1) }}"
                                        class="btn btn-sm btn-secondary rounded-pill px-3"><i
                                            class="bi bi-eye-fill"></i></a>
                                    <button class="btn btn-sm btn-danger rounded-pill px-3" data-bs-toggle="modal"
                                        data-bs-target="#modalCerrarCaja"><i class="bi bi-lock-fill"></i></button>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td class="px-4 text-muted">2</td>
                            <td class="px-4">02/05/2026</td>
                            <td class="px-4">08:00 AM</td>
                            <td class="px-4 fw-semibold">RD$ 4,000</td>
                            <td class="px-4">RD$ 0</td>
                            <td class="px-4"><span class="badge bg-secondary">Cerrada</span></td>
                            <td class="px-4">
                                <div class="d-flex gap-2">
                                    <a href="{{ route('caja-chica.show', 2) }}"
                                        class="btn btn-sm btn-secondary rounded-pill px-3"><i
                                            class="bi bi-eye-fill"></i></a>
                                </div>
                            </td>
                        </tr>

                    </tbody>
                </table>

            </div>

            <div class="d-flex align-items-center justify-content-between px-4 py-3 border-top">
                <small class="text-muted">Mostrando 1–2 de 2 resultados</small>
                <nav>
                    <ul class="pagination pagination-sm mb-0">
                        <li class="page-item disabled"><span class="page-link">‹</span></li>
                        <li class="page-item active"><span class="page-link">1</span></li>
                        <li class="page-item disabled"><span class="page-link">›</span></li>
                    </ul>
                </nav>
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
