<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - Sisfo Perpustakaan</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @stack('styles')
</head>
<body>
    <div class="app-shell">
        @include('partials.sidebar')

        <div class="sidebar-overlay" data-toggle="sidebar"></div>

        <div class="app-main">
            @include('partials.topbar')

            <main class="app-content">
                @if (session('success'))
                    <div class="alert-system alert-success-system" data-autohide>
                        <i class="bi bi-check-lg"></i> {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert-system alert-error-system" data-autohide>
                        <i class="bi bi-exclamation-circle"></i> {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    @stack('scripts')
</body>
</html>


