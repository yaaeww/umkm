<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Belanjain</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="login-page d-flex align-items-center justify-content-center" style="min-height: 100vh; background-color: #f7f7f7;">
        <div class="card shadow p-4" style="width: 100%; max-width: 420px;">
            <div class="text-center mb-4">
                <h4 class="mb-1">Login ke Belanjain</h4>
                <p class="text-muted small">Masukkan email dan password Anda</p>
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-3" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Address -->
                <div class="mb-3">
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="form-control mt-1" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="text-danger small mt-1" />
                </div>

                <!-- Password -->
                <div class="mb-3">
                    <x-input-label for="password" :value="__('Password')" />
                    <x-text-input id="password" class="form-control mt-1" type="password" name="password" required autocomplete="current-password" />
                    <x-input-error :messages="$errors->get('password')" class="text-danger small mt-1" />
                </div>

                <!-- Remember Me -->
                <div class="form-check mb-3">
                    <input id="remember_me" type="checkbox" class="form-check-input" name="remember">
                    <label class="form-check-label" for="remember_me">
                        {{ __('Remember me') }}
                    </label>
                </div>

                <!-- Submit & Forgot Password -->
                <div class="d-flex justify-content-between align-items-center mb-3">
                    @if (Route::has('password.request'))
                        <a class="text-decoration-none small" href="{{ route('password.request') }}">
                            {{ __('Forgot your password?') }}
                        </a>
                    @endif

                    <x-primary-button class="btn btn-primary">
                        {{ __('Log in') }}
                    </x-primary-button>
                </div>
            </form>

            <!-- Link to Register -->
            <div class="text-center mt-3">
                <p class="small">
                    Belum punya akun? 
                    <a href="{{ route('register') }}" class="text-decoration-none">
                        Daftar di sini
                    </a>
                </p>
            </div>
        </div>
    </div>
</body>
</html>
