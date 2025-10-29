@extends('layouts.pembeli-navbar')

@section('content')

<style>
    /* Background halaman */
    body {
        background-color: #000000 !important; /* Putih */
        color: #000; /* Teks hitam default */
    }

    a.text-dark {
        color: #000 !important; /* Link teks hitam */
    }

    /* Card putih dengan teks hitam */
    .card-box, .list-group-item, .product-detail-desc {
        background-color: #fff;
        color: #000;
        border-radius: 12px;
        padding: 20px;
        border: 1px solid #e0e0e0;
    }

    /* Harga */
    .price ins {
        color: #dc3545; /* Diskon merah */
    }

    .price del {
        color: #6c757d; /* Harga asli abu-abu */
    }

    /* Rating bintang */
    .review-star {
        color: #f0ad4e;
    }

    /* Produk terkait */
    .card-box img {
        border-radius: 12px;
    }

    /* Teks tambahan */
    .text-color {
        color: #000;
    }
</style>

<div class="row">
    {{-- Gambar Produk --}}
    <div class="col-lg-6 col-md-12 col-sm-12 d-flex justify-content-center mb-4 mb-lg-0">
        <div class="product-slider slider-arrow w-100" style="max-width: 400px;">
            <div class="product-slide">
                @if ($produk->gambar)
                    <img src="{{ asset('storage/' . $produk->gambar) }}" class="img-fluid rounded" alt="{{ $produk->nama }}">
                @else
                    <img src="{{ asset('vendors/images/no-image.png') }}" class="img-fluid rounded" alt="Tidak ada gambar">
                @endif
            </div>
        </div>
    </div>

    {{-- Detail Produk --}}
    <div class="col-lg-6 col-md-12 col-sm-12">
        <div class="product-detail-desc card-box height-100-p">
            <h4 class="mb-3 pt-3 text-center">{{ $produk->nama }}</h4>
            <p>{{ $produk->deskripsi }}</p>

            <div class="price mb-3">
                @if ($produk->harga_setelah_diskon < $produk->harga)
                    @php
                        $diskon = 100 - round(($produk->harga_setelah_diskon / $produk->harga) * 100);
                    @endphp
                    <del class="text-muted">
                        Rp{{ number_format($produk->harga, 0, ',', '.') }}
                        <span class="badge bg-danger ms-2">{{ $diskon }}% OFF</span>
                    </del>
                    <br>
                    <ins class="fs-4 fw-bold text-danger">
                        Rp{{ number_format($produk->harga_setelah_diskon, 0, ',', '.') }}
                    </ins>
                @else
                    <ins class="fs-4 fw-bold text-primary">Rp{{ number_format($produk->harga, 0, ',', '.') }}</ins>
                @endif
            </div>

            <div class="mb-3">
                <label class="fw-bold">Stok tersedia:</label> {{ $produk->stok }}
            </div>

            {{-- Rating Produk --}}
            <div class="mb-3">
                <label class="fw-bold">Rating:</label>
                @php
                    $roundedRating = round($produk->rating ?? 0);
                @endphp
                @for ($i = 1; $i <= 5; $i++)
                    @if ($i <= $roundedRating)
                        <i class="review-star fa fa-star"></i>
                    @else
                        <i class="text-secondary fa fa-star-o"></i>
                    @endif
                @endfor
                <small>({{ number_format($produk->rating ?? 0, 1) }}/5)</small>
            </div>

            {{-- Form Add to Cart --}}
            <form action="{{ route('pembeli.keranjang.store') }}" method="POST" class="mt-2">
                @csrf
                <input type="hidden" name="produk_id" value="{{ $produk->id }}">
                <input type="hidden" name="quantity" value="1">
                <button type="submit" class="btn btn-success w-100">Tambah ke Keranjang</button>
            </form>

            {{-- Info Penjual --}}
            <hr class="mt-4 mb-3">
            <div class="mt-2">
                <h6 class="fw-bold">Dijual oleh:</h6>
                <p class="mb-0">{{ $produk->user->name ?? 'Penjual' }}</p>
                <p class="text-muted">{{ $produk->user->email ?? '-' }}</p>
            </div>
        </div>
    </div>
</div>

{{-- Ulasan Produk --}}
<div class="mt-5 text-color">
    <h5 class="mb-3">Ulasan Produk</h5>
    <div class="mb-4">
        <label class="fw-bold">Rating Rata-rata:</label>
        @php
            $roundedRating = round($produk->rating ?? 0);
            $jumlahUserUnik = $ulasan->groupBy('user_id')->count();
        @endphp
        <div class="mb-1">
            @for ($i = 1; $i <= 5; $i++)
                @if ($i <= $roundedRating)
                    <i class="review-star fa fa-star"></i>
                @else
                    <i class="text-secondary fa fa-star-o"></i>
                @endif
            @endfor
            <small>({{ number_format($produk->rating ?? 0, 1) }}/5 dari {{ $jumlahUserUnik }} pengguna)</small>
        </div>
    </div>

    @if($ulasan->isEmpty())
        <p class="text-muted">Belum ada ulasan untuk produk ini.</p>
    @else
        <div class="list-group">
            @foreach($ulasan as $review)
                <div class="list-group-item list-group-item-light mb-3 rounded">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <strong>{{ $review->user->name ?? 'Pengguna' }}</strong>
                        <small class="text-muted">{{ $review->created_at->format('d M Y') }}</small>
                    </div>
                    <div class="mb-1">
                        @for ($i = 1; $i <= 5; $i++)
                            @if ($i <= $review->rating)
                                <i class="review-star fa fa-star"></i>
                            @else
                                <i class="text-secondary fa fa-star-o"></i>
                            @endif
                        @endfor
                    </div>
                    <p>{{ $review->ulasan }}</p>
                </div>
            @endforeach
        </div>
    @endif
</div>

{{-- Produk Terkait --}}
<div class="mt-5 text-color">
    <h5 class="mb-3">Produk Lain dari Toko Ini</h5>
    <div class="row">
        @forelse ($produkTerkait as $item)
            <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                <div class="card-box shadow border-0 rounded h-100">
                    <div class="position-relative" style="height: 200px; overflow: hidden;">
                        @if ($item->gambar)
                            <img src="{{ asset('storage/' . $item->gambar) }}" class="w-100 h-100" style="object-fit: cover;" alt="{{ $item->nama }}">
                        @else
                            <img src="{{ asset('vendors/images/no-image.png') }}" class="w-100 h-100" style="object-fit: cover;" alt="Tidak ada gambar">
                        @endif
                    </div>
                    <div class="p-3">
                        <h6 class="fw-bold">
                            <a href="{{ route('pembeli.produk.show', $item->id) }}" class="text-dark text-decoration-none">
                                {{ $item->nama }}
                            </a>
                        </h6>
                        <div class="price text-primary fw-semibold">
                            Rp{{ number_format($item->harga, 0, ',', '.') }}
                        </div>
                        <a href="{{ route('pembeli.produk.show', $item->id) }}" class="btn btn-outline-primary mt-2 btn-sm w-100">Lihat Produk</a>
                    </div>
                </div>
            </div>
        @empty
            <p class="text-muted px-3">Belum ada produk lain dari toko ini.</p>
        @endforelse
    </div>
</div>

@endsection
