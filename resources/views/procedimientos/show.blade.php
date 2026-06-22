@extends('layouts.app')

@section('title', 'Detalle del Procedimiento')

@section('content')
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="d-flex align-items-center gap-3">
            <a href="{{ route('procedimientos.index') }}" class="btn btn-sm btn-light rounded-pill px-3" title="Volver al listado">
                <i class="bi bi-arrow-left"></i>
            </a>
            <h2 class="fw-semibold mb-0">Detalle del procedimiento</h2>
        </div>
        
        <a href="{{ route('procedimientos.edit', $procedimiento->idProcedimiento) }}" 
           class="btn rounded-pill px-4 text-white" style="background-color: #0ea5e9;">
            <i class="bi bi-pencil-fill me-1"></i> Editar procedimiento
        </a>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body p-4">

            <div class="row g-4 mb-4">
                <div class="col-md-8">
                    <span class="text-muted fw-semibold small d-block mb-1">Nombre del procedimiento</span>
                    <div class="fs-5 fw-semibold text-dark bg-light p-3 rounded-3 border-0">
                        {{ $procedimiento->nombre }}
                    </div>
                </div>

                <div class="col-md-4">
                    <span class="text-muted fw-semibold small d-block mb-1">Precio</span>
                    <div class="fs-5 fw-bold text-dark bg-light p-3 rounded-3 border-0">
                        RD$ {{ number_format($procedimiento->precio, 2) }}
                    </div>
                </div>
            </div>

            <div class="border-top pt-4 mt-2">
                <div class="mb-3">
                    <h5 class="fw-semibold mb-0">Insumos asignados</h5>
                    <p class="text-muted small mb-0">Materiales que se consumen automáticamente al realizar este procedimiento.</p>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th style="width: 50%;" class="ps-3">Producto</th>
                                <th style="width: 25%;" class="text-center">Cantidad requerida</th>
                                <th style="width: 25%;" class="text-center">Ud. Medida</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($procedimiento->productos->isEmpty())
                                <tr>
                                    <td colspan="3" class="text-center text-muted py-4">
                                        <i class="bi bi-box-seam d-block fs-4 mb-2 text-secondary"></i>
                                        Este procedimiento no tiene insumos o productos asignados.
                                    </td>
                                </tr>
                            @else
                                @foreach($procedimiento->productos as $item)
                                    <tr>
                                        <td class="fw-medium ps-3 text-dark">
                                            {{ $item->producto->nombre }}
                                        </td>
                                        <td class="text-center fw-semibold text-secondary">
                                            {{ $item->cantidad }}
                                        </td>
                                        <td class="text-center text-muted small">
                                            {{ $item->producto->unidadMedida }}
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection