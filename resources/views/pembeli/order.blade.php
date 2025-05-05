@extends('layouts.pembeli-navbar')

@section('content')
<div class="container my-5">

    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card shadow border-0 rounded p-4">
                <div class="row g-4">
                    {{-- Kolom Gambar dan Info Produk --}}
                    <div class="col-md-5">
                        <div class="card border-0 shadow-sm">
                            @if ($produk->gambar)
                                <img src="{{ asset('storage/' . $produk->gambar) }}" class="card-img-top" alt="{{ $produk->nama }}" style="max-height: 250px; object-fit: cover;">
                            @else
                                <img src="{{ asset('images/default.jpg') }}" class="card-img-top" alt="Default">
                            @endif

                            <div class="card-body">
                                <h5 class="card-title fw-bold">{{ $produk->nama }}</h5>
                                <p class="card-text">{{ $produk->deskripsi }}</p>
                                <p class="card-text">Harga: Rp{{ number_format($produk->harga, 0, ',', '.') }}</p>
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
                                <input type="text" name="name" class="form-control" placeholder="Masukkan Nama Lengkap Anda!">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Nomor HP</label>
                                <input type="text" name="phone" class="form-control" placeholder="Masukkan Nomor HP/WA!">
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Alamat Pengiriman</label>
                                <textarea name="alamat" class="form-control" rows="4" placeholder="Masukkan Alamat Lengkap Anda!"></textarea>
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
