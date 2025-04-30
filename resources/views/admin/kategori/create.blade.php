@extends('admin.dashboard') <!-- Ganti sesuai layout yang kamu pakai -->

@section('content')
    <h4>Tambah Kategori Produk</h4>

    <form action="{{ route('admin.kategori.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="nama">Nama Kategori</label>
            <input type="text" name="nama" class="form-control" required>
        </div>
    
        <div class="form-group mt-3">
            <label for="gambar">Upload Gambar</label>
            <input type="file" name="gambar" class="form-control" accept="image/*">
        </div>
    
        <button type="submit" class="btn btn-primary mt-3">Simpan</button>
    </form>
    
@endsection
