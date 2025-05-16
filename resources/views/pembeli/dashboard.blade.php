@extends('layouts.pembeli-navbar')

@section('content')
    <style>
        body {
            background-color: #f5e6cc;
        }

        .card-img-top {
            height: 200px;
            object-fit: cover;
        }

        .section-title {
            margin-bottom: 30px;
            text-align: center;
        }

        .product-card,
        .kategori-card {
            margin-bottom: 30px;
            position: relative;
            overflow: hidden;
        }

        .kategori-overlay,
        .product-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.4);
            opacity: 0;
            transition: opacity 0.3s ease-in-out;
            z-index: 1;
        }

        .kategori-card:hover .kategori-overlay,
        .product-card:hover .product-overlay {
            opacity: 1;
        }

        .kategori-item {
            flex: 0 0 auto;
            width: 220px;
        }

        .subkategori-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: flex-start;
        }

        .card-subkategori {
            width: 220px;
        }

        .img-fixed {
            height: 160px;
            object-fit: cover;
        }
    </style>

    <div class="container mt-5">
        <!-- Judul Halaman -->
        <div class="section-title">
            <h2>===========================</h2>
            <h1>KATEGORI PRODUK</h1>
            <h2>----------------------------</h2>
            <p class="lead">Temukan produk terbaik dari UMKM Indramayu</p>
        </div>

        <!-- Notifikasi -->
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

        <!-- Kategori Utama -->
        <div class="row mb-5">
            @forelse($kategoris as $kategori)
                <div class="col-lg-3 col-md-6 col-sm-12 mb-4">
                    <div class="card kategori-card shadow border-0">
                        <img src="{{ $kategori->gambar ? asset('storage/kategori/' . basename($kategori->gambar)) : asset('images/default.jpg') }}"
                            class="card-img-top" alt="{{ $kategori->nama }}">
                        <div class="kategori-overlay d-flex justify-content-center align-items-center">
                            <h5 class="text-white text-center">{{ $kategori->nama }}</h5>
                        </div>
                        <a href="{{ route('pembeli.dashboard', ['kategori' => $kategori->id]) }}" class="stretched-link"></a>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center">
                    <div class="alert alert-warning">Belum ada kategori tersedia.</div>
                </div>
            @endforelse
        </div>

        <!-- Subkategori & Sub-subkategori -->
        @if ($kategoriAktif && $subkategoris->count())
            <div class="section-title">
                <h3>Subkategori & Produk dari: {{ $kategoriAktif->nama }}</h3>
            </div>

            <div class="subkategori-grid mb-5">
                @foreach ($subkategoris as $sub)
                    <div class="card shadow-sm card-subkategori">
                        <img src="{{ $sub->gambar ? asset('storage/kategori/' . basename($sub->gambar)) : asset('images/default.jpg') }}"
                            class="card-img-top img-fixed" alt="{{ $sub->nama }}">
                        <div class="card-body text-center">
                            <h5>{{ $sub->nama }}</h5>

                            @if ($sub->produks->count())
                                <ul class="mt-2 text-start small">
                                    @foreach ($sub->produks as $produk)
                                        <li>{{ $produk->nama }}</li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="text-muted"></p>
                            @endif
                        </div>

                        {{-- Sub-subkategori --}}
                        @if ($sub->children->count())
                            <div class="card-footer bg-light">
                                <strong class="d-block text-center">{{ $kategoriAktif->nama ?? 'Kategori' }}</strong>
                                @foreach ($sub->children as $subchild)
                                    <div class="card shadow-sm my-2 mx-auto" style="width: 180px;">
                                        <a href="{{ route('pembeli.dashboard', ['kategori' => $subchild->id]) }}">
                                            <img src="{{ $subchild->gambar ? asset('storage/kategori/' . basename($subchild->gambar)) : asset('images/default.jpg') }}"
                                                class="card-img-top img-fixed" alt="{{ $subchild->nama }}">
                                            <div class="card-body p-2">
                                                <p class="text-center small">{{ $subchild->nama }}</p>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif

        <!-- Semua Produk -->
        <div class="section-title mt-5">
            <h2>==================================</h2>
            <h2>PRODUK</h2>
            <p class="lead">Temukan produk yang anda mau</p>
            <h2>-------------------------------</h2>
        </div>

        <div class="row">
            @forelse ($produks as $produk)
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="card shadow border-0 product-card h-100">
                        <img src="{{ $produk->gambar ? asset('storage/' . $produk->gambar) : asset('images/default.jpg') }}"
                            class="card-img-top" alt="{{ $produk->nama }}">
                        <div class="product-overlay d-flex justify-content-center align-items-center">
                            <a href="{{ route('pembeli.produk.show', $produk->id) }}" class="stretched-link"></a>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">{{ $produk->nama }}</h5>
                            <p class="card-text">{{ Str::limit($produk->deskripsi, 60) }}</p>
                            <p class="card-text"><strong>Rp {{ number_format($produk->harga, 0, ',', '.') }}</strong></p>
                        </div>
                        <div class="card-footer bg-transparent border-top-0">
                            <form action="{{ route('pembeli.keranjang.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="produk_id" value="{{ $produk->id }}">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="btn btn-success w-100">Tambah ke Keranjang</button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center">
                    <div class="alert alert-warning">Tidak ada produk ditemukan.</div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
            {{ $produks->withQueryString()->links() }}
        </div>
    </div>
@endsection