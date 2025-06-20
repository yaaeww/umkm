@extends('layouts.app')
@section('page_title', 'Edit Akun Pembeli')
@section('title', 'Edit Akun Pembeli')

@section('content')
<div class="container">
    
    <form action="{{ route('admin.pembeli.update', $pembeli->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Nama</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $pembeli->name) }}" required>
            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $pembeli->email) }}" required>
            @error('email') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <!-- Tambahkan field lain sesuai kebutuhan -->

        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        <a href="{{ route('admin.pembeli.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
