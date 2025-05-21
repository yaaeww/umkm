@extends('layouts.pembeli-navbar')

@section('title', 'Beri Ulasan Produk')

@section('content')
<style>
    body {
        background-color: black !important;
        color: white;
    }
    .card {
        background-color: #222;
        color: white;
    }
</style>

<div class="container mt-4">
    <h3>Beri Ulasan untuk Produk: <strong>{{ $produk->nama }}</strong></h3>

    <div class="card p-4 mt-3">
        <form action="{{ route('pembeli.rating.store') }}" method="POST">
            @csrf
            <input type="hidden" name="orders_id" value="{{ $order->id }}">
            <input type="hidden" name="produks_id" value="{{ $produk->id }}">

            <div class="mb-3">
                <label for="bintang" class="form-label">Rating (1-5):</label>
                <select id="bintang" name="bintang" class="form-select" required>
                    <option value="">Pilih rating</option>
                    @for ($i = 1; $i <= 5; $i++)
                        <option value="{{ $i }}" {{ old('bintang') == $i ? 'selected' : '' }}>{{ $i }} ⭐</option>
                    @endfor
                </select>
                @error('bintang')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="ulasan" class="form-label">Ulasan:</label>
                <textarea id="ulasan" name="ulasan" rows="4" class="form-control" required>{{ old('ulasan') }}</textarea>
                @error('ulasan')
                    <div class="text-danger mt-1">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">Kirim Ulasan</button>
            <a href="{{ route('pembeli.status.dikirim') }}" class="btn btn-secondary ms-2">Batal</a>
        </form>
    </div>
</div>
@endsection
