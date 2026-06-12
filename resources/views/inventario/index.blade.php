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
            <a href="{{ route('inventario.reporte') }}" target="_blank" class="btn btn-sm rounded-pill px-4"
                style="background:#f1f5f9; color:#64748b; border:1px solid #e2e8f0;">
                <i class="bi bi-file-earmark-pdf me-1"></i> Exportar PDF
            </a>
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
                            <h4 class="fw-bold mb-0">{{ $totalProductos }}</h4>
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
                            <h4 class="fw-bold mb-0">{{ $stockBajo }}</h4>
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
                            <h4 class="fw-bold mb-0">{{ $sinStock }}</h4>
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
                            <h4 class="fw-bold mb-0">{{ $porVencer }}</h4>
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
                                @if ($totalAlertas > 0)
                                    <span class="badge bg-warning text-dark rounded-pill ms-1">
                                        {{ $totalAlertas }}
                                    </span>
                                @endif
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

                                    <i
                                        class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>

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

                    <!-- contenido de tab de alertas -->
                    <div class="tab-pane fade" id="tab-alertas" role="tabpanel">
                        <div class="p-4 d-flex flex-column gap-4">

                            <!-- sin stock -->
                            @if ($alertasSinStock->count() > 0)
                                <div>
                                    <p class="text-muted fw-semibold mb-2 text-uppercase"
                                        style="letter-spacing:.05em; font-size:11px;">
                                        <i class="bi bi-x-circle-fill me-1" style="color:#e03131;"></i> Sin stock
                                    </p>
                                    <div class="d-flex flex-wrap gap-2">
                                        @foreach ($alertasSinStock as $p)
                                            <div class="d-flex align-items-center gap-2 px-3 py-2 rounded-pill"
                                                style="background:#fdecea; color:#e03131; font-size:13px;">
                                                <strong>{{ $p->nombre }}</strong>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <!-- stock bajo -->
                            @if ($alertasStockBajo->count() > 0)
                                <div>
                                    <p class="text-muted fw-semibold mb-2 text-uppercase"
                                        style="letter-spacing:.05em; font-size:11px;">
                                        <i class="bi bi-exclamation-triangle-fill me-1" style="color:#c2510a;"></i> Stock bajo
                                    </p>
                                    <div class="d-flex flex-wrap gap-2">
                                        @foreach ($alertasStockBajo as $p)
                                            <div class="d-flex align-items-center gap-2 px-3 py-2 rounded-pill"
                                                style="background:#fff0e6; color:#c2510a; font-size:13px;">
                                                <strong>{{ $p->nombre }}</strong>
                                                <span class="fw-normal">— {{ $p->stockActual }} {{ $p->unidadMedida }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <!-- por vencer -->
                            @if ($alertasVencimiento->count() > 0)
                                <div>
                                    <p class="text-muted fw-semibold mb-2 text-uppercase"
                                        style="letter-spacing:.05em; font-size:11px;">
                                        <i class="bi bi-clock-fill me-1" style="color:#7c3aed;"></i> Por vencer
                                    </p>
                                    <div class="d-flex flex-wrap gap-2">
                                        @foreach ($alertasVencimiento as $d)
                                            <div class="d-flex align-items-center gap-2 px-3 py-2 rounded-pill"
                                                style="background:#f3eeff; color:#7c3aed; font-size:13px;">
                                                <strong>{{ $d->producto->nombre }}</strong>
                                                <span class="fw-normal">
                                                    — {{ \Carbon\Carbon::parse($d->fechaVencimiento)->format('d/m/Y') }}
                                                </span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <!-- sin alertas -->
                            @if ($totalAlertas === 0)
                                <div class="text-center py-5 text-muted">
                                    <i class="bi bi-check-circle fs-1 d-block mb-2 text-success"></i>
                                    Todo el inventario está en orden.
                                </div>
                            @endif

                        </div>
                    </div>

                    <!-- movimientos -->
                    <div class="tab-pane fade" id="tab-movimientos" role="tabpanel">

                        <div id="contenedorTablaMovimientos">
                            @include('inventario.partials.tabla-movimientos')
                        </div>

                    </div>

                </div>
            </div>
        </div>

    </div>


    <!-- modal ajuste de inventario -->
    <div class="modal fade" id="modalAjuste" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow rounded-4">

                <div class="modal-header border-0 pb-0">
                    <div class="d-flex align-items-center gap-2">
                        <div class="rounded-circle bg-info bg-opacity-10 d-flex align-items-center justify-content-center"
                            style="width:40px; height:40px;">
                            <i class="bi bi-pencil-square text-info" style="font-size:16px;"></i>
                        </div>
                        <div>
                            <h5 class="modal-title fw-semibold mb-0">Realizar ajuste</h5>
                        </div>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body px-3 py-2">
                    <form id="formAjuste" action="{{ route('inventario.ajuste') }}" method="POST">
                        @csrf

                        <!-- producto -->
                        <div class="mb-3">
                            <label class="form-label small fw-semibold text-muted">Producto</label>
                            <div class="position-relative">

                                <input type="text" id="producto_nombre" class="form-control rounded-pill pe-5"
                                    placeholder="Buscar producto...">

                                <i
                                    class="bi bi-search position-absolute top-50 end-0 translate-middle-y me-3 text-muted"></i>

                            </div>

                            <div id="resultadosProductos" class="list-group mt-1 shadow-sm"></div>

                            <input type="hidden" name="idProducto" id="producto_id">
                        </div>

                        <!-- stock actual -->
                        <div class="mb-2">
                            <label class="form-label small fw-semibold text-muted">Stock actual</label>
                            <input type="text" id="stockActualAjuste" class="form-control rounded-pill bg-light"
                                placeholder="—" readonly>
                        </div>

                        <!-- nuevo stock -->
                        <div class="mb-2">
                            <label class="form-label small fw-semibold text-muted">Nuevo stock</label>
                            <div class="input-group">
                                <input type="number" name="nuevoStock" id="nuevoStockAjuste"
                                    class="form-control rounded-pill" min="0" placeholder="0" required>
                                <span class="input-group-text bg-light border-0 text-muted small ms-2 rounded-pill"
                                    id="unidadAjuste"></span>
                            </div>
                        </div>

                        <!-- motivo -->
                        <div class="mb-2">
                            <label class="form-label small fw-semibold text-muted">Motivo del ajuste</label>
                            <select name="motivo" class="form-select rounded-pill" required>
                                <option value="">Seleccionar motivo...</option>
                                <option value="Producto vencido">Producto vencido</option>
                                <option value="Producto dañado">Producto dañado</option>
                                <option value="Conteo físico">Corrección por conteo físico</option>
                                <option value="Error de registro">Error de registro</option>
                                <option value="Otro">Otro</option>
                            </select>
                        </div>

                        <!-- observacion opcional -->
                        <div class="mb-2">
                            <label class="form-label small fw-semibold text-muted">
                                Observación <span class="fw-normal">(opcional)</span>
                            </label>
                            <textarea name="observacion" class="form-control" style="border-radius:12px;" rows="1"
                                placeholder="Detalles adicionales..."></textarea>
                        </div>

                    </form>
                </div>

                <div class="modal-footer border-0 pt-0 px-4">
                    <button type="button" class="btn btn-sm rounded-pill px-4"
                        style="border:1px solid #dee2e6; color:#6c757d;" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" form="formAjuste" class="btn btn-sm rounded-pill px-4 text-white"
                        style="background-color:#0ea5e9; border:none;">
                        <i class="bi bi-check-lg me-1"></i> Guardar ajuste
                    </button>
                </div>

            </div>
        </div>
    </div>

@endsection

@section('scripts')
    <script src="{{ asset('js/inventario.js') }}"></script>
@endsection