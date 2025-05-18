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
        body {
            background-color: #f5e6cc;
        }

        .navbar {
            height: 70px;
            padding-top: 0;
            padding-bottom: 0;
        }

        .navbar-brand {
            padding: 0;
            display: flex;
            align-items: center;
        }

        .navbar-logo {
            max-height: 250px;
            width: auto;
            object-fit: contain;
        }

        .card-img-top {
            height: 200px;
            object-fit: cover;
        }

        .section-title {
            margin-bottom: 30px;
            text-align: center;
        }

        .product-card {
            position: relative;
            overflow: hidden;
        }

        .kategori-card {
            position: relative;
            overflow: hidden;
        }

        .kategori-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            opacity: 0;
            transition: opacity 0.3s ease-in-out;
            z-index: 1;
        }

        .kategori-card:hover .kategori-overlay {
            opacity: 1;
        }

        .produk-card-wrapper {
            position: relative;
            overflow: hidden;
        }

        .produk-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.4);
            opacity: 0;
            transition: opacity 0.3s ease-in-out;
            z-index: 2;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .produk-card-wrapper:hover .produk-overlay {
            opacity: 1;
        }

        .produk-overlay h5 {
            color: white;
            text-align: center;
            padding: 10px;
        }
    </style>
</head>

<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container d-flex align-items-center justify-content-between">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <img src="{{ asset('aset/finalisasi logo.png') }}" alt="Logo" class="navbar-logo">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <form class="d-flex" action="{{ route('pembeli.dashboard') }}" method="GET">
                    <input class="form-control me-2" type="search" name="search" placeholder="Cari produk..."
                        value="{{ request('search') }}">
                    <button class="btn btn-outline-success" type="submit">Cari</button>
                </form>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Daftar</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mt-5">
        <div class="section-title">
            <h1>============================</h1>
            <h1>Selamat Datang </h1>
            <p class="lead">Temukan produk terbaik dari UMKM Indramayu</p>
        </div>


        <!-- Kategori Produk (Parent Only) -->
        <div class="row mb-5">
            @foreach($kategoris as $kategori)
                <div class="col-lg-3 col-md-6 col-sm-12 mb-4">
                    <div class="card position-relative overflow-hidden border-0 shadow kategori-card">
                        @if($kategori->gambar)
                            <img src="{{ asset('storage/kategori/' . basename($kategori->gambar)) }}" class="card-img-top"
                                alt="{{ $kategori->nama }}">
                        @else
                            <img src="{{ asset('images/default.jpg') }}" class="card-img-top" alt="Default">
                        @endif

                        <div class="kategori-overlay d-flex justify-content-center align-items-center">
                            <h5 class="text-white text-center">{{ $kategori->nama }}</h5>
                        </div>

                        <a href="{{ route('pembeli.dashboard', ['kategori' => $kategori->id]) }}"
                            class="stretched-link"></a>
                    </div>
                </div>
            @endforeach
        </div>






        <!-- Produk Pilihan -->
        <div class="section-title">
            <h2>Produk Pilihan</h2>
            <p class="lead">Temukan produk menarik dari berbagai kategori</p>
        </div>

        <div class="row">
            @foreach($produks as $produk)
                <div class="col-md-4 product-card">
                    <div class="card position-relative overflow-hidden border-0 shadow produk-card-wrapper">
                        @if($produk->gambar)
                            <img src="{{ asset('storage/' . $produk->gambar) }}" class="card-img-top" alt="{{ $produk->nama }}">
                        @else
                            <img src="{{ asset('images/default.jpg') }}" class="card-img-top" alt="Default Image">
                        @endif

                        <!-- Overlay saat hover -->
                        <div class="produk-overlay">
                            <h5>{{ $produk->nama }}</h5>
                        </div>

                        <!-- Link seluruh kartu -->
                        <a href="{{ route('login') }}" class="stretched-link"></a>
                    </div>

                    <!-- Card body terpisah -->
                    <div class="card border-0 shadow">
                        <div class="card-body">
                            <p class="card-text">{{ Str::limit($produk->deskripsi, 100) }}</p>
                            <p class="card-text"><strong>Rp {{ number_format($produk->harga, 0, ',', '.') }}</strong></p>
                            <a href="{{ route('login') }}" class="btn btn-primary">Pesan Sekarang</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        


    </div>
    <footer class="bg-light text-center text-lg-start border-top py-3 mt-5">
        <div class="container text-center">
            <p class="mb-0">&copy; {{ date('Y') }} UMKM Indramayu. Kelompok 7.</p>
            <small>Powered by Laravel & Bootstrap | Designed by Belanjain</small>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>