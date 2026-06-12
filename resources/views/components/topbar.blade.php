@php
    use Illuminate\Support\Str;

    $usuario = auth()->user();

    if ($usuario->persona) {
        $nombreCompleto = Str::title(
            $usuario->persona->nombre . ' ' . $usuario->persona->apellido
        );
    } else {
        $nombreCompleto = Str::title($usuario->username);
    }
@endphp


<nav class="topbar navbar navbar-expand navbar-light bg-white border-bottom sticky-top">

    <ul class="navbar-nav ms-auto align-items-center">

        <li class="nav-item me-3">
            <a class="topbar-icon-btn position-relative" href="#">
                <i class="bi bi-bell"></i>
                <span class="notification-dot"></span>
            </a>
        </li>


        <li class="nav-item dropdown">
            <a class="nav-link d-flex align-items-center" href="#" data-bs-toggle="dropdown">

                <div class="text-end me-2 d-none d-sm-block">
                    <p class="m-0 small fw-bold">
                        {{ $nombreCompleto }}
                    </p>

                    <p class="m-0 extra-small text-muted" style="font-size: 11px;">
                        {{ $usuario->rol->nombre }}
                    </p>
                </div>

                <img
                    src="https://ui-avatars.com/api/?name={{ urlencode($nombreCompleto) }}&background=0ea5e9&color=fff"
                    class="rounded-circle"
                    width="35"
                    height="35"
                    alt="Avatar">
            </a>

            <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-3">
                <li>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf

                        <button type="submit" class="dropdown-item text-danger">
                            <i class="bi bi-box-arrow-left me-2"></i>
                            Salir
                        </button>
                    </form>
                </li>
            </ul>
        </li>

    </ul>

</nav>
