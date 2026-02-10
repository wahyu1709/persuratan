<div class="navbar-glass navbar navbar-expand-lg px-0 px-lg-4">
    <div class="container-fluid px-lg-0">
        <div class="d-flex align-items-center gap-4">
            <div class="d-block d-lg-none">
                <a class="text-inherit" data-bs-toggle="offcanvas" href="#offcanvasExample" role="button">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-menu-2">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M4 6l16 0" />
                        <path d="M4 12l16 0" />
                        <path d="M4 18l16 0" />
                    </svg>
                </a>
            </div>
        </div>
        <div class="d-none d-lg-block">
            <a class="sidebar-toggle d-flex texttooltip p-3" href="javascript:void(0)" data-template="collapseMessage">
            <span class="collapse-mini">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-bar-left text-secondary">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M4 12l10 0" />
                <path d="M4 12l4 4" />
                <path d="M4 12l4 -4" />
                <path d="M20 4l0 16" />
                </svg>
            </span>
            <span class="collapse-expanded">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-bar-right text-secondary">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M20 12l-10 0" />
                <path d="M20 12l-4 4" />
                <path d="M20 12l-4 -4" />
                <path d="M4 4l0 16" />
                </svg>
                <div id="collapseMessage" class="d-none">
                <span class="small">Collapse</span>
                </div>
            </span>
            </a>
        </div>

        <ul class="list-unstyled d-flex align-items-center mb-0 gap-2 ms-auto">
            <!-- Theme Toggle -->
            <li>
                <div class="dropdown">
                    <button class="btn btn-ghost btn-icon rounded-circle d-flex align-items-center" type="button" data-bs-toggle="dropdown">
                        <i class="ti theme-icon-active lh-1 fs-5"><i class="ti theme-icon ti-sun"></i></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow">
                        <li><button type="button" class="dropdown-item d-flex align-items-center active" data-bs-theme-value="light"><i class="ti ti-sun"></i><span class="ms-2">Light</span></button></li>
                        <li><button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="dark"><i class="ti ti-moon-stars"></i><span class="ms-2">Dark</span></button></li>
                        <li><button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="auto"><i class="ti ti-circle-half-2"></i><span class="ms-2">Auto</span></button></li>
                    </ul>
                </div>
            </li>

            <!-- User Dropdown -->
            <li class="ms-3 dropdown">
                <a href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <img src="{{ asset('assets/images/avatar/avatar-1.jpg') }}" alt="Avatar" class="avatar avatar-sm rounded-circle" />
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-md p-0">
                    <div class="p-3 d-flex flex-column gap-1">
                        <a href="#" class="dropdown-item d-flex align-items-center gap-2">
                            <i class="ti ti-user"></i> <span>Profil</span>
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item d-flex align-items-center gap-2 text-danger">
                                <i class="ti ti-logout"></i> <span>Logout</span>
                            </button>
                        </form>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</div>