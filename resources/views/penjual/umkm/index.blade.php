@extends('layouts.app')

@section('page_title', 'Toko Saya')

@section('title')
    <i class="fas fa-store me-2"></i> Toko Saya
@endsection

@section('content')
<style>
    .toko-page {
        background: linear-gradient(135deg, var(--dark-blue) 0%, var(--medium-blue) 100%);
        min-height: 100vh;
        padding: 20px 0;
    }

    .toko-card {
        background: linear-gradient(135deg, rgba(26, 58, 95, 0.8) 0%, rgba(42, 74, 127, 0.9) 100%);
        border: 2px solid rgba(255, 215, 0, 0.3);
        border-radius: 15px;
        backdrop-filter: blur(10px);
        transition: all 0.3s ease;
    }

    .toko-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 30px rgba(255, 215, 0, 0.3);
        border-color: var(--gold);
    }

    .text-theme {
        color: #e0e0e0 !important;
    }

    .text-gold {
        color: var(--gold) !important;
    }

    .text-gold-light {
        color: var(--gold-light) !important;
    }

    .avatar-photo {
        width: 150px;
        height: 150px;
        object-fit: cover;
        border-radius: 50%;
        border: 3px solid var(--gold);
        padding: 3px;
        background: rgba(255, 215, 0, 0.1);
    }

    .profile-info ul {
        list-style: none;
        padding: 0;
    }

    .profile-info li {
        margin-bottom: 15px;
        padding-bottom: 15px;
        border-bottom: 1px solid rgba(255, 215, 0, 0.2);
    }

    .profile-info li:last-child {
        border-bottom: none;
    }

    .profile-info span {
        font-weight: 600;
        color: var(--gold);
        display: block;
        margin-bottom: 5px;
    }

    .profile-info p {
        margin: 0;
        color: #c0c0c0;
    }

    .badge {
        padding: 8px 16px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.85rem;
    }

    .badge-success {
        background: linear-gradient(135deg, #28a745, #20c997);
        color: white;
    }

    .badge-warning {
        background: linear-gradient(135deg, #ffc107, #fd7e14);
        color: white;
    }

    .badge-danger {
        background: linear-gradient(135deg, #dc3545, #e83e8c);
        color: white;
    }

    .btn-primary {
        background: linear-gradient(135deg, var(--gold) 0%, var(--gold-light) 100%);
        border: none;
        color: var(--dark-blue);
        font-weight: 700;
        padding: 10px 25px;
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .btn-primary:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 20px rgba(255, 215, 0, 0.5);
        color: var(--dark-blue);
    }

    .alert-warning {
        background: linear-gradient(135deg, rgba(255, 193, 7, 0.2) 0%, rgba(255, 215, 0, 0.3) 100%);
        border: 2px solid rgba(255, 215, 0, 0.5);
        border-radius: 12px;
        backdrop-filter: blur(10px);
    }

    .section-title {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 30px;
        background: linear-gradient(135deg, var(--gold) 0%, var(--gold-light) 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        text-align: center;
    }
</style>

<div class="toko-page">
    <div class="container">
        <h2 class="section-title"><i class="fas fa-store me-3"></i>Toko Saya</h2>
        
        <div class="row justify-content-center">
            {{-- Jika UMKM belum terdaftar --}}
            @if (!$umkm)
                <div class="col-lg-8">
                    <div class="alert alert-warning text-theme text-center p-4">
                        <div class="mb-3">
                            <i class="fas fa-store fa-3x text-gold mb-3"></i>
                        </div>
                        <h4 class="text-gold mb-3">Toko Anda belum terdaftar!</h4>
                        <p class="mb-4">Silakan daftar toko terlebih dahulu agar dapat melanjutkan.</p>
                        <a href="{{ route('penjual.umkm.create') }}" class="btn btn-primary btn-lg">
                            <i class="fas fa-plus-circle me-2"></i>Daftar Toko
                        </a>
                    </div>
                </div>
            @else
                {{-- Kartu Profil Toko --}}
                <div class="col-xl-4 col-lg-5 col-md-6 col-sm-12 mb-4">
                    <div class="p-4 toko-card text-theme h-100">
                        <div class="profile-photo text-center mb-4">
                            @if ($umkm->logo)
                                <img src="{{ asset('storage/' . $umkm->logo) }}" alt="Logo Toko" class="avatar-photo">
                            @else
                                <div class="avatar-photo d-flex align-items-center justify-content-center mx-auto">
                                    <i class="fas fa-store fa-3x text-gold"></i>
                                </div>
                            @endif
                        </div>

                        <h4 class="text-center text-gold mb-2">{{ $umkm->nama_toko }}</h4>
                        <p class="text-center text-gold-light mb-4">{{ $umkm->deskripsi ?? 'Tidak ada deskripsi' }}</p>

                        <div class="profile-info">
                            <h5 class="mb-3 text-gold"><i class="fas fa-info-circle me-2"></i>Informasi Toko</h5>
                            <ul>
                                <li>
                                    <span><i class="fas fa-map-marker-alt me-2"></i>Alamat:</span>
                                    <p>{{ $umkm->alamat }}</p>
                                </li>
                                <li>
                                    <span><i class="fas fa-phone me-2"></i>No. Telepon:</span>
                                    <p>{{ $umkm->no_telp ?? '-' }}</p>
                                </li>
                                <li>
                                    <span><i class="fas fa-tag me-2"></i>Status:</span>
                                    <p>
                                        <span class="badge badge-{{ $umkm->status == 'approved' ? 'success' : ($umkm->status == 'pending' ? 'warning' : 'danger') }}">
                                            {{ ucfirst($umkm->status) }}
                                        </span>
                                    </p>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                {{-- Kartu Status atau Aksi --}}
                <div class="col-xl-8 col-lg-7 col-md-6 col-sm-12 mb-4">
                    <div class="p-4 toko-card text-theme h-100 d-flex flex-column justify-content-center">
                        @switch($umkm->status)
                            @case('pending')
                                <div class="text-center">
                                    <i class="fas fa-clock fa-3x text-gold mb-3"></i>
                                    <h3 class="text-gold mb-3">Toko Menunggu Persetujuan</h3>
                                    <p class="text-theme mb-4">Toko <strong>"{{ $umkm->nama_toko }}"</strong> sedang dalam proses review oleh admin. Harap tunggu konfirmasi lebih lanjut.</p>
                                    <div class="spinner-border text-gold" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                </div>
                                @break

                            @case('approved')
                                <div class="text-center">
                                    <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                                    <h3 class="text-gold mb-3">Toko Aktif</h3>
                                    <div class="text-start mb-4">
                                        <p class="text-theme"><strong>Nama Toko:</strong> {{ $umkm->nama_toko }}</p>
                                        <p class="text-theme"><strong>Alamat:</strong> {{ $umkm->alamat }}</p>
                                        <p class="text-theme"><strong>No. Telepon:</strong> {{ $umkm->no_telp ?? '-' }}</p>
                                    </div>
                                    <div class="d-flex gap-3 justify-content-center flex-wrap">
                                        <a href="{{ route('penjual.umkm.edit', $umkm->id) }}" class="btn btn-primary">
                                            <i class="fas fa-edit me-2"></i>Edit Toko
                                        </a>
                                        <a href="{{ route('penjual.produk.index') }}" class="btn btn-primary">
                                            <i class="fas fa-box me-2"></i>Kelola Produk
                                        </a>
                                    </div>
                                </div>
                                @break

                            @case('rejected')
                                <div class="text-center">
                                    <i class="fas fa-times-circle fa-3x text-danger mb-3"></i>
                                    <h3 class="text-gold mb-3">Toko Ditolak</h3>
                                    <p class="text-theme mb-4">Toko Anda ditolak oleh admin. Silakan perbaiki data Anda dan daftar ulang.</p>
                                    <a href="{{ route('penjual.umkm.edit', $umkm->id) }}" class="btn btn-primary btn-lg">
                                        <i class="fas fa-redo me-2"></i>Perbaiki Data Toko
                                    </a>
                                </div>
                                @break

                            @default
                                <div class="text-center">
                                    <i class="fas fa-question-circle fa-3x text-gold mb-3"></i>
                                    <h3 class="text-gold">Status Tidak Dikenali</h3>
                                    <p class="text-theme">Silakan hubungi administrator untuk bantuan lebih lanjut.</p>
                                </div>
                        @endswitch
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection