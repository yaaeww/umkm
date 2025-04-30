@extends('layouts.app')
@section('title', 'Tambah Produk')

@section('content')
<div class="container">
    <h1 class="text-2xl font-bold mb-6">Tambah Produk Baru</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="list-disc ml-6">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('penjual.produk.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-4">
            <label for="kategori_produk_id" class="block font-semibold">Kategori</label>
            <select name="kategori_produk_id" id="kategori_produk_id" class="form-control" required>
                <option value="">Pilih Kategori</option>
                @foreach($kategoriProduks as $kategori)
                    <option value="{{ $kategori->id }}">{{ $kategori->nama }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label for="nama" class="block font-semibold">Nama Produk</label>
            <input type="text" name="nama" id="nama" class="form-control" required>
        </div>

        <div class="mb-4">
            <label for="deskripsi" class="block font-semibold">Deskripsi</label>
            <textarea name="deskripsi" id="deskripsi" class="form-control" rows="4"></textarea>
        </div>

        <div class="mb-4">
            <label for="harga" class="block font-semibold">Harga</label>
            <input type="number" name="harga" id="harga" class="form-control" required>
        </div>

        <div class="mb-4">
            <label for="stok" class="block font-semibold">Stok</label>
            <input type="number" name="stok" id="stok" class="form-control" required>
        </div>

        <div class="mb-4">
            <label for="gambar" class="block font-semibold">Gambar Produk</label>
            <input type="file" name="gambar" id="gambar" class="form-control">
        </div>

        <button type="submit" class="btn btn-success">Simpan Produk</button>
    </form>
</div>
@endsection
