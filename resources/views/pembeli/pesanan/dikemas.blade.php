@extends('layouts.pembeli-navbar')

@section('title', 'Pesanan Dikemas')

@section('content')
<style>
    body {
        background-color: black !important;
        color: white; /* agar tulisan terlihat */
    }
    .card {
        background-color: #222; /* card gelap */
        color: white;
    }
    .badge.bg-info {
        background-color: #17a2b8 !important;
    }
</style>

<div class="container mt-4">
    <h3 class="mb-3">Pesanan Sedang Dikemas</h3>

    @forelse ($orders as $order)
        <div class="card mb-3">
            <div class="card-body">
                <h5>Invoice: {{ $pesanan->invoice ?? '-' }}</h5>
                <p><strong>Nama Produk:</strong> {{ $pesanan->produk->nama ?? 'Tidak tersedia' }}</p>
                <p><strong>Total:</strong> Rp{{ number_format($pesanan->total_harga ?? 0, 0, ',', '.') }}</p>
                <p><strong>Status:</strong> 
                    <span class="badge bg-info text-white">
                        {{ ucfirst($pesanan->status_pesanan ?? '-') }}
                    </span>
                </p>
                <p><strong>Tanggal Pesanan:</strong> 
                    {{ $pesanan->created_at ? $pesanan->created_at->format('d-m-Y H:i') : '-' }}
                </p>
            </div>
        </div>
    @empty
        <div class="alert alert-warning">Belum ada pesanan yang sedang dikemas.</div>
    @endforelse

    <div class="mt-4 text-center">
        <a href="{{ route('pembeli.pesanan.index') }}" class="btn btn-primary">Kembali ke Daftar Pesanan</a>
    </div>
</div>
@endsection
