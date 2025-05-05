@extends('layouts.pembeli-navbar')

@section('content')
    <style>
        .card-img-top {
            height: 200px;
            object-fit: cover;
        }

        .section-title {
            margin-bottom: 30px;
            text-align: center;
        }

        .product-card, .kategori-card {
            margin-bottom: 30px;
            position: relative;
            overflow: hidden;
        }

        .kategori-overlay, .product-overlay {
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
    </style>

    <div class="container mt-5">
        <div class="section-title">
            <h2 class="mb-4 text-center">Mau Cari Apa {{ Auth::user()->name }}?</h2>
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

        {{-- Kategori --}}
        <div class="row mb-5">
            @foreach($kategoris as $kategori)
                <div class="col-lg-3 col-md-6 col-sm-12 mb-4">
                    <div class="card kategori-card shadow border-0">
                        @if($kategori->gambar)
                            <img src="{{ asset('storage/kategori/' . basename($kategori->gambar)) }}" class="card-img-top"
                                alt="{{ $kategori->nama }}">
                        @else
                            <img src="{{ asset('images/default.jpg') }}" class="card-img-top" alt="Default">
                        @endif
                        <div class="kategori-overlay d-flex justify-content-center align-items-center">
                            <h5 class="text-white text-center">{{ $kategori->nama }}</h5>
                        </div>
                        <a href="{{ route('pembeli.dashboard', ['kategori' => $kategori->id]) }}" class="stretched-link"></a>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Produk --}}
        <div class="section-title">
            <p class="lead">Temukan produk yang anda mau</p>
        </div>
        <div class="row">
            @forelse ($produks as $produk)
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="card shadow border-0 product-card h-100">
                        @if ($produk->gambar)
                            <img src="{{ asset('storage/' . $produk->gambar) }}" class="card-img-top" alt="{{ $produk->nama }}">
                        @else
                            <img src="{{ asset('images/default.jpg') }}" class="card-img-top" alt="Default Image">
                        @endif

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

        <div class="d-flex justify-content-center mt-4">
            {{ $produks->withQueryString()->links() }}
        </div>
    </div>
@endsection
