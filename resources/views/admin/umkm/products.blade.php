@extends('layouts.app')
@section('page_title', 'Produk Toko')

@section('title')
    <i class="icon-copy fa fa-shopping-bag"></i> Produk Toko
@endsection

@section('content')
<div class="container mt-4 text-theme">
    <h4 class="mb-4 text-theme">Produk dari UMKM: <strong>{{ $umkm->nama_toko }}</strong></h4>

    <div class="row text-theme">
        @forelse ($products as $produk)
            <div class="col-md-3 mb-4 text-theme">
                <div class="card h-100 d-flex flex-column text-theme">
                    @if ($produk->gambar && file_exists(public_path('storage/' . $produk->gambar)))
                        <img src="{{ asset('storage/' . $produk->gambar) }}" class="card-img-top" style="height: 180px; object-fit: cover;" alt="{{ $produk->nama }}">
                    @else
                        <img src="https://via.placeholder.com/300x180?text=No+Image" class="card-img-top" alt="No Image">
                    @endif
                    <div class="card-body flex-grow-1 text-theme">
                        <h5 class="card-title text-theme">{{ $produk->nama }}</h5>
                        <p class="card-text text-theme">{{ $produk->deskripsi }}</p>
                        <p class="card-text text-theme"><strong>Harga:</strong> Rp{{ number_format($produk->harga, 0, ',', '.') }}</p>
                    </div>
                    <div class="card-footer bg-white border-top-0 text-theme">
                        <form action="{{ route('admin.produk.destroy', $produk->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus produk ini?') ">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger w-100 text-theme">Hapus</button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-warning">
                    Belum ada produk untuk UMKM ini.
                </div>
            </div>
        @endforelse
    </div>

    <a href="{{ route('admin.umkm.index') }}" class="btn btn-secondary mt-3">Kembali ke Daftar UMKM</a>
</div>
@endsection
