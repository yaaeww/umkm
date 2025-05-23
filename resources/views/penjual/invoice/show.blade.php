@extends('layouts.app')
@section('page_title', 'Invoice')

@section('title')
    <i class="icon-copy bi bi-cash-stack"></i> Detail Pesanan
@endsection
@section('content')
@php
    use Illuminate\Support\Number;
@endphp

<style>
    /* Contoh style untuk text-theme, ganti sesuai warna tema kamu */
    .text-theme {
        color: #0d6efd; /* contoh biru bootstrap primary */
    }

    /* Override teks pada tabel agar sesuai text-theme */
    .text-theme table thead th {
        color: #0d6efd;
    }

    /* Override tombol agar teksnya mengikuti text-theme */
    .text-theme .btn {
        color: #0d6efd;
        border-color: #0d6efd;
    }

    /* Tombol hover tetap ada efek */
    .text-theme .btn:hover {
        color: #000000;
        background-color: #0d6efd;
        border-color: #0d6efd;
    }
    .text-color{
        color: #000000;
    }
</style>

<div class="card shadow-sm p-4 bg-white rounded text-theme">
    <div class="text-center mb-4">
        <h4 class="mt-3">INVOICE PEMESANAN</h4>
    </div>

    <div class="row mb-4 text-color">
        <div class="col-md-6">
            <h6>Data Pembeli</h6>
            <p class="mb-1">Tanggal Pesanan: <strong>{{ $order->created_at->format('d M Y') }}</strong></p>
            <p class="mb-1">Invoice: <strong>INV-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</strong></p>
            <p class="mb-1">Status: <strong>{{ ucfirst($order->status) }}</strong></p>
        </div>
        <div class="col-md-6 text-md-end text-color">
            <p class="mb-1">Nama: {{ $order->name }}</p>
            <p class="mb-1">Alamat: {{ $order->alamat }}</p>
            <p class="mb-1">No. HP: {{ $order->phone }}</p>
        </div>
    </div>

    <div class="table-responsive mb-4 text-color">
        <table class="table table-bordered text-color">
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
                    <td>{{ Number::currency($order->produk->harga, 'IDR', locale: 'id_ID') }}</td>
                    <td>{{ $order->jumlah }}</td>
                    <td>{{ Number::currency($order->total_harga, 'IDR', locale: 'id_ID') }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="row mb-4">
        <div class="col-md-6 text-color">
            <h6>Info Tambahan</h6>
            <p class="mb-1">Metode Pembayaran: <strong>Transfer Bank</strong></p>
            <p class="mb-1">Bank Tujuan: <strong>BCA - 123456789</strong></p>
        </div>
        <div class="col-md-6 text-md-end text-color">
            <p class="mb-1">Jatuh Tempo: <strong>{{ $order->created_at->addDays(1)->format('d M Y') }}</strong></p>
            <h5 class="mt-2">Total: {{ Number::currency($order->total_harga, 'IDR', locale: 'id_ID') }}</h5>
        </div>
    </div>

    <div class="mt-4 text-center">
        <a href="{{ route('penjual.pesanan.index') }}" class="btn btn-outline-primary me-2">Kembali ke Daftar Pesanan</a>
        <a href="{{ route('penjual.pesanan.invoice.pdf', $order->id) }}" class="btn btn-outline-primary">Cetak PDF</a>
    </div>
</div>
@endsection
