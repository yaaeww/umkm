@extends('layouts.pembeli-navbar')

@section('content')
<style>
    body {
        background-color: black !important;
    }
</style>
<div class="container mt-5">
    <h1 class="mb-4 text-center">Detail Pesanan</h1>

    <div class="card mb-4">
        <div class="card-body">
            <h5>Kode Pesanan: {{ $pesanan->kode_pesanan }}</h5>
            <p>Status: <span class="badge bg-info">{{ ucfirst($pesanan->status) }}</span></p>
            <p>Alamat Pengiriman: {{ $pesanan->alamat_pengiriman }}</p>
            <p>Metode Pembayaran: {{ strtoupper($pesanan->metode_pembayaran) }}</p>
            <p>Total Harga: Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</p>
            <p>Tanggal Pesan: {{ $pesanan->created_at->format('d M Y H:i') }}</p>
        </div>
    </div>

    <h4>Produk yang Dipesan:</h4>
    <div class="row">
        @foreach ($pesanan->pesananDetails as $detail)
            <div class="col-md-4">
                <div class="card mb-3">
                    @if ($detail->produk && $detail->produk->gambar)
                        <img src="{{ asset('storage/' . $detail->produk->gambar) }}" class="card-img-top" alt="{{ $detail->produk->nama }}">
                    @else
                        <img src="{{ asset('images/default.jpg') }}" class="card-img-top" alt="Default Image">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $detail->produk->nama ?? '-' }}</h5>
                        <p>Harga: Rp {{ number_format($detail->harga, 0, ',', '.') }}</p>
                        <p>Jumlah: {{ $detail->jumlah }}</p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <a href="{{ route('pembeli.pesanan.index') }}" class="btn btn-secondary mt-3">Kembali ke Pesanan Saya</a>
</div>
@endsection
