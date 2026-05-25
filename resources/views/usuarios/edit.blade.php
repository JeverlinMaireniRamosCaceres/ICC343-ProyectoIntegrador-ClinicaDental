@extends('layouts.app')

@section('content')

<div class="container-fluid px-4 py-4">

    <div class="d-flex align-items-center gap-3 mb-4">

        <a href="{{ route('usuarios.index') }}"
           class="btn btn-light rounded-circle shadow-sm d-flex align-items-center justify-content-center"
           style="width: 40px; height: 40px;">
            <i class="bi bi-arrow-left"></i>
        </a>

        <h4 class="fw-semibold mb-0">Editar Usuario: {{ $usuario->username }}</h4>

    </div>

    <form action="{{ route('usuarios.update', $usuario->idUsuario) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row g-4">

            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4">

                        <h6 class="fw-semibold mb-3">Información de cuenta</h6>

                        <div class="row g-3">

                            <div class="col-md-6">
                                <label for="username" class="form-label text-muted fw-semibold small">Usuario</label>
                                <input type="text" 
                                       name="username" 
                                       id="username"
                                       class="form-control border-secondary-subtle @error('username') is-invalid @enderror"
                                       value="{{ old('username', $usuario->username) }}">
                                @error('username')
                                    <div class="invalid-feedback ps-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 {{ old('idRol', $usuario->idRol) == 3 ? '' : 'd-none' }}" id="contenedorPersona">
                                <label for="persona_nombre" class="form-label text-muted fw-semibold small">Persona vinculada</label>

                                <div class="position-relative">
                                    <input type="text"
                                           id="persona_nombre"
                                           name="persona_nombre"
                                           class="form-control border-secondary-subtle pe-5"
                                           value="{{ old('persona_nombre', $personaAsociada ? $personaAsociada->nombre . ' ' . $personaAsociada->apellido : '') }}"
                                           placeholder="Buscar persona..."
                                           autocomplete="off">

                                    <i class="bi bi-search position-absolute top-50 end-0 translate-middle-y me-3 text-muted"></i>
                                </div>

                                <div id="resultadosPersonas" class="list-group mt-1 shadow-sm position-absolute w-100 z-3"></div>

                                <input type="hidden" name="idPersona" id="persona_id" value="{{ old('idPersona', $usuario->idPersona) }}">
                                
                                @error('idPersona')
                                    <div class="text-danger small mt-1 ps-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="password" class="form-label text-muted fw-semibold small">Nueva contraseña</label>
                                <input type="password"
                                       name="password"
                                       id="password"
                                       class="form-control border-secondary-subtle @error('password') is-invalid @enderror"
                                       placeholder="********">

                                <small class="text-muted d-block mt-1">
                                    Dejar vacío para no cambiar la contraseña
                                </small>
                                @error('password')
                                    <div class="invalid-feedback ps-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="password_confirmation" class="form-label text-muted fw-semibold small">Confirmar contraseña</label>
                                <input type="password"
                                       name="password_confirmation"
                                       id="password_confirmation"
                                       class="form-control border-secondary-subtle"
                                       placeholder="********">
                            </div>

                        </div>

                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4">

                        <h6 class="fw-semibold mb-3">Configuración</h6>

                        <div class="mb-3">
                            <label for="idRol" class="form-label text-muted fw-semibold small">Rol</label>
                            <select name="idRol" id="idRol" class="form-select border-secondary-subtle @error('idRol') is-invalid @enderror">
                                <option value="">Seleccione un rol</option>
                                @foreach ($roles as $rol)
                                    <option value="{{ $rol->idRol }}" {{ old('idRol', $usuario->idRol) == $rol->idRol ? 'selected' : '' }}>
                                        {{ $rol->nombre }}
                                    </option>
                                @endforeach
                            </select>
                            @error('idRol')
                                <div class="invalid-feedback d-block ps-2">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>
                </div>

                <div class="d-grid mt-3">
                    <button type="submit" class="btn rounded-pill py-2 shadow-sm text-white" style="background-color: #0ea5e9;">
                        <i class="bi bi-floppy"></i> Actualizar Usuario
                    </button>
                </div>

            </div>

        </div>

    </form>

</div>

<script src="{{ asset('js/buscar-persona-usuario.js') }}"></script>

@endsection