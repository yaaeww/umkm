@extends('layouts.app')

@section('title')

    <i class="bi bi-tags-fill"></i> Daftar Produk
@endsection

@section('content')
    <div class="container text-theme">

        <a href="{{ route('penjual.produk.create') }}" class="btn btn-primary mb-4">+ Tambah Produk</a>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="row">
            @forelse($produks as $produk)
                <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
                    <div class="card shadow border-0 h-100">
                        <div class="position-relative">
                            @if ($produk->gambar)
                                <img src="{{ asset('storage/' . $produk->gambar) }}" class="card-img-top"
                                    style="height: 200px; object-fit: cover;" alt="Gambar Produk">
                            @else
                                <img src="{{ asset('images/default.jpg') }}" class="card-img-top"
                                    style="height: 200px; object-fit: cover;" alt="Default Image">
                            @endif
                        </div>
                        <div class="card-body text-center">
                            <h5 class="card-title">{{ $produk->nama }}</h5>

                            {{-- Tampilkan harga diskon jika ada dan aktif --}}
                            @if ($produk->diskon && now()->between($produk->diskon->tanggal_mulai, $produk->diskon->tanggal_berakhir))
                                <p class="card-text mb-1">
                                    <del class="text-muted">Rp {{ number_format($produk->harga, 0, ',', '.') }}</del>
                                </p>
                                <p class="card-text text-danger fw-bold">
                                    Rp {{ number_format($produk->harga_setelah_diskon, 0, ',', '.') }}
                                </p>
                            @else
                                <p class="card-text text-muted">
                                    Rp {{ number_format($produk->harga, 0, ',', '.') }}
                                </p>
                            @endif
                        </div>
                        <div class="card-footer bg-transparent border-top-0 d-flex justify-content-center gap-1">
                            <a href="{{ route('penjual.produk.show', $produk->id) }}" class="btn btn-info btn-sm">Detail</a>
                            <a href="{{ route('penjual.produk.edit', $produk->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('penjual.produk.destroy', $produk->id) }}" method="POST"
                                onsubmit="return confirm('Yakin mau hapus produk ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <p>Belum ada produk. Yuk tambah produk baru!</p>
            @endforelse
        </div>

        <div class="mt-4 d-flex justify-content-center">
            {{ $produks->links() }}
        </div>
    </div>
@endsection