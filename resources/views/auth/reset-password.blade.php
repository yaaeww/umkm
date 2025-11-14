<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - Belanjain</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body,
        html {
            height: 100%;
            margin: 0;
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #0f0f1e 0%, #1a1a2e 50%, #16213e 100%);
        }

        .bg-cover {
            min-height: 100vh;
            position: relative;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
        }

        .animated-bg {
            position: absolute;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 0;
        }

        .animated-bg::before,
        .animated-bg::after {
            content: '';
            position: absolute;
            width: 500px;
            height: 500px;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.15;
            animation: float 20s infinite ease-in-out;
        }

        .animated-bg::before {
            background: linear-gradient(45deg, #ff5c8a, #a855f7);
            top: -10%;
            left: -10%;
            animation-delay: 0s;
        }

        .animated-bg::after {
            background: linear-gradient(45deg, #3b82f6, #06b6d4);
            bottom: -10%;
            right: -10%;
            animation-delay: 5s;
        }

        @keyframes float {

            0%,
            100% {
                transform: translate(0, 0) scale(1);
            }

            33% {
                transform: translate(30px, -30px) scale(1.1);
            }

            66% {
                transform: translate(-20px, 20px) scale(0.9);
            }
        }

        .reset-container {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 440px;
        }

        .login-form {
            background: rgba(30, 30, 46, 0.7);
            border-radius: 24px;
            padding: 3rem 2.5rem;
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.4);
        }

        .logo-container {
            text-align: center;
            margin-bottom: 2rem;
        }

        .logo-container img {
            width: 80px;
            height: 80px;
            margin-bottom: 1rem;
            filter: drop-shadow(0 4px 12px rgba(255, 92, 138, 0.3));
        }

        .logo-container h5 {
            font-size: 1.75rem;
            font-weight: 700;
            margin: 0;
            background: linear-gradient(135deg, #fff 0%, #e5e5e5 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .form-control {
            background-color: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: white;
            padding: 0.875rem 1.25rem;
            border-radius: 12px;
            transition: all 0.3s ease;
            font-size: 0.95rem;
        }

        .form-control:focus {
            background-color: rgba(255, 255, 255, 0.08);
            border-color: #ff5c8a;
            box-shadow: 0 0 0 3px rgba(255, 92, 138, 0.15);
            color: white;
        }

        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }

        .form-control.is-invalid {
            border-color: #ef4444;
        }

        .btn-login {
            background: linear-gradient(135deg, #ff5c8a 0%, #ff3366 100%);
            border: none;
            padding: 0.875rem;
            width: 100%;
            font-weight: 600;
            border-radius: 12px;
            transition: all 0.3s ease;
            font-size: 1rem;
            letter-spacing: 0.5px;
            box-shadow: 0 4px 15px rgba(255, 92, 138, 0.3);
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255, 92, 138, 0.4);
            background: linear-gradient(135deg, #ff3366 0%, #ff5c8a 100%);
        }

        .top-nav {
            position: absolute;
            top: 2rem;
            right: 2rem;
            display: flex;
            gap: 1.5rem;
            z-index: 10;
        }

        .top-nav a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 500;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .top-nav a:hover {
            color: #fff;
            background: rgba(255, 255, 255, 0.1);
        }

        .bottom-links {
            font-size: 0.875rem;
            text-align: center;
            margin-top: 1.5rem;
            padding-top: 1.5rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .bottom-links a {
            color: #ff5c8a;
            text-decoration: none;
            transition: color 0.3s ease;
            font-weight: 500;
        }

        .bottom-links a:hover {
            color: #ff3366;
            text-decoration: underline;
        }

        .alert {
            border-radius: 12px;
            border: none;
            padding: 1rem;
            font-size: 0.875rem;
            margin-bottom: 1.5rem;
        }

        .alert-success {
            background: rgba(34, 197, 94, 0.15) !important;
            color: #86efac !important;
            border: 1px solid rgba(34, 197, 94, 0.3) !important;
        }

        .alert-danger {
            background: rgba(239, 68, 68, 0.15) !important;
            color: #fca5a5 !important;
            border: 1px solid rgba(239, 68, 68, 0.3) !important;
        }

        .alert ul {
            margin: 0;
            padding-left: 1.25rem;
        }

        .alert ul li {
            margin-bottom: 0.25rem;
        }

        .alert ul li:last-child {
            margin-bottom: 0;
        }

        @media (max-width: 576px) {
            .login-form {
                padding: 2rem 1.5rem;
            }

            .top-nav {
                top: 1rem;
                right: 1rem;
                gap: 0.75rem;
            }

            .top-nav a {
                font-size: 0.85rem;
                padding: 0.4rem 0.75rem;
            }
        }
    </style>
</head>

<body>
    <div class="bg-cover">
        <div class="animated-bg"></div>

        <!-- Top Nav -->
        <div class="top-nav">
            <a href="/">Beranda</a>
            <a href="{{ route('login') }}">Login</a>
            <a href="{{ route('register') }}">Daftar</a>
        </div>

        <!-- Reset Password Container -->
        <div class="reset-container">
            <div class="login-form">
                <div class="logo-container">
                    <img src="{{ asset('aset/finalisasi logo.png') }}" alt="Logo Belanjain">
                    <h5>Reset Password</h5>
                </div>

                @if (session('status'))
                    <div class="alert alert-success">
                        ✓ {{ session('status') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('password.store') }}">
                    @csrf

                    <input type="hidden" name="token" value="{{ request()->route('token') }}">

                    <!-- Email -->
                    <div class="mb-3">
                        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                            value="{{ old('email', request('email')) }}" placeholder="Email" required autofocus>
                    </div>

                    <!-- Password Baru -->
                    <div class="mb-3">
                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                            name="password" placeholder="Password Baru" required>
                    </div>

                    <!-- Konfirmasi Password -->
                    <div class="mb-4">
                        <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror"
                            name="password_confirmation" placeholder="Konfirmasi Password" required>
                    </div>

                    <button type="submit" class="btn btn-login text-white">RESET PASSWORD</button>

                    <div class="bottom-links">
                        <a href="{{ route('login') }}">← Kembali ke Login</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>