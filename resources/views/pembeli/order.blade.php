@extends('layouts.pembeli-navbar')

@section('content')
<div class="container my-5">
<style>
    body {
        background-color: black !important;
    }
</style>

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow border-0 rounded p-4">
                <div class="row g-4">
                    {{-- Kolom Gambar dan Info Produk --}}
                    <div class="col-md-5">
                        <div class="card border-0 shadow-sm">
                            @if ($produk->gambar)
                            <img src="{{ asset('storage/' . $produk->gambar) }}" class="card-img-top"
                                alt="{{ $produk->nama }}" style="max-height: 250px; object-fit: cover;">
                            @else
                            <img src="{{ asset('images/default.jpg') }}" class="card-img-top" alt="Default">
                            @endif

                            <div class="card-body">
                                <h5 class="card-title fw-bold">{{ $produk->nama }}</h5>
                                <p class="card-text">{{ $produk->deskripsi }}</p>

                                {{-- Tampilkan harga dengan diskon --}}
                                @if($harga_diskon < $produk->harga)
                                <p class="card-text">
                                    Harga: <del>Rp{{ number_format($produk->harga, 0, ',', '.') }}</del>
                                    <span class="text-danger fw-bold">Rp{{ number_format($harga_diskon, 0, ',', '.') }}</span>
                                </p>
                                @else
                                <p class="card-text">Harga: Rp{{ number_format($produk->harga, 0, ',', '.') }}</p>
                                @endif

                                <p class="card-text">Jumlah: {{ $quantity }}</p>
                                <p class="card-text"><strong>Total: Rp{{ number_format($total_harga, 0, ',', '.') }}</strong></p>
                            </div>
                        </div>
                    </div>

                    {{-- Kolom Form Pemesanan --}}
                    <div class="col-md-7">
                        <h5 class="mb-3">Isi Data Pemesanan</h5>
                        <form action="{{ route('pembeli.checkout') }}" method="POST">
                            @csrf
                            <input type="hidden" name="produk_id" value="{{ $produk->id }}">
                            <input type="hidden" name="jumlah" value="{{ $quantity }}">

                            <div class="mb-3">
                                <label class="form-label">Nama Lengkap</label>
                                <input type="text" name="name" class="form-control"
                                    placeholder="Masukkan Nama Lengkap Anda!" required
                                    value="{{ old('name') }}">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Nomor HP</label>
                                <input type="text" name="phone" class="form-control"
                                    placeholder="Masukkan Nomor HP/WA!" required
                                    value="{{ old('phone') }}">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Alamat Pengiriman</label>
                                <textarea name="alamat" class="form-control" rows="4" placeholder="Masukkan Alamat Lengkap Anda!" required>{{ old('alamat') }}</textarea>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">Pesan Sekarang</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
