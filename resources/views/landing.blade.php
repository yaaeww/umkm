<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>UMKM Indramayu</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>

<body>
    <!-- Navbar -->
    <style>
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
    
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container d-flex align-items-center justify-content-between">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <img src="aset/finalisasi logo.png" alt="Logo" class="navbar-logo">
            </a>
    
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
    
            <div class="collapse navbar-collapse" id="navbarNav">
                <!-- Search Form -->
                <form action="" method="GET" class="d-flex mx-auto" style="max-width: 400px;">
                    <input class="form-control me-2" type="search" name="query" placeholder="Cari produk..." aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Cari</button>
                </form>
    
                <!-- Menu kanan -->
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">Daftar</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    

    <!-- Main Content -->
    <div class="container mt-5">
        <h1 class="mb-4 text-center">Selamat Datang di BELANJAIN</h1>

        <div class="row">
            <!-- Loop Produk -->
            @foreach ($produks as $produk)
            <div class="col-md-4">
                <div class="card mb-4">
                    @if($produk->gambar)
                        <img src="{{ asset('storage/' . $produk->gambar) }}" class="card-img-top" alt="{{ $produk->nama }}">
                    @else
                        <img src="{{ asset('images/default.jpg') }}" class="card-img-top" alt="Default Image">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $produk->nama }}</h5>
                        <p class="card-text">{{ Str::limit($produk->deskripsi, 100) }}</p>
                        <p class="card-text"><strong>Rp {{ number_format($produk->harga, 0, ',', '.') }}</strong></p>
                        <a href="{{ route('login') }}" class="btn btn-primary">Pesan Sekarang</a>
                    </div>
                </div>
            </div>
        @endforeach
        
        </div>

        <div class="text-center mt-4">
            <a href="{{ route('login') }}" class="btn btn-outline-success">Login untuk Melihat Lebih Banyak Produk</a>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
