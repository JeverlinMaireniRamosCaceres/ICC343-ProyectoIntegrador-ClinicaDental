<div id="sidebar-container" class="d-flex flex-column shadow">
    <div class="sidebar-header py-4 text-center text-white">

        <div class="brand">

            <svg class="brand-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 64 64" width="24" height="24">
                <path fill="currentColor"
                    d="M32 4C22 4 14 10 14 20c0 6 3 10 4 14 1 4 2 18 6 18s4-8 8-8 4 8 8 8 5-14 6-18c1-4 4-8 4-14C50 10 42 4 32 4z" />
            </svg>
            <span class="link-text">Clinica Dental</span>
        </div>

        <!-- boton para colapsar -->
        <button id="toggle-sidebar" class="sidebar-toggle">
            <i class="bi bi-chevron-left toggle-icon"></i>
        </button>

    </div>

    <ul class="nav flex-column sidebar-nav flex-grow-1">

        <li>
            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="bi bi-grid-1x2"></i>
                <span class="link-text">Dashboard</span>
            </a>
        </li>

        <!-- PACIENTES -->
        <li>
            <a href="{{ route('pacientes.index') }}" class="nav-link {{ request()->routeIs('pacientes.*') ? 'active' : '' }}">
                <i class="bi bi-people"></i>
                <span class="link-text">Pacientes</span>
            </a>
        </li>

        <li><a href="#" class="nav-link"><i class="bi bi-calendar-check"></i> <span
                    class="link-text">Citas</span></a></li>
        <li><a href="#" class="nav-link"><i class="bi bi-journal-medical"></i> <span
                    class="link-text">Consultas</span></a></li>
        <a href="{{ route('odontologos.index') }}"
        class="nav-link {{ request()->routeIs('odontologos.*') ? 'active' : '' }}">

            <i class="bi bi-person-badge"></i>
            <span class="link-text">Odontólogos</span>
        </a>

        <!-- INVENTARIO -->
        <li>
            <a class="nav-link dropdown-toggle
                {{ request()->routeIs('compras.*') || request()->routeIs('proveedores.*') || request()->routeIs('productos.*') ? 'active' : '' }}
                {{ request()->routeIs('compras.*') || request()->routeIs('proveedores.*') || request()->routeIs('productos.*') ? '' : 'collapsed' }}"
                href="#invSubmenu" data-bs-toggle="collapse">
                <i class="bi bi-boxes"></i> <span class="link-text">Inventario</span>
            </a>
            <ul class="collapse submenu {{ request()->routeIs('compras.*') || request()->routeIs('proveedores.*') || request()->routeIs('productos.*') ? 'show' : '' }}"
                id="invSubmenu">
                <li>
                    <a class="nav-link {{ request()->routeIs('productos.*') ? 'active' : '' }}"
                        href="{{ route('productos.index') }}">
                        <i class="bi bi-box-seam"></i>
                        <span class="link-text">Productos</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('compras.index') }}"
                        class="nav-link {{ request()->routeIs('compras.*') ? 'active' : '' }}">
                        <i class="bi bi-cart-check"></i>
                        <span class="link-text">Compras</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('proveedores.index') }}"
                        class="nav-link {{ request()->routeIs('proveedores.*') ? 'active' : '' }}">
                        <i class="bi bi-truck"></i>
                        <span class="link-text">Proveedores</span>
                    </a>
                </li>
            </ul>
        </li>

        <!-- FACTURACION -->
        <li>
            <a class="nav-link dropdown-toggle" href="#facSubmenu" data-bs-toggle="collapse">
                <i class="bi bi-receipt"></i> <span class="link-text">Facturación</span>
            </a>
            <ul class="collapse submenu" id="facSubmenu">
                <li>
                    <a class="nav-link" href="#">
                        <i class="bi bi-receipt-cutoff"></i>
                        <span class="link-text">Facturas</span>
                    </a>
                </li>
                <li>
                    <a class="nav-link" href="#">
                        <i class="bi bi-credit-card"></i>
                        <span class="link-text">Pagos</span>
                    </a>
                </li>
            </ul>
        </li>

        <li><a href="#" class="nav-link"><i class="bi bi-safe"></i> <span class="link-text">Caja chica</span></a>
        </li>

        <!-- CONFIGURACION -->
        <li>
            <a class="nav-link dropdown-toggle
                {{ request()->routeIs('procedimientos.*') || request()->routeIs('usuarios.*') ? 'active' : '' }}
                {{ request()->routeIs('procedimientos.*') || request()->routeIs('usuarios.*') ? '' : 'collapsed' }}"
                href="#configSubmenu" data-bs-toggle="collapse">

                <i class="bi bi-gear"></i>
                <span class="link-text">Configuración</span>

            </a>

            <ul class="collapse submenu {{ request()->routeIs('usuarios.*') || request()->routeIs('procedimientos.*') ? 'show' : '' }}"
                id="configSubmenu">
                <li>
                    <a href="{{ route('usuarios.index') }}"
                    class="nav-link {{ request()->routeIs('usuarios.*') ? 'active' : '' }}">
                        <i class="bi bi-people"></i>
                        <span class="link-text">Usuarios</span>
                    </a>
                </li>
                <li>
                    <a class="nav-link {{ request()->routeIs('procedimientos.*') ? 'active' : '' }}"
                        href="{{ route('procedimientos.index') }}">
                        <i class="bi bi-clipboard2-plus"></i>
                        <span class="link-text">Procedimientos</span>
                    </a>
                </li>
                <li>
                    <a class="nav-link" href="#">
                        <i class="bi bi-award"></i>
                        <span class="link-text">Especialidades</span>
                    </a>
                </li>
                <li>
                    <a class="nav-link" href="#">
                        <i class="bi bi-exclamation-triangle"></i>
                        <span class="link-text">Alergias</span>
                    </a>
                </li>
            </ul>
        </li>

    </ul>

    <div class="sidebar-footer">
        <a href="#" class="nav-link text-danger">
            <i class="bi bi-box-arrow-left"></i>
            <span class="link-text">Cerrar sesión</span>
        </a>
    </div>
</div>
