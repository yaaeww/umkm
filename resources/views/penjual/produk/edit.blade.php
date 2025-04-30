@extends('penjual.dashboard')

@section('content')
<div class="container">
    <h1 class="text-2xl font-bold mb-6">Edit Produk</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="list-disc ml-6">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('penjual.produk.update', $produk->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="kategori_produk_id" class="block font-semibold">Kategori</label>
            <select name="kategori_produk_id" id="kategori_produk_id" class="form-control" required>
                @foreach($kategoriProduks as $kategori)
                    <option value="{{ $kategori->id }}" {{ $produk->kategori_produk_id == $kategori->id ? 'selected' : '' }}>
                        {{ $kategori->nama }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label for="nama" class="block font-semibold">Nama Produk</label>
            <input type="text" name="nama" id="nama" class="form-control" value="{{ $produk->nama }}" required>
        </div>

        <div class="mb-4">
            <label for="deskripsi" class="block font-semibold">Deskripsi</label>
            <textarea name="deskripsi" id="deskripsi" class="form-control" rows="4">{{ $produk->deskripsi }}</textarea>
        </div>

        <div class="mb-4">
            <label for="harga" class="block font-semibold">Harga</label>
            <input type="number" name="harga" id="harga" class="form-control" value="{{ $produk->harga }}" required>
        </div>

        <div class="mb-4">
            <label for="stok" class="block font-semibold">Stok</label>
            <input type="number" name="stok" id="stok" class="form-control" value="{{ $produk->stok }}" required>
        </div>

        <div class="mb-4">
            <label for="gambar" class="block font-semibold">Gambar Produk (Kosongkan jika tidak diubah)</label>
            <input type="file" name="gambar" id="gambar" class="form-control">
            @if($produk->gambar)
                <img src="{{ asset('storage/' . $produk->gambar) }}" class="mt-2 w-32 h-32 object-cover">
            @endif
        </div>

        <button type="submit" class="btn btn-primary">Update Produk</button>
    </form>
</div>
@endsection
