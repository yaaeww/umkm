@extends('layouts.app')

@section('title', 'Toko Saya')

@section('title')
    <i class="bi bi-shop"></i> Toko Saya
@endsection

@section('content')
<div class="card-box p-4 text-theme">
    

    <form action="{{ route('penjual.umkm.update', $umkm->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- Nama Toko --}}
        <div class="form-group">
            <label for="nama_toko">Nama Toko</label>
            <input type="text" name="nama_toko" id="nama_toko" class="form-control @error('nama_toko') is-invalid @enderror" value="{{ old('nama_toko', $umkm->nama_toko) }}" required>
            @error('nama_toko')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        {{-- Deskripsi --}}
        <div class="form-group">
            <label for="deskripsi">Deskripsi</label>
            <textarea name="deskripsi" id="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror">{{ old('deskripsi', $umkm->deskripsi) }}</textarea>
            @error('deskripsi')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        {{-- Alamat --}}
        <div class="form-group">
            <label for="alamat">Alamat</label>
            <input type="text" name="alamat" id="alamat" class="form-control @error('alamat') is-invalid @enderror" value="{{ old('alamat', $umkm->alamat) }}" required>
            @error('alamat')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        {{-- No Telepon --}}
        <div class="form-group">
            <label for="no_telp">No. Telepon</label>
            <input type="text" name="no_telp" id="no_telp" class="form-control @error('no_telp') is-invalid @enderror" value="{{ old('no_telp', $umkm->no_telp) }}">
            @error('no_telp')
                <span class="invalid-feedback">{{ $message }}</span>
            @enderror
        </div>

        {{-- Logo --}}
        <div class="form-group">
            <label for="logo">Logo Toko</label><br>
            @if ($umkm->logo)
                <img src="{{ asset('storage/' . $umkm->logo) }}" alt="Logo Toko" width="120" class="mb-2"><br>
            @endif
            <input type="file" name="logo" id="logo" class="form-control-file @error('logo') is-invalid @enderror">
            @error('logo')
                <span class="invalid-feedback d-block">{{ $message }}</span>
            @enderror
        </div>

        {{-- Tombol Submit --}}
        <button type="submit" class="btn btn-success">Simpan Perubahan</button>
        <a href="{{ route('penjual.umkm.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
