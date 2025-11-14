<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Tipe Akun - UMKM Indramayu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

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
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, var(--dark-blue) 0%, var(--medium-blue) 50%, var(--light-blue) 100%);
        }

        .register-page {
            min-height: 100vh;
            position: relative;
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

        .register-container {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 480px;
        }

        .card {
            background: rgba(30, 30, 46, 0.7);
            border-radius: 24px;
            padding: 3rem 2.5rem;
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.4);
            color: white;
        }

        .card h4 {
            font-size: 1.75rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            background: linear-gradient(135deg, var(--gold) 0%, var(--gold-light) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .text-muted {
            color: rgba(255, 255, 255, 0.6) !important;
        }

        /* Role Selection */
        .role-option {
            background: rgba(255, 255, 255, 0.05);
            border: 2px solid rgba(255, 255, 255, 0.1) !important;
            border-radius: 16px;
            padding: 1.5rem 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .role-option::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(255, 215, 0, 0.1), rgba(255, 237, 78, 0.1));
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .role-option:hover::before {
            opacity: 1;
        }

        .role-option:hover {
            transform: translateY(-4px);
            border-color: rgba(255, 215, 0, 0.5) !important;
            box-shadow: 0 8px 24px rgba(255, 215, 0, 0.2);
        }

        .role-option.active {
            border-color: var(--gold) !important;
            background: linear-gradient(135deg, rgba(255, 215, 0, 0.15), rgba(255, 237, 78, 0.15));
            box-shadow: 0 8px 32px rgba(255, 215, 0, 0.3);
        }

        .role-option.active::after {
            content: '✓';
            position: absolute;
            top: 10px;
            right: 10px;
            width: 24px;
            height: 24px;
            background: var(--gold);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--dark-blue);
            font-weight: bold;
            font-size: 14px;
        }

        .role-option img {
            height: 60px;
            width: 60px;
            border-radius: 50%;
            margin-bottom: 0.75rem;
            object-fit: cover;
            border: 2px solid rgba(255, 255, 255, 0.1);
        }

        .role-option p {
            color: white;
            font-weight: 600;
            margin: 0;
            font-size: 1rem;
        }

        /* Form Inputs */
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

        /* Buttons */
        .btn-primary {
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

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255, 215, 0, 0.4);
            background: linear-gradient(135deg, var(--gold-light) 0%, var(--gold) 100%);
            color: var(--dark-blue);
        }

        .btn-google {
            background: rgba(255, 255, 255, 0.05);
            color: #fff;
            border: 1px solid rgba(255, 255, 255, 0.1);
            width: 100%;
            font-weight: 500;
            padding: 0.875rem;
            border-radius: 12px;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .btn-google:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: rgba(255, 255, 255, 0.2);
            transform: translateY(-2px);
            color: white;
        }

        .btn-google img {
            width: 20px;
            height: 20px;
        }

        /* Divider */
        .divider {
            display: flex;
            align-items: center;
            margin: 1.5rem 0;
            color: rgba(255, 255, 255, 0.5);
            font-size: 0.875rem;
        }

        .divider hr {
            flex: 1;
            border: none;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            margin: 0;
        }

        .divider span {
            padding: 0 1rem;
        }

        /* Links */
        a {
            color: var(--gold);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        a:hover {
            color: var(--gold-light);
            text-decoration: underline;
        }

        /* Error Messages */
        .text-danger {
            color: #fca5a5 !important;
            font-size: 0.875rem;
            display: block;
            margin-top: 0.25rem;
        }

        /* Top Navigation */
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

        /* Responsive */
        @media (max-width: 576px) {
            .card {
                padding: 2rem 1.5rem;
            }

            .role-option {
                padding: 1.25rem 0.75rem;
            }

            .role-option img {
                height: 50px;
                width: 50px;
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
    <div class="register-page">
        <div class="animated-bg"></div>
        <div class="sparkle"></div>

        <!-- Top Navigation -->
        <div class="top-nav">
            <a href="{{ route('login') }}">Login</a>
            <a href="/">Beranda</a>
            <a href="#" style="color: var(--gold); background: rgba(255, 215, 0, 0.1);">Daftar</a>
        </div>

        <div class="register-container">
            <div class="card">
                <div class="text-center mb-4">
                    <h4>Pilih Tipe Akun</h4>
                    <p class="text-muted small">Silakan isi formulir di bawah untuk mendaftar</p>
                </div>

                <div class="d-flex justify-content-between mb-4 gap-3">
                    <div class="role-option text-center flex-fill {{ old('role') == 'penjual' ? 'active' : '' }}"
                        data-role="penjual">
                        <img src="{{ asset('aset/iconpenjual.png') }}" alt="Penjual">
                        <p>Penjual</p>
                    </div>
                    <div class="role-option text-center flex-fill {{ old('role') == 'pembeli' ? 'active' : '' }}"
                        data-role="pembeli">
                        <img src="{{ asset('aset/iconpembeli.jpg') }}" alt="Pembeli">
                        <p>Pembeli</p>
                    </div>
                </div>

                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <input type="hidden" name="role" id="roleInput" value="{{ old('role') }}">

                    <div class="mb-3">
                        <input id="name" class="form-control @error('name') is-invalid @enderror" type="text"
                            name="name" placeholder="Nama Lengkap" value="{{ old('name') }}" required autofocus />
                        @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3">
                        <input id="email" class="form-control @error('email') is-invalid @enderror" type="email"
                            name="email" placeholder="Email" value="{{ old('email') }}" required />
                        @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-3">
                        <input id="password" class="form-control @error('password') is-invalid @enderror"
                            type="password" name="password" placeholder="Password" required />
                        @error('password') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <div class="mb-4">
                        <input id="password_confirmation"
                            class="form-control @error('password_confirmation') is-invalid @enderror" type="password"
                            name="password_confirmation" placeholder="Konfirmasi Password" required />
                        @error('password_confirmation') <span class="text-danger">{{ $message }}</span> @enderror
                    </div>

                    <button type="submit" class="btn btn-primary mb-3">
                        <i class="fas fa-user-plus me-2"></i>Daftar
                    </button>

                    <div class="divider">
                        <hr>
                        <span>atau</span>
                        <hr>
                    </div>

                    <a href="{{ route('auth.google') }}" class="btn btn-google mb-3">
                        <img src="https://developers.google.com/identity/images/g-logo.png" alt="Google">
                        <span>Daftar dengan Google</span>
                    </a>

                    <p class="text-center mt-3 small text-muted">
                        Sudah punya akun? <a href="{{ route('login') }}" class="fw-semibold">Login</a>
                    </p>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.querySelectorAll('.role-option').forEach(btn => {
            btn.addEventListener('click', function () {
                const role = this.getAttribute('data-role');
                const roleInput = document.getElementById('roleInput');
                const roleOptions = document.querySelectorAll('.role-option');

                roleInput.value = role;
                roleOptions.forEach(el => el.classList.remove('active'));
                this.classList.add('active');
            });
        });

        document.addEventListener('DOMContentLoaded', () => {
            const initialRole = document.getElementById('roleInput').value;
            if (initialRole) {
                const activeRoleBtn = document.querySelector(`.role-option[data-role="${initialRole}"]`);
                if (activeRoleBtn) {
                    activeRoleBtn.classList.add('active');
                }
            }
        });

        // Add sparkle animation on page load
        window.addEventListener('load', () => {
            const registerPage = document.querySelector('.register-page');
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
                registerPage.appendChild(sparkle);

                setTimeout(() => sparkle.remove(), 2000);
            }, 500);
        });
    </script>
</body>

</html>