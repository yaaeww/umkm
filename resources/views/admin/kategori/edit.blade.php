@extends('layouts.app')

@section('title', 'Edit Kategori')

@section('content')
    <h4>Edit Kategori Produk</h4>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('admin.kategori.update', $kategori->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="nama" class="form-label">Nama Kategori</label>
            <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama', $kategori->nama) }}" required>
            @error('nama')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="gambar" class="form-label">Gambar Kategori</label>
            <input type="file" class="form-control @error('gambar') is-invalid @enderror" id="gambar" name="gambar" accept="image/*">
            @error('gambar')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror

            @if ($kategori->gambar)
                <div class="mt-3">
                    <label>Gambar Saat Ini:</label>
                    <img src="{{ asset('storage/kategori/' . $kategori->gambar) }}" alt="gambar kategori" width="100" height="100">
                </div>
            @endif
        </div>

        <button type="submit" class="btn btn-primary">Update Kategori</button>
        <a href="{{ route('admin.kategori.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
@endsection
