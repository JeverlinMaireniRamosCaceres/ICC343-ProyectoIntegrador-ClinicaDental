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

        @if ($errors->any())

            <div class="alert alert-danger">

                <ul class="mb-0">

                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach

                </ul>

            </div>

        @endif

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
                                       name="username"
                                       value="{{ old('username') }}"
                                       class="form-control border-secondary-subtle"
                                       placeholder="Ej: admin">

                                @error('username')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- contrasenia -->
                            <div class="col-md-6">
                                <label class="form-label">Contraseña</label>
                                <input type="password"
                                       name="password"
                                       class="form-control border-secondary-subtle"
                                       placeholder="********">

                                @error('password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <!-- confirmar contrasenia -->
                            <div class="col-md-6">
                                <label class="form-label">Confirmar contraseña</label>
                                <input type="password"
                                       name="password_confirmation"
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
                            <select name="idRol" id="idRol" class="form-select border-secondary-subtle @error('idRol') is-invalid @enderror">>

                            <option value="">Seleccione un rol</option>

                            @foreach($roles as $rol)
                                <option value="{{ $rol->idRol }}"
                                    {{ old('idRol') == $rol->idRol ? 'selected' : '' }}>
                                    {{ $rol->nombre }}
                                </option>
                            @endforeach

                            </select>

                            @error('idRol')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- persona vinculada -->
                            <div class="mb-3 d-none" id="contenedorPersona">
                                <label class="form-label">Persona vinculada</label>

                                <div class="position-relative">
                                    <input type="text"
                                        value="{{ old('persona_nombre') }}"
                                        class="form-control border-secondary-subtle pe-5"
                                        name="persona_nombre"
                                        id="persona_nombre"
                                        placeholder="Buscar persona...">

                                    <i class="bi bi-search position-absolute top-50 end-0 translate-middle-y me-3 text-muted"></i>
                                </div>

                                <div id="resultadosPersonas"
                                    class="list-group mt-1 shadow-sm">
                                </div>

                                <input type="hidden" name="idPersona" id="persona_id" value="{{ old('idPersona') }}">

                                <small class="text-muted">
                                    Escribe el nombre de la persona para vincularla al usuario.
                                </small>

                                @error('idPersona')
                                    <div class="text-danger small mt-1">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                    </div>
                </div>

                <!-- boton -->
                <div class="d-grid mt-3">
                    <button type="submit" class="btn btn-primary rounded-pill py-2 shadow-sm">
                        Guardar
                    </button>
                </div>

            </div>

        </div>

    </form>

</div>

<script src="{{ asset('js/buscar-persona-usuario.js') }}"></script>

@endsection