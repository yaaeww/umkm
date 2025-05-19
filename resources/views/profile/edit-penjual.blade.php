@extends('layouts.app')

@section('title')
    <i class="bi bi-pencil-square"></i> Edit Profil Toko
@endsection

@section('content')
<div class="container">
    <div class="card shadow-sm">
        <div class="card-body text-theme">
            <h5 class="mb-4 text-theme">Edit Informasi Toko</h5>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('penjual.profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                <!-- Nama Toko -->
                <div class="mb-3">
                    <label for="name" class="form-label">Nama Toko</label>
                    <input type="text" name="name" id="name" class="form-control text-theme" value="{{ old('name', $user->name) }}" required>
                </div>

                <!-- Email -->
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" id="email" class="form-control text-theme" value="{{ old('email', $user->email) }}" required>
                </div>

                <!-- No. Telepon -->
                <div class="mb-3">
                    <label for="no_telp" class="form-label">No. Telepon</label>
                    <input type="text" name="no_telp" id="no_telp" class="form-control text-theme" value="{{ old('no_telp', $umkm->no_telp ?? '') }}">
                </div>

                <!-- Alamat -->
                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat</label>
                    <textarea name="alamat" id="alamat" class="form-control text-theme" rows="3">{{ old('alamat', $umkm->alamat ?? '') }}</textarea>
                </div>

                <!-- Avatar -->
                <div class="mb-3">
                    <label for="avatar" class="form-label">Avatar</label>
                    <input type="file" name="avatar" id="avatar" class="form-control text-theme">
                    @if($user->avatar)
                        <div class="mt-2">
                            <img src="{{ asset('storage/avatar/' . $user->avatar) }}" alt="Avatar" class="img-thumbnail" style="max-height: 150px;">
                        </div>
                    @endif
                </div>

                <button type="submit" class="btn btn-success text-theme">
                    <i class="bi bi-save"></i> Simpan Perubahan
                </button>
                <a href="{{ route('penjual.profile.show') }}" class="btn btn-secondary text-theme">
                    <i class="bi bi-arrow-left"></i> Kembali
                </a>
            </form>
        </div>
    </div>
</div>
@endsection
