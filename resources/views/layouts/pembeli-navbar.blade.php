<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'UMKM Indramayu')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <!-- DeskApp CSS -->
    <link rel="stylesheet" href="{{ asset('vendors/styles/core.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/styles/icon-font.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/styles/style.css') }}">
    <link rel="stylesheet" href="{{ asset('vendors/styles/responsive.css') }}">
</head>
<body>

    {{-- Navbar Pembeli --}}
    <style>
        body {
        background-color: #f5e6cc;
    }
        .navbar {
            height: 70px; /* Navbar tetap ramping */
            padding-top: 0;
            padding-bottom: 0;
        }
    
        .navbar-brand {
            padding: 0;
            display: flex;
            align-items: center;
        }
    
        .navbar-logo {
            max-height: 250px; /* Logo cukup besar tapi tetap muat di navbar */
            width: auto; /* Biar proporsional */
            object-fit: contain;
        }
        </style>
        
        <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
            <div class="container">
                <a class="navbar-brand fw-bold" href="{{ route('pembeli.dashboard') }}">
                    <img src="{{ asset('aset/finalisasi logo.png') }}" alt="Logo UMKM Indramayu" class="navbar-logo me-2">
                </a>
        

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <!-- Menu kiri -->
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('pembeli.dashboard') ? 'active' : '' }}" href="{{ route('pembeli.dashboard') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('pembeli.produk.index')}}">Produk</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('pembeli.pesanan.index')}}">Pesanan</a>
                    </li>
                </ul>

                <!-- Search form -->
                <form class="d-flex" action="{{ route('pembeli.dashboard') }}" method="GET">
                    <input class="form-control me-2" type="search" name="search" placeholder="Cari produk..." value="{{ request('search') }}">
                    <button class="btn btn-outline-success" type="submit">Cari</button>
                </form>

                <!-- Ikon keranjang -->
                <ul class="navbar-nav ms-3">
                    <li class="nav-item">
                        <a class="nav-link position-relative" href="{{ route('pembeli.keranjang.index') }}">
                            <i class="bi bi-cart" style="font-size: 1.5rem;"></i>
                            @if($totalKeranjang > 0)
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                    {{ $totalKeranjang }}
                                    <span class="visually-hidden">item keranjang</span>
                                </span>
                            @endif
                        </a>
                    </li>
                </ul>
                <ul class="navbar-nav ms-3">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <span class="user-name">{{ auth()->user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="{{route('pembeli.profile.show')}}"><i class="bi bi-person-circle"></i> Profile</a></li>
<br>
                            <ul class="navbar-nav ms-3">
                                <li class="nav-item">
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button class="btn btn-danger btn-sm" type="submit">Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </ul>
                    </li>
                </ul>
            
                
            
                <!-- Logout -->
                
            </div>
        </div>
    </nav>

    {{-- Konten Halaman --}}
    <main class="container py-4">
        @yield('content')
    </main>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- DeskApp JS -->
    <script src="{{ asset('vendors/scripts/core.js') }}"></script>
    <script src="{{ asset('vendors/scripts/script.min.js') }}"></script>
    <script src="{{ asset('vendors/scripts/process.js') }}"></script>
    <script src="{{ asset('vendors/scripts/layout-settings.js') }}"></script>
</body>
</html>
