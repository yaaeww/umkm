<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - UMKM Indramayu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        :root {
            --dark-blue: #0a1628;
            --medium-blue: #1a3a5f;
            --light-blue: #2a4a7f;
            --gold: #ffd700;
            --gold-light: #ffed4e;
            --gold-dark: #d4af37;
        }

        body,
        html {
            height: 100%;
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, var(--dark-blue) 0%, var(--medium-blue) 50%, var(--light-blue) 100%);
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
            background: linear-gradient(45deg, var(--gold), var(--gold-light));
            top: -10%;
            left: -10%;
            animation-delay: 0s;
        }

        .animated-bg::after {
            background: linear-gradient(45deg, var(--light-blue), var(--medium-blue));
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

        .login-container {
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
            filter: drop-shadow(0 4px 12px rgba(255, 215, 0, 0.3));
        }

        .logo-container h2 {
            font-size: 1.75rem;
            font-weight: 700;
            margin: 0;
            background: linear-gradient(135deg, var(--gold) 0%, var(--gold-light) 100%);
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
            border-color: var(--gold);
            box-shadow: 0 0 0 3px rgba(255, 215, 0, 0.15);
            color: white;
        }

        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }

        .form-control.is-invalid {
            border-color: #ef4444;
        }

        .btn-login {
            background: linear-gradient(135deg, var(--gold) 0%, var(--gold-light) 100%);
            border: none;
            padding: 0.875rem;
            width: 100%;
            font-weight: 600;
            border-radius: 12px;
            transition: all 0.3s ease;
            font-size: 1rem;
            letter-spacing: 0.5px;
            box-shadow: 0 4px 15px rgba(255, 215, 0, 0.3);
            color: var(--dark-blue);
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255, 215, 0, 0.4);
            background: linear-gradient(135deg, var(--gold-light) 0%, var(--gold) 100%);
            color: var(--dark-blue);
        }

        .divider {
            display: flex;
            align-items: center;
            text-align: center;
            margin: 1.5rem 0;
            color: rgba(255, 255, 255, 0.5);
            font-size: 0.875rem;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .divider span {
            padding: 0 1rem;
        }

        .btn-google {
            background: rgba(255, 255, 255, 0.05);
            color: #fff;
            border: 1px solid rgba(255, 255, 255, 0.1);
            width: 100%;
            font-weight: 500;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 0.875rem;
            border-radius: 12px;
            transition: all 0.3s ease;
        }

        .btn-google:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: rgba(255, 255, 255, 0.2);
            transform: translateY(-2px);
        }

        .btn-google img {
            width: 20px;
            height: 20px;
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
            transition: color 0.3s ease;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .top-nav a:hover {
            color: var(--gold);
            background: rgba(255, 255, 255, 0.1);
        }

        .bottom-links {
            font-size: 0.875rem;
            color: rgba(255, 255, 255, 0.7);
        }

        .bottom-links a {
            color: var(--gold);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .bottom-links a:hover {
            color: var(--gold-light);
            text-decoration: underline;
        }

        .checkbox-wrapper {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .checkbox-wrapper input[type="checkbox"] {
            width: 18px;
            height: 18px;
            accent-color: var(--gold);
            cursor: pointer;
        }

        .checkbox-wrapper label {
            margin: 0;
            cursor: pointer;
            user-select: none;
        }

        .alert {
            border-radius: 12px;
            border: none;
            padding: 1rem;
            font-size: 0.875rem;
        }

        .alert-danger {
            background: rgba(239, 68, 68, 0.15);
            color: #fca5a5;
            border: 1px solid rgba(239, 68, 68, 0.3);
        }

        .signup-link {
            text-align: center;
            margin-top: 1.5rem;
            padding-top: 1.5rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        /* Sparkle effect */
        .sparkle {
            position: absolute;
            width: 100%;
            height: 100%;
            pointer-events: none;
            overflow: hidden;
        }

        @keyframes sparkleFloat {

            0%,
            100% {
                transform: translateY(0) scale(1);
                opacity: 0;
            }

            50% {
                transform: translateY(-30px) scale(1.5);
                opacity: 1;
            }
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
        <div class="sparkle"></div>

        <!-- Top Nav -->
        <div class="top-nav">
            <a href="#" style="color: var(--gold); background: rgba(255, 215, 0, 0.1);">Login</a>
            <a href="/">Beranda</a>
            <a href="{{ route('register') }}">Daftar</a>
        </div>

        <!-- Login Container -->
        <div class="login-container">
            <div class="login-form">
                <div class="logo-container">
                    <img src="{{ asset('aset/finalisasi logo.png') }}" alt="Logo UMKM Indramayu">
                    <h2>UMKM Indramayu</h2>
                </div>

                {{-- Notifikasi Error dari Session --}}
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif

                {{-- Validasi Error --}}
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0 ps-3">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="mb-3">
                        <input type="email" class="form-control @error('email') is-invalid @enderror" name="email"
                            placeholder="Email" value="{{ old('email') }}" required autofocus>
                    </div>

                    <div class="mb-4">
                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                            name="password" placeholder="Password" required>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-4 bottom-links">
                        <div class="checkbox-wrapper">
                            <input type="checkbox" id="remember" name="remember">
                            <label for="remember">Ingat saya</label>
                        </div>
                        <a href="{{ route('password.request') }}">Lupa password?</a>
                    </div>

                    <button type="submit" class="btn btn-login">MASUK</button>

                    <div class="divider">
                        <span>atau</span>
                    </div>

                    <!-- LOGIN GOOGLE -->
                    <a href="{{ route('auth.google') }}" class="btn btn-google">
                        <img src="https://developers.google.com/identity/images/g-logo.png" alt="Google">
                        <span>Masuk dengan Google</span>
                    </a>

                    <div class="signup-link bottom-links">
                        Belum punya akun? <a href="{{ route('register') }}">Daftar sekarang</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Add sparkle animation on page load
        window.addEventListener('load', () => {
            const bgCover = document.querySelector('.bg-cover');
            setInterval(() => {
                const sparkle = document.createElement('div');
                sparkle.style.position = 'absolute';
                sparkle.style.width = '4px';
                sparkle.style.height = '4px';
                sparkle.style.background = '#ffd700';
                sparkle.style.borderRadius = '50%';
                sparkle.style.boxShadow = '0 0 10px #ffd700';
                sparkle.style.left = Math.random() * 100 + '%';
                sparkle.style.top = Math.random() * 100 + '%';
                sparkle.style.animation = 'sparkleFloat 2s forwards';
                sparkle.style.pointerEvents = 'none';
                bgCover.appendChild(sparkle);

                setTimeout(() => sparkle.remove(), 2000);
            }, 500);
        });
    </script>
</body>

</html>