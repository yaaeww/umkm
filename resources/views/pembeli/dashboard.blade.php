<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Pembeli - UMKM Indramayu</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('pembeli.dashboard') }}">UMKM Indramayu</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <!-- Menu kiri -->
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('pembeli.dashboard') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Kategori</a>
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
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                0
                                <span class="visually-hidden">item keranjang</span>
                            </span>
                        </a>
                    </li>
                </ul>
                
                <!-- Logout -->
                <ul class="navbar-nav ms-3">
                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button class="btn btn-danger btn-sm" type="submit">Logout</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mt-5">
        <h1 class="mb-4 text-center">Selamat Datang, {{ Auth::user()->name }}!</h1>

        <!-- NOTIFIKASI SUKSES -->
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Jika ada pencarian, tampilkan info -->
        @if (request('search'))
            <div class="alert alert-info">
                Hasil pencarian untuk: <strong>{{ request('search') }}</strong>
            </div>
        @endif

        <div class="row">
            <!-- Loop Produk -->
            @forelse ($produks as $produk)
                <div class="col-md-4">
                    <div class="card mb-4">
                        @if ($produk->gambar)
                            <img src="{{ asset('storage/' . $produk->gambar) }}" class="card-img-top" alt="{{ $produk->nama }}">
                        @else
                            <img src="{{ asset('images/default.jpg') }}" class="card-img-top" alt="Default Image">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $produk->nama }}</h5>
                            <p class="card-text">{{ Str::limit($produk->deskripsi, 100) }}</p>
                            <p class="card-text"><strong>Rp {{ number_format($produk->harga, 0, ',', '.') }}</strong></p>
                            <a href="{{ route('pembeli.produk.show', $produk->id) }}" class="btn btn-primary">Lihat Detail</a>
                            <form action="{{ route('pembeli.keranjang.store') }}" method="POST" class="mt-2">
                                @csrf
                                <input type="hidden" name="produk_id" value="{{ $produk->id }}">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="btn btn-success w-100">Tambah ke Keranjang</button>
                            </form>                            
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-warning text-center">
                        Tidak ada produk ditemukan.
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
            {{ $produks->withQueryString()->links() }}
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
