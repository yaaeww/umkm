@extends('penjual.dashboard')
@section('title')
    <i class="bi bi-tags-fill"></i> Edit Produk
@endsection
@section('content')
<div class="container">
    
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
            <label for="kategori_utama" class="block font-semibold">Kategori Utama</label>
            <select id="kategori_utama" class="form-control">
                <option value="">-- Pilih Kategori Utama --</option>
                @foreach($kategoriUtamas as $kategori)
                    <option value="{{ $kategori->id }}" {{ $produk->kategori->parent_id == $kategori->id ? 'selected' : '' }}>
                        {{ $kategori->nama }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label for="kategori_produk_id" class="block font-semibold">Subkategori</label>
            <select name="kategori_produk_id" id="subkategori" class="form-control" required>
                <option value="">-- Pilih Subkategori --</option>
                @foreach($subkategoris as $sub)
                    <option value="{{ $sub->id }}" {{ $produk->kategori_produk_id == $sub->id ? 'selected' : '' }}>
                        {{ $sub->nama }}
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
                <img src="{{ asset('storage/' . $produk->gambar) }}" class="mt-2 w-32 h-32 object-cover" alt="Gambar Produk">
            @endif
        </div>

        {{-- Diskon Produk --}}
        <fieldset class="mb-4 border p-3 rounded">
            <legend class="font-semibold text-theme mb-2">Diskon (Opsional)</legend>

            <div class="mb-3">
                <label for="persen_diskon" class="block font-semibold">Persen Diskon (%)</label>
                <input 
                    type="number" 
                    name="persen_diskon" 
                    id="persen_diskon" 
                    class="form-control" 
                    min="0" max="100" 
                    value="{{ old('persen_diskon', optional($produk->diskon)->persen_diskon) }}" 
                    placeholder="Contoh: 10"
                >
            </div>

            <div class="mb-3">
                <label for="tanggal_mulai" class="block font-semibold">Tanggal Mulai Diskon</label>
                <input 
                    type="date" 
                    name="tanggal_mulai" 
                    id="tanggal_mulai" 
                    class="form-control" 
                    value="{{ old('tanggal_mulai', optional($produk->diskon)->tanggal_mulai ? \Carbon\Carbon::parse($produk->diskon->tanggal_mulai)->format('Y-m-d') : '') }}"

                >
            </div>

            <div class="mb-3">
                <label for="tanggal_berakhir" class="block font-semibold">Tanggal Berakhir Diskon</label>
                <input 
                    type="date" 
                    name="tanggal_berakhir" 
                    id="tanggal_berakhir" 
                    class="form-control" 
                    value="{{ old('tanggal_berakhir', optional($produk->diskon)->tanggal_berakhir ? \Carbon\Carbon::parse($produk->diskon->tanggal_berakhir)->format('Y-m-d') : '') }}"

                >
            </div>
            <small class="text-muted">Isi semua field diskon jika ingin memberikan diskon pada produk ini.</small>
        </fieldset>

        <button type="submit" class="btn btn-primary">Update Produk</button>
    </form>
</div>
@endsection
