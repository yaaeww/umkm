@extends('layouts.app') {{-- Layout dashboard penjual --}}
@section('title', 'Detail Produk')

@section('content')
<div class="container mx-auto p-4">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-bold">Detail Produk</h2>
        <a href="{{ route('penjual.produk.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded">
            Kembali
        </a>
    </div>

    <div class="bg-white shadow-md rounded p-6">
        {{-- Gambar Produk --}}
        @if($produk->gambar)
            <div class="mb-6 text-center">
                <img src="{{ asset('storage/' . $produk->gambar) }}" alt="{{ $produk->nama }}" class="mx-auto rounded-lg shadow-md w-64 h-64 object-cover">
            </div>
        @endif

        {{-- Informasi Produk --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h3 class="text-xl font-bold mb-2">{{ $produk->nama }}</h3>
                <p class="text-gray-600 mb-2"><strong>Kategori:</strong> {{ $produk->kategoriProduk->nama ?? '-' }}</p>
                <p class="text-gray-600 mb-2"><strong>Harga:</strong> Rp{{ number_format($produk->harga, 0, ',', '.') }}</p>
                <p class="text-gray-600 mb-2"><strong>Stok:</strong> {{ $produk->stok }}</p>
                <p class="text-gray-600 mb-2"><strong>Rating:</strong> ⭐ {{ $produk->rating ?? '0' }}</p>
            </div>
            <div>
                <h4 class="text-lg font-semibold mb-2">Deskripsi:</h4>
                <p class="text-gray-700 whitespace-pre-line">{{ $produk->deskripsi ?? 'Tidak ada deskripsi.' }}</p>
            </div>
        </div>

        {{-- Aksi Edit dan Hapus --}}
        <div class="mt-6 flex space-x-4">
            <a href="{{ route('penjual.produk.edit', $produk->id) }}" class="bg-yellow-500 hover:bg-yellow-600 text-white py-2 px-4 rounded">
                Edit Produk
            </a>
            <form action="{{ route('penjual.produk.destroy', $produk->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus produk ini?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white py-2 px-4 rounded">
                    Hapus Produk
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
