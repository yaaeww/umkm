@extends('layouts.app') {{-- Layout dashboard penjual --}}

@section('page_title', 'Detail produk')

@section('title')

    <i class="bi bi-tags-fill"></i> Detail Produk
@endsection


@section('content')

<div class="container mx-auto p-4 text-theme">
    <div class="bg-dark shadow-md rounded-lg p-6">

        {{-- Gambar Produk --}}
        @if($produk->gambar)
            <div class="mb-10 text-center">
                <img src="{{ asset('storage/' . $produk->gambar) }}" alt="{{ $produk->nama }}"
                    class="mx-auto rounded-lg shadow w-64 h-64 object-cover">
            </div>
        @endif

        {{-- Informasi Produk --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <h3 class="text-2xl font-bold text-theme mb-4">{{ $produk->nama }}</h3>

                <ul class="space-y-2 text-sm text-theme mt-10">
                    <li><strong>Kategori:</strong> {{ $produk->kategoriProduk->nama ?? '-' }}</li>
                    @php
                        $hargaSetelahDiskon = $produk->harga;
                        $diskon = $produk->diskon;
                        $today = \Carbon\Carbon::now();

                        if ($diskon && $today->between($diskon->tanggal_mulai, $diskon->tanggal_berakhir)) {
                            $hargaSetelahDiskon = round($produk->harga * (1 - ($diskon->persen_diskon / 100)), 2);
                        }
                    @endphp

                    <li><strong>Harga:</strong> Rp{{ number_format($produk->harga, 0, ',', '.') }}</li>
                    @if ($hargaSetelahDiskon < $produk->harga)
                        <li><strong>Harga Setelah Diskon:</strong> Rp{{ number_format($hargaSetelahDiskon, 0, ',', '.') }}</li>
                    @endif

                    <li><strong>Stok:</strong> {{ $produk->stok }}</li>
                    <li><strong>Rating:</strong> ⭐ {{ number_format($produk->rating ?? 0, 1) }} / 5</li>
                </ul>

                <div class="mt-4">
                    <h4 class="font-semibold mb-1 text-theme">Deskripsi:</h4>
                    <p class="whitespace-pre-line text-sm text-theme-light">
                        {{ $produk->deskripsi ?? 'Tidak ada deskripsi.' }}
                    </p>
                </div>
            </div>
        </div>

        {{-- Ulasan Produk --}}
        <div class="mt-10">
            <h4 class="text-lg font-semibold text-theme mb-4">Ulasan Pelanggan</h4>

            @if($ulasan->count())
                <div class="space-y-4">
                    @foreach($ulasan as $u)
                        <div class="flex items-start space-x-3">
                            {{-- Avatar Placeholder --}}
                            <div
                                class="w-10 h-10 rounded-full bg-secondary flex items-center justify-center text-white font-semibold">
                                {{ strtoupper(substr($u->user->name ?? 'U', 0, 1)) }}
                            </div>

                            <div>
                                <div class="bg-secondary p-4 rounded-xl shadow-sm text-theme-light">
                                    <p class="text-sm font-semibold">{{ $u->user->name ?? 'User' }}</p>
                                    <p class="text-sm">Rating: ⭐ {{ $u->bintang }}</p>
                                    <p class="mt-1 text-sm">{{ $u->ulasan ?? '-' }}</p>
                                </div>
                                <p class="text-xs text-theme-light mt-1">Diulas pada {{ $u->created_at->format('d M Y') }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-sm text-theme-light">Belum ada ulasan untuk produk ini.</p>
            @endif
        </div>

        {{-- Aksi Edit dan Hapus --}}
        <div class="mt-8 flex flex-wrap gap-3">
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
