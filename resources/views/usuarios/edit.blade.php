@extends('layouts.app')

@section('content')
    <div class="container py-4">

        <div class="d-flex align-items-center gap-3 mb-4">

            <a href="{{ route('usuarios.index') }}" class="btn btn-sm btn-light rounded-pill px-3">
                <i class="bi bi-arrow-left"></i>
            </a>

            <h2 class="fw-semibold mb-0">
                Editar usuario
            </h2>

        </div>

        <div class="card border-0 shadow-sm rounded-3">
            <div class="card-body p-4">

                <h6 class="fw-semibold mb-3">Información de cuenta</h6>

                <form action="{{ route('usuarios.update', $usuario->idUsuario) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="username" class="form-label text-muted fw-semibold small">Usuario</label>

                        <input type="text" name="username" id="username"
                            class="form-control @error('username') is-invalid @enderror"
                            value="{{ old('username', $usuario->username) }}" placeholder="Ej: admin">

                        @error('username')
                            <div class="invalid-feedback ps-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label text-muted fw-semibold small">
                            Nueva contraseña
                        </label>

                        <input type="password" name="password" id="password"
                            class="form-control @error('password') is-invalid @enderror" placeholder="********">

                        <small class="text-muted d-block mt-1">
                            Dejar vacío para no cambiar la contraseña
                        </small>

                        @error('password')
                            <div class="invalid-feedback ps-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label text-muted fw-semibold small">
                            Confirmar contraseña
                        </label>

                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control"
                            placeholder="********">
                    </div>

                    <br>

                    <h6 class="fw-semibold mb-3">Configuración</h6>

                    <div class="mb-3">
                        <label class="form-label">Rol</label>

                        <select name="idRol" id="idRol"
                            class="form-select border-secondary-subtle @error('idRol') is-invalid @enderror">

                            <option value="">Seleccione un rol</option>

                            @foreach ($roles as $rol)
                                <option value="{{ $rol->idRol }}"
                                    {{ old('idRol', $usuario->idRol) == $rol->idRol ? 'selected' : '' }}>
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

                    <div class="mb-3 {{ old('idRol', $usuario->idRol) == 3 ? '' : 'd-none' }}" id="contenedorPersona">

                        <label class="form-label">Persona vinculada</label>

                        <div class="position-relative">
                            <input type="text"
                                value="{{ old('persona_nombre', $personaAsociada ? $personaAsociada->nombre . ' ' . $personaAsociada->apellido : '') }}"
                                class="form-control border-secondary-subtle pe-5" name="persona_nombre" id="persona_nombre"
                                placeholder="Buscar persona..." autocomplete="off">

                            <i class="bi bi-search position-absolute top-50 end-0 translate-middle-y me-3 text-muted"></i>
                        </div>

                        <div id="resultadosPersonas" class="list-group mt-1 shadow-sm">
                        </div>

                        <input type="hidden" name="idPersona" id="persona_id"
                            value="{{ old('idPersona', $usuario->idPersona) }}">

                        <small class="text-muted">
                            Escribe el nombre de la persona para vincularla al usuario.
                        </small>

                        @error('idPersona')
                            <div class="text-danger small mt-1">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2 justify-content-end">
                        <a href="{{ route('usuarios.index') }}" class="btn btn-light rounded-pill px-4">
                            Cancelar
                        </a>

                        <button type="submit" class="btn rounded-pill px-4 text-white" style="background-color: #0ea5e9;">

                           <i class="bi bi-arrow-clockwise"></i>
                           Actualizar
                        </button>
                    </div>

                </form>

            </div>
        </div>

    </div>

    <script src="{{ asset('js/buscar-persona-usuario.js') }}"></script>
@endsection
