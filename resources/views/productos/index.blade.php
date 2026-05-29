@extends('layouts.app')

@section('title', 'Productos')

@section('content')
<div class="container py-4">

    <div class="d-flex align-items-center justify-content-between mb-4">
        <h2 class="fw-semibold mb-0">Productos</h2>

        <a href="{{ route('productos.create') }}"
           class="btn d-flex align-items-center gap-2 rounded-pill px-4 text-white"
           style="background-color: #0ea5e9;">
            <i class="bi bi-plus-lg"></i>
            Nuevo
        </a>
    </div>

    <div class="card border-0 shadow-sm rounded-3">
        
        <div class="card-header bg-transparent border-0 pt-4 px-4 pb-2">
            <form action="{{ route('productos.index') }}" method="GET">
                <div class="d-flex align-items-center gap-2 px-3 py-2 bg-light rounded-pill border border-transparent"
                     style="width: 300px; transition: border-color 0.2s;"
                     onfocusin="this.style.background='#fff'; this.style.borderColor='#0ea5e9';"
                     onfocusout="this.style.background=''; this.style.borderColor='transparent';">
                    
                    <i class="bi bi-search text-secondary" style="font-size: 14px;"></i>
                    <input type="text"
                           name="buscar"
                           value="{{ $buscar ?? '' }}"
                           class="border-0 bg-transparent p-0 w-100"
                           style="outline: none; font-size: 14px;"
                           placeholder="Buscar producto...">
                </div>
            </form>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="px-4 py-3 text-muted fw-semibold small">ID</th>
                        <th class="px-4 py-3 text-muted fw-semibold small">Nombre</th>
                        <th class="px-4 py-3 text-muted fw-semibold small">Descripción</th>
                        <th class="px-4 py-3 text-muted fw-semibold small">Stock Mínimo</th>
                        <th class="px-4 py-3 text-muted fw-semibold small">Unidad</th>
                        <th class="px-4 py-3 text-muted fw-semibold small text-end">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($productos as $producto)
                        <tr>
                            <td class="px-4 text-muted">{{ $producto->idProducto }}</td>
                            <td class="px-4 fw-medium">{{ $producto->nombre }}</td>
                            <td class="px-4 text-muted">{{ $producto->descripcion ?? 'Sin descripción' }}</td>
                            <td class="px-4 text-muted">{{ $producto->stockMinimo }}</td>
                            <td class="px-4 text-muted">{{ $producto->unidadMedida }}</td>
                            <td class="px-4">
                                <div class="d-flex gap-2 justify-content-end">
                                    
                                    <a href="{{ route('productos.edit', $producto->idProducto) }}"
                                       class="btn btn-sm btn-warning rounded-pill px-3 d-flex align-items-center gap-1 text-white"
                                       title="Editar">
                                        <i class="bi bi-pencil-fill small"></i>
                                        Editar
                                    </a>

                                    <form action="{{ route('productos.destroy', $producto->idProducto) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="btn btn-sm btn-danger rounded-pill px-3 d-flex align-items-center gap-1"
                                                onclick="return confirm('¿Estás seguro de que deseas eliminar este producto?')">
                                            <i class="bi bi-trash3-fill small"></i>
                                            Eliminar
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">
                                <i class="bi bi-box-seam d-block mb-2" style="font-size: 24px;"></i>
                                No se encontraron productos registrados.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex align-items-center justify-content-between px-4 py-3 border-top">
            <small class="text-muted">
                Mostrando {{ $productos->firstItem() ?? 0 }}–{{ $productos->lastItem() ?? 0 }} de {{ $productos->total() }} resultados
            </small>

            <nav>
                {{ $productos->links('pagination::bootstrap-5') }}
            </nav>
        </div>

    </div>
</div>
@endsection