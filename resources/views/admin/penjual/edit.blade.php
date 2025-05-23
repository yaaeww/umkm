@extends('layouts.app')

@section('page_title', 'Edit Akun Penjual')

@section('title', 'Edit Akun Penjual')

@section('content')
<div class="container">
    <h1>Edit Akun Penjual</h1>

    <form action="{{ route('admin.penjual.update', $penjual->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Nama</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $penjual->name) }}" required>
            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $penjual->email) }}" required>
            @error('email') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <!-- Tambahkan field lain yang diperlukan, misalnya nomor telepon, alamat, dll -->

        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        <a href="{{ route('admin.penjual.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
