<x-app-layout>
    <h2>Detail Produk</h2>
    <p><strong>Nama:</strong> {{ $produk->nama }}</p>
    <p><strong>Harga:</strong> Rp {{ number_format($produk->harga, 0, ',', '.') }}</p>
    <p><strong>Deskripsi:</strong><br>{{ $produk->deskripsi }}</p>
    <a href="{{ route('penjual.dashboard') }}" class="btn btn-secondary">Kembali</a>
</x-app-layout>
