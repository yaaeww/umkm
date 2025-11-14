@extends('layouts.pembeli-navbar')

@push('style')
    <style>
        :root {
            --dark-blue: #0a1628;
            --medium-blue: #1a3a5f;
            --light-blue: #2a4a7f;
            --gold: #ffd700;
            --gold-light: #ffed4e;
            --gold-dark: #d4af37;
        }

        .main-content-push {
            padding-top: 80px !important;
        }

        .section-title {
            margin-bottom: 40px;
            text-align: center;
            color: var(--gold);
    }

        .section-title h1,
        .section-title h2,
        .section-title h3,
        .section-title h4 {
            font-weight: 700;
            background: linear-gradient(135deg, var(--gold) 0%, var(--gold-light) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .section-title p.lead {
            color: rgba(255, 255, 255, 0.8) !important;
        }

        /* Carousel Produk Terlaris */
        .carousel-container {
            overflow: hidden;
            position: relative;
            width: 100%;
            margin-bottom: 50px;
        }

        .carousel-track {
            display: flex;
            gap: 20px;
            animation: scrollCarousel 30s linear infinite;
            width: max-content;
        }

        @keyframes scrollCarousel {
            0% {
                transform: translateX(0);
            }

            100% {
                transform: translateX(-50%);
            }
        }

        .kategori-item {
            flex: 0 0 auto;
            width: 220px;
            position: relative;
            border-radius: 12px;
            overflow: hidden;
            transition: transform 0.3s ease;
            cursor: pointer;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .kategori-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(255, 215, 0, 0.3);
            border-color: var(--gold);
        }

        .kategori-item img {
            width: 100%;
            height: 150px;
            object-fit: cover;
        }

        .kategori-overlay {
            background: linear-gradient(135deg, rgba(255, 215, 0, 0.8), rgba(255, 237, 78, 0.8));
            opacity: 0;
            transition: opacity 0.3s ease;
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1;
        }

        .kategori-item:hover .kategori-overlay {
            opacity: 1;
        }

        .kategori-overlay h5 {
            color: var(--dark-blue);
            font-weight: 700;
            text-align: center;
        }

        /* Kartu Kategori & Produk */
        .product-card,
        .kategori-card {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            overflow: hidden;
            transition: all 0.3s ease;
            height: 100%;
            color: white;
            backdrop-filter: blur(10px);
        }

        .kategori-card:hover,
        .product-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 35px rgba(255, 215, 0, 0.3);
            border-color: var(--gold);
        }

        .card-img-top {
            height: 200px;
            object-fit: cover;
            transition: transform 0.4s ease;
        }

        .kategori-card .card-img-top {
            height: 180px;
        }

        .kategori-card:hover .card-img-top,
        .product-card:hover .card-img-top {
            transform: scale(1.05);
        }

        .product-overlay {
            background: linear-gradient(135deg, rgba(255, 215, 0, 0.8), rgba(255, 237, 78, 0.8));
            opacity: 0;
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 1;
        }

        .kategori-card:hover .kategori-overlay,
        .product-card:hover .product-overlay {
            opacity: 1;
        }

        .product-overlay h5 {
            color: var(--dark-blue);
            font-weight: 700;
            text-align: center;
        }

        /* Subkategori Grid */
        .subkategori-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: flex-start;
            margin-bottom: 50px;
        }

        .card-subkategori {
            width: 250px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            overflow: hidden;
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
        }

        .card-subkategori:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(255, 215, 0, 0.2);
            border-color: var(--gold);
        }

        .card-subkategori a {
            color: white;
            text-decoration: none;
        }

        .img-fixed {
            height: 160px;
            object-fit: cover;
        }

        .card-subkategori .card-body h5 {
            color: var(--gold);
            font-weight: 600;
        }

        .card-subkategori .card-body ul {
            max-height: 80px;
            overflow: auto;
            padding-left: 20px;
            margin-top: 5px;
            list-style: disc;
            color: rgba(255, 255, 255, 0.8);
        }

        .card-footer.bg-light {
            background: rgba(255, 255, 255, 0.05) !important;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding: 15px;
            color: white;
        }

        .card-footer .badge {
            background: linear-gradient(135deg, var(--gold), var(--gold-light)) !important;
            color: var(--dark-blue) !important;
            border: none;
        }

        /* Produk Detail */
        .product-card .card-body {
            padding: 15px;
            text-align: left;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }

        .product-card .card-body h5 {
            color: var(--gold);
        }

        .product-card .card-body p {
            color: rgba(255, 255, 255, 0.8);
        }

        .product-card .card-body .fs-5 {
            color: var(--gold-light) !important;
            font-weight: 700;
        }

        /* Alert Styles */
        .alert {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            color: white;
            backdrop-filter: blur(10px);
        }

        .alert-success {
            border-color: rgba(40, 167, 69, 0.3);
        }

        .alert-warning {
            border-color: rgba(255, 193, 7, 0.3);
        }

        .alert-info {
            border-color: rgba(23, 162, 184, 0.3);
        }

        /* Responsive */
        @media (max-width: 992px) {
            .kategori-item {
                width: 200px;
            }

            .card-subkategori {
                width: calc(50% - 10px);
            }
        }

        @media (max-width: 768px) {
            .subkategori-grid {
                justify-content: center;
            }

            .card-subkategori {
                width: 100%;
                max-width: 350px;
            }
        }

        @media (max-width: 576px) {
            .kategori-item {
                width: 150px;
            }

            .carousel-track {
                gap: 10px;
            }

            .card-img-top,
            .kategori-card .card-img-top {
                height: 150px;
            }

            .main-content-push {
                padding-top: 60px !important;
            }
        }
    </style>
