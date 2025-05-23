@extends('layouts.app')


@section('page_title', 'Tambah produk')

@section('title')

    <i class="bi bi-tags-fill"></i> Tambah Produk
@endsection


@section('content')
<div class="container text-theme">

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

        {{-- Kategori Produk --}}
        <div class="mb-4">
            <label for="kategori_produk_id" class="block font-semibold">Kategori</label>
            <select name="kategori_produk_id" id="kategori_produk_id" class="form-control" required>
                <option value="">Pilih Kategori</option>
                @foreach($kategoriProduks as $kategori)
                    <option value="{{ $kategori->id }}">
                        {{ $kategori->nama }}
                    </option>
                    @foreach ($kategori->children as $sub)
                        <option value="{{ $sub->id }}">— {{ $sub->nama }}</option>
                    @endforeach
                @endforeach
            </select>
        </div>

        {{-- Nama Produk --}}
        <div class="mb-4">
            <label for="nama" class="block font-semibold">Nama Produk</label>
            <input type="text" name="nama" id="nama" class="form-control" required>
        </div>

        {{-- Deskripsi Produk --}}
        <div class="mb-4">
            <label for="deskripsi" class="block font-semibold">Deskripsi</label>
            <textarea name="deskripsi" id="deskripsi" class="form-control" rows="4"></textarea>
        </div>

        {{-- Harga Produk --}}
        <div class="mb-4">
            <label for="harga" class="block font-semibold">Harga</label>
            <input type="number" name="harga" id="harga" class="form-control" min="0" required>
        </div>

        {{-- Stok Produk --}}
        <div class="mb-4">
            <label for="stok" class="block font-semibold">Stok</label>
            <input type="number" name="stok" id="stok" class="form-control" min="0" required>
        </div>

        {{-- Gambar Produk --}}
        <div class="mb-4">
            <label for="gambar" class="block font-semibold">Gambar Produk</label>
            <input type="file" name="gambar" id="gambar" class="form-control" accept="image/*" onchange="previewImage(event)">
            <div class="mt-2">
                <img id="preview" src="#" alt="Preview Gambar" style="display: none; max-height: 200px;">
            </div>
        </div>

        {{-- Diskon Produk --}}
        <fieldset class="mb-4 border p-3 rounded">
            <legend class="font-semibold text-theme mb-2">Diskon (Opsional)</legend>

            <div class="mb-3">
                <label for="persen_diskon" class="block font-semibold">Persen Diskon (%)</label>
                <input type="number" name="persen_diskon" id="persen_diskon" class="form-control" min="0" max="100" placeholder="Contoh: 10">
            </div>

            <div class="mb-3">
                <label for="tanggal_mulai" class="block font-semibold">Tanggal Mulai Diskon</label>
                <input type="date" name="tanggal_mulai" id="tanggal_mulai" class="form-control">
            </div>

            <div class="mb-3">
                <label for="tanggal_berakhir" class="block font-semibold">Tanggal Berakhir Diskon</label>
                <input type="date" name="tanggal_berakhir" id="tanggal_berakhir" class="form-control">
            </div>
            <small class="text-muted">Isi semua field diskon jika ingin memberikan diskon pada produk ini.</small>
        </fieldset>

        <button type="submit" class="btn btn-success">Simpan Produk</button>
    </form>
</div>

{{-- Preview Gambar Script --}}
@push('scripts')
<script>
    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function(){
            const output = document.getElementById('preview');
            output.src = reader.result;
            output.style.display = 'block';
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>
@endpush
@endsection
