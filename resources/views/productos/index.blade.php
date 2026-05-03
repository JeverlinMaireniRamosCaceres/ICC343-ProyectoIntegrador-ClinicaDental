@extends('layouts.app')

@section('title', 'Productos')

@section('content')
<div class="container py-4">

    <div class="d-flex align-items-center justify-content-between mb-4">

        <h2 class="fw-semibold mb-0">Productos</h2>

        <div class="d-flex align-items-center gap-2">

            <!-- BUSCADOR (visual) -->

            <form>

                <div class="d-flex align-items-center gap-2 px-3 py-2 bg-light rounded-pill border border-transparent"
                     style="width: 280px; transition: border-color 0.2s;"
                     onfocusin="this.style.background='#fff'; this.style.borderColor='#2563EB';"
                     onfocusout="this.style.background=''; this.style.borderColor='transparent';">

                    <i class="bi bi-search text-secondary" style="font-size: 14px;"></i>

                    <input type="text"
                           class="border-0 bg-transparent p-0 w-100"
                           style="outline: none; font-size: 14px;"
                           placeholder="Buscar producto...">

                </div>

            </form>

            <!-- BOTON NUEVO -->

            <a href="{{ route('productos.create') }}"
               class="btn btn-primary d-flex align-items-center gap-2 rounded-pill px-4">

                <i class="bi bi-plus-lg"></i>
                Nuevo

            </a>

        </div>

    </div>

    <div class="card border-0 shadow-sm rounded-3">

        <div class="table-responsive">

            <table class="table table-hover align-middle mb-0">

                <thead class="table-light">

                    <tr>

                        <th class="px-4 py-3 text-muted fw-semibold small">ID</th>
                        <th class="px-4 py-3 text-muted fw-semibold small">Nombre</th>
                        <th class="px-4 py-3 text-muted fw-semibold small">Descripción</th>
                        <th class="px-4 py-3 text-muted fw-semibold small">Stock</th>
                        <th class="px-4 py-3 text-muted fw-semibold small">Stock Mínimo</th>
                        <th class="px-4 py-3 text-muted fw-semibold small">Unidad</th>
                        <th class="px-4 py-3 text-muted fw-semibold small">Acciones</th>

                    </tr>

                </thead>

                <tbody>

                    <!-- FILA 1 -->

                    <tr>

                        <td class="px-4 text-muted">1</td>

                        <td class="px-4 fw-medium">
                            Guantes Latex
                        </td>

                        <td class="px-4 text-muted">
                            Caja de guantes desechables
                        </td>

                        <td class="px-4 fw-semibold">
                            150
                        </td>

                        <td class="px-4 text-muted">
                            50
                        </td>

                        <td class="px-4 text-muted">
                            Cajas
                        </td>

                        <td class="px-4">

                            <div class="d-flex gap-2">

                                <a href="{{ route('productos.edit', 1) }}"
                                   class="btn btn-sm btn-warning rounded-pill px-3"
                                   style="color:white;"
                                   title="Editar">

                                    <i class="bi bi-pencil-fill"></i>

                                </a>

                                <button type="button"
                                        class="btn btn-sm btn-danger rounded-pill px-3"
                                        title="Eliminar">

                                    <i class="bi bi-trash3-fill"></i>

                                </button>

                            </div>

                        </td>

                    </tr>

                    <!-- FILA 2 (stock bajo) -->

                    <tr>

                        <td class="px-4 text-muted">2</td>

                        <td class="px-4 fw-medium">
                            Mascarillas
                        </td>

                        <td class="px-4 text-muted">
                            Mascarillas quirúrgicas
                        </td>

                        <td class="px-4 fw-semibold text-danger">
                            20
                        </td>

                        <td class="px-4 text-muted">
                            50
                        </td>

                        <td class="px-4 text-muted">
                            Cajas
                        </td>

                        <td class="px-4">

                            <div class="d-flex gap-2">

                                <a href="{{ route('productos.edit', 2) }}"
                                   class="btn btn-sm btn-warning rounded-pill px-3"
                                   style="color:white;">

                                    <i class="bi bi-pencil-fill"></i>

                                </a>

                                <button type="button"
                                        class="btn btn-sm btn-danger rounded-pill px-3">

                                    <i class="bi bi-trash3-fill"></i>

                                </button>

                            </div>

                        </td>

                    </tr>

                    <!-- FILA 3 -->

                    <tr>

                        <td class="px-4 text-muted">3</td>

                        <td class="px-4 fw-medium">
                            Anestesia
                        </td>

                        <td class="px-4 text-muted">
                            Anestesia local dental
                        </td>

                        <td class="px-4 fw-semibold">
                            75
                        </td>

                        <td class="px-4 text-muted">
                            20
                        </td>

                        <td class="px-4 text-muted">
                            Unidades
                        </td>

                        <td class="px-4">

                            <div class="d-flex gap-2">

                                <a href="{{ route('productos.edit', 3) }}"
                                   class="btn btn-sm btn-warning rounded-pill px-3"
                                   style="color:white;">

                                    <i class="bi bi-pencil-fill"></i>

                                </a>

                                <button type="button"
                                        class="btn btn-sm btn-danger rounded-pill px-3">

                                    <i class="bi bi-trash3-fill"></i>

                                </button>

                            </div>

                        </td>

                    </tr>

                </tbody>

            </table>

        </div>

        <!-- FOOTER VISUAL -->

        <div class="d-flex align-items-center justify-content-between px-4 py-3 border-top">

            <small class="text-muted">
                Mostrando 1–3 de 3 resultados
            </small>

            <nav>
                <ul class="pagination pagination-sm mb-0">

                    <li class="page-item disabled">
                        <span class="page-link">‹</span>
                    </li>

                    <li class="page-item active">
                        <span class="page-link">1</span>
                    </li>

                    <li class="page-item disabled">
                        <span class="page-link">›</span>
                    </li>

                </ul>
            </nav>

        </div>

    </div>

</div>
@endsection
