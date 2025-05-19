@extends('admin.dashboard') <!-- Ganti sesuai layout yang kamu pakai -->
@section('title')
    <i class="bi bi-tags-fill"></i> tambah kategori
@endsection
@section('content')
    
    <form action="{{ route('admin.kategori.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Nama Kategori --}}
        <div class="form-group">
            <label for="nama">Nama Kategori</label>
            <input 
                type="text" 
                name="nama" 
                class="form-control @error('nama') is-invalid @enderror" 
                value="{{ old('nama') }}" 
                required
            >
            @error('nama')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Parent Kategori --}}
        <div class="form-group mt-3">
            <label for="parent_id">Kategori Induk (Opsional)</label>
            <select name="parent_id" class="form-control @error('parent_id') is-invalid @enderror">
                <option value="">-- Tidak ada (Kategori Utama) --</option>
                @foreach ($kategoriUtamaFlat as $utama)
                    <option value="{{ $utama->id }}" {{ old('parent_id') == $utama->id ? 'selected' : '' }}>
                        {{ $utama->nama }}
                    </option>
                @endforeach
            </select>
            @error('parent_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Upload Gambar --}}
        <div class="form-group mt-3">
            <label for="gambar">Upload Gambar</label>
            <input 
                type="file" 
                name="gambar" 
                class="form-control @error('gambar') is-invalid @enderror" 
                accept="image/*"
            >
            @error('gambar')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        {{-- Tombol Simpan --}}
        <button type="submit" class="btn btn-primary mt-3">Simpan</button>
    </form>
@endsection
