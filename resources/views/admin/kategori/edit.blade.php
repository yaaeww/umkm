@extends('layouts.app')
@section('page_title', 'Kategori')

@section('title')
    <i class="bi bi-tags-fill"></i> Edit Kategori Produk
@endsection

@section('content')

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('admin.kategori.update', $kategori->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- Nama Kategori --}}
        <div class="mb-3">
            <label for="nama" class="form-label">Nama Kategori</label>
            <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama"
                value="{{ old('nama', $kategori->nama) }}" required>
            @error('nama')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Parent Kategori --}}
        <div class="mb-3">
            <label for="parent_id" class="form-label">Kategori Induk (Opsional)</label>
            <select name="parent_id" id="parent_id" class="form-control @error('parent_id') is-invalid @enderror">
                <option value="">-- Tidak ada (Kategori Utama) --</option>
                @foreach ($kategoriUtamaFlat as $utama)
                    @if ($utama->id != $kategori->id) {{-- Hindari jadi parent dirinya sendiri --}}
                        <option value="{{ $utama->id }}"
                            {{ old('parent_id', $kategori->parent_id) == $utama->id ? 'selected' : '' }}>
                            {{ $utama->nama }}
                        </option>
                    @endif
                @endforeach
            </select>
            @error('parent_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Gambar Kategori --}}
        <div class="mb-3">
            <label for="gambar" class="form-label">Gambar Kategori</label>
            <input type="file" class="form-control @error('gambar') is-invalid @enderror" id="gambar" name="gambar"
                accept="image/*">
            @error('gambar')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror

            @if ($kategori->gambar)
                <div class="mt-3">
                    <label>Gambar Saat Ini:</label><br>
                    <img src="{{ asset('storage/kategori/' . $kategori->gambar) }}" alt="gambar kategori" width="100"
                        height="100">
                </div>
            @endif
        </div>

        {{-- Edit Subkategori --}}
        @if ($kategori->children->count())
            <hr>
            <h5>Subkategori yang Ada</h5>
            @foreach ($kategori->children as $index => $child)
                <div class="mb-3">
                    <input type="hidden" name="subkategori_id[]" value="{{ $child->id }}">
                    <label class="form-label">Subkategori {{ $index + 1 }}</label>
                    <input type="text" name="subkategori_nama[]" class="form-control"
                        value="{{ old('subkategori_nama.' . $index, $child->nama) }}">
                </div>
            @endforeach
        @endif

        
        <button type="submit" class="btn btn-primary">Update Kategori</button>
        <a href="{{ route('admin.kategori.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
@endsection
