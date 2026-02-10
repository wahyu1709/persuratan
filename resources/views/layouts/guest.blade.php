<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta content="Codescandy" name="author" />
    <title>@yield('title', 'Sistem Persuratan')</title>

    <!-- Favicon -->
    @foreach(['57','60','72','76','114','120','144','152','180'] as $size)
        <link rel="apple-touch-icon" sizes="{{ $size }}x{{ $size }}" href="{{ asset("assets/images/favicon/apple-icon-{$size}x{$size}.png") }}" />
    @endforeach
    @foreach(['192','32','96','16'] as $size)
        <link rel="icon" type="image/png" sizes="{{ $size }}x{{ $size }}" href="{{ asset("assets/images/favicon/android-icon-{$size}x{$size}.png") }}" />
    @endforeach

    <meta name="msapplication-TileColor" content="#ffffff" />
    <meta name="theme-color" content="#ffffff" />

    <!-- Color modes -->
    <script src="{{ asset('assets/js/vendors/color-modes.js') }}"></script>
    <script>
        if (localStorage.getItem('sidebarExpanded') === 'false') {
            document.documentElement.classList.add('collapsed');
            document.documentElement.classList.remove('expanded');
        } else {
            document.documentElement.classList.remove('collapsed');
            document.documentElement.classList.add('expanded');
        }
    </script>

    <!-- Fonts & Libs -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700;800&display=swap" />
    <link rel="stylesheet" href="{{ asset('assets/libs/simplebar/dist/simplebar.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/libs/@tabler/icons-webfont/tabler-icons.min.css') }}" />

    <!-- Theme CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/theme.min.css') }}">
</head>
<body>
    @yield('content')

    <!-- Libs JS -->
    <script src="{{ asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/libs/simplebar/dist/simplebar.min.js') }}"></script>

    <!-- Theme JS -->
    <script src="{{ asset('assets/js/theme.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendors/password.js') }}"></script>

    @stack('scripts')
</body>
</html>