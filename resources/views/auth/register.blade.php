@extends('layouts.guest')

@section('title', 'Daftar Akun – Sistem Persuratan')

@section('content')
<main class="d-flex flex-column justify-content-center vh-100">
    <section>
        <div class="container">
            <div class="row mb-8">
                <div class="col-xl-4 offset-xl-4 col-md-12 col-12">
                    <div class="text-center">
                        <a href="{{ route('login') }}" class="fs-2 fw-bold d-flex align-items-center gap-2 justify-content-center mb-6">
                            <img src="{{ asset('assets/images/brand/logo/logo-icon.svg') }}" alt="Logo" />
                            <span>Sistem Persuratan</span>
                        </a>
                        <h1 class="mb-1">Buat Akun Baru</h1>
                        <p class="mb-0 text-muted">
                            Sudah punya akun?
                            <a href="{{ route('login') }}" class="text-primary">Masuk di sini</a>
                        </p>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-xl-5 col-lg-6 col-md-8 col-12">
                    <div class="card card-lg mb-6">
                        <div class="card-body p-6">

                            @if ($errors->any())
                                <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                                    {{ $errors->first() }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            @endif

                            <form method="POST" action="{{ route('register') }}" class="needs-validation" novalidate>
                                @csrf

                                <!-- Nama Lengkap -->
                                <div class="mb-3">
                                    <label for="name" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="text"
                                               class="form-control @error('name') is-invalid @enderror"
                                               id="name"
                                               name="name"
                                               value="{{ old('name') }}"
                                               required>
                                        <span class="input-group-text bg-transparent border-start-0">
                                            @if($errors->has('name'))
                                                <i class="ti ti-x text-danger"></i>
                                            @elseif(old('name'))
                                                <i class="ti ti-check text-success"></i>
                                            @else
                                                <i class="ti ti-user text-muted"></i>
                                            @endif
                                        </span>
                                    </div>
                                    <div class="invalid-feedback">Harap isi nama lengkap.</div>
                                </div>

                                <!-- Email -->
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email Universitas <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="email"
                                               class="form-control @error('email') is-invalid @enderror"
                                               id="email"
                                               name="email"
                                               value="{{ old('email') }}"
                                               required>
                                        <span class="input-group-text bg-transparent border-start-0">
                                            @if($errors->has('email'))
                                                <i class="ti ti-x text-danger"></i>
                                            @elseif(old('email') && filter_var(old('email'), FILTER_VALIDATE_EMAIL))
                                                <i class="ti ti-check text-success"></i>
                                            @else
                                                <i class="ti ti-mail text-muted"></i>
                                            @endif
                                        </span>
                                    </div>
                                    <small class="form-text text-muted">Contoh: nama@ui.ac.id atau nama@fk.ui.ac.id</small>
                                    <div class="invalid-feedback">Harap masukkan email yang valid.</div>
                                </div>

                                <!-- Role -->
                                <div class="mb-3">
                                    <label class="form-label">Sebagai <span class="text-danger">*</span></label>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="radio" name="role" id="roleMahasiswa" value="mahasiswa" required {{ old('role') == 'mahasiswa' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="roleMahasiswa">Mahasiswa</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="role" id="roleStaff" value="staff" required {{ old('role') == 'staff' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="roleStaff">Staff / Dosen</label>
                                    </div>
                                </div>

                                <!-- NIM (untuk mahasiswa) -->
                                <div id="nimField" class="mb-3" style="{{ old('role') != 'staff' ? '' : 'display:none;' }}">
                                    <label for="nim" class="form-label">NIM <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="text"
                                               class="form-control @error('nim') is-invalid @enderror"
                                               id="nim"
                                               name="nim"
                                               value="{{ old('nim') }}"
                                               placeholder="Contoh: 2306123456">
                                        <span class="input-group-text bg-transparent border-start-0">
                                            @if($errors->has('nim'))
                                                <i class="ti ti-x text-danger"></i>
                                            @elseif(old('nim'))
                                                <i class="ti ti-hash text-success"></i>
                                            @else
                                                <i class="ti ti-hash text-muted"></i>
                                            @endif
                                        </span>
                                    </div>
                                    <div class="invalid-feedback">NIM wajib diisi untuk mahasiswa.</div>
                                </div>

                                <!-- NIP (untuk staff) -->
                                <div id="nipField" class="mb-3" style="{{ old('role') == 'staff' ? '' : 'display:none;' }}">
                                    <label for="nip" class="form-label">NIP <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <input type="text"
                                               class="form-control @error('nip') is-invalid @enderror"
                                               id="nip"
                                               name="nip"
                                               value="{{ old('nip') }}"
                                               placeholder="Nomor Induk Pegawai">
                                        <span class="input-group-text bg-transparent border-start-0">
                                            @if($errors->has('nip'))
                                                <i class="ti ti-x text-danger"></i>
                                            @elseif(old('nip'))
                                                <i class="ti ti-id text-success"></i>
                                            @else
                                                <i class="ti ti-id text-muted"></i>
                                            @endif
                                        </span>
                                    </div>
                                    <div class="invalid-feedback">NIP wajib diisi untuk staff.</div>
                                </div>

                                <!-- Jenjang Pendidikan -->
                                <div id="academicFields" class="mb-3" style="{{ old('role') != 'staff' ? '' : 'display:none;' }}">
                                    <label for="study_level" class="form-label">Jenjang Pendidikan <span class="text-danger">*</span></label>
                                    <select name="study_level" id="study_level" class="form-select" required>
                                        <option value="">-- Pilih Jenjang --</option>
                                        <option value="s1" {{ old('study_level') == 's1' ? 'selected' : '' }}>S1</option>
                                        <option value="s2" {{ old('study_level') == 's2' ? 'selected' : '' }}>S2</option>
                                        <option value="s3" {{ old('study_level') == 's3' ? 'selected' : '' }}>S3</option>
                                    </select>
                                </div>

                                <!-- Semester -->
                                <div id="semesterField" class="mb-3" style="{{ old('role') != 'staff' ? '' : 'display:none;' }}">
                                    <label for="semester" class="form-label">Semester <span class="text-danger">*</span></label>
                                    <select name="semester" id="semester" class="form-select" required>
                                        <option value="">-- Pilih Semester --</option>
                                        @for($i = 1; $i <= 14; $i++)
                                            <option value="{{ $i }}" {{ old('semester') == $i ? 'selected' : '' }}>{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>

                                <!-- Password -->
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                                    <div class="password-field position-relative">
                                        <input type="password"
                                               class="form-control fakePassword @error('password') is-invalid @enderror"
                                               id="password"
                                               name="password"
                                               required 
                                               minlength="8"
                                               style="padding-right: 40px;">
                                        <span class="position-absolute top-50 end-0 translate-middle-y" style="right: 10px !important; z-index: 10;">
                                            <i class="ti ti-eye-off passwordToggler" style="cursor: pointer; font-size: 1.2rem;"></i>
                                        </span>
                                    </div>
                                    <small class="form-text text-muted">Minimal 8 karakter</small>
                                    @error('password')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @else
                                        <div class="invalid-feedback">Password minimal 8 karakter.</div>
                                    @enderror
                                </div>

                                <!-- Konfirmasi Password -->
                                <div class="mb-4">
                                    <label for="password_confirmation" class="form-label">Konfirmasi Password <span class="text-danger">*</span></label>
                                    <div class="password-field position-relative">
                                        <input type="password"
                                               class="form-control fakePassword @error('password_confirmation') is-invalid @enderror"
                                               id="password_confirmation"
                                               name="password_confirmation"
                                               required
                                               style="padding-right: 40px;">
                                        <span class="position-absolute top-50 end-0 translate-middle-y" style="right: 10px !important; z-index: 10;">
                                            <i class="ti ti-eye-off passwordToggler" style="cursor: pointer; font-size: 1.2rem;"></i>
                                        </span>
                                    </div>
                                    @error('password_confirmation')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @else
                                        <div class="invalid-feedback">Konfirmasi password tidak cocok.</div>
                                    @enderror
                                </div>

                                <div class="d-grid">
                                    <button class="btn btn-primary" type="submit">Daftar Akun</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Theme Toggle -->
    <div class="position-absolute end-0 bottom-0 m-4">
        <div class="dropdown">
            <button class="btn btn-light btn-icon rounded-circle d-flex align-items-center" type="button" aria-expanded="false" data-bs-toggle="dropdown" aria-label="Toggle theme (auto)">
                <i class="bi theme-icon-active lh-1"><i class="bi theme-icon bi-sun-fill"></i></i>
                <span class="visually-hidden bs-theme-text">Toggle theme</span>
            </button>
            <ul class="dropdown-menu dropdown-menu-end shadow">
                <li>
                    <button type="button" class="dropdown-item d-flex align-items-center active" data-bs-theme-value="light" aria-pressed="true">
                        <i class="ti theme-icon ti ti-sun"></i>
                        <span class="ms-2">Light</span>
                    </button>
                </li>
                <li>
                    <button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="dark" aria-pressed="false">
                        <i class="ti theme-icon ti-moon-stars"></i>
                        <span class="ms-2">Dark</span>
                    </button>
                </li>
                <li>
                    <button type="button" class="dropdown-item d-flex align-items-center" data-bs-theme-value="auto" aria-pressed="false">
                        <i class="ti theme-icon ti-circle-half-2"></i>
                        <span class="ms-2">Auto</span>
                    </button>
                </li>
            </ul>
        </div>
    </div>
</main>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const roleMahasiswa = document.getElementById('roleMahasiswa');
    const roleStaff = document.getElementById('roleStaff');
    const nimField = document.getElementById('nimField');
    const nipField = document.getElementById('nipField');
    const academicFields = document.getElementById('academicFields');
    const semesterField = document.getElementById('semesterField');

    function toggleFields() {
        if (roleMahasiswa.checked) {
            nimField.style.display = 'block';
            nipField.style.display = 'none';
            academicFields.style.display = 'block';
            semesterField.style.display = 'block';

            // Pastikan NIP kosong (agar tidak ikut dikirim)
            document.getElementById('nip').value = '';
        } else if (roleStaff.checked) {
            nimField.style.display = 'none';
            nipField.style.display = 'block';
            academicFields.style.display = 'none';
            semesterField.style.display = 'none';

            // Pastikan NIM & akademik kosong
            document.getElementById('nim').value = '';
            document.getElementById('study_level').value = '';
            document.getElementById('semester').value = '';
        }
    }

    roleMahasiswa.addEventListener('change', toggleFields);
    roleStaff.addEventListener('change', toggleFields);

    // Inisialisasi awal
    toggleFields();
});
</script>
@endpush