@extends('layouts.pembeli-navbar')

@push('style')

    <style>
        body {
            background-color: black !important;
            color: black !important;
            /* Default text color jadi hitam */
        }

        .carousel-container {
            overflow: hidden;
            position: relative;
            width: 100%;
            margin-bottom: 40px;
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
            border-radius: 8px;
            overflow: hidden;
            transition: transform 0.3s ease;
            cursor: pointer;
        }

        .kategori-item img {
            width: 100%;
            height: 150px;
            object-fit: cover;
        }

        .kategori-item .kategori-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.6);
            /* overlay jadi terang supaya teks hitam terlihat */
            display: flex;
            justify-content: center;
            align-items: center;
            opacity: 0;
            transition: opacity 0.3s ease;
            z-index: 1;
        }

        .kategori-item:hover .kategori-overlay {
            opacity: 1;
        }

        .kategori-item h5 {
            color: black;
            /* teks kategori overlay hitam */
            text-align: center;
            padding: 0 10px;
        }

        .card-img-top {
            height: 200px;
            object-fit: cover;
            transition: transform 0.4s ease;
        }

        .card-img-top:hover {
            transform: scale(1.05);
        }

        .section-title {
            margin-bottom: 30px;
            text-align: center;
            color: black;
            /* teks judul section hitam */
        }

        .product-card,
        .kategori-card {
            margin-bottom: 30px;
            position: relative;
            overflow: hidden;
            cursor: pointer;
            transition: transform 0.2s ease-in-out;
            color: black;
            /* teks kartu jadi hitam */
        }

        .kategori-overlay,
        .product-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.6);
            /* overlay terang */
            opacity: 0;
            transition: opacity 0.3s ease-in-out;
            z-index: 1;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .kategori-card:hover .kategori-overlay,
        .product-card:hover .product-overlay {
            opacity: 1;
        }

        .kategori-card:hover,
        .product-card:hover {
            transform: scale(1.03);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        .subkategori-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: flex-start;
        }

        .card-subkategori {
            width: 220px;
            color: black;
            /* teks subkategori hitam */
        }

        .img-fixed {
            height: 160px;
            object-fit: cover;
        }

        .card-footer.bg-light strong {
            font-size: 0.9rem;
            color: black;
            /* footer teks hitam */
        }

        @media (max-width: 576px) {
            .card-subkategori {
                width: 100%;
            }

            .section-title h1,
            .section-title h2,
            .section-title h3,
            .section-title h4 {
                color: black;
                font-weight: 700;
                letter-spacing: 1px;
            }

            .section-title p {
                font-size: 1rem;
                color: #444;
                /* sedikit abu-abu gelap */
            }

            .card-body h5 {
                font-weight: 600;
                font-size: 1.1rem;
                color: black;
            }

            .card-body p {
                font-size: 0.9rem;
                color: #333;
            }

            .btn-success {
                background-color: #28a745;
                border: none;
                transition: background-color 0.3s ease;
                color: white;
                /* tombol teks tetap putih */
            }

            .btn-success:hover {
                background-color: #218838;
            }

            .card:hover {
                transform: translateY(-5px);
                transition: transform 0.3s ease;
            }

            .carousel .carousel-item {
                transition: transform 0.6s ease-in-out;
            }

            .carousel-control-prev-icon,
            .carousel-control-next-icon {
                background-color: rgba(0, 0, 0, 0.5);
                padding: 10px;
                border-radius: 50%;
            }

            .carousel-inner .row {
                display: flex;
                justify-content: center;
            }

            .carousel-item .col-md-3 {
                display: flex;
                justify-content: center;
            }
        }
    </style>
@endpush

@section('content')

    <!-- PRODUK TERLARIS SCROLL AUTO -->
    <div class="section-title">
        <h2>🔥 Produk Teratas 🔥</h2>
    </div>

    @if ($produkTerlaris->count())
        <div class="carousel-container">
            <div class="carousel-track">
                @foreach ($produkTerlaris as $produk)
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
                @foreach ($produkTerlaris as $produk)
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
        <div class="alert alert-warning text-center">Belum ada produk terlaris tersedia.</div>
    @endif

    <div class="container mt-5">
        <div class="section-title">
            <h1>KATEGORI PRODUK</h1>
            <p class="lead">Temukan produk terbaik dari UMKM Indramayu</p>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (request('search'))
            <div class="alert alert-info">
                Hasil pencarian untuk: <strong>{{ request('search') }}</strong>
            </div>
        @endif

        <!-- Kategori -->
        <div class="row mb-5">
            @forelse($kategoris as $kategori)
                <div class="col-lg-3 col-md-6 col-sm-12 mb-4">
                    <div class="card kategori-card shadow border-0">
                        <img src="{{ $kategori->gambar ? asset('storage/kategori/' . basename($kategori->gambar)) : asset('images/default.jpg') }}"
                            class="card-img-top" alt="{{ $kategori->nama }}" loading="lazy">
                        <div class="kategori-overlay">
                            <h5 class="text-center px-2">{{ $kategori->nama }}</h5>
                        </div>
                        <a href="{{ route('pembeli.dashboard', ['kategori' => $kategori->id]) }}" class="stretched-link"
                            aria-label="Lihat kategori {{ $kategori->nama }}"></a>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center">
                    <div class="alert alert-warning">Belum ada kategori tersedia.</div>
                </div>
            @endforelse
        </div>

        <!-- Subkategori & Produk -->
        @if ($kategoriAktif)
            <div class="section-title">
                <h3>Subkategori & Produk dari: {{ $kategoriAktif->nama }}</h3>
            </div>

            @if ($subkategoris->count())
                <div class="subkategori-grid mb-5">
                    @foreach ($subkategoris as $sub)
                        <div class="card shadow-sm card-subkategori">
                            <img src="{{ $sub->gambar ? asset('storage/kategori/' . basename($sub->gambar)) : asset('images/default.jpg') }}"
                                class="card-img-top img-fixed" alt="{{ $sub->nama }}" loading="lazy">
                            <div class="card-body text-center">
                                <h5>{{ $sub->nama }}</h5>
                                @if ($sub->produks->count())
                                    <ul class="mt-2 text-start small mb-0">
                                        @foreach ($sub->produks as $produk)
                                            <li>{{ $produk->nama }}</li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p class="text-muted small mb-0">Belum ada produk.</p>
                                @endif
                            </div>

                            @if ($sub->children->count())
                                <div class="card-footer bg-light">
                                    <strong class="d-block text-center mb-2">{{ $kategoriAktif->nama }}</strong>
                                    <div class="d-flex flex-wrap justify-content-center gap-3">
                                        @foreach ($sub->children as $subchild)
                                            <div class="card shadow-sm" style="width: 180px;">
                                                <a href="{{ route('pembeli.dashboard', ['kategori' => $subchild->id]) }}"
                                                    class="text-decoration-none" aria-label="Lihat subkategori {{ $subchild->nama }}">
                                                    <img src="{{ $subchild->gambar ? asset('storage/kategori/' . basename($subchild->gambar)) : asset('images/default.jpg') }}"
                                                        class="card-img-top img-fixed" alt="{{ $subchild->nama }}" loading="lazy">
                                                    <div class="card-body p-2">
                                                        <p class="text-center small mb-0">{{ $subchild->nama }}</p>
                                                    </div>
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @else
                <div class="alert alert-warning text-center">
                    Tidak ada subkategori ditemukan dalam kategori ini.
                </div>
            @endif

            <!-- Produk dari semua level kategori dan subkategori -->
            @isset($kategoriAktif)
                @if ($produks->isNotEmpty())
                    <div class="section-title">
                        <h4>Produk dalam Kategori: {{ $kategoriAktif->nama }} (dan turunannya)</h4>
                    </div>
                    <div class="row">
                        @foreach ($produks as $produk)
                            <div class="col-lg-3 col-md-6 col-sm-12 mb-4">
                                <div class="card product-card shadow border-0 h-100">
                                    <a href="{{ route('pembeli.produk.show', $produk->id) }}" class="text-decoration-none text-dark">
                                        <img src="{{ $produk->gambar ? asset('storage/' . $produk->gambar) : asset('images/default.jpg') }}"
                                            class="card-img-top" alt="{{ $produk->nama }}" loading="lazy">
                                        <div class="product-overlay">
                                            <h5 class="text-center px-2">{{ $produk->nama }}</h5>
                                        </div>
                                    </a>
                                    <div class="card-body text-center d-flex flex-column">
                                        <p class="card-text text-truncate mb-0">{{ Str::limit($produk->deskripsi, 50) }}</p>
                                    </div>

                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="d-flex justify-content-center mt-4">
                        {{ $produks->links() }}
                    </div>
                @else
                    <div class="alert alert-warning text-center">Tidak ada produk ditemukan dalam kategori ini.</div>
                @endif
            @endisset

        @endif

    </div>

@endsection