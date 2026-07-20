@php
    use Illuminate\Support\Str;

    $usuario = auth()->user();

    if ($usuario->persona) {
        $nombreCompleto = Str::title($usuario->persona->nombre . ' ' . $usuario->persona->apellido);
    } else {
        $nombreCompleto = Str::title($usuario->username);
    }
@endphp


<nav class="topbar navbar navbar-expand navbar-light bg-white border-bottom sticky-top">

    <ul class="navbar-nav ms-auto align-items-center">

        @rol('Administrador', 'Secretaria')
            <li class="nav-item me-3 dropdown">
                <a class="topbar-icon-btn position-relative" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-bell"></i>
                    @if ($totalAlertasTopbar > 0)
                        <span class="notification-dot"></span>
                    @endif
                </a>

                <div class="dropdown-menu dropdown-menu-end shadow border-0 mt-3 p-0"
                    style="width: 340px; max-height: 400px; overflow-y: auto;">

                    <div class="px-3 py-2 border-bottom">
                        <p class="fw-semibold mb-0 small">Alertas de inventario</p>
                    </div>

                    @if ($totalAlertasTopbar === 0)
                        <div class="text-center py-4 text-muted small">
                            <i class="bi bi-check-circle fs-4 d-block mb-1 text-success"></i>
                            Todo el inventario está en orden.
                        </div>
                    @else
                        <div class="p-2">

                            @foreach ($alertasSinStockTopbar as $p)
                                <a href="{{ route('inventario.index') }}#tab-alertas"
                                    class="dropdown-item rounded-3 py-2 small">
                                    <i class="bi bi-x-circle-fill me-2" style="color:#e03131;"></i>
                                    <strong>{{ $p->nombre }}</strong> | sin stock
                                </a>
                            @endforeach

                            @foreach ($alertasStockBajoTopbar as $p)
                                <a href="{{ route('inventario.index') }}#tab-alertas"
                                    class="dropdown-item rounded-3 py-2 small">
                                    <i class="bi bi-exclamation-triangle-fill me-2" style="color:#c2510a;"></i>
                                    <strong>{{ $p->nombre }}</strong> | stock bajo ({{ $p->stockActual }})
                                </a>
                            @endforeach

                            @foreach ($alertasVencimientoTopbar as $d)
                                <a href="{{ route('inventario.index') }}#tab-alertas"
                                    class="dropdown-item rounded-3 py-2 small">
                                    <i class="bi bi-clock-fill me-2" style="color:#7c3aed;"></i>
                                    <strong>{{ $d->producto->nombre }}</strong> | vence
                                    {{ \Carbon\Carbon::parse($d->fechaVencimiento)->format('d/m/Y') }}
                                </a>
                            @endforeach

                            @foreach ($alertasSoloVencidoTopbar as $p)
                                <a href="{{ route('inventario.index') }}#tab-alertas"
                                    class="dropdown-item rounded-3 py-2 small">
                                    <i class="bi bi-clock-fill me-2" style="color:#7c3aed;"></i>
                                    <strong>{{ $p->nombre }}</strong> | todo vencido
                                </a>
                            @endforeach

                        </div>
                    @endif

                </div>
            </li>
        @endrol


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

                <img src="https://ui-avatars.com/api/?name={{ urlencode($nombreCompleto) }}&background=0ea5e9&color=fff"
                    class="rounded-circle" width="35" height="35" alt="Avatar">
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
