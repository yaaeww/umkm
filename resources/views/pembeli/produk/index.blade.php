@extends('layouts.pembeli-navbar')

@section('content')
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        body {
            background-color: black !important;
            color: white;
        }

        .card-img-top {
            height: 200px;
            object-fit: cover;
        }

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

        .product-card:hover .product-overlay {
            opacity: 1;
        }

        .product-card {
            position: relative;
            overflow: hidden;
        }

        /* Harga diskon */
        .price-original {
            text-decoration: line-through;
            color: #dc3545; /* bootstrap danger */
            font-size: 0.9rem;
            margin-right: 0.5rem;
        }

        .badge-discount {
            background-color: #dc3545;
            font-size: 0.75rem;
            margin-left: 0.3rem;
        }
        
    </style>

    <div class="container mt-5">
        <div class="section-title text-center mb-4 text-dark">
            <h2>Semua Produk</h2>
            <p class="lead text-dark">Lihat produk dari berbagai UMKM di Indramayu</p>
        </div>

        <div class="row">
            @forelse ($produks as $produk)
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="card shadow border-0 product-card h-100 bg-dark text-white">
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
                            <p class="card-text">
                                @if(isset($produk->harga_setelah_diskon) && $produk->harga_setelah_diskon < $produk->harga)
                                    @php
                                        $diskon = 100 - round(($produk->harga_setelah_diskon / $produk->harga) * 100);
                                    @endphp
                                    <span class="price-original">
                                        Rp{{ number_format($produk->harga, 0, ',', '.') }}
                                        <span class="badge badge-discount text-white">{{ $diskon }}% OFF</span>
                                    </span><br>
                                    <span class="fs-5 fw-bold text-warning">
                                        Rp{{ number_format($produk->harga_setelah_diskon, 0, ',', '.') }}
                                    </span>
                                @else
                                    <span class="fs-5 fw-bold text-primary">
                                        Rp{{ number_format($produk->harga, 0, ',', '.') }}
                                    </span>
                                @endif
                            </p>
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
