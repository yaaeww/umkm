@extends('layouts.pembeli-navbar')

@section('title', 'Pesanan Dikirim & Diterima')

@section('content')
    @php use App\Models\Ulasan; @endphp
    <style>
        body {
            background-color: black !important;
            color: white;
        }
        .card {
            background-color: #222;
            color: white;
        }
        .badge.bg-primary {
            background-color: #007bff !important;
        }
        .badge.bg-success {
            background-color: #28a745 !important;
        }
        table {
            color: white;
        }
    </style>
    <div class="container mt-4">
        <h4>Pesanan Sedang Dikirim</h4>

        @php
            $dikirimOrders = $orders->where('status_pesanan', 'dikirim');
            $diterimaOrders = $orders->where('status_pesanan', 'diterima');
        @endphp

        {{-- Pesanan Dikirim --}}
        @if($dikirimOrders->count())
            @foreach($dikirimOrders as $order)
                <div class="card mb-3">
                    <div class="card-body">
                        <p><strong>Nomor Pesanan:</strong> {{ $order->invoice ?? 'INV-' . $order->id }}</p>
                        <p><strong>Status:</strong> <span class="badge bg-primary">{{ ucfirst($order->status_pesanan) }}</span></p>
                        <p><strong>Total:</strong> Rp{{ number_format($order->total_harga, 0, ',', '.') }}</p>
                        <p><strong>Tanggal:</strong> {{ $order->created_at->format('d-m-Y') }}</p>

                        <form action="{{ route('pembeli.pesanan.updateStatus', $order->id) }}" method="POST"
                              onsubmit="return confirm('Yakin ingin mengonfirmasi pesanan ini sudah diterima?')">
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

        {{-- Pesanan Diterima --}}
        <h4>Pesanan Diterima</h4>

        @if($diterimaOrders->count())
            <table class="table table-striped table-dark">
                <thead>
                    <tr>
                        <th>Nomor Pesanan</th>
                        <th>Status</th>
                        <th>Total Harga</th>
                        <th>Tanggal Diterima</th>
                        <th>Produk</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($diterimaOrders as $order)
                        @php
                            $produk = $order->produk; // pastikan relasi ada
                            $sudahDinilai = Ulasan::where('users_id', auth()->id())
                                ->where('orders_id', $order->id)
                                ->where('produks_id', $produk->id)
                                ->exists();
                        @endphp
                        <tr>
                            <td>{{ $order->invoice ?? 'INV-' . $order->id }}</td>
                            <td><span class="badge bg-success">{{ ucfirst($order->status_pesanan) }}</span></td>
                            <td>Rp{{ number_format($order->total_harga, 0, ',', '.') }}</td>
                            <td>{{ $order->updated_at->format('d-m-Y') }}</td>
                            <td>{{ $produk->nama }}</td>
                            <td>
                                @if(!$sudahDinilai)
                                    <a href="{{ route('pembeli.rating.create', ['order' => $order->id, 'product' => $produk->id]) }}" class="btn btn-sm btn-primary">
                                        Beri Ulasan
                                    </a>
                                @else
                                    <span class="badge bg-secondary">Sudah Dinilai</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div class="alert alert-info">Tidak ada pesanan yang sudah diterima.</div>
        @endif

        <a href="{{ route('pembeli.profile.show') }}" class="btn btn-secondary mt-3">Kembali ke Profil</a>
    </div>
@endsection
