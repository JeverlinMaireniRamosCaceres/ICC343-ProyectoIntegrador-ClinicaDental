@extends('layouts.app')

@section('title', 'Detalle Compra')

@section('content')
    <div class="container py-4">

        <div class="d-flex align-items-center gap-3 mb-4">
            <a href="{{ route('compras.index') }}" class="btn btn-sm btn-light rounded-pill px-3">
                <i class="bi bi-arrow-left"></i>
            </a>
            <h2 class="fw-semibold mb-0">Detalle de Compra</h2>
        </div>

        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-body p-4">

                <!-- DATOS GENERALES -->

                <div class="row mb-4">

                    <div class="col-md-3">
                        <label class="text-muted small fw-semibold">ID Compra</label>
                        <div class="fw-medium">1</div>
                    </div>

                    <div class="col-md-3">
                        <label class="text-muted small fw-semibold">Proveedor</label>
                        <div class="fw-medium">Dental Depot</div>
                    </div>

                    <div class="col-md-3">
                        <label class="text-muted small fw-semibold">Fecha</label>
                        <div class="fw-medium">01/05/2026</div>
                    </div>

                    <div class="col-md-3">
                        <label class="text-muted small fw-semibold">Estado</label>
                        <div>
                            <span class="badge bg-success">
                                Pagada
                            </span>
                        </div>
                    </div>

                </div>

                <!-- DETALLE -->

                <div class="mb-4">

                    <label class="form-label text-muted fw-semibold small">
                        Detalle de compra
                    </label>

                    <div class="table-responsive">

                        <table class="table table-bordered align-middle mb-0">

                            <thead class="table-light">
                                <tr>
                                    <th class="small text-muted">Producto</th>
                                    <th class="small text-muted">Cantidad</th>
                                    <th class="small text-muted">Precio Unitario</th>
                                    <th class="small text-muted">Subtotal</th>
                                    <th class="small text-muted">Fecha Vencimiento</th>
                                </tr>
                            </thead>

                            <tbody>

                                <tr>
                                    <td>Guantes Latex</td>
                                    <td>2</td>
                                    <td>RD$ 500.00</td>
                                    <td>RD$ 1,000.00</td>
                                    <td>01/12/2026</td>
                                </tr>

                                <tr>
                                    <td>Mascarillas</td>
                                    <td>3</td>
                                    <td>RD$ 300.00</td>
                                    <td>RD$ 900.00</td>
                                    <td>15/10/2026</td>
                                </tr>

                                <tr>
                                    <td>Anestesia</td>
                                    <td>1</td>
                                    <td>RD$ 1,200.00</td>
                                    <td>RD$ 1,200.00</td>
                                    <td>01/08/2027</td>
                                </tr>

                            </tbody>

                        </table>

                    </div>

                </div>

                <!-- TOTAL -->

                <div class="d-flex justify-content-end">

                    <div style="width: 300px;">

                        <div class="d-flex justify-content-between border-top pt-3">

                            <span class="fw-semibold">
                                Total
                            </span>

                            <span class="fw-bold" style="color: #0ea5e9;">
                                RD$ 3,100.00
                            </span>

                        </div>

                    </div>

                </div>

            </div>
        </div>

    </div>
@endsection
