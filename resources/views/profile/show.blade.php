@extends('layouts.app')

@section('page_title', 'Profile Toko')

@section('title')
<i class="icon-copy bi bi-person-circle"></i> Profile saya
    
@endsection

@section('content')
<div class="row">
    <!-- Sidebar Profil -->
    <div class="col-xl-4 col-lg-4 col-md-5 mb-4">
        <div class="card shadow-sm">
            <div class="card-body text-center text-theme">
                @php
                    $avatarPath = auth()->user()->avatar;
                    $fullPath = 'avatar/' . ltrim($avatarPath, '/');
                    $avatarExists = $avatarPath && Storage::disk('public')->exists($fullPath);
                    $avatarUrl = $avatarExists
                        ? asset('storage/' . $fullPath)
                        : asset('images/default-avatar.png');
                @endphp

                <img src="{{ $avatarUrl }}" class="rounded-circle img-thumbnail mb-3" style="max-height: 150px;" alt="Avatar Pengguna">

                <form action="{{ route('penjual.profile.avatar') }}" method="POST" enctype="multipart/form-data" class="mb-3 text-start">
                    @csrf
                    <div class="form-group">
                        <label for="avatar" class="form-label text-theme">Ganti Avatar</label>
                        <input type="file" name="avatar" id="avatar" accept="image/*" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-sm btn-primary mt-2">Update Avatar</button>
                </form>

                <h5 class="card-title mb-0 text-theme">{{ $user->name }}</h5>
                <div class="text-muted mb-3">Penjual Terdaftar</div>

                <div class="text-start">
                    <h6 class="text-primary">Informasi Kontak</h6>
                    <ul class="list-unstyled mb-0 text-theme">
                        <li><strong>Email:</strong> {{ $user->email }}</li>
                        <li><strong>No. Telepon:</strong> {{ $umkm->no_telp ?? '-' }}</li>
                        <li><strong>Alamat:</strong> {{ $umkm->alamat ?? '-' }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Konten Toko -->
    <div class="col-xl-8 col-lg-8 col-md-7 mb-4">
        <div class="card shadow-sm">
            <div class="card-body text-theme">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <ul class="nav nav-tabs mb-3" id="profileTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active text-theme" id="toko-tab" data-bs-toggle="tab" data-bs-target="#toko" type="button" role="tab">
                            Toko
                        </button>
                    </li>
                    @if($umkm && $umkm->status === 'approved')
                    <a href="{{ route('penjual.profile.edit') }}" class="btn btn-warning text-theme">
    Edit Toko
</a>

                    @endif
                </ul>

                <div class="tab-content" id="profileTabContent">
                    <!-- Tab Info Toko -->
                    <div class="tab-pane fade show active text-theme" id="toko" role="tabpanel" aria-labelledby="toko-tab">
                        @if ($umkm)
                            @if ($umkm->status === 'pending')
                                <div class="alert alert-warning text-theme">
                                    Toko Anda sedang menunggu persetujuan admin.
                                </div>
                            @elseif ($umkm->status === 'approved')
                                <h5 class="mb-3 text-theme">Informasi Toko</h5>
                                <p><strong>Nama:</strong> {{ $user->name }}</p>
                                <p><strong>Alamat:</strong> {{ $umkm->alamat }}</p>
                                <p><strong>No. Telepon:</strong> {{ $umkm->no_telp }}</p>
                            @elseif ($umkm->status === 'rejected')
                                <div class="alert alert-danger text-theme">
                                    Toko Anda ditolak oleh admin.<br>
                                    Silakan perbaiki data dan daftar ulang.
                                </div>
                                <a href="{{ route('penjual.umkm.create') }}" class="btn btn-primary">Daftarkan Ulang Toko</a>
                            @endif
                        @else
                            <div class="alert alert-secondary text-theme">
                                Anda belum memiliki toko. Silakan daftar toko Anda terlebih dahulu.
                            </div>
                            <a href="{{ route('penjual.umkm.create') }}" class="btn btn-primary">Daftarkan Toko</a>
                        @endif
                    </div>

                    <!-- Tab Edit Toko -->
                    <div class="tab-pane fade text-theme" id="edit-toko" role="tabpanel" aria-labelledby="edit-toko-tab">
                        @if ($umkm && $umkm->status === 'approved')
                            <form action="{{ route('penjual.umkm.update', $umkm->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="mb-3">
                                    <label for="alamat" class="form-label">Alamat</label>
                                    <textarea name="alamat" id="alamat" class="form-control" rows="3" required>{{ old('alamat', $umkm->alamat) }}</textarea>
                                </div>

                                <div class="mb-3">
                                    <label for="no_telp" class="form-label">No. Telepon</label>
                                    <input type="text" name="no_telp" id="no_telp" class="form-control" value="{{ old('no_telp', $umkm->no_telp) }}" required>
                                </div>

                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                            </form>
                        @else
                            <div class="alert alert-warning">Anda hanya bisa mengedit toko yang telah disetujui.</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
