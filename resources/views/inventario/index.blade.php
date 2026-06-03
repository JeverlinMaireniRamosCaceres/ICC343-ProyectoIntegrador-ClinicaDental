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
                            <button class="nav-link active" id="tab-productos-btn" data-bs-toggle="tab"
                                data-bs-target="#tab-productos" type="button" role="tab">
                                <i class="bi bi-box-seam me-2"></i>Productos
                            </button>
                        </li>

                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="tab-alertas-btn" data-bs-toggle="tab" data-bs-target="#tab-alertas"
                                type="button" role="tab">
                                <i class="bi bi-bell me-2"></i>Alertas
                                <span class="badge bg-warning text-dark rounded-pill ms-1">2</span>
                            </button>
                        </li>

                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="tab-movimientos-btn" data-bs-toggle="tab"
                                data-bs-target="#tab-movimientos" type="button" role="tab">
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

                                <div class="position-relative" style="max-width:350px;">

                                    <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>

                                    <input type="text" name="buscar" id="buscarProducto" value="{{ request('buscar') }}"
                                        class="form-control rounded-pill ps-5 search-input"
                                        placeholder="Buscar producto...">

                                </div>

                                <div class="ms-auto d-flex gap-2">
                                    <button type="button" class="btn btn-sm rounded-pill px-3 btn-filtro active"
                                        data-filtro="">Todos</button>
                                    <button type="button" class="btn btn-sm rounded-pill px-3 btn-filtro"
                                        data-filtro="normal">Normal</button>
                                    <button type="button" class="btn btn-sm rounded-pill px-3 btn-filtro"
                                        data-filtro="bajo">Stock bajo</button>
                                    <button type="button" class="btn btn-sm rounded-pill px-3 btn-filtro"
                                        data-filtro="agotado">Sin stock</button>
                                </div>

                                <!-- separador -->
                                <div class="vr mx-1"></div>

                                <button type="button" class="btn btn-sm rounded-pill px-3 text-white"
                                    style="background-color: #0ea5e9; border: none;" data-bs-toggle="modal"
                                    data-bs-target="#modalAjuste">
                                    <i class="bi bi-pencil-square me-1"></i> Hacer ajuste
                                </button>

                            </div>
                        </div>

                        <!-- tabla de productos -->
                        <div id="contenedorTablaProductos">

                            @include('inventario.partials.tabla')

                        </div>

                    </div>

                    <!-- alertas -->
                    <div class="tab-pane fade" id="tab-alertas" role="tabpanel">
                        <div class="p-4">

                            <div class="p-4 d-flex flex-column gap-4">

                                <!-- sin stock -->
                                <div>
                                    <p class="text-muted small fw-semibold mb-2 text-uppercase"
                                        style="letter-spacing:.05em; font-size:11px;">
                                        <i class="bi bi-x-circle-fill me-1" style="color:#e03131;"></i> Sin stock
                                    </p>
                                    <div class="d-flex flex-wrap gap-2">
                                        <div class="d-flex align-items-center gap-2 px-3 py-2 rounded-pill"
                                            style="background:#fdecea; color:#e03131; font-size:13px;">
                                            <strong>Ibuprofeno</strong>
                                        </div>
                                        <div class="d-flex align-items-center gap-2 px-3 py-2 rounded-pill"
                                            style="background:#fdecea; color:#e03131; font-size:13px;">
                                            <strong>Amoxicilina</strong>
                                        </div>
                                    </div>
                                </div>

                                <!-- stock bajo -->
                                <div>
                                    <p class="text-muted small fw-semibold mb-2 text-uppercase"
                                        style="letter-spacing:.05em; font-size:11px;">
                                        <i class="bi bi-exclamation-triangle-fill me-1" style="color:#c2510a;"></i> Stock
                                        bajo
                                    </p>
                                    <div class="d-flex flex-wrap gap-2">
                                        <div class="d-flex align-items-center gap-2 px-3 py-2 rounded-pill"
                                            style="background:#fff0e6; color:#c2510a; font-size:13px;">
                                            <strong>Paracetamol</strong> <span class="fw-normal">— 5 unidades</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- por vencer -->
                                <div>
                                    <p class="text-muted small fw-semibold mb-2 text-uppercase"
                                        style="letter-spacing:.05em; font-size:11px;">
                                        <i class="bi bi-clock-fill me-1" style="color:#7c3aed;"></i> Por vencer
                                    </p>
                                    <div class="d-flex flex-wrap gap-2">
                                        <div class="d-flex align-items-center gap-2 px-3 py-2 rounded-pill"
                                            style="background:#f3eeff; color:#7c3aed; font-size:13px;">
                                            <strong>Amoxicilina</strong> <span class="fw-normal">— 30/06/2026</span>
                                        </div>
                                    </div>
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
                                                <i class="bi bi-arrow-up-circle"></i>
                                            </span>
                                        </td>

                                        <td class="px-4">
                                            <div class="d-flex align-items-center gap-2">
                                                <span
                                                    style="width:8px; height:8px; border-radius:50%; background:#e03131; display:inline-block;"></span>
                                                <span>-2</span>
                                            </div>
                                        </td>
                                        <td class="px-4 text-muted small">Procedimiento #312: Consulta</td>
                                    </tr>
                                    <tr>
                                        <td class="px-4 text-muted small">28/05/2026 09:10</td>
                                        <td class="px-4 fw-medium">Paracetamol</td>
                                        <td class="px-4">
                                            <span class="badge bg-success-subtle text-success rounded-pill px-3 py-2">
                                                <i class="bi bi-arrow-down-circle"></i>
                                            </span>
                                        </td>

                                        <td class="px-4">
                                            <div class="d-flex align-items-center gap-2">
                                                <span
                                                    style="width:8px; height:8px; border-radius:50%; background:#2f9e44; display:inline-block;"></span>
                                                <span>+30</span>
                                            </div>
                                        </td>
                                        <td class="px-4 text-muted small">Compra #0041</td>
                                    </tr>
                                    <tr>
                                        <td class="px-4 text-muted small">25/05/2026 14:55</td>
                                        <td class="px-4 fw-medium">Ibuprofeno</td>
                                        <td class="px-4">
                                            <span class="badge bg-danger-subtle text-danger rounded-pill px-3 py-2">
                                                <i class="bi bi-arrow-up-circle"></i>
                                            </span>
                                        </td>

                                        <td class="px-4">
                                            <div class="d-flex align-items-center gap-2">
                                                <span
                                                    style="width:8px; height:8px; border-radius:50%; background:#e03131; display:inline-block;"></span>
                                                <span>-1</span>
                                            </div>
                                        </td>
                                        <td class="px-4 text-muted small">Procedimiento #298: Extracción</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-between align-items-center px-4 py-3 border-top">
                            <small class="text-muted">Mostrando 1–3 de 3 resultados</small>
                            <nav>
                                <ul class="pagination pagination-sm mb-0">
                                    <li class="page-item disabled">
                                        <span class="page-link rounded-pill">&laquo;</span>
                                    </li>
                                    <li class="page-item active">
                                        <span class="page-link rounded-pill">1</span>
                                    </li>
                                    <li class="page-item disabled">
                                        <span class="page-link rounded-pill">&raquo;</span>
                                    </li>
                                </ul>
                            </nav>
                        </div>

                    </div>

                </div>
            </div>
        </div>

    </div>


@endsection

@section('scripts')
    <script src="{{ asset('js/inventario.js') }}"></script>
@endsection