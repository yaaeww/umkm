<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'UMKM Indramayu')</title>
    @stack('style')

    <!-- Bootstrap & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <!-- DeskApp CSS -->
    <link rel="stylesheet" href="{{ asset('vendors/styles/core.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/styles/icon-font.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/styles/style.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/styles/responsive.css') }}">

    <!-- Custom CSS -->
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }

        .hero-banner {
            background: url('{{ asset('aset/finalisasi logo.png') }}') no-repeat center center;
            background-size: cover;
            height: 300px;
            position: relative;
        }

        .hero-banner::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.4);
        }

        .hero-banner-content {
            position: relative;
            z-index: 1;
            color: white;
            padding: 60px 30px;
            text-align: center;
        }

        .navbar {
            background-color: rgba(0, 0, 0, 0.6) !important;
            backdrop-filter: blur(8px);
        }

        .navbar-nav .nav-link {
            color: white !important;
            transition: 0.3s;
        }

        .navbar-nav .nav-link:hover {
            color: #ffc107 !important;
        }

        .main-content {
            margin-top: 2rem;
        }

        .main-card {
            background-color: rgba(255, 255, 255, 0.95);
            border-radius: 1rem;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.08);
            padding: 2rem;
        }

        footer {
            background-color: #212529;
            color: #fff;
            padding: 1.5rem 0;
            text-align: center;
        }

        .navbar-logo {
            height: 45px;
        }

        .badge.bg-light {
            border: 1px solid #ddd;
        }
    </style>
</head>

<body>
    {{-- Navbar --}}
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top shadow-sm">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center fw-bold text-white"
                href="{{ route('pembeli.dashboard') }}">
                <img src="{{ asset('aset/finalisasi logo.png') }}" alt="UMKM Logo" class="navbar-logo me-2">
                UMKM Indramayu
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('pembeli.dashboard') ? 'active' : '' }}"
                            href="{{ route('pembeli.dashboard') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('pembeli.produk.index') ? 'active' : '' }}"
                            href="{{ route('pembeli.produk.index') }}">Produk</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('pembeli.pesanan.index') ? 'active' : '' }}"
                            href="{{ route('pembeli.pesanan.index') }}">Pesanan</a>
                    </li>
                </ul>

                <form class="d-flex" method="GET" action="{{ route('pembeli.dashboard') }}">
                    <input class="form-control me-2" type="search" name="search" placeholder="Cari produk..."
                        value="{{ request('search') }}">
                    <button class="btn btn-outline-light" type="submit">Cari</button>
                </form>

                <ul class="navbar-nav ms-3 align-items-center">
                    {{-- Keranjang --}}
                    <li class="nav-item me-3 position-relative">
                        <a class="nav-link" href="{{ route('pembeli.keranjang.index') }}">
                            <i class="bi bi-cart" style="font-size: 1.5rem;"></i>
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
                            <i class="bi bi-truck" style="font-size: 1.5rem;"></i>
                            @if($notifikasiDikirim->count() > 0)
                                <span
                                    class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-warning text-dark">
                                    {{ $notifikasiDikirim->count() }}
                                </span>
                            @endif
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            @forelse($notifikasiDikirim as $notif)
                                <li>
                                    <a class="dropdown-item small" href="{{ route('pembeli.pesanan.index') }}">
                                        📦 Pesanan "{{ $notif->produk->nama }}" sedang dikirim
                                    </a>
                                </li>
                            @empty
                                <li><span class="dropdown-item text-muted">Tidak ada notifikasi</span></li>
                            @endforelse
                        </ul>
                    </li>

                    <!-- Chatbot -->
                    <li class="nav-item me-3">
    <a href="{{ route('chatbot.index') }}" class="btn btn-primary">
        <i class="bi bi-chat-dots"></i> Chatbot
    </a>
</li>


                    {{-- Profil --}}
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white" href="#" data-bs-toggle="dropdown">
                            {{ auth()->user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('pembeli.profile.show') }}"><i
                                        class="bi bi-person-circle me-2"></i>Profil</a></li>
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button class="dropdown-item text-danger" type="submit">Logout</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    {{-- Hero Banner --}}
    <section class="hero-banner d-flex align-items-center justify-content-center">
        <div class="hero-banner-content">
            <h1 class="display-5 fw-bold">Selamat Datang di UMKM Indramayu</h1>
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
            <p class="mb-2">&copy; {{ date('Y') }} UMKM Indramayu - Kelompok 7</p>
            <small>Powered by Laravel & Bootstrap | Designed by Belanjain</small>
        </div>
    </footer>

    {{-- Scripts --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('vendors/scripts/core.js') }}"></script>
    <script src="{{ asset('vendors/scripts/script.min.js') }}"></script>
    <script src="{{ asset('vendors/scripts/process.js') }}"></script>
    <script src="{{ asset('vendors/scripts/layout-settings.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const toggleBtn = document.getElementById('chatbot-toggle');
            const chatBox = document.getElementById('chatbot-box');
            const closeBtn = document.getElementById('close-chat');
            const chatForm = document.getElementById('chat-form');
            const chatInput = document.getElementById('chat-input');
            const chatMessages = document.getElementById('chat-messages');

            toggleBtn.addEventListener('click', () => chatBox.style.display = 'block');
            closeBtn.addEventListener('click', () => chatBox.style.display = 'none');

            chatForm.addEventListener('submit', async (e) => {
                e.preventDefault();
                const message = chatInput.value.trim();
                if (!message) return;

                chatMessages.innerHTML += `<div class="text-end mb-2"><span class="badge bg-primary">${message}</span></div>`;
                chatInput.value = '';

                try {
                    const res = await fetch("{{ route('chatbot.chat') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ message })
                    });

                    const data = await res.json();
                    chatMessages.innerHTML += `<div class="text-start mb-2"><span class="badge bg-light text-dark">${data.reply}</span></div>`;
                    chatMessages.scrollTop = chatMessages.scrollHeight;
                } catch (err) {
                    chatMessages.innerHTML += `<div class="text-start mb-2"><span class="badge bg-danger">Terjadi kesalahan server</span></div>`;
                }
            });
        });
    </script>
</body>

</html>