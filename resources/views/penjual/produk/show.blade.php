@extends('layouts.app') {{-- Layout dashboard penjual --}}

@section('title')
    <i class="bi bi-tags-fill"></i> Detail Produk
@endsection

@section('content')
<div class="container mx-auto p-4 text-theme">
    <div class="bg-white shadow-md rounded p-6">
        {{-- Gambar Produk --}}
        @if($produk->gambar)
            <div class="mb-6 text-center">
                <img src="{{ asset('storage/' . $produk->gambar) }}" alt="{{ $produk->nama }}"
                    class="mx-auto rounded-lg shadow-md w-64 h-64 object-cover">
            </div>
        @endif

        {{-- Informasi Produk --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-theme">
            <div class="text-theme">
                <h3 class="text-theme font-bold mb-2">{{ $produk->nama }}</h3>
                <p class="mb-2"><strong>Kategori:</strong> {{ $produk->kategoriProduk->nama ?? '-' }}</p>
                <p class="mb-2"><strong>Harga:</strong> Rp{{ number_format($produk->harga, 0, ',', '.') }}</p>
                <p class="mb-2"><strong>Stok:</strong> {{ $produk->stok }}</p>
                <p class="mb-2"><strong>Rating:</strong> ⭐ {{ number_format($produk->rating ?? 0, 1) }} / 5</p>
                <h4 class="text-lg font-semibold mb-2 text-theme">Deskripsi:</h4>
                <p class="whitespace-pre-line text-theme">{{ $produk->deskripsi ?? 'Tidak ada deskripsi.' }}</p>
            </div>
        </div>

        {{-- Ulasan Produk --}}
        <div class="mt-8">
            <h4 class="text-lg font-semibold mb-4 text-theme">Ulasan Pelanggan</h4>

            @if($ulasan->count())
                @foreach($ulasan as $u)
                    <div class="border-t border-gray-300 pt-4 mt-4">
                        <p class="font-semibold">{{ $u->user->name ?? 'User' }}</p>
                        <p class="text-sm text-gray-600">Rating: ⭐ {{ $u->bintang }}</p>
                        <p class="mt-1">{{ $u->komentar ?? '-' }}</p>
                        <p class="text-xs text-gray-400 mt-1">Diulas pada {{ $u->created_at->format('d M Y') }}</p>
                    </div>
                @endforeach
            @else
                <p class="text-gray-500">Belum ada ulasan untuk produk ini.</p>
            @endif
        </div>

        {{-- Aksi Edit dan Hapus --}}
        <div class="mt-6 flex flex-wrap gap-3">
            <a href="{{ route('penjual.produk.edit', $produk->id) }}" class="btn btn-warning">
                <i class="bi bi-pencil-square"></i> Edit Produk
            </a>
            <form action="{{ route('penjual.produk.destroy', $produk->id) }}" method="POST"
                onsubmit="return confirm('Yakin ingin menghapus produk ini?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">
                    <i class="bi bi-trash-fill"></i> Hapus Produk
                </button>
            </form>
        </div>

        {{-- Tombol Kembali --}}
        <div class="mt-4">
            <a href="{{ route('penjual.produk.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>
    </div>
</div>
@endsection
