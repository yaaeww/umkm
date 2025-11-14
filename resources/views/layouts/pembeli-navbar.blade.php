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
        }

        .navbar-custom {
            background: rgba(10, 22, 40, 0.95);
            backdrop-filter: blur(10px);
            padding: 1rem 0;
            border-bottom: 2px solid var(--gold);
            box-shadow: 0 4px 20px rgba(255, 215, 0, 0.2);
        }

        .navbar-logo {
            height: 45px;
            filter: brightness(1.2);
        }

        .navbar-brand {
            color: var(--gold) !important;
            font-weight: 700;
            font-size: 1.5rem;
            text-shadow: 0 0 10px rgba(255, 215, 0, 0.5);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .navbar-custom .nav-link {
            color: #e0e0e0;
            font-weight: 500;
            margin: 0 10px;
            padding: 8px 16px;
            border-radius: 6px;
            transition: all 0.3s ease;
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
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(255, 215, 0, 0.4);
            background: linear-gradient(135deg, var(--gold-light) 0%, var(--gold) 100%);
        }

        .hero-banner {
            background: linear-gradient(135deg, var(--dark-blue) 0%, var(--medium-blue) 50%, var(--light-blue) 100%);
            height: 300px;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: 5%;
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
        }

        .hero-banner-content h1 {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 1rem;
            background: linear-gradient(135deg, var(--gold) 0%, var(--gold-light) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .main-content {
            margin-top: 2rem;
        }

        .main-card {
            background: rgba(30, 30, 46, 0.7);
            border-radius: 24px;
            padding: 2rem;
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.4);
            color: white;
        }

        footer {
            background: linear-gradient(135deg, var(--dark-blue) 0%, rgba(26, 58, 95, 0.95) 100%);
            color: #fff;
            padding: 1.5rem 0;
            text-align: center;
            margin-top: 3rem;
            border-top: 2px solid var(--gold);
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
    </style>
</head>

<body>
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

                <form class="d-flex me-3" method="GET" action="{{ route('pembeli.dashboard') }}">
                    <input class="form-control me-2" type="search" name="search" placeholder="Cari produk..."
                        value="{{ request('search') }}">
                    <button class="btn btn-outline-light" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </form>

                <ul class="navbar-nav align-items-center">
                    {{-- Keranjang --}}
                    <li class="nav-item me-3 position-relative">
                        <a class="nav-link" href="{{ route('pembeli.keranjang.index') }}">
                            <i class="fas fa-shopping-cart" style="font-size: 1.5rem;"></i>
                            @if($totalKeranjang > 0)
                                <span
                                    class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                    {{ $totalKeranjang }}
                                </span>
                            @endif
                        </a>
                    </li>

                    {{-- Notifikasi Dikirim --}}
                    <li class="nav-item dropdown me-3">
                        <a class="nav-link dropdown-toggle position-relative" href="#" role="button"
                            data-bs-toggle="dropdown">
                            <i class="fas fa-truck" style="font-size: 1.5rem;"></i>
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
                    <li class="nav-item me-3">
                        <a href="{{ route('pembeli.chat.index') }}" class="btn btn-primary">
                            <i class="fas fa-robot me-1"></i>Chatbot
                        </a>
                    </li>

                    {{-- Profil --}}
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white" href="#" data-bs-toggle="dropdown">
                            <i class="fas fa-user-circle me-1"></i>{{ auth()->user()->name }}
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
</body>

</html>