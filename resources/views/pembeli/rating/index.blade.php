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

    @if(empty($produkBelumDinilai) || count($produkBelumDinilai) === 0)
        <p>Tidak ada pesanan dengan status diterima.</p>
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
                        $produk = $item->produk; // diasumsikan ini objek produk, bukan koleksi
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
</div>
@endsection
