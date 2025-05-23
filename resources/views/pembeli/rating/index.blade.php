@extends('layouts.pembeli-navbar')

@section('content')
<style>
    body {
        background-color: black !important;
        color: white;
    }
</style>

<div class="container mt-4 text-color">
    <h2>Rating dan Ulasan Saya</h2>

    {{-- Produk Belum Dinilai --}}
    <h4 class="mt-4">Belum Dinilai</h4>
    @if(empty($produkBelumDinilai) || count($produkBelumDinilai) === 0)
        <div class="alert alert-info">Tidak ada pesanan dengan status diterima yang belum dinilai.</div>
    @else
        <table class="table table-striped table-dark">
            <thead>
                <tr>
                    <th>Nomor Pesanan</th>
                    <th>Produk</th>
                    <th>Status Pesanan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($produkBelumDinilai as $item)
                    @php
                        $order = $item->order;
                        $produk = $item->produk;
                    @endphp
                    <tr>
                        <td>{{ $order->invoice ?? 'INV-' . $order->id }}</td>
                        <td>{{ $produk->nama ?? '-' }}</td>
                        <td>{{ ucfirst(str_replace('_', ' ', $order->status_pesanan ?? 'Unknown')) }}</td>
                        <td>
                            <a href="{{ route('pembeli.rating.create', ['order' => $order->id, 'product' => $produk->id]) }}" class="btn btn-sm btn-primary">
                                Beri Ulasan
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    {{-- Produk Sudah Dinilai --}}
    <h4 class="mt-5">Sudah Dinilai</h4>
    @if(empty($produkSudahDinilai) || count($produkSudahDinilai) === 0)
        <div class="alert alert-info">Belum ada ulasan yang diberikan.</div>
    @else
        <table class="table table-striped table-dark">
            <thead>
                <tr>
                    <th>Nomor Pesanan</th>
                    <th>Produk</th>
                    <th>Rating</th>
                    <th>Ulasan</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($produkSudahDinilai as $ulasan)
                    @php
                        $produk = $ulasan->produk;
                        $order = $ulasan->order;
                    @endphp
                    <tr>
                        <td>{{ $order->invoice ?? 'INV-' . $order->id }}</td>
                        <td>{{ $produk->nama ?? '-' }}</td>
                        <td>{{ $ulasan->bintang }} ⭐</td>
                        <td>{{ $ulasan->ulasan }}</td>
                        <td>{{ $ulasan->created_at->format('d-m-Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

</div>
@endsection
