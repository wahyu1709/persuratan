<!-- Vertical Sidebar -->
<div id="miniSidebar">
    <div class="brand-logo">
        <a class="d-none d-md-flex align-items-center gap-2" href="{{ route('dashboard') }}">
            <img src="{{ asset('assets/images/brand/logo/logo-icon.svg') }}" alt="Logo" />
            <span class="fw-bold fs-4 site-logo-text">Persuratan</span>
        </a>
    </div>
    <ul class="navbar-nav flex-column">
        @if(auth()->user()->isStudent())
            <li class="nav-item">
                <a class="nav-link" href="{{ route('letters.my') }}">
                    <span class="nav-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-file-text">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                            <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
                            <path d="M9 9l1 0" />
                            <path d="M9 13l6 0" />
                            <path d="M9 17l6 0" />
                        </svg>
                    </span>
                    <span class="text">Surat Saya</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('letters.create') }}">
                    <span class="nav-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-plus">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M12 5l0 14" />
                            <path d="M5 12l14 0" />
                        </svg>
                    </span>
                    <span class="text">Ajukan Surat</span>
                </a>
            </li>
        @else
            {{-- Staff / Ketua Divisi --}}
            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.letters.index') }}">
                    <span class="nav-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-inbox">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M4 4m0 2a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2z" />
                            <path d="M4 13h3l3 3h4l3 -3h3" />
                        </svg>
                    </span>
                    <span class="text">Kelola Surat</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="{{ route('admin.letters.history') }}">
                    <span class="nav-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-users">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                            <path d="M4 4m0 2a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2z" />
                            <path d="M4 13h3l3 3h4l3 -3h3" />
                        </svg>
                    </span>
                    <span class="text">Riwayat Surat</span>
                </a>
            </li>

            @if(auth()->user()->isDivisionHead())
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <span class="nav-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-users">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                <path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" />
                                <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                                <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                                <path d="M21 21v-2a4 4 0 0 0 -3 -3.85" />
                            </svg>
                        </span>
                        <span class="text">Kelola Staff</span>
                    </a>
                </li>
            @endif
        @endif

        <li class="mt-auto">
            <div class="text-center py-5 upgrade-ui">
                <div>
                    <img src="{{ asset('assets/images/avatar/avatar-1.jpg') }}" alt="User" class="avatar avatar-md rounded-circle">
                    <div class="my-3">
                        <h5 class="mb-1 fs-6">{{ auth()->user()->name }}</h5>
                        <span class="text-secondary">
                            @if(auth()->user()->isStudent()) Mahasiswa
                            @elseif(auth()->user()->isDivisionHead()) Ketua Divisi
                            @else Staff @endif
                        </span>
                    </div>
                </div>
            </div>
        </li>
    </ul>
</div>