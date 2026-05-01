@extends('layouts.app')

@section('title', 'Nuevo Proveedor')

@section('content')
<div class="container py-4">

    <div class="d-flex align-items-center gap-3 mb-4">
        <a href="{{ route('proveedores.index') }}"
           class="btn btn-sm btn-light rounded-pill px-3">
            <i class="bi bi-arrow-left"></i>
        </a>
        <h2 class="fw-semibold mb-0">Nuevo Proveedor</h2>
    </div>

    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-body p-4">

            <form action="{{ route('proveedores.store') }}" method="POST">
                @csrf

                <!-- NOMBRE -->

                <div class="mb-3">
                    <label for="nombre" class="form-label text-muted fw-semibold small">
                        Nombre
                    </label>

                    <input type="text"
                           name="nombre"
                           id="nombre"
                           class="form-control @error('nombre') is-invalid @enderror"
                           value="{{ old('nombre') }}"
                           placeholder="Ej: Dental Depot">

                    @error('nombre')
                        <div class="invalid-feedback ps-2">{{ $message }}</div>
                    @enderror
                </div>

                <!-- TELEFONO -->

                <div class="mb-3">
                    <label for="telefono" class="form-label text-muted fw-semibold small">
                        Teléfono
                    </label>

                    <input type="text"
                           name="telefono"
                           id="telefono"
                           class="form-control @error('telefono') is-invalid @enderror"
                           value="{{ old('telefono') }}"
                           placeholder="Ej: 809-555-1234">

                    @error('telefono')
                        <div class="invalid-feedback ps-2">{{ $message }}</div>
                    @enderror
                </div>

                <!-- CORREO -->

                <div class="mb-4">
                    <label for="correo" class="form-label text-muted fw-semibold small">
                        Correo
                    </label>

                    <input type="email"
                           name="correo"
                           id="correo"
                           class="form-control @error('correo') is-invalid @enderror"
                           value="{{ old('correo') }}"
                           placeholder="Ej: proveedor@email.com">

                    @error('correo')
                        <div class="invalid-feedback ps-2">{{ $message }}</div>
                    @enderror
                </div>

                <!-- BOTONES -->

                <div class="d-flex gap-2 justify-content-end">
                    <a href="{{ route('proveedores.index') }}"
                       class="btn btn-light rounded-pill px-4">
                        Cancelar
                    </a>

                    <button type="submit"
                            class="btn btn-primary rounded-pill px-4">
                        <i class="bi bi-floppy"></i> Guardar
                    </button>
                </div>

            </form>

        </div>
    </div>

</div>
@endsection
