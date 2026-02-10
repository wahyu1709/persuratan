@extends('layouts.guest')

@section('title', 'Login – Sistem Persuratan')

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
                        <h1 class="mb-1">Welcome Back</h1>
                        <p class="mb-0 text-muted">
                            Don't have an account yet?
                            <a href="{{ route('register') }}" class="text-primary">Register here</a>
                        </p>
                    </div>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-xl-5 col-lg-6 col-md-8 col-12">
                    <div class="card card-lg mb-6">
                        <div class="card-body p-6">

                            @if ($errors->any())
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    {{ $errors->first() }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                </div>
                            @endif

                            <form method="POST" action="{{ route('login') }}" class="needs-validation" novalidate>
                                @csrf

                                <!-- Email -->
                                <div class="mb-3">
                                    <label for="signinEmailInput" class="form-label">
                                        Email
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="input-group">
                                        <input
                                            type="email"
                                            class="form-control @error('email') is-invalid @enderror"
                                            id="signinEmailInput"
                                            name="email"
                                            value="{{ old('email') }}"
                                            required
                                            autofocus
                                        />
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
                                    <div class="invalid-feedback">Please enter a valid email.</div>
                                </div>

                                <!-- Password -->
                                <div class="mb-3">
                                    <label for="formSignUpPassword" class="form-label">
                                        Password
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="password-field position-relative">
                                        <input
                                            type="password"
                                            class="form-control fakePassword @error('password') is-invalid @enderror"
                                            id="formSignUpPassword"
                                            name="password"
                                            required
                                            style="padding-right: 40px;"
                                        />
                                        <span class="position-absolute top-50 end-0 translate-middle-y" style="right: 10px !important; z-index: 10;">
                                            <i class="ti ti-eye-off passwordToggler" style="cursor: pointer; font-size: 1.2rem;"></i>
                                        </span>
                                    </div>
                                    @error('password')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @else
                                        <div class="invalid-feedback">Please enter your password.</div>
                                    @enderror
                                </div>

                                <!-- Remember me + Forgot Password -->
                                <div class="mb-4 d-flex align-items-center justify-content-between">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="rememberMeCheckbox" {{ old('remember') ? 'checked' : '' }}>
                                        <label class="form-check-label" for="rememberMeCheckbox">Remember me</label>
                                    </div>
                                    {{-- Tempat untuk "Forgot Password" nanti --}}
                                </div>

                                <div class="d-grid">
                                    <button class="btn btn-primary" type="submit">Sign In</button>
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
<!-- Validasi Bootstrap -->
<script>
    (function () {
        'use strict';
        var forms = document.querySelectorAll('.needs-validation');
        Array.prototype.slice.call(forms).forEach(function (form) {
            form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    })();
</script>
@endpush
@endsection