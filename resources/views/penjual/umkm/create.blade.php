@extends('layouts.app')

@section('title', 'Toko Saya')

@section('title')
    <i class="bi bi-shop"></i> Toko Saya
@endsection

@section('content')
<div class="container text-theme">


    <form action="{{ route('penjual.umkm.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label class="form-label">Nama Toko</label>
            <input type="text" name="nama_toko" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Deskripsi</label>
            <textarea name="deskripsi" class="form-control"></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Alamat</label>
            <input type="text" name="alamat" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">No Telepon</label>
            <input type="text" name="no_telp" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Logo Toko</label>
            <input type="file" name="logo" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Kirim Pendaftaran</button>
    </form>
</div>
@endsection
