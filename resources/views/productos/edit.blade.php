@extends('layouts.app')

@section('title', 'Editar Producto')

@section('content')
<div class="container py-4">

    <div class="d-flex align-items-center gap-3 mb-4">

        <a href="{{ route('productos.index') }}"
           class="btn btn-sm btn-light rounded-pill px-3">
            <i class="bi bi-arrow-left"></i>
        </a>

        <h2 class="fw-semibold mb-0">
            Editar Producto
        </h2>

    </div>

    <div class="card border-0 shadow-sm rounded-3">

        <div class="card-body p-4">

            <form action="{{ route('productos.update', 1) }}" method="POST">

                @csrf
                @method('PUT')

                <!-- NOMBRE -->

                <div class="mb-3">

                    <label class="form-label text-muted fw-semibold small">
                        Nombre
                    </label>

                    <input type="text"
                           name="nombre"
                           class="form-control"
                           value="Guantes Latex"
                           placeholder="Ej: Guantes Latex">

                </div>

                <!-- DESCRIPCION -->

                <div class="mb-3">

                    <label class="form-label text-muted fw-semibold small">
                        Descripción
                    </label>

                    <textarea name="descripcion"
                              class="form-control"
                              rows="3"
                              placeholder="Ej: Caja de guantes desechables">Caja de guantes desechables</textarea>

                </div>

                <!-- STOCK ACTUAL -->

                <div class="mb-3">

                    <label class="form-label text-muted fw-semibold small">
                        Stock Actual
                    </label>

                    <input type="number"
                           name="stockActual"
                           class="form-control"
                           value="150"
                           min="0">

                </div>

                <!-- STOCK MINIMO -->

                <div class="mb-3">

                    <label class="form-label text-muted fw-semibold small">
                        Stock Mínimo
                    </label>

                    <input type="number"
                           name="stockMinimo"
                           class="form-control"
                           value="50"
                           min="0">

                </div>

                <!-- UNIDAD MEDIDA -->

                <div class="mb-4">

                    <label class="form-label text-muted fw-semibold small">
                        Unidad de Medida
                    </label>

                    <select name="unidadMedida"
                            class="form-select">

                        <option value="Unidades">
                            Unidades
                        </option>

                        <option value="Cajas" selected>
                            Cajas
                        </option>

                        <option value="Paquetes">
                            Paquetes
                        </option>

                        <option value="Frascos">
                            Frascos
                        </option>

                    </select>

                </div>

                <!-- BOTONES -->

                <div class="d-flex gap-2 justify-content-end">

                    <a href="{{ route('productos.index') }}"
                       class="btn btn-light rounded-pill px-4">

                        Cancelar

                    </a>

                    <button type="submit"
                            class="btn btn-primary rounded-pill px-4">

                        <i class="bi bi-arrow-clockwise"></i>
                        Actualizar

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>
@endsection
