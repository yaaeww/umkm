<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'UMKM Indramayu')</title>
    @stack('style')

    <!-- Bootstrap & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <style>
        :root {
            --dark-blue: #0a1628;
            --medium-blue: #1a3a5f;
            --light-blue: #2a4a7f;
            --gold: #ffd700;
            --gold-light: #ffed4e;
            --gold-dark: #d4af37;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, var(--dark-blue) 0%, var(--medium-blue) 100%);
            color: #e0e0e0;
            margin: 0;
            padding: 0;
            position: relative;
            overflow-x: hidden;
        }

        /* Animasi Bintang Kerlap-Kerlip */
        .stars {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 1;
        }

        .star {
            position: absolute;
            background: white;
            border-radius: 50%;
            animation: twinkle linear infinite;
        }

        @keyframes twinkle {

            0%,
            100% {
                opacity: 0;
                transform: scale(0);
            }

            50% {
                opacity: 1;
                transform: scale(1);
            }
        }

        /* Variasi ukuran dan durasi bintang */
        .star.small {
            width: 2px;
            height: 2px;
        }

        .star.medium {
            width: 3px;
            height: 3px;
        }

        .star.large {
            width: 4px;
            height: 4px;
            box-shadow: 0 0 4px rgba(255, 255, 255, 0.8);
        }

        /* Tambahan z-index untuk elemen lain */
        .navbar-custom {
            background: rgba(10, 22, 40, 0.95);
            backdrop-filter: blur(10px);
            padding: 0.75rem 0;
            border-bottom: 2px solid var(--gold);
            box-shadow: 0 4px 20px rgba(255, 215, 0, 0.2);
            position: relative;
            z-index: 1000;
        }

        .navbar-logo {
            height: 40px;
            filter: brightness(1.2);
        }

        .navbar-brand {
            color: var(--gold) !important;
            font-weight: 700;
            font-size: 1.3rem;
            text-shadow: 0 0 10px rgba(255, 215, 0, 0.5);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .navbar-custom .nav-link {
            color: #e0e0e0;
            font-weight: 500;
            margin: 0 5px;
            padding: 6px 12px;
            border-radius: 6px;
            transition: all 0.3s ease;
            font-size: 0.9rem;
        }

        .navbar-custom .nav-link:hover,
        .navbar-custom .nav-link.active {
            color: var(--gold);
            background: rgba(255, 215, 0, 0.1);
            transform: translateY(-2px);
        }

        .form-control {
            background-color: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: white;
            padding: 0.75rem 1rem;
            border-radius: 12px;
            transition: all 0.3s ease;
            font-size: 0.9rem;
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

        .btn-outline-light {
            border: 2px solid rgba(255, 255, 255, 0.3);
            color: white;
            transition: all 0.3s ease;
        }

        .btn-outline-light:hover {
            background: var(--gold);
            border-color: var(--gold);
            color: var(--dark-blue);
            transform: translateY(-2px);
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--gold) 0%, var(--gold-light) 100%);
            border: none;
            color: var(--dark-blue);
            font-weight: 600;
            transition: all 0.3s ease;
            padding: 0.6rem 1.2rem;
            font-size: 0.9rem;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(255, 215, 0, 0.4);
            background: linear-gradient(135deg, var(--gold-light) 0%, var(--gold) 100%);
        }

        .hero-banner {
            background: linear-gradient(135deg, var(--dark-blue) 0%, var(--medium-blue) 50%, var(--light-blue) 100%);
            height: auto;
            min-height: 220px;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: 3%;
            padding: 2rem 1rem;
            z-index: 2;
        }

        .hero-banner::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image:
                radial-gradient(circle at 20% 50%, rgba(255, 215, 0, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(255, 215, 0, 0.1) 0%, transparent 50%);
        }

        .hero-banner-content {
            position: relative;
            z-index: 1;
            color: white;
            text-align: center;
            padding: 0 1rem;
        }

        .hero-banner-content h1 {
            font-size: 1.8rem;
            font-weight: 800;
            margin-bottom: 1rem;
            background: linear-gradient(135deg, var(--gold) 0%, var(--gold-light) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .hero-banner-content p {
            font-size: 1rem;
        }

        .main-content {
            margin-top: 1.5rem;
            position: relative;
            z-index: 2;
            padding: 0 1rem;
        }

        .main-card {
            background: rgba(30, 30, 46, 0.7);
            border-radius: 20px;
            padding: 1.5rem;
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.4);
            color: white;
        }

        footer {
            background: linear-gradient(135deg, var(--dark-blue) 0%, rgba(26, 58, 95, 0.95) 100%);
            color: #fff;
            padding: 1.5rem 0;
            text-align: center;
            margin-top: 3rem;
            border-top: 2px solid var(--gold);
            position: relative;
            z-index: 2;
        }

        .badge.bg-danger {
            background: linear-gradient(135deg, #dc3545, #c82333) !important;
        }

        .badge.bg-warning {
            background: linear-gradient(135deg, var(--gold), var(--gold-light)) !important;
            color: var(--dark-blue) !important;
        }

        .dropdown-menu {
            background: rgba(30, 30, 46, 0.95);
            border: 1px solid rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(20px);
        }

        .dropdown-item {
            color: #e0e0e0;
        }

        .dropdown-item:hover {
            background: rgba(255, 215, 0, 0.1);
            color: var(--gold);
        }

        .dropdown-item.text-danger:hover {
            background: rgba(220, 53, 69, 0.1);
            color: #dc3545 !important;
        }

        /* Responsive adjustments */
        @media (min-width: 576px) {
            .navbar-logo {
                height: 45px;
            }

            .navbar-brand {
                font-size: 1.5rem;
            }

            .hero-banner {
                min-height: 250px;
                padding: 3rem 1rem;
            }

            .hero-banner-content h1 {
                font-size: 2.2rem;
            }

            .main-card {
                padding: 2rem;
                border-radius: 24px;
            }
        }

        @media (min-width: 768px) {
            .navbar-custom {
                padding: 1rem 0;
            }

            .navbar-custom .nav-link {
                margin: 0 10px;
                padding: 8px 16px;
                font-size: 1rem;
            }

            .hero-banner {
                min-height: 300px;
            }

            .hero-banner-content h1 {
                font-size: 2.5rem;
            }

            .btn-primary {
                padding: 0.75rem 1.5rem;
                font-size: 1rem;
            }
        }

        @media (min-width: 992px) {
            .hero-banner {
                padding: 4rem 1rem;
            }

            .main-content {
                margin-top: 2rem;
            }
        }

        @media (max-width: 991.98px) {
            .navbar-nav .nav-item {
                margin-bottom: 0.5rem;
            }

            .navbar-nav .nav-link {
                text-align: center;
            }

            .form-control {
                margin-top: 0.5rem;
                margin-bottom: 0.5rem;
            }

            .navbar-nav.align-items-center {
                flex-direction: row;
                justify-content: center;
                flex-wrap: wrap;
                margin-top: 1rem;
            }

            .navbar-nav.align-items-center .nav-item {
                margin: 0.25rem 0.5rem;
            }
        }

        @media (max-width: 575.98px) {
            .navbar-brand {
                font-size: 1.1rem;
            }

            .navbar-logo {
                height: 35px;
            }

            .hero-banner-content h1 {
                font-size: 1.5rem;
            }

            .hero-banner-content p {
                font-size: 0.9rem;
            }

            .main-card {
                padding: 1rem;
                border-radius: 16px;
            }

            footer .container {
                padding: 0 1rem;
            }

            footer p,
            footer small {
                font-size: 0.85rem;
            }
        }
    </style>
</head>

<body>
    <!-- Layer Bintang -->
    <div class="stars" id="stars"></div>

    {{-- Navbar --}}
    <nav class="navbar navbar-expand-lg navbar-custom fixed-top">
        <div class="container">
            <a class="navbar-brand" href="{{ route('pembeli.dashboard') }}">
                <img src="{{ asset('aset/finalisasi logo.png') }}" alt="UMKM Logo" class="navbar-logo">
                UMKM Indramayu
            </a>

            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                style="background: rgba(255,215,0,0.2);">
                <span class="navbar-toggler-icon" style="filter: brightness(0) invert(1);"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('pembeli.dashboard') ? 'active' : '' }}"
                            href="{{ route('pembeli.dashboard') }}">
                            <i class="fas fa-home me-1"></i>Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('pembeli.produk.index') ? 'active' : '' }}"
                            href="{{ route('pembeli.produk.index') }}">
                            <i class="fas fa-box me-1"></i>Produk
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('pembeli.pesanan.index') ? 'active' : '' }}"
                            href="{{ route('pembeli.pesanan.index') }}">
                            <i class="fas fa-shopping-bag me-1"></i>Pesanan
                        </a>
                    </li>
                </ul>

                <form class="d-flex me-3 mb-2 mb-lg-0" method="GET" action="{{ route('pembeli.dashboard') }}">
                    <input class="form-control me-2" type="search" name="search" placeholder="Cari produk..."
                        value="{{ request('search') }}">
                    <button class="btn btn-outline-light" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </form>

                <ul class="navbar-nav align-items-center">
                    {{-- Keranjang --}}
                    <li class="nav-item me-2 me-lg-3 position-relative">
                        <a class="nav-link" href="{{ route('pembeli.keranjang.index') }}">
                            <i class="fas fa-shopping-cart" style="font-size: 1.3rem;"></i>
                            @if($totalKeranjang > 0)
                                <span
                                    class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                    {{ $totalKeranjang }}
                                </span>
                            @endif
                        </a>
                    </li>

                    {{-- Notifikasi Dikirim --}}
                    <li class="nav-item dropdown me-2 me-lg-3">
                        <a class="nav-link dropdown-toggle position-relative" href="#" role="button"
                            data-bs-toggle="dropdown">
                            <i class="fas fa-truck" style="font-size: 1.3rem;"></i>
                            @if($notifikasiDikirim->count() > 0)
                                <span
                                    class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-warning">
                                    {{ $notifikasiDikirim->count() }}
                                </span>
                            @endif
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            @forelse($notifikasiDikirim as $notif)
                                <li>
                                    <a class="dropdown-item small" href="{{ route('pembeli.pesanan.index') }}">
                                        <i class="fas fa-shipping-fast me-2"></i>Pesanan "{{ $notif->produk->nama }}" sedang
                                        dikirim
                                    </a>
                                </li>
                            @empty
                                <li><span class="dropdown-item text-white">Tidak ada notifikasi</span></li>
                            @endforelse
                        </ul>
                    </li>

                    <!-- Chatbot -->
                    <li class="nav-item me-2 me-lg-3">
                        <a href="{{ route('pembeli.chat.index') }}" class="btn btn-primary">
                            <i class="fas fa-robot me-1"></i>Chatbot
                        </a>
                    </li>

                    {{-- Profil --}}
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white" href="#" data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle me-1"></i>
                            <span class="d-none d-sm-inline">{{ auth()->user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="{{ route('pembeli.profile.show') }}">
                                    <i class="fas fa-user me-2"></i>Profil
                                </a>
                            </li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button class="dropdown-item text-danger" type="submit">
                                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    {{-- Hero Banner --}}
    <section class="hero-banner">
        <div class="hero-banner-content">
            <h1>Selamat Datang di UMKM Indramayu</h1>
            <p class="lead">Belanja Produk UMKM Lokal Lebih Mudah dan Menyenangkan!</p>
        </div>
    </section>

    {{-- Main Content --}}
    <main class="container main-content">
        <div class="main-card">
            @yield('content')
        </div>
    </main>

    {{-- Footer --}}
    <footer>
        <div class="container">
            <div class="mb-2">
                <i class="fas fa-store me-2" style="color: var(--gold);"></i>
                <strong style="color: var(--gold);">UMKM Indramayu</strong>
            </div>
            <p class="mb-2">&copy; {{ date('Y') }} UMKM Indramayu - Kelompok 7</p>
            <small>Powered by Laravel & Bootstrap | Designed by Belanjain</small>
        </div>
    </footer>

    {{-- Scripts --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Generate bintang-bintang kerlap-kerlip
        function createStars() {
            const starsContainer = document.getElementById('stars');
            const numberOfStars = 100; // Jumlah bintang

            for (let i = 0; i < numberOfStars; i++) {
                const star = document.createElement('div');
                star.className = 'star';

                // Random size
                const sizes = ['small', 'medium', 'large'];
                star.classList.add(sizes[Math.floor(Math.random() * sizes.length)]);

                // Random position
                star.style.left = Math.random() * 100 + '%';
                star.style.top = Math.random() * 100 + '%';

                // Random animation duration (2-5 detik)
                star.style.animationDuration = (Math.random() * 3 + 2) + 's';

                // Random animation delay
                star.style.animationDelay = Math.random() * 5 + 's';

                starsContainer.appendChild(star);
            }
        }

        // Jalankan saat halaman dimuat
        window.addEventListener('load', createStars);
    </script>
</body>

</html>