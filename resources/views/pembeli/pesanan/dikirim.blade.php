@extends('layouts.pembeli-navbar')

@section('title', 'Pesanan Dikirim & Diterima')

@section('content')
@php use App\Models\Ulasan; @endphp

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

                    <hr>
                    <p><strong>Produk dalam Pesanan:</strong></p>

                    @if($order->produks && $order->produks->count())
                        @foreach($order->produks as $produk)
                            @php
                                $sudahDinilai = Ulasan::where('users_id', auth()->id())
                                    ->where('orders_id', $order->id)
                                    ->where('produks_id', $produk->id)
                                    ->exists();
                            @endphp

                            <div class="border p-2 mb-2">
                                <p>🛍️ {{ $produk->nama }}</p>

                                @if(!$sudahDinilai)
                                    <form action="{{ route('pembeli.rating.store') }}" method="POST" class="mt-2">
                                        @csrf
                                        <input type="hidden" name="orders_id" value="{{ $order->id }}">
                                        <input type="hidden" name="produks_id" value="{{ $produk->id }}">

                                        <div class="mb-2">
                                            <label class="form-label">Rating:</label>
                                            <select name="bintang" class="form-select form-select-sm" required>
                                                <option value="">Pilih rating</option>
                                                @for($i = 1; $i <= 5; $i++)
                                                    <option value="{{ $i }}">{{ $i }} ⭐</option>
                                                @endfor
                                            </select>
                                        </div>

                                        <div class="mb-2">
                                            <label class="form-label">Ulasan:</label>
                                            <textarea name="ulasan" class="form-control form-control-sm" rows="2" required placeholder="Tulis ulasan singkat..."></textarea>
                                        </div>

                                        <button type="submit" class="btn btn-sm btn-primary">Kirim Ulasan</button>
                                    </form>
                                @else
                                    <div class="alert alert-success p-2 mt-2 mb-0">
                                        Anda sudah memberi ulasan untuk produk ini.
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    @else
                        <div class="alert alert-warning">Tidak ada produk terkait dengan pesanan ini.</div>
                    @endif
                </div>
            </div>
        @endforeach
    @else
        <div class="alert alert-info">Tidak ada pesanan yang sudah diterima.</div>
    @endif

    <a href="{{ route('pembeli.profile.show') }}" class="btn btn-secondary mt-3">Kembali ke Profil</a>
</div>
@endsection
