<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sisfo Perpustakaan</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tabler-icons/3.1.0/iconfont/tabler-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div class="login-shell">
        <div class="login-card">
            <div class="text-center mb-4">
                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="mx-auto mb-3">
                    <path d="M12 2L13.5 10.5L22 12L13.5 13.5L12 22L10.5 13.5L2 12L10.5 10.5L12 2Z" fill="#cc785c"/>
                </svg>
                <h2 class="font-display mb-1">Sisfo Perpustakaan</h2>
                <h2 class="font-display mb-1">SMA N 1 Kretek</h2>
                <p class="text-muted-custom" style="font-size: 14px;">Masuk sebagai admin untuk mengelola perpustakaan</p>
            </div>

            @if ($errors->any())
                <div class="alert-system alert-error-system">
                    <i class="bi bi-exclamation-circle"></i> {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('login.attempt') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="admin@perpus.test" required autofocus>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="••••••••" required>
                </div>

                <div class="form-check mb-4">
                    <input type="checkbox" name="remember" id="remember" class="form-check-input">
                    <label for="remember" class="form-check-label" style="font-size: 14px; color: var(--color-muted);">Ingat saya</label>
                </div>

                <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-box-arrow-in-right"></i> Masuk
                </button>
            </form>
        </div>
    </div>
</body>
</html>


