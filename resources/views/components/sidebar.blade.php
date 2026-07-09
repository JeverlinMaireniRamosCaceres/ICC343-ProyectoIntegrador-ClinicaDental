<div id="sidebar-container" class="d-flex flex-column shadow sidebar-expanded">

    <div class="sidebar-header">
        <div class="brand">
            <img src="{{ asset('favicon.ico') }}" alt="Logo Clínica" class="brand-icon">
            <span class="link-text">Clínica Dental</span>
        </div>
        <button id="sidebarToggle" class="sidebar-toggle-btn">
            <i class="bi bi-chevron-left"></i>
        </button>
    </div>

    <ul class="nav flex-column sidebar-nav flex-grow-1">

        <li><span class="sidebar-section-label">General</span></li>

        <li>
            <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="bi bi-grid-1x2"></i>
                <span class="link-text">Dashboard</span>
            </a>
        </li>

        <li>
            <a href="{{ route('citas.index') }}" class="nav-link {{ request()->routeIs('citas.*') ? 'active' : '' }}">
                <i class="bi bi-calendar-check"></i>
                <span class="link-text">Citas</span>
            </a>
        </li>

        <li>
            <hr class="sidebar-divider">
        </li>

        <li>
            <span class="sidebar-section-label">Clínica</span>
        </li>

        <li>
            <a class="nav-link dropdown-toggle
        {{ request()->routeIs('pacientes.*') || request()->routeIs('consultas.*') || request()->routeIs('odontologos.*') ? 'active' : '' }}
        {{ request()->routeIs('pacientes.*') || request()->routeIs('consultas.*') || request()->routeIs('odontologos.*') ? '' : 'collapsed' }}"
                href="#clinicaSubmenu" data-bs-toggle="collapse">

                <i class="bi bi-hospital"></i>
                <span class="link-text">Clínica</span>
            </a>

            <ul class="collapse submenu {{ request()->routeIs('pacientes.*') || request()->routeIs('consultas.*') || request()->routeIs('odontologos.*') ? 'show' : '' }}"
                id="clinicaSubmenu">

                <li>
                    <a href="{{ route('pacientes.index') }}"
                        class="nav-link {{ request()->routeIs('pacientes.*') ? 'active' : '' }}">
                        <i class="bi bi-people"></i>
                        <span class="link-text">Pacientes</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('consultas.index') }}"
                        class="nav-link {{ request()->routeIs('consultas.*') ? 'active' : '' }}">
                        <i class="bi bi-journal-medical"></i>
                        <span class="link-text">Consultas</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('odontologos.index') }}"
                        class="nav-link {{ request()->routeIs('odontologos.*') ? 'active' : '' }}">
                        <i class="bi bi-person-badge"></i>
                        <span class="link-text">Odontólogos</span>
                    </a>
                </li>

            </ul>
        </li>

        <li>
            <hr class="sidebar-divider">
        </li>

        <li><span class="sidebar-section-label">Inventario</span></li>

        <li>
            <a class="nav-link dropdown-toggle
        {{ request()->routeIs('inventario.*') || request()->routeIs('productos.*') || request()->routeIs('compras.*') || request()->routeIs('proveedores.*') ? 'active' : '' }}
        {{ request()->routeIs('inventario.*') || request()->routeIs('productos.*') || request()->routeIs('compras.*') || request()->routeIs('proveedores.*') ? '' : 'collapsed' }}"
                href="#inventarioSubmenu" data-bs-toggle="collapse">

                <i class="bi bi-boxes"></i>
                <span class="link-text">Inventario</span>
            </a>

            <ul class="collapse submenu {{ request()->routeIs('inventario.*') || request()->routeIs('productos.*') || request()->routeIs('compras.*') || request()->routeIs('proveedores.*') ? 'show' : '' }}"
                id="inventarioSubmenu">

                <li>
                    <a href="{{ route('inventario.index') }}"
                        class="nav-link {{ request()->routeIs('inventario.*') ? 'active' : '' }}">
                        <i class="bi bi-boxes"></i>
                        <span class="link-text">Inventario</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('productos.index') }}"
                        class="nav-link {{ request()->routeIs('productos.*') ? 'active' : '' }}">
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


        <li>
            <hr class="sidebar-divider">
        </li>
        <li><span class="sidebar-section-label">Facturación</span></li>

        <li>
            <a class="nav-link {{ request()->routeIs('facturacion.*') ? 'active' : '' }}"
                href="{{ route('facturacion.index') }}">
                <i class="bi bi-receipt-cutoff"></i>
                <span class="link-text">Facturas</span>
            </a>
        </li>
        <li>
            <a class="nav-link {{ request()->routeIs('pagos.*') ? 'active' : '' }}" href="{{ route('pagos.index') }}">
                <i class="bi bi-credit-card"></i>
                <span class="link-text">Pagos</span>
            </a>
        </li>

        <li>
            <hr class="sidebar-divider">
        </li>
        <li><span class="sidebar-section-label">Finanzas</span></li>

        <li>
            <a href="{{ route('caja-chica.index') }}"
                class="nav-link {{ request()->routeIs('caja-chica.*') ? 'active' : '' }}">
                <i class="bi bi-safe"></i>
                <span class="link-text">Caja chica</span>
            </a>
        </li>

        {{-- SISTEMA --}}
        <li>
            <hr class="sidebar-divider">
        </li>
        <li><span class="sidebar-section-label">Sistema</span></li>

        <li>
            <a class="nav-link dropdown-toggle
            {{ request()->routeIs('procedimientos.*') || request()->routeIs('usuarios.*') || request()->routeIs('alergias.*') || request()->routeIs('especialidades.*') ? 'active' : '' }}
            {{ request()->routeIs('procedimientos.*') || request()->routeIs('usuarios.*') || request()->routeIs('alergias.*') || request()->routeIs('especialidades.*') ? '' : 'collapsed' }}"
                href="#configSubmenu" data-bs-toggle="collapse">
                <i class="bi bi-gear"></i>
                <span class="link-text">Configuración</span>
            </a>
            <ul class="collapse submenu {{ request()->routeIs('usuarios.*') || request()->routeIs('procedimientos.*') || request()->routeIs('alergias.*') || request()->routeIs('especialidades.*') ? 'show' : '' }}"
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
                    <a class="nav-link {{ request()->routeIs('especialidades.*') ? 'active' : '' }}"
                        href="{{ route('especialidades.index') }}">
                        <i class="bi bi-award"></i>
                        <span class="link-text">Especialidades</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('alergias.index') }}"
                        class="nav-link {{ request()->routeIs('alergias.*') ? 'active' : '' }}">
                        <i class="bi bi-exclamation-triangle"></i>
                        <span class="link-text">Alergias</span>
                    </a>
                </li>
            </ul>
        </li>

    </ul>

    <div class="sidebar-footer">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="nav-link text-danger">
                <i class="bi bi-box-arrow-left"></i>
                <span class="link-text">Cerrar sesión</span>
            </button>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {

        const sidebar = document.getElementById('sidebar-container');
        const toggleBtn = document.getElementById('sidebarToggle');
        const icon = toggleBtn.querySelector('i');

        const collapsed =
            localStorage.getItem('sidebarCollapsed') === 'true';

        if (collapsed) {
            sidebar.classList.remove('sidebar-expanded');
            sidebar.classList.add('sidebar-collapsed');

            icon.classList.remove('bi-chevron-left');
            icon.classList.add('bi-chevron-right');
        } else {
            sidebar.classList.remove('sidebar-collapsed');
            sidebar.classList.add('sidebar-expanded');
        }

        toggleBtn.addEventListener('click', () => {

            sidebar.classList.toggle('sidebar-expanded');
            sidebar.classList.toggle('sidebar-collapsed');

            const isCollapsed =
                sidebar.classList.contains('sidebar-collapsed');

            localStorage.setItem(
                'sidebarCollapsed',
                isCollapsed
            );

            if (isCollapsed) {
                icon.classList.remove('bi-chevron-left');
                icon.classList.add('bi-chevron-right');
            } else {
                icon.classList.remove('bi-chevron-right');
                icon.classList.add('bi-chevron-left');
            }
        });

    });
</script>
