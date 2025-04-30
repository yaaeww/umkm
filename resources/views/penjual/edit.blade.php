<x-app-layout>
    <h2>Edit Produk</h2>

    <form method="POST" action="{{ route('produk.update', $produk->id) }}">
        @csrf @method('PUT')

        <div class="mb-3">
            <label>Nama Produk</label>
            <input type="text" name="nama" class="form-control" value="{{ $produk->nama }}">
        </div>
        <div class="mb-3">
            <label>Harga</label>
            <input type="number" name="harga" class="form-control" value="{{ $produk->harga }}">
        </div>
        <div class="mb-3">
            <label>Deskripsi</label>
            <textarea name="deskripsi" class="form-control">{{ $produk->deskripsi }}</textarea>
        </div>

        <button class="btn btn-primary" type="submit">Simpan</button>
    </form>
</x-app-layout>