@endpush

@section('content')
    <div class="container main-content-push">

        <div class="section-title">
            <h2><i class="fas fa-fire me-2"></i>Produk Teratas</h2>
            <p class="lead">Jangan lewatkan produk terlaris di bulan ini!</p>
        </div>

        @if ($produkTerlaris->count())
            <div class="carousel-container">
                <div class="carousel-track">
                    @foreach (array_merge($produkTerlaris->all(), $produkTerlaris->all()) as $produk)
                        <div class="kategori-item">
                            <a href="{{ route('pembeli.produk.show', $produk->id) }}" class="text-decoration-none">
                                <img src="{{ $produk->gambar ? asset('storage/' . $produk->gambar) : asset('images/default.jpg') }}"
                                    alt="{{ $produk->nama }}" loading="lazy">
                                <div class="kategori-overlay">
                                    <h5>{{ $produk->nama }}</h5>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            <div class="alert alert-warning text-center mx-3 mb-5">
                <i class="fas fa-info-circle me-2"></i>Belum ada produk terlaris tersedia.
            </div>
        @endif

        <div class="section-title">
            <h1><i class="fas fa-layer-group me-2"></i>KATEGORI PRODUK</h1>
            <p class="lead">Temukan produk terbaik dari UMKM Indramayu</p>
        </div>

        {{-- Session Alert & Search Info --}}
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"
                    style="filter: brightness(0) invert(1);"></button>
            </div>
        @endif

        @if (request('search'))
            <div class="alert alert-info">
                <i class="fas fa-search me-2"></i>Hasil pencarian untuk: <strong>{{ request('search') }}</strong>
            </div>
        @endif

        <div class="row mb-5">
            @forelse($kategoris as $kategori)
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="card kategori-card border-0">
                        <img src="{{ $kategori->gambar ? asset('storage/kategori/' . basename($kategori->gambar)) : asset('images/default.jpg') }}"
                            class="card-img-top" alt="{{ $kategori->nama }}" loading="lazy">
                        <div class="kategori-overlay product-overlay">
                            <h5 class="text-center px-2">{{ $kategori->nama }}</h5>
                        </div>
                        <a href="{{ route('pembeli.dashboard', ['kategori' => $kategori->id]) }}" class="stretched-link"
                            aria-label="Lihat kategori {{ $kategori->nama }}"></a>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center">
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>Belum ada kategori tersedia.
                    </div>
                </div>
            @endforelse
        </div>

        @if ($kategoriAktif)
            <div class="section-title">
                <h3><i class="fas fa-folder-open me-2"></i>Subkategori & Produk dalam: <span
                        style="color: var(--gold);">{{ $kategoriAktif->nama }}</span></h3>
            </div>

            {{-- Subkategori Grid --}}
            @if ($subkategoris->count())
                <div class="subkategori-grid mb-5">
                    @foreach ($subkategoris as $sub)
                        <div class="card card-subkategori">
                            <a href="{{ route('pembeli.dashboard', ['kategori' => $sub->id]) }}" class="text-decoration-none">
                                <img src="{{ $sub->gambar ? asset('storage/kategori/' . basename($sub->gambar)) : asset('images/default.jpg') }}"
                                    class="card-img-top img-fixed" alt="{{ $sub->nama }}" loading="lazy">
                                <div class="card-body text-center">
                                    <h5>{{ $sub->nama }}</h5>
                                    @if ($sub->produks->count())
                                        <p class="text-success small mb-0 fw-bold">
                                            <i class="fas fa-box me-1"></i>{{ $sub->produks->count() }} Produk
                                        </p>
                                    @else
                                        <p class="text-muted small mb-0">
                                            <i class="fas fa-box-open me-1"></i>Belum ada produk.
                                        </p>
                                    @endif
                                </div>
                            </a>

                            {{-- Subchildren (jika ada) --}}
                            @if ($sub->children->count())
                                <div class="card-footer bg-light">
                                    <strong class="d-block text-center mb-2">
                                        <i class="fas fa-sitemap me-1"></i>Lihat Turunan:
                                    </strong>
                                    <div class="d-flex flex-wrap justify-content-center gap-2">
                                        @foreach ($sub->children as $subchild)
                                            <a href="{{ route('pembeli.dashboard', ['kategori' => $subchild->id]) }}"
                                                class="badge text-decoration-none">
                                                {{ $subchild->nama }}
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @else
                <div class="alert alert-info text-center">
                    <i class="fas fa-info-circle me-2"></i>Tidak ada subkategori turunan di bawah kategori
                    <strong>{{ $kategoriAktif->nama }}</strong>.
                </div>
            @endif

            {{-- Daftar Produk dari Kategori Aktif --}}
            @if ($produks->isNotEmpty())
                <div class="section-title">
                    <h4><i class="fas fa-boxes me-2"></i>Semua Produk dalam kategori <strong>{{ $kategoriAktif->nama }}</strong>
                    </h4>
                </div>
                <div class="row">
                    @foreach ($produks as $produk)
                        <div class="col-lg-3 col-md-6 col-sm-12 mb-4">
                            <div class="card product-card border-0 h-100 d-flex flex-column">
                                <a href="{{ route('pembeli.produk.show', $produk->id) }}" class="text-decoration-none">
                                    <img src="{{ $produk->gambar ? asset('storage/' . $produk->gambar) : asset('images/default.jpg') }}"
                                        class="card-img-top" alt="{{ $produk->nama }}" loading="lazy">
                                    <div class="product-overlay">
                                        <h5>{{ $produk->nama }}</h5>
                                    </div>
                                </a>
                                <div class="card-body d-flex flex-column">
                                    <h6 class="fw-bold mb-1 text-truncate">{{ $produk->nama }}</h6>
                                    <p class="card-text small flex-grow-1">{{ Str::limit($produk->deskripsi, 40) }}</p>

                                    <div class="mt-auto pt-2 border-top">
                                        <p class="fw-bold mb-2 fs-5">
                                            Rp. {{ number_format($produk->harga, 0, ',', '.') }}
                                        </p>
                                        <a href="{{ route('pembeli.produk.show', $produk->id) }}" class="btn btn-primary w-100">
                                            <i class="fas fa-eye me-1"></i>Lihat Detail
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="d-flex justify-content-center mt-4">
                    {{ $produks->links() }}
                </div>
            @else
                <div class="alert alert-warning text-center">
                    <i class="fas fa-exclamation-triangle me-2"></i>Tidak ada produk ditemukan langsung di bawah kategori ini.
                </div>
            @endif
        @endif
    </div>
@endsection