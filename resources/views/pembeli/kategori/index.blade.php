<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UMKM Indramayu</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
        integrity="sha512-..." crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        :root {
            --dark-blue: #0a1628;
            --medium-blue: #1a3a5f;
            --light-blue: #2a4a7f;
            --gold: #ffd700;
            --gold-light: #ffed4e;
            --gold-dark: #d4af37;
            --success-color: #28a745;
            --warning-color: #ffc107;
            --danger-color: #dc3545;
            --info-color: #17a2b8;
            --secondary-color: #6c757d;
        }

        body {
            background-color: #000 !important;
            color: rgba(255, 255, 255, 0.9);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .navbar {
            height: 80px;
            padding-top: 0;
            padding-bottom: 0;
            background: rgba(10, 22, 40, 0.95) !important;
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 215, 0, 0.3);
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.5);
        }

        .navbar-brand {
            padding: 0;
            display: flex;
            align-items: center;
        }

        .navbar-logo {
            max-height: 60px;
            width: auto;
            object-fit: contain;
            filter: brightness(0) invert(1);
        }

        .nav-link {
            color: rgba(255, 255, 255, 0.8) !important;
            font-weight: 500;
            padding: 0.5rem 1rem !important;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .nav-link:hover {
            color: var(--gold) !important;
            background: rgba(255, 215, 0, 0.1);
            transform: translateY(-2px);
        }

        .form-control {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 8px;
            color: rgba(255, 255, 255, 0.9);
            padding: 0.75rem 1rem;
        }

        .form-control:focus {
            background: rgba(255, 255, 255, 0.08);
            border-color: var(--gold);
            color: rgba(255, 255, 255, 0.9);
            box-shadow: 0 0 0 3px rgba(255, 215, 0, 0.1);
        }

        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }

        .btn-outline-success {
            border-color: var(--gold);
            color: var(--gold);
            background: transparent;
            transition: all 0.3s ease;
        }

        .btn-outline-success:hover {
            background: var(--gold);
            color: var(--dark-blue);
            border-color: var(--gold);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(255, 215, 0, 0.3);
        }

        .container {
            padding-top: 20px;
        }

        .hero-section {
            text-align: center;
            padding: 4rem 0;
            background: linear-gradient(135deg, rgba(10, 22, 40, 0.8), rgba(42, 74, 127, 0.8));
            border-radius: 20px;
            margin: 2rem 0;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 215, 0, 0.2);
            position: relative;
            overflow: hidden;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 1000"><polygon fill="rgba(255,215,0,0.05)" points="0,1000 1000,0 1000,1000"/></svg>');
            background-size: cover;
            opacity: 0.5;
        }

        .page-title {
            background: linear-gradient(135deg, var(--gold) 0%, var(--gold-light) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: 700;
            font-size: 3.5rem;
            margin-bottom: 1rem;
        }

        .page-subtitle {
            color: rgba(255, 255, 255, 0.8);
            font-size: 1.3rem;
            margin-bottom: 2rem;
        }

        .section-title {
            background: linear-gradient(135deg, var(--gold) 0%, var(--gold-light) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: 600;
            font-size: 2.2rem;
            margin: 3rem 0 2rem 0;
            text-align: center;
        }

        .section-subtitle {
            color: rgba(255, 255, 255, 0.7);
            text-align: center;
            margin-bottom: 3rem;
            font-size: 1.1rem;
        }

        .kategori-card {
            background: rgba(30, 30, 46, 0.7);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            overflow: hidden;
            transition: all 0.4s ease;
            backdrop-filter: blur(10px);
            position: relative;
            height: 100%;
        }

        .kategori-card:hover {
            transform: translateY(-8px);
            border-color: var(--gold);
            box-shadow: 0 12px 30px rgba(255, 215, 0, 0.25);
        }

        .kategori-image {
            height: 200px;
            object-fit: cover;
            transition: transform 0.4s ease;
        }

        .kategori-card:hover .kategori-image {
            transform: scale(1.1);
        }

        .kategori-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(255, 215, 0, 0.9), rgba(255, 237, 78, 0.9));
            opacity: 0;
            transition: opacity 0.3s ease-in-out;
            z-index: 2;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .kategori-card:hover .kategori-overlay {
            opacity: 1;
        }

        .kategori-name {
            color: var(--dark-blue);
            font-weight: 700;
            font-size: 1.3rem;
            text-align: center;
        }

        .product-card {
            background: rgba(30, 30, 46, 0.7);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            overflow: hidden;
            transition: all 0.4s ease;
            backdrop-filter: blur(10px);
            height: 100%;
            margin-bottom: 2rem;
        }

        .product-card:hover {
            transform: translateY(-5px);
            border-color: var(--gold);
            box-shadow: 0 8px 25px rgba(255, 215, 0, 0.2);
        }

        .product-image {
            height: 220px;
            object-fit: cover;
            transition: transform 0.4s ease;
        }

        .product-card:hover .product-image {
            transform: scale(1.08);
        }

        .card-body {
            padding: 1.5rem;
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .product-title {
            color: var(--gold);
            font-weight: 600;
            font-size: 1.2rem;
            margin-bottom: 0.75rem;
            line-height: 1.4;
        }

        .product-description {
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.9rem;
            line-height: 1.5;
            margin-bottom: 1rem;
            flex-grow: 1;
        }

        .product-price {
            color: var(--gold-light);
            font-weight: 700;
            font-size: 1.3rem;
            margin-bottom: 1rem;
        }

        .btn {
            border: none;
            border-radius: 8px;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            cursor: pointer;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--gold) 0%, var(--gold-light) 100%);
            color: var(--dark-blue);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(255, 215, 0, 0.4);
            background: linear-gradient(135deg, var(--gold-light) 0%, var(--gold) 100%);
        }

        .btn-outline-success {
            border: 2px solid var(--gold);
            color: var(--gold);
            background: transparent;
            padding: 1rem 2rem;
            font-size: 1.1rem;
        }

        .btn-outline-success:hover {
            background: var(--gold);
            color: var(--dark-blue);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255, 215, 0, 0.3);
        }

        .login-prompt {
            text-align: center;
            padding: 3rem 0;
            margin: 3rem 0;
            background: rgba(30, 30, 46, 0.7);
            border-radius: 16px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
        }

        .stretched-link::after {
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            z-index: 1;
            content: "";
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .navbar {
                height: auto;
                padding: 1rem 0;
            }

            .navbar-logo {
                max-height: 50px;
            }

            .page-title {
                font-size: 2.5rem;
            }

            .page-subtitle {
                font-size: 1.1rem;
            }

            .section-title {
                font-size: 1.8rem;
            }

            .hero-section {
                padding: 3rem 1rem;
                margin: 1rem 0;
            }

            .kategori-image, .product-image {
                height: 180px;
            }
        }

        @media (max-width: 576px) {
            .page-title {
                font-size: 2rem;
            }

            .section-title {
                font-size: 1.6rem;
            }

            .btn {
                width: 100%;
                justify-content: center;
            }

            .navbar-collapse {
                margin-top: 1rem;
            }
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container d-flex align-items-center justify-content-between">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <img src="{{ asset('aset/finalisasi logo.png') }}" alt="Logo BELANJAIN" class="navbar-logo">
                <span class="ms-2 fw-bold text-white">BELANJAIN</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <form class="d-flex me-3" action="{{ route('pembeli.dashboard') }}" method="GET">
                    <input class="form-control me-2" type="search" name="search" placeholder="Cari produk..."
                        value="{{ request('search') }}">
                    <button class="btn btn-outline-success" type="submit">
                        <i class="fas fa-search me-1"></i>Cari
                    </button>
                </form>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">
                            <i class="fas fa-sign-in-alt me-1"></i>Login
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">
                            <i class="fas fa-user-plus me-1"></i>Daftar
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container">
        <!-- Hero Section -->
        <div class="hero-section">
            <h1 class="page-title">Selamat Datang di BELANJAIN</h1>
            <p class="page-subtitle">Temukan produk terbaik dari UMKM Indramayu</p>
            <div class="mt-4">
                <a href="#produk" class="btn btn-primary btn-lg">
                    <i class="fas fa-shopping-bag me-2"></i>Jelajahi Produk
                </a>
            </div>
        </div>

        <!-- Kategori Produk -->
        <h2 class="section-title">
            <i class="fas fa-tags me-2"></i>Kategori Produk
        </h2>
        <p class="section-subtitle">Telusuri berbagai kategori produk unggulan dari UMKM Indramayu</p>

        <div class="row mb-5">
            @foreach($kategoris as $kategori)
                <div class="col-lg-3 col-md-6 col-sm-12 mb-4">
                    <div class="kategori-card position-relative overflow-hidden">
                        @if($kategori->gambar)
                            <img src="{{ asset('storage/kategori/' . basename($kategori->gambar)) }}" 
                                 class="kategori-image w-100" alt="{{ $kategori->nama }}">
                        @else
                            <img src="{{ asset('images/default.jpg') }}" 
                                 class="kategori-image w-100" alt="Default Image">
                        @endif

                        <!-- Overlay yang muncul saat hover -->
                        <div class="kategori-overlay">
                            <h5 class="kategori-name">{{ $kategori->nama }}</h5>
                        </div>

                        <!-- Link seluruh kartu -->
                        <a href="{{ route('pembeli.dashboard', ['kategori' => $kategori->id]) }}"
                            class="stretched-link"></a>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Produk Pilihan -->
        <h2 class="section-title" id="produk">
            <i class="fas fa-star me-2"></i>Produk Pilihan
        </h2>
        <p class="section-subtitle">Temukan produk menarik dari berbagai kategori</p>

        <div class="row">
            @foreach($produks as $produk)
                <div class="col-lg-4 col-md-6 col-sm-12">
                    <div class="product-card">
                        @if($produk->gambar)
                            <img src="{{ asset('storage/' . $produk->gambar) }}" 
                                 class="product-image w-100" alt="{{ $produk->nama }}">
                        @else
                            <img src="{{ asset('images/default.jpg') }}" 
                                 class="product-image w-100" alt="Default Image">
                        @endif
                        <div class="card-body">
                            <h5 class="product-title">{{ $produk->nama }}</h5>
                            <p class="product-description">{{ Str::limit($produk->deskripsi, 100) }}</p>
                            <p class="product-price">Rp {{ number_format($produk->harga, 0, ',', '.') }}</p>
                            <a href="{{ route('login') }}" class="btn btn-primary">
                                <i class="fas fa-shopping-cart me-2"></i>Pesan Sekarang
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Login Prompt -->
        <div class="login-prompt">
            <h3 class="text-gold mb-3">Ingin Melihat Lebih Banyak Produk?</h3>
            <p class="text-muted mb-4">Login untuk mengakses seluruh katalog produk dan fitur belanja lengkap</p>
            <a href="{{ route('login') }}" class="btn btn-outline-success">
                <i class="fas fa-sign-in-alt me-2"></i>Login Sekarang
            </a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Smooth scroll untuk anchor links
        document.addEventListener('DOMContentLoaded', function() {
            const anchorLinks = document.querySelectorAll('a[href^="#"]');
            
            anchorLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    const targetId = this.getAttribute('href');
                    if (targetId === '#') return;
                    
                    const targetElement = document.querySelector(targetId);
                    if (targetElement) {
                        targetElement.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                    }
                });
            });

            // Animasi saat scroll
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                    }
                });
            }, observerOptions);

            // Terapkan animasi pada elemen yang diinginkan
            const animatedElements = document.querySelectorAll('.kategori-card, .product-card');
            animatedElements.forEach(el => {
                el.style.opacity = '0';
                el.style.transform = 'translateY(20px)';
                el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
                observer.observe(el);
            });
        });
    </script>
</body>

</html>