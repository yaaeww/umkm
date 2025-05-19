@extends('layouts.app')

@section('title')
    <i class="icon-copy dw dw-groceries-store"></i> Detail Toko
@endsection

@section('content')
<div class="container mt-4">

    <div class="card mb-4 text-theme">
        <div class="card-header">
            Informasi UMKM
        </div>
        <div class="card-body text-theme">
            <div class="mb-3">
                <h5 class="text-theme">Logo UMKM</h5>
                @if($umkm->logo)
                    <div class="card" style="width: 150px;">
                        <img src="{{ asset('storage/' . $umkm->logo) }}" class="card-img-top" alt="Logo UMKM" style="height: 150px; object-fit: cover;">
                    </div>
                @else
                    <div class="alert alert-warning">
                        Tidak Ada Logo
                    </div>
                @endif
            </div>
            <p class="text-theme"><strong>Nama UMKM:</strong> {{ $umkm->nama_toko }}</p>
            <p class="text-theme"><strong>Nama Pemilik (User):</strong> {{ $umkm->user->name ?? 'Tidak tersedia' }}</p>
            <p class="text-theme"><strong>Email Pemilik:</strong> {{ $umkm->user->email ?? '-' }}</p>
            <p class="text-theme"><strong>Alamat:</strong> {{ $umkm->alamat }}</p>
            <p class="text-theme"><strong>Telepon:</strong> {{ $umkm->no_telp }}</p>
            <p class="text-theme"><strong>Status:</strong> 
                <span class="badge 
                    @if($umkm->status == 'approved') bg-success 
                    @elseif($umkm->status == 'pending') bg-warning 
                    @else bg-danger 
                    @endif">
                    {{ ucfirst($umkm->status) }}
                </span>
            </p>
        </div>
    </div>

    <h4 class="text-theme">Produk UMKM</h4>

    @if($umkm->produks && $umkm->produks->count() > 0)
        <div class="row text-theme">
            @foreach($umkm->produks as $produk)
            <div class="col-md-4 text-theme">
                <div class="card mb-3 h-100 text-theme">
                    @if($produk->gambar)
                        <img src="{{ asset('storage/' . $produk->gambar) }}" class="card-img-top" style="height: 200px; object-fit: cover;" alt="{{ $produk->nama }}">
                    @else
                        <img src="{{ asset('images/no-image.png') }}" class="card-img-top" style="height: 200px; object-fit: cover;" alt="No Image">
                    @endif

                    <div class="card-body">
                        <h5 class="card-title text-theme">{{ $produk->nama }}</h5>
                        <p class="card-text text-theme">{{ Str::limit($produk->deskripsi, 80) }}</p>
                        <p class="card-text text-theme"><strong>Harga:</strong> Rp{{ number_format($produk->harga, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    @else
        <div class="alert alert-info">
            UMKM ini belum memiliki produk.
        </div>
    @endif

    <a href="{{ route('admin.umkm.index') }}" class="btn btn-secondary mt-3">Kembali ke Daftar UMKM</a>

</div>
@endsection
