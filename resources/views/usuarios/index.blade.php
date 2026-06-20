@extends('layouts.app')

@section('title', 'Usuarios')

@section('content')

    <div class="container-fluid py-2 px-2">

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm rounded-4 border-0 mb-4" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i>
                {{ session('success') }}

                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- header -->
        <div class="d-flex justify-content-between align-items-center mb-3">

            <div>
                <h2 class="fw-bold page-title mb-1">Usuarios</h2>
            </div>

            <a href="{{ route('usuarios.create') }}" class="btn btn-medical-primary rounded-pill px-4 shadow-sm">

                <i class="bi bi-plus-lg me-1"></i>
                Nuevo

            </a>

        </div>

        <!-- card -->
        <div class="card border-0 shadow-sm rounded-4">

            <div class="card-body p-0">

                <!-- barra busqueda -->
                <div class="p-4 border-bottom">

                    <div class="position-relative" style="max-width: 350px;">

                        <i class="bi bi-search position-absolute top-50 start-0 translate-middle-y ms-3 text-muted"></i>

                        <form method="GET" action="{{ route('usuarios.index') }}">

                            <input type="text" name="buscar" id="buscarUsuario" value="{{ request('buscar') }}"
                                class="form-control rounded-pill ps-5 search-input" placeholder="Buscar usuario...">
                        </form>

                    </div>

                </div>

                <!-- tabla -->
                <div id="contenedorTablaUsuarios">

                    @include('usuarios.partials.tabla')

                </div>

            </div>

        </div>

    </div>

    <!-- modal dar de baja -->
    <div class="modal fade" id="modalEliminarUsuario" tabindex="-1" aria-hidden="true">

        <div class="modal-dialog modal-dialog-centered">

            <div class="modal-content border-0 shadow rounded-4">

                <div class="modal-header border-0 pb-0">

                    <div class="d-flex align-items-center gap-2">

                        <div class="rounded-circle bg-danger bg-opacity-10 d-flex align-items-center justify-content-center"
                            style="width: 42px; height: 42px;">

                            <i class="bi bi-trash3-fill text-danger"></i>

                        </div>

                        <div>
                            <h5 class="fw-bold mb-0">Dar de baja a usuario</h5>
                        </div>

                    </div>

                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>

                </div>

                <div class="modal-body pt-3">

                    <p class="mb-0">
                        ¿Estás seguro de que deseas darle de baja a
                        <strong id="nombreUsuarioEliminar">
                            este usuario</strong>?
                    </p>

                </div>

                <div class="modal-footer border-0 pt-0">

                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">

                        Cancelar

                    </button>

                    <form id="formEliminarUsuario" method="POST">

                        @csrf
                        @method('DELETE')

                        <button type="submit" class="btn btn-danger rounded-pill px-4">

                            Dar de baja

                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

    <!-- modal activar -->
    <div class="modal fade" id="modalActivarUsuario" tabindex="-1" aria-hidden="true">

        <div class="modal-dialog modal-dialog-centered">

            <div class="modal-content border-0 shadow rounded-4">

                <div class="modal-header border-0 pb-0">

                    <div class="d-flex align-items-center gap-2">

                        <div class="rounded-circle bg-success bg-opacity-10 d-flex align-items-center justify-content-center"
                            style="width: 42px; height: 42px;">

                            <i class="bi bi-check-circle-fill text-success"></i>

                        </div>

                        <div>
                            <h5 class="fw-bold mb-0">Activar usuario</h5>
                        </div>

                    </div>

                    <button type="button" class="btn-close" data-bs-dismiss="modal">
                    </button>

                </div>

                <div class="modal-body pt-3">

                    <p class="mb-0">
                        ¿Estás seguro de que deseas activar
                        <strong id="nombreUsuarioActivar">
                            este usuario</strong>?
                    </p>

                </div>

                <div class="modal-footer border-0 pt-0">

                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">

                        Cancelar

                    </button>

                    <form id="formActivarUsuario" method="POST">

                        @csrf
                        @method('PUT')

                        <button type="submit" class="btn btn-success rounded-pill px-4">

                            Activar

                        </button>

                    </form>

                </div>

            </div>

        </div>

    </div>

    <script src="{{ asset('js/usuario.js') }}"></script>

@endsection
