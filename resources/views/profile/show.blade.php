@extends('layouts.app')

@section('title', 'Profil Penjual')

@section('content')
<div class="row">
    <!-- Sidebar Profil -->
    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-30">
        <div class="pd-20 card-box height-100-p">
            <div class="profile-photo text-center mb-3">
                <img 
                    src="{{ $user->avatar ? asset('storage/avatar/' . $user->avatar) : asset('vendors/images/photo1.jpg') }}" 
                    alt="Profile Photo" 
                    class="avatar-photo"
                    style="width: 120px; height: 120px; object-fit: cover; border-radius: 50%;">
            </div>

            <!-- Form Ganti Avatar -->
        <form action="{{ route('penjual.profile.avatar') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <label for="avatar">Upload Avatar</label>
    <input type="file" name="avatar" id="avatar" accept="image/*">
    <button type="submit" class="btn btn-primary">Update Avatar</button>
</form>


            <h5 class="text-center h5 mb-0">{{ $user->name }}</h5>
            <p class="text-center text-muted font-14">Penjual Terdaftar</p>

            <div class="profile-info">
                <h5 class="mb-20 h5 text-blue">Informasi Kontak</h5>
                <ul>
                    <li><span>Email:</span> {{ $user->email }}</li>
                    <li><span>No. Telepon:</span> {{ $umkm->no_telp ?? '-' }}</li>
                    <li><span>Alamat:</span> {{ $umkm->alamat ?? '-' }}</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Konten Toko -->
    <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 mb-30">
        <div class="card-box height-100-p overflow-hidden">
            <div class="profile-tab height-100-p">
                <div class="tab height-100-p">
                    <ul class="nav nav-tabs customtab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#toko" role="tab">Toko</a>
                        </li>
                    </ul>
                    <div class="tab-content pt-3">
                        <div class="tab-pane fade show active" id="toko" role="tabpanel">
                            @if ($umkm)
                                @if ($umkm->status === 'pending')
                                    <h5 class="text-warning">Toko Anda sedang menunggu persetujuan admin.</h5>
                                @elseif ($umkm->status === 'approved')
                                    <h5 class="mb-3">Informasi Toko:</h5>
                                    <p><strong>Nama :</strong> {{ $user->name }}</p>
                                    <p><strong>Alamat:</strong> {{ $umkm->alamat }}</p>
                                    <p><strong>No. Telepon:</strong> {{ $umkm->no_telp }}</p>
                                @elseif ($umkm->status === 'rejected')
                                    <h5 class="text-danger">Toko Anda ditolak oleh admin.</h5>
                                    <p>Silakan perbaiki data Anda dan daftar ulang.</p>
                                    <a href="{{ route('penjual.umkm.create') }}" class="btn btn-primary">Daftarkan Ulang Toko</a>
                                @endif
                            @else
                                <h5 class="text-muted">Anda belum memiliki toko</h5>
                                <p>Silakan daftar toko Anda terlebih dahulu.</p>
                                <a href="{{ route('penjual.umkm.create') }}" class="btn btn-primary">Daftarkan Toko</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
