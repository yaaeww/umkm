@extends('layouts.pembeli-navbar')

@section('title', 'Pesanan Dikirim & Diterima')

@section('content')
<style>
    body {
        background-color: black !important;
    }
</style>
<div class="container mt-4">
    <h4>Pesanan Sedang Dikirim</h4>

    @php
        $dikirimOrders = $orders->where('status_pesanan', 'dikirim');
        $diterimaOrders = $orders->where('status_pesanan', 'diterima');
    @endphp

    @if($dikirimOrders->count())
        @foreach($dikirimOrders as $order)
            <div class="card mb-3">
                <div class="card-body">
                    <p><strong>Nomor Pesanan:</strong> {{ $order->invoice ?? 'INV-' . $order->id }}</p>
                    <p><strong>Status:</strong> <span class="badge bg-primary">{{ ucfirst($order->status_pesanan) }}</span></p>
                    <p><strong>Total:</strong> Rp{{ number_format($order->total_harga, 0, ',', '.') }}</p>
                    <p><strong>Tanggal:</strong> {{ $order->created_at->format('d-m-Y') }}</p>

                    <form action="{{ route('pembeli.pesanan.updateStatus', $order->id) }}" method="POST" onsubmit="return confirm('Yakin ingin mengonfirmasi pesanan ini sudah diterima?')">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-success btn-sm mt-2">Konfirmasi Diterima</button>
                    </form>
                </div>
            </div>
        @endforeach
    @else
        <div class="alert alert-info">Tidak ada pesanan yang sedang dikirim.</div>
    @endif

    <hr class="my-4">

    <h4>Pesanan Diterima</h4>

    @if($diterimaOrders->count())
        @foreach($diterimaOrders as $order)
            <div class="card mb-3 border-success">
                <div class="card-body">
                    <p><strong>Nomor Pesanan:</strong> {{ $order->invoice ?? 'INV-' . $order->id }}</p>
                    <p><strong>Status:</strong> <span class="badge bg-success">{{ ucfirst($order->status_pesanan) }}</span></p>
                    <p><strong>Total:</strong> Rp{{ number_format($order->total_harga, 0, ',', '.') }}</p>
                    <p><strong>Tanggal Diterima:</strong> {{ $order->updated_at->format('d-m-Y') }}</p>
                </div>
            </div>
        @endforeach
    @else
        <div class="alert alert-info">Tidak ada pesanan yang sudah diterima.</div>
    @endif

    <a href="{{ route('pembeli.profile.show') }}" class="btn btn-secondary mt-3">Kembali ke Profil</a>
</div>
@endsection
