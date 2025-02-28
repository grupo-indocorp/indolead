<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 "
    id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
            aria-hidden="true" id="iconSidenav"></i>
        <a class="align-items-center d-flex m-0 navbar-brand text-wrap" href="{{ route('dashboard') }}">
            <img src="img/logo.png" class="navbar-brand-img h-100" alt="...">
            <span class="ms-3 font-weight-bold">Indotech CRM</span>
        </a>
    </div>
    <hr class="horizontal dark mt-0">
    <div class="navbar-collapse w-auto" id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <li class="nav-item pb-2">
                <a class="nav-link {{ Request::is('dashboard') ? 'active' : '' }}" href="{{ url('dashboard') }}">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i style="font-size: 1rem;"
                            class="fas fa-lg fa-home ps-2 pe-2 text-center text-dark {{ Request::is('dashboard') ? 'text-white' : 'text-dark' }} "
                            aria-hidden="true"></i>
                    </div>
                    <span class="nav-link-text ms-1">Dashboard</span>
                </a>
            </li>
            <li class="nav-item mt-2">
                <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">General</h6>
            </li>
            <li class="nav-item pb-2">
                <a class="nav-link {{ Request::is('cliente') ? 'active' : '' }}" href="{{ url('cliente') }}">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i style="font-size: 1rem;"
                            class="fas fa-lg fa-users ps-2 pe-2 text-center text-dark {{ Request::is('cliente') ? 'text-white' : 'text-dark' }} "
                            aria-hidden="true"></i>
                    </div>
                    <span class="nav-link-text ms-1">Clientes</span>
                </a>
            </li>
            <li class="nav-item mt-2">
                <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Gestión de Clientes</h6>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('funell') ? 'active' : '' }}" href="{{ url('funell') }}">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i style="font-size: 1rem;"
                            class="fas fa-lg fa-table ps-2 pe-2 text-center text-dark {{ Request::is('funell') ? 'text-white' : 'text-dark' }} "
                            aria-hidden="true"></i>
                    </div>
                    <span class="nav-link-text ms-1">Funell</span>
                </a>
            </li>
            <li class="nav-item pb-2">
                <a class="nav-link {{ Request::is('gestion-cliente') ? 'active' : '' }}"
                    href="{{ url('gestion-cliente') }}">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i style="font-size: 1rem;"
                            class="fas fa-lg fa-user-plus ps-2 pe-2 text-center text-dark {{ Request::is('gestion-cliente') ? 'text-white' : 'text-dark' }} "
                            aria-hidden="true"></i>
                    </div>
                    <span class="nav-link-text ms-1">Gestión Clientes</span>
                </a>
            </li>
            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Gestión de Usuarios</h6>
            </li>
            <li class="nav-item pb-2">
                <a class="nav-link {{ Request::is('lista-usuario') ? 'active' : '' }}"
                    href="{{ url('lista-usuario') }}">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i style="font-size: 1rem;"
                            class="fas fa-lg fa-users ps-2 pe-2 text-center text-dark {{ Request::is('lista-usuario') ? 'text-white' : 'text-dark' }} "
                            aria-hidden="true"></i>
                    </div>
                    <span class="nav-link-text ms-1">Lista de Usuarios</span>
                </a>
            </li>
            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Gestión de Equipos</h6>
            </li>
            <li class="nav-item pb-2">
                <a class="nav-link {{ Request::is('user-management') ? 'active' : '' }}"
                    href="{{ url('user-management') }}">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i style="font-size: 1rem;"
                            class="fas fa-lg fa-users ps-2 pe-2 text-center text-dark {{ Request::is('user-management') ? 'text-white' : 'text-dark' }} "
                            aria-hidden="true"></i>
                    </div>
                    <span class="nav-link-text ms-1">Lista de Equipos</span>
                </a>
            </li>
            <!-- Nueva sección: Gestión de Biblioteca -->
            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Gestión de Biblioteca</h6>
            </li>
            <li class="nav-item pb-2">
                <a class="nav-link {{ Request::is('files') ? 'active' : '' }}" href="{{ url('files') }}">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i style="font-size: 1rem;"
                            class="fas fa-lg fa-file ps-2 pe-2 text-center text-dark {{ Request::is('files') ? 'text-white' : 'text-dark' }} "
                            aria-hidden="true"></i>
                    </div>
                    <span class="nav-link-text ms-1">Gestión de Biblioteca</span>
                </a>
            </li>

            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Biblioteca</h6>
            </li>
            <li class="nav-item pb-2">
                <a class="nav-link {{ Request::is('documentos') ? 'active' : '' }}" href="{{ url('documentos') }}">
                    <div
                        class="icon icon-shape icon-sm shadow border-radius-md bg-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i style="font-size: 1rem;"
                            class="fas fa-lg fa-file ps-2 pe-2 text-center text-dark {{ Request::is('files') ? 'text-white' : 'text-dark' }} "
                            aria-hidden="true"></i>
                    </div>
                    <span class="nav-link-text ms-1">Biblioteca</span>
                </a>
            </li>
        </ul>
    </div>
</aside>
