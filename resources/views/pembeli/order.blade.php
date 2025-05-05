@extends('layouts.pembeli-navbar')

@section('content')
<div class="container">
    <h1 class="my-4">Form Pemesanan Produk</h1>

    {{-- Card Produk --}}
    {{-- Card Produk --}}
<div class="card shadow rounded border-0 mb-4" style="max-width: 500px">
    @if ($produk->gambar)
        <img src="{{ asset('storage/' . $produk->gambar) }}" class="card-img-top" alt="{{ $produk->nama }}">
    @endif

    <div class="card-body">
        <h5 class="card-title fw-bold">{{ $produk->nama }}</h5>
        <p class="card-text">{{ $produk->deskripsi }}</p>
        <p class="card-text">Harga: Rp{{ number_format($produk->harga, 0, ',', '.') }}</p>
        <p class="card-text">Jumlah: {{ $quantity }}</p>
        <p class="card-text">
            Total: <strong>Rp{{ number_format($total_harga, 0, ',', '.') }}</strong>
        </p>
    </div>
</div>


    {{-- Form Pemesanan --}}
    <div class="card shadow rounded border-0 p-4" style="max-width: 500px">
        <form action="{{ route('pembeli.checkout') }}" method="POST">
            @csrf
            <input type="hidden" name="produk_id" value="{{ $produk->id }}">
            <input type="hidden" name="jumlah" value="{{ $quantity }}">


            <div class="mb-3">
                <label class="form-label">Nama Lengkap</label>
                <input type="text" name="name" class="form-control" id="name" placeholder="Masukkan Nama Lengkap Anda!">
            </div>

            <div class="mb-3">
                <label class="form-label">Nomor HP</label>
                <input type="text" name="phone" class="form-control" id="phone" placeholder="Masukkan Nomor HP/WA!">
            </div>

            <div class="mb-3">
                <label class="form-label">Alamat Pengiriman</label>
                <textarea name="alamat" class="form-control" rows="3" id="alamat" placeholder="Masukkan Alamat Lengkap Anda!"></textarea>
            </div>

            <button type="submit" class="btn btn-primary w-100" style="background-color: #0000ff;">Pesan Sekarang</button>
        </form>
    </div>
</div>
@endsection
