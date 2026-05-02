@extends('layouts.app')

@section('content')

<div class="container-fluid px-4">

    <!-- header -->
    <div class="d-flex align-items-center gap-3 mb-4">

        <a href="{{ route('usuarios.index') }}"
        class="btn btn-light rounded-circle shadow-sm d-flex align-items-center justify-content-center"
        style="width: 40px; height: 40px;">
            <i class="bi bi-arrow-left"></i>
        </a>

        <h4 class="fw-semibold mb-0">Nuevo usuario</h4>

    </div>

    <form action="{{ route('usuarios.store') }}" method="POST">
        @csrf

        <div class="row g-4">

            <!-- informacion de cuenta -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body">

                        <h6 class="fw-semibold mb-3">Información de cuenta</h6>

                        <div class="row g-3">

                            <!-- usuario -->
                            <div class="col-md-6">
                                <label class="form-label">Usuario</label>
                                <input type="text"
                                       class="form-control border-secondary-subtle"
                                       placeholder="Ej: admin">
                            </div>

                            <!-- persona vinculada -->
                            <div class="col-md-6">
                                <label class="form-label">Persona vinculada</label>

                                <div class="position-relative">
                                    <input type="text"
                                        class="form-control border-secondary-subtle pe-5"
                                        name="persona_nombre"
                                        id="persona_nombre"
                                        placeholder="Buscar persona...">

                                    <i class="bi bi-search position-absolute top-50 end-0 translate-middle-y me-3 text-muted"></i>
                                </div>

                                <input type="hidden" name="persona_id" id="persona_id">

                                <small class="text-muted">
                                    Escribe el nombre de la persona para vincularla al usuario.
                                </small>
                            </div>

                            <!-- contrasenia -->
                            <div class="col-md-6">
                                <label class="form-label">Contraseña</label>
                                <input type="password"
                                       class="form-control border-secondary-subtle"
                                       placeholder="********">
                            </div>

                            <!-- confirmar contrasenia -->
                            <div class="col-md-6">
                                <label class="form-label">Confirmar contraseña</label>
                                <input type="password"
                                       class="form-control border-secondary-subtle"
                                       placeholder="********">
                            </div>

                        </div>

                    </div>
                </div>
            </div>

            <!-- configuracion -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body">

                        <h6 class="fw-semibold mb-3">Configuración</h6>

                        <!-- Rol -->
                        <div class="mb-3">
                            <label class="form-label">Rol</label>
                            <select class="form-select border-secondary-subtle">
                                <option>Administrador</option>
                                <option>Recepcionista</option>
                                <option>Odontólogo</option>
                            </select>
                        </div>



                    </div>
                </div>

                <!-- Botón -->
                <div class="d-grid mt-3">
                    <button type="submit" class="btn btn-primary rounded-pill py-2 shadow-sm">
                        Guardar
                    </button>
                </div>

            </div>

        </div>

    </form>

</div>

@endsection