@extends('layouts.pembeli-navbar')

@section('title', 'Invoice')

@section('content')

<link rel="stylesheet" href="{{ asset('vendors/styles/invoice.css') }}"> {{-- pastikan file ini ada --}}
<div class="card shadow-sm p-4 bg-white rounded">
    <div class="text-center mb-4">
        
        <h4 class="mt-3">INVOICE</h4>
    </div>

    <div class="row mb-4">
        <div class="col-md-6">
            <h6>Data Pembeli</h6>
            <p class="mb-1">Tanggal: <strong>{{ $order->created_at->format('d M Y') }}</strong></p>
            <p class="mb-1">No. Invoice: <strong>INV-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</strong></p>
        </div>
        <div class="col-md-6 text-md-end">
            <p class="mb-1">Nama: {{ $order->name }}</p>
            <p class="mb-1">Alamat: {{ $order->alamat }}</p>
            <p class="mb-1">No. HP: {{ $order->phone }}</p>
        </div>
    </div>

    <div class="table-responsive mb-4">
        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th>Produk</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $order->produk->nama }}</td>
                    <td>Rp {{ number_format($order->produk->harga, 0, ',', '.') }}</td>
                    <td>{{ $order->jumlah }}</td>
                    <td>Rp {{ number_format($order->total_harga, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="row mb-4">
        <div class="col-md-6">
            <h6>Informasi Bank</h6>
            <p class="mb-1">No. Rekening: <strong>123 456 789</strong></p>
            <p class="mb-1">Kode Bank: <strong>002</strong></p>
        </div>
        <div class="col-md-6 text-md-end">
            <p class="mb-1">Jatuh Tempo: <strong>{{ $order->created_at->addDays(1)->format('d M Y') }}</strong></p>
            <h5 class="text-danger mt-2">Total Bayar: Rp {{ number_format($order->total_harga, 0, ',', '.') }}</h5>
        </div>
    </div>

    <div class="text-center mt-4">
        <h5 class="text-success">Terima Kasih!!</h5>
    </div>
</div>

@endsection
