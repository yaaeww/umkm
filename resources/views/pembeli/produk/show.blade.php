@extends('layouts.pembeli-navbar')

@section('content')
<div class="row">
    {{-- Gambar Produk --}}
    <div class="col-lg-6 col-md-12 col-sm-12 d-flex justify-content-center">
        <div class="product-slider slider-arrow">
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
        <div class="product-detail-desc pd-20 card-box height-100-p">
            <h4 class="mb-20 pt-20">{{ $produk->nama }}</h4>
            <p>{{ $produk->deskripsi }}</p>

            <div class="price">
                <ins class="fs-4 fw-bold text-primary">Rp{{ number_format($produk->harga, 0, ',', '.') }}</ins>
            </div>

            <div class="mb-3">
                <label class="text-blue fw-bold">Stok tersedia:</label> {{ $produk->stok }}
            </div>

            {{-- Rating Produk --}}
            <div class="mb-3">
                <label class="text-blue fw-bold">Rating:</label>
                @for ($i = 1; $i <= 5; $i++)
                    @if ($i <= round($produk->rating ?? 0))
                        <i class="text-warning fa fa-star"></i>
                    @else
                        <i class="text-secondary fa fa-star-o"></i>
                    @endif
                @endfor
                <small>({{ number_format($produk->rating ?? 0, 1) }}/5)</small>
            </div>

            {{-- Form untuk Add to Cart --}}
            <form action="{{ route('pembeli.keranjang.store') }}" method="POST" class="mt-2">
                @csrf
                <input type="hidden" name="produk_id" value="{{ $produk->id }}">
                <input type="hidden" name="quantity" value="1">
                <button type="submit" class="btn btn-success w-100">Tambah ke Keranjang</button>
            </form>

            {{-- Info Toko Penjual --}}
            <hr class="mt-4 mb-3">
            <div class="mt-2">
                <h6 class="fw-bold">Dijual oleh:</h6>
                <p class="mb-0">{{ $produk->user->name }}</p>
                <p class="text-muted">{{ $produk->user->email }}</p>
            </div>
        </div>
    </div>
</div>

{{-- Produk Terkait --}}
<div class="mt-5">
    <h5 class="mb-3">Produk Lain dari Toko Ini</h5>
    <div class="product-list">
        <ul class="row">
            @forelse ($produkTerkait as $item)
                <li class="col-lg-4 col-md-6 col-sm-12 mb-4">
                    <div class="product-box card">
                        <div class="product-img">
                            @if ($item->gambar)
                                <img src="{{ asset('storage/' . $item->gambar) }}" class="card-img-top" alt="{{ $item->nama }}">
                            @else
                                <img src="{{ asset('vendors/images/no-image.png') }}" class="card-img-top" alt="Tidak ada gambar">
                            @endif
                        </div>
                        <div class="product-caption p-3">
                            <h6><a href="{{ route('pembeli.produk.show', $item->id) }}">{{ $item->nama }}</a></h6>
                            <div class="price">
                                <ins>Rp{{ number_format($item->harga, 0, ',', '.') }}</ins>
                            </div>
                            <a href="{{ route('pembeli.produk.show', $item->id) }}" class="btn btn-outline-primary mt-2 btn-sm">Lihat Produk</a>
                        </div>
                    </div>
                </li>
            @empty
                <p class="text-muted px-3">Belum ada produk lain dari toko ini.</p>
            @endforelse
        </ul>
    </div>
</div>

@endsection
