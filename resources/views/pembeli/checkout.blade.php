@extends('layouts.pembeli-navbar')

@section('title', 'Checkout Pesanan')

@section('content')
<div class="container py-5">
    <h1 class="text-center mb-5">Checkout Pesanan</h1>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="row">
        <!-- Detail Produk -->
        <div class="col-md-7 mb-4">
            <h4>Detail Produk</h4>
            <div class="card shadow-sm">
                <div class="card-body">
                    @php $total = 0; @endphp

                    @foreach ($items as $item)
                        @php
                            $produk = $item->produk ?? null;
                            $jumlah = $item->jumlah ?? 1;
                            $harga = $produk->harga ?? 0;
                            $subtotal = $harga * $jumlah;
                            $total += $subtotal;
                        @endphp

                        @if ($produk)
                            <div class="d-flex justify-content-between align-items-center border-bottom py-2">
                                <div>
                                    <h6 class="mb-1">{{ $produk->nama_produk }}</h6>
                                    <small>Jumlah: {{ $jumlah }}</small><br>
                                    <small>Harga: Rp {{ number_format($harga, 0, ',', '.') }}</small>
                                </div>
                                <div class="text-end">
                                    <strong>Rp {{ number_format($subtotal, 0, ',', '.') }}</strong>
                                </div>
                            </div>
                        @else
                            <div class="alert alert-warning py-2">
                                Salah satu produk tidak tersedia.
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Form Alamat dan Ringkasan -->
        <div class="col-md-5">
            <h4>Alamat Pengiriman</h4>
            <div class="card shadow-sm">
                <div class="card-body">
                    <form action="{{ route('pembeli.checkout.store') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="alamat_pengiriman" class="form-label">Alamat Lengkap</label>
                            <textarea class="form-control" id="alamat_pengiriman" name="alamat_pengiriman" rows="3" required>{{ old('alamat_pengiriman') }}</textarea>
                            @error('alamat_pengiriman')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <h5 class="mt-4">Total Bayar:</h5>
                        <h3 class="text-primary">Rp {{ number_format($total, 0, ',', '.') }}</h3>

                        <button type="submit" class="btn btn-success w-100 mt-4">Proses Pesanan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
