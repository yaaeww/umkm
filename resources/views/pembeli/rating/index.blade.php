@extends('layouts.pembeli-navbar')

@section('content')
<style>
    body {
        background-color: black !important;
    }
</style>

<div class="container mt-4">
    <h2>Rating dan Ulasan Saya</h2>

    @if (count($produkBelumDinilai) === 0)
        <p>Semua produk yang sudah diterima telah Anda beri penilaian.</p>
    @else
        @foreach ($produkBelumDinilai as $item)
            <div class="card my-3">
                <div class="card-body">
                    <h5>Produk: {{ $item->produk->nama ?? 'Produk tidak ditemukan' }}</h5>
                    <p>Status Order: {{ ucfirst($item->status_order) }}</p>

                    <form action="{{ route('pembeli.rating.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="orders_id" value="{{ $item->order_id }}">
                        <input type="hidden" name="produks_id" value="{{ $item->produk->id }}">

                        <div class="mb-3">
                            <label for="bintang-{{ $item->order_id }}-{{ $item->produk->id }}" class="form-label">Rating (1-5):</label>
                            <select id="bintang-{{ $item->order_id }}-{{ $item->produk->id }}" name="bintang" class="form-select" required>
                                <option value="">Pilih rating</option>
                                @for ($i = 1; $i <= 5; $i++)
                                    <option value="{{ $i }}">{{ $i }} ⭐</option>
                                @endfor
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="ulasan-{{ $item->order_id }}-{{ $item->produk->id }}" class="form-label">Ulasan:</label>
                            <textarea id="ulasan-{{ $item->order_id }}-{{ $item->produk->id }}" name="ulasan" rows="3" class="form-control" placeholder="Tulis ulasan Anda..." required></textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">Kirim Penilaian</button>
                    </form>
                </div>
            </div>
        @endforeach
    @endif
</div>
@endsection
