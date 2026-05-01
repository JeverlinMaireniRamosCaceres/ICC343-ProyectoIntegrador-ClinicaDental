@extends('layouts.app')

@section('title', 'Editar Proveedor')

@section('content')
<div class="container py-4">

    <div class="d-flex align-items-center gap-3 mb-4">
        <a href="{{ route('proveedores.index') }}"
           class="btn btn-sm btn-light rounded-pill px-3">
            <i class="bi bi-arrow-left"></i>
        </a>
        <h2 class="fw-semibold mb-0">Editar Proveedor</h2>
    </div>

    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-body p-4">

            <form action="{{ route('proveedores.update', 1) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="nombre" class="form-label text-muted fw-semibold small">
                        Nombre
                    </label>

                    <input type="text"
                           name="nombre"
                           id="nombre"
                           class="form-control"
                           value="Dental Depot"
                           placeholder="Ej: Dental Depot">
                </div>

                <div class="mb-3">
                    <label for="telefono" class="form-label text-muted fw-semibold small">
                        Teléfono
                    </label>

                    <input type="text"
                           name="telefono"
                           id="telefono"
                           class="form-control"
                           value="809-555-1234"
                           placeholder="Ej: 809-555-1234">
                </div>

                <div class="mb-4">
                    <label for="correo" class="form-label text-muted fw-semibold small">
                        Correo
                    </label>

                    <input type="email"
                           name="correo"
                           id="correo"
                           class="form-control"
                           value="dentaldepot@email.com"
                           placeholder="Ej: proveedor@email.com">
                </div>

                <div class="d-flex gap-2 justify-content-end">

                    <a href="{{ route('proveedores.index') }}"
                       class="btn btn-light rounded-pill px-4">
                        Cancelar
                    </a>

                    <button type="submit"
                            class="btn btn-primary rounded-pill px-4">
                        <i class="bi bi-arrow-clockwise"></i> Actualizar
                    </button>

                </div>

            </form>

        </div>
    </div>

</div>
@endsection
