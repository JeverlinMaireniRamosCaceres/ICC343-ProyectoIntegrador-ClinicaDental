<div id="sidebar-container" class="d-flex flex-column shadow">
    <div class="sidebar-header py-4 text-center text-white">

        <div class="brand">

        <img src="{{ asset('favicon.ico') }}"
            alt="Logo Clínica"
            class="brand-icon">
            <span class="link-text mr-4">Clínica Dental</span>
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

        <a href="{{ route('citas.index') }}"
        class="nav-link {{ request()->routeIs('citas.*') ? 'active' : '' }}">
            <i class="bi bi-calendar-check"></i>
            <span class="link-text">Citas</span>
        </a>

        <a href="{{ route('consultas.index') }}"
        class="nav-link {{ request()->routeIs('consultas.*') ? 'active' : '' }}">
            <i class="bi bi-journal-medical"></i>
            <span class="link-text">Consultas</span>
        </a>
        
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
            <a class="nav-link dropdown-toggle
                {{ request()->routeIs('facturacion.*') ? 'active' : '' }}
                {{ request()->routeIs('facturacion.*') ? '' : 'collapsed' }}"
                href="#facSubmenu" data-bs-toggle="collapse">
                <i class="bi bi-receipt"></i> <span class="link-text">Facturación</span>
            </a>
            <ul class="collapse submenu {{ request()->routeIs('facturacion.*') ? 'show' : '' }}" id="facSubmenu">
                <li>
                    <a class="nav-link {{ request()->routeIs('facturacion.*') ? 'active' : '' }}" href="{{route('facturacion.create')}}">
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

        <!-- CAJA CHICA -->
        <li>
            <a href="{{ route('caja-chica.index') }}"
                class="nav-link {{ request()->routeIs('caja-chica.*') ? 'active' : '' }}"><i class="bi bi-safe"></i> <span
                class="link-text">Caja chica</span></a>
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

                <a href="{{ route('alergias.index') }}"
                class="nav-link {{ request()->routeIs('alergias.*') ? 'active' : '' }}">

                    <i class="bi bi-exclamation-triangle"></i>

                    <span class="link-text">Alergias</span>

                </a>

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
