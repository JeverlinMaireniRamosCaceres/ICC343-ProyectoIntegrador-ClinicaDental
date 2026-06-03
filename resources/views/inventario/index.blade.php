@extends('layouts.app')

@section('title', 'Inventario')

@section('content')
<div class="container-fluid py-4 px-5">

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm rounded-4 border-0 mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show shadow-sm rounded-4 border-0 mb-4" role="alert">
            <i class="bi bi-exclamation-circle-fill me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold text-dark mb-0">Inventario</h2>
    </div>

    <!-- cards con info rapida -->
    <div class="row g-3 mb-4">

        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body d-flex align-items-center gap-3 p-4">
                    <div class="inv-metric-icon bg-info bg-opacity-10 text-info">
                        <i class="bi bi-boxes fs-4"></i>
                    </div>
                    <div>
                        <p class="text-muted small mb-0">Total productos</p>
                        <h4 class="fw-bold mb-0">10</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body d-flex align-items-center gap-3 p-4">
                    <div class="inv-metric-icon bg-info bg-opacity-10 text-info">
                        <i class="bi bi-exclamation-triangle fs-4"></i>
                    </div>
                    <div>
                        <p class="text-muted small mb-0">Stock bajo</p>
                        <h4 class="fw-bold mb-0">5</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body d-flex align-items-center gap-3 p-4">
                    <div class="inv-metric-icon bg-info bg-opacity-10 text-info">
                        <i class="bi bi-x-circle fs-4"></i>
                    </div>
                    <div>
                        <p class="text-muted small mb-0">Sin stock</p>
                        <h4 class="fw-bold mb-0">1</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body d-flex align-items-center gap-3 p-4">
                    <div class="inv-metric-icon bg-info bg-opacity-10 text-info">
                        <i class="bi bi-clock-history fs-4"></i>
                    </div>
                    <div>
                        <p class="text-muted small mb-0">Por vencer </p>
                        <h4 class="fw-bold mb-0">3</h4>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- card con las tabs -->
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-0">

            <!-- tabs de navegacion -->
            <div class="px-4 pt-3">
                <ul class="nav consulta-tabs" id="inventarioTabs" role="tablist">

                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="tab-productos-btn"
                            data-bs-toggle="tab" data-bs-target="#tab-productos"
                            type="button" role="tab">
                            <i class="bi bi-box-seam me-2"></i>Productos
                        </button>
                    </li>

                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="tab-alertas-btn"
                            data-bs-toggle="tab" data-bs-target="#tab-alertas"
                            type="button" role="tab">
                            <i class="bi bi-bell me-2"></i>Alertas
                            <span class="badge bg-warning text-dark rounded-pill ms-1">2</span>
                        </button>
                    </li>

                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="tab-movimientos-btn"
                            data-bs-toggle="tab" data-bs-target="#tab-movimientos"
                            type="button" role="tab">
                            <i class="bi bi-eye me-2"></i>Movimientos
                        </button>
                    </li>

                </ul>
            </div>

            <!-- contenido -->
            <div class="tab-content" id="inventarioTabsContent">

                <!-- productos tab -->
                <div class="tab-pane fade show active" id="tab-productos" role="tabpanel">

                    <!-- barra de busqueda -->
                    <div class="p-4 border-bottom">
                        <div class="d-flex gap-3 flex-wrap align-items-center">

                            <div class="position-relative">
                                <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>
                                <input type="text" id="buscarProducto"
                                    class="form-control rounded-pill ps-5 search-input"
                                    placeholder="Buscar producto..."
                                    style="width: 320px;">
                            </div>

                            <div class="ms-auto d-flex gap-2">
                                <button type="button" class="btn btn-sm rounded-pill px-3 btn-filtro active" data-filtro="">Todos</button>
                                <button type="button" class="btn btn-sm rounded-pill px-3 btn-filtro" data-filtro="normal">Normal</button>
                                <button type="button" class="btn btn-sm rounded-pill px-3 btn-filtro" data-filtro="bajo">Stock bajo</button>
                                <button type="button" class="btn btn-sm rounded-pill px-3 btn-filtro" data-filtro="agotado">Sin stock</button>
                            </div>

                        </div>
                    </div>

                    <!-- tabla de productos -->
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0" id="tablaProductos">
                            <thead class="table-light">
                                <tr>
                                    <th class="px-4 py-3 text-muted fw-semibold small">Producto</th>
                                    <th class="px-4 py-3 text-muted fw-semibold small">Descripción</th>
                                    <th class="px-4 py-3 text-muted fw-semibold small">Stock actual</th>
                                    <th class="px-4 py-3 text-muted fw-semibold small">Stock mín.</th>
                                    <th class="px-4 py-3 text-muted fw-semibold small">Unidad</th>
                                    <th class="px-4 py-3 text-muted fw-semibold small">Vencimiento</th>
                                    <th class="px-4 py-3 text-muted fw-semibold small">Estado</th>
                                    <th class="px-4 py-3 text-muted fw-semibold small text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="px-4 fw-medium">Paracetamol</td>
                                    <td class="px-4 text-muted">Tabletas 500mg</td>
                                    <td class="px-4 fw-semibold text-success">50</td>
                                    <td class="px-4 text-muted">10</td>
                                    <td class="px-4 text-muted">Unidades</td>
                                    <td class="px-4 text-muted">15/09/2026</td>
                                    <td class="px-4">
                                        <span class="badge bg-success-subtle text-success rounded-pill px-3 py-2">Normal</span>
                                    </td>
                                    <td class="px-4 text-center">
                                        <button class="btn btn-sm btn-secondary rounded-pill px-3 btnVerMovimientos"
                                            data-nombre="Paracetamol" title="Ver movimientos">
                                            <i class="bi bi-eye-fill"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-4 fw-medium">Ibuprofeno</td>
                                    <td class="px-4 text-muted">Tabletas 400mg</td>
                                    <td class="px-4 fw-semibold text-warning">5</td>
                                    <td class="px-4 text-muted">10</td>
                                    <td class="px-4 text-muted">Unidades</td>
                                    <td class="px-4 text-muted">20/08/2026</td>
                                    <td class="px-4">
                                        <span class="badge bg-warning-subtle text-warning rounded-pill px-3 py-2">Stock bajo</span>
                                    </td>
                                    <td class="px-4 text-center">
                                        <button class="btn btn-sm btn-secondary rounded-pill px-3 btnVerMovimientos"
                                            data-nombre="Ibuprofeno" title="Ver movimientos">
                                            <i class="bi bi-eye-fill"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-4 fw-medium">Amoxicilina</td>
                                    <td class="px-4 text-muted">Cápsulas 500mg</td>
                                    <td class="px-4 fw-semibold text-danger">0</td>
                                    <td class="px-4 text-muted">10</td>
                                    <td class="px-4 text-muted">Unidades</td>
                                    <td class="px-4 fw-semibold text-danger">30/06/2026</td>
                                    <td class="px-4">
                                        <span class="badge bg-danger-subtle text-danger rounded-pill px-3 py-2">Sin stock</span>
                                    </td>
                                    <td class="px-4 text-center">
                                        <button class="btn btn-sm btn-secondary rounded-pill px-3 btnVerMovimientos"
                                            data-nombre="Amoxicilina" title="Ver movimientos">
                                            <i class="bi bi-eye-fill"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- paginacion -->
                    <div class="d-flex justify-content-between align-items-center px-4 py-3 border-top">
                        <small class="text-muted">Mostrando 1–3 de 3 resultados</small>

                    </div>

                </div>

                <!-- alertas -->
                <div class="tab-pane fade" id="tab-alertas" role="tabpanel">
                    <div class="p-4">

                        <div class="d-flex flex-column gap-2">

                            <div class="inv-alerta-item inv-alerta-warning d-flex align-items-center gap-2">
                                <i class="bi bi-exclamation-triangle-fill"></i>
                                <span><strong>Paracetamol</strong> | stock bajo (5 unidades, mín. 10)</span>
                            </div>

                            <div class="inv-alerta-item inv-alerta-danger d-flex align-items-center gap-2">
                                <i class="bi bi-x-circle-fill"></i>
                                <span><strong>Ibuprofeno</strong> | sin stock (0 unidades)</span>
                            </div>

                            <div class="inv-alerta-item inv-alerta-pink d-flex align-items-center gap-2">
                                <i class="bi bi-clock-fill"></i>
                                <span><strong>Amoxicilina</strong> | vence el 30/06/2026</span>
                            </div>

                        </div>

                    </div>
                </div>

                <!-- movimientos -->
                <div class="tab-pane fade" id="tab-movimientos" role="tabpanel">

                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="px-4 py-3 text-muted fw-semibold small">Fecha</th>
                                    <th class="px-4 py-3 text-muted fw-semibold small">Producto</th>
                                    <th class="px-4 py-3 text-muted fw-semibold small">Tipo</th>
                                    <th class="px-4 py-3 text-muted fw-semibold small">Cantidad</th>
                                    <th class="px-4 py-3 text-muted fw-semibold small">Origen</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="px-4 text-muted small">01/06/2026 10:32</td>
                                    <td class="px-4 fw-medium">Amoxicilina</td>
                                    <td class="px-4">
                                        <span class="badge bg-danger-subtle text-danger rounded-pill px-3 py-2">
                                            <i class="bi bi-arrow-up-circle me-1"></i>Salida
                                        </span>
                                    </td>
                                    <td class="px-4 fw-semibold text-danger">-2</td>
                                    <td class="px-4 text-muted small">Procedimiento #312: Consulta</td>
                                </tr>
                                <tr>
                                    <td class="px-4 text-muted small">28/05/2026 09:10</td>
                                    <td class="px-4 fw-medium">Paracetamol</td>
                                    <td class="px-4">
                                        <span class="badge bg-success-subtle text-success rounded-pill px-3 py-2">
                                            <i class="bi bi-arrow-down-circle me-1"></i>Entrada
                                        </span>
                                    </td>
                                    <td class="px-4 fw-semibold text-success">+30</td>
                                    <td class="px-4 text-muted small">Compra #0041</td>
                                </tr>
                                <tr>
                                    <td class="px-4 text-muted small">25/05/2026 14:55</td>
                                    <td class="px-4 fw-medium">Ibuprofeno</td>
                                    <td class="px-4">
                                        <span class="badge bg-danger-subtle text-danger rounded-pill px-3 py-2">
                                            <i class="bi bi-arrow-up-circle me-1"></i>Salida
                                        </span>
                                    </td>
                                    <td class="px-4 fw-semibold text-danger">-1</td>
                                    <td class="px-4 text-muted small">Procedimiento #298: Extracción</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="d-flex justify-content-between align-items-center px-4 py-3 border-top">
                        <small class="text-muted">Mostrando 1–3 de 3 resultados</small>
                    </div>

                </div>

            </div>
        </div>
    </div>

</div>
@endsection
