@extends('admin.dashboard') <!-- Ganti sesuai layout yang kamu pakai -->

@section('content')
    <h4>Tambah Kategori Produk</h4>

    <form action="{{ route('admin.kategori.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Nama Kategori --}}
        <div class="form-group">
            <label for="nama">Nama Kategori</label>
            <input type="text" name="nama" class="form-control" required>
        </div>

        {{-- Parent Kategori --}}
        <div class="form-group mt-3">
            <label for="parent_id">Kategori Induk (Opsional)</label>
            <select name="parent_id" class="form-control">
                <option value="">-- Tidak ada (Kategori Utama) --</option>
                @foreach ($kategoriUtamaFlat as $utama)
                    <option value="{{ $utama->id }}">{{ $utama->nama }}</option>
                @endforeach

            </select>
        </div>

        {{-- Upload Gambar --}}
        <div class="form-group mt-3">
            <label for="gambar">Upload Gambar</label>
            <input type="file" name="gambar" class="form-control" accept="image/*">
        </div>

        {{-- Tombol Simpan --}}
        <button type="submit" class="btn btn-primary mt-3">Simpan</button>
    </form>
@endsection