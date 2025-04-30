@extends('layouts.app')
@section('title', 'Produk saya')
@section('content')
<div class="container">
    <h1 class="text-2xl font-bold mb-4">Daftar Produk Saya</h1>

    <a href="{{ route('penjual.produk.create') }}" class="btn btn-primary mb-4">+ Tambah Produk</a>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @forelse($produks as $produk)
            <div class="border p-4 rounded shadow">
                <img src="{{ asset('storage/' . $produk->gambar) }}" alt="{{ $produk->nama }}" class="w-full h-40 object-cover mb-3">
                <h2 class="text-lg font-semibold">{{ $produk->nama }}</h2>
                <p class="text-sm text-gray-600 mb-2">Rp {{ number_format($produk->harga, 0, ',', '.') }}</p>
                <a href="{{ route('penjual.produk.show', $produk->id) }}" class="btn btn-info btn-sm">Detail</a>
                <a href="{{ route('penjual.produk.edit', $produk->id) }}" class="btn btn-warning btn-sm">Edit</a>
                <form action="{{ route('penjual.produk.destroy', $produk->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin mau hapus produk ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                </form>
            </div>
        @empty
            <p>Belum ada produk. Yuk tambah produk baru!</p>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $produks->links() }}
    </div>
</div>
@endsection