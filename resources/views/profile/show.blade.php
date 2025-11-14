@extends('layouts.app')

@section('page_title', 'Profile Toko')

@section('title')
    <i class="fas fa-user-circle me-2"></i> Profile Saya
@endsection

@section('content')
    <style>
        .profile-container {
            background: linear-gradient(135deg, rgba(10, 22, 40, 0.8) 0%, rgba(26, 58, 95, 0.9) 100%);
            border: 2px solid rgba(255, 215, 0, 0.3);
            border-radius: 15px;
            padding: 30px;
            backdrop-filter: blur(10px);
            margin-bottom: 30px;
        }

        .profile-card {
            background: linear-gradient(135deg, rgba(26, 58, 95, 0.7) 0%, rgba(42, 74, 127, 0.8) 100%);
            border: 2px solid rgba(255, 215, 0, 0.2);
            border-radius: 12px;
            padding: 25px;
            backdrop-filter: blur(10px);
            height: 100%;
            transition: all 0.3s ease;
        }

        .profile-card:hover {
            border-color: rgba(255, 215, 0, 0.4);
            transform: translateY(-5px);
        }

        .text-theme {
            color: #e0e0e0 !important;
        }

        .text-gold {
            color: var(--gold) !important;
        }

        .avatar-container {
            text-align: center;
            margin-bottom: 25px;
        }

        .avatar-img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            border: 3px solid var(--gold);
            padding: 3px;
            background: rgba(255, 215, 0, 0.1);
            object-fit: cover;
        }

        .avatar-placeholder {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            border: 3px solid var(--gold);
            background: rgba(26, 58, 95, 0.6);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
        }

        .avatar-placeholder i {
            font-size: 3rem;
            color: var(--gold);
            opacity: 0.7;
        }

        .form-control {
            background: rgba(26, 58, 95, 0.6);
            border: 2px solid rgba(255, 215, 0, 0.2);
            border-radius: 8px;
            color: #e0e0e0;
            padding: 12px 15px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            background: rgba(26, 58, 95, 0.8);
            border-color: var(--gold);
            color: #e0e0e0;
            box-shadow: 0 0 15px rgba(255, 215, 0, 0.3);
            outline: none;
        }

        .form-label {
            font-weight: 600;
            color: var(--gold);
            margin-bottom: 8px;
            font-size: 1rem;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--gold) 0%, var(--gold-light) 100%);
            border: none;
            color: var(--dark-blue);
            font-weight: 700;
            padding: 10px 20px;
            border-radius: 8px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(255, 215, 0, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(255, 215, 0, 0.5);
            color: var(--dark-blue);
        }

        .btn-warning {
            background: linear-gradient(135deg, #ffc107, #fd7e14);
            border: none;
            color: white;
            font-weight: 700;
            padding: 10px 20px;
            border-radius: 8px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(255, 193, 7, 0.3);
        }

        .btn-warning:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(255, 193, 7, 0.5);
            color: white;
        }

        .alert {
            background: linear-gradient(135deg, rgba(40, 167, 69, 0.2) 0%, rgba(32, 201, 151, 0.3) 100%);
            border: 2px solid rgba(40, 167, 69, 0.5);
            border-radius: 12px;
            backdrop-filter: blur(10px);
            color: #e0e0e0;
            margin-bottom: 20px;
        }

        .alert-warning {
            background: linear-gradient(135deg, rgba(255, 193, 7, 0.2) 0%, rgba(255, 215, 0, 0.3) 100%);
            border: 2px solid rgba(255, 193, 7, 0.5);
        }

        .alert-danger {
            background: linear-gradient(135deg, rgba(220, 53, 69, 0.2) 0%, rgba(232, 62, 140, 0.3) 100%);
            border: 2px solid rgba(220, 53, 69, 0.5);
        }

        .alert-secondary {
            background: linear-gradient(135deg, rgba(108, 117, 125, 0.2) 0%, rgba(134, 142, 150, 0.3) 100%);
            border: 2px solid rgba(108, 117, 125, 0.5);
        }

        .nav-tabs {
            border-bottom: 2px solid rgba(255, 215, 0, 0.3);
            margin-bottom: 25px;
        }

        .nav-tabs .nav-link {
            background: rgba(26, 58, 95, 0.6);
            border: 2px solid rgba(255, 215, 0, 0.2);
            border-bottom: none;
            border-radius: 8px 8px 0 0;
            color: #e0e0e0;
            padding: 12px 20px;
            margin-right: 5px;
            transition: all 0.3s ease;
        }

        .nav-tabs .nav-link:hover {
            background: rgba(26, 58, 95, 0.8);
            border-color: rgba(255, 215, 0, 0.4);
            color: var(--gold);
        }

        .nav-tabs .nav-link.active {
            background: linear-gradient(135deg, rgba(255, 215, 0, 0.1) 0%, rgba(255, 237, 78, 0.05) 100%);
            border-color: var(--gold);
            color: var(--gold);
            font-weight: 600;
        }

        .info-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .info-list li {
            padding: 12px 0;
            border-bottom: 1px solid rgba(255, 215, 0, 0.2);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .info-list li:last-child {
            border-bottom: none;
        }

        .info-label {
            font-weight: 600;
            color: var(--gold);
            min-width: 120px;
        }

        .info-value {
            color: #e0e0e0;
            text-align: right;
            flex: 1;
        }

        .section-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--gold);
            margin-bottom: 20px;
            border-bottom: 2px solid rgba(255, 215, 0, 0.3);
            padding-bottom: 10px;
        }

        .user-role-badge {
            background: linear-gradient(135deg, var(--gold) 0%, var(--gold-light) 100%);
            color: var(--dark-blue);
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 600;
            margin: 10px 0;
            display: inline-block;
        }

        .file-input-label {
            background: linear-gradient(135deg, var(--gold) 0%, var(--gold-light) 100%);
            color: var(--dark-blue);
            padding: 8px 16px;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-block;
            font-weight: 600;
            font-size: 0.9rem;
            margin-bottom: 10px;
        }

        .file-input-label:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(255, 215, 0, 0.4);
        }

        /* Mobile responsiveness */
        @media (max-width: 768px) {
            .profile-container {
                padding: 20px 15px;
            }

            .profile-card {
                padding: 20px;
            }

            .avatar-img,
            .avatar-placeholder {
                width: 120px;
                height: 120px;
            }

            .info-list li {
                flex-direction: column;
                align-items: flex-start;
            }

            .info-label {
                min-width: auto;
                margin-bottom: 5px;
            }

            .info-value {
                text-align: left;
            }

            .nav-tabs .nav-link {
                padding: 10px 15px;
                font-size: 0.9rem;
            }
        }
    </style>

    <div class="container">
        <h2 class="section-title text-center mb-4"><i class="fas fa-user-circle me-3"></i>Profile Saya</h2>

        <div class="profile-container">
            <div class="row">
                <!-- Sidebar Profil -->
                <div class="col-xl-4 col-lg-4 col-md-5 mb-4">
                    <div class="profile-card">
                        <div class="avatar-container">
                            @php
                                $avatarPath = auth()->user()->avatar;
                                $fullPath = 'avatar/' . ltrim($avatarPath, '/');
                                $avatarExists = $avatarPath && Storage::disk('public')->exists($fullPath);
                            @endphp

                            @if($avatarExists)
                                <img src="{{ asset('storage/' . $fullPath) }}" class="avatar-img" alt="Avatar Pengguna">
                            @else
                                <div class="avatar-placeholder">
                                    <i class="fas fa-user"></i>
                                </div>
                            @endif

                            <form action="{{ route('penjual.profile.avatar') }}" method="POST" enctype="multipart/form-data"
                                class="mt-4">
                                @csrf
                                <div class="mb-3">
                                    <label for="avatar" class="file-input-label">
                                        <i class="fas fa-camera me-2"></i>Pilih Avatar
                                    </label>
                                    <input type="file" name="avatar" id="avatar" accept="image/*" class="d-none"
                                        onchange="this.form.submit()">
                                    <small class="text-muted d-block mt-2">Format: JPG, PNG, JPEG | Maksimal: 2MB</small>
                                </div>
                            </form>

                            <h4 class="text-gold mb-2 mt-3">{{ $user->name }}</h4>
                            <div class="user-role-badge">
                                <i class="fas fa-store me-2"></i>Penjual Terdaftar
                            </div>

                            <div class="mt-4">
                                <h6 class="text-gold mb-3"><i class="fas fa-info-circle me-2"></i>Informasi Kontak</h6>
                                <ul class="info-list">
                                    <li>
                                        <span class="info-label"><i class="fas fa-envelope me-2"></i>Email:</span>
                                        <span class="info-value">{{ $user->email }}</span>
                                    </li>
                                    <li>
                                        <span class="info-label"><i class="fas fa-phone me-2"></i>Telepon:</span>
                                        <span class="info-value">{{ $umkm->no_telp ?? '-' }}</span>
                                    </li>
                                    <li>
                                        <span class="info-label"><i class="fas fa-map-marker-alt me-2"></i>Alamat:</span>
                                        <span class="info-value">{{ $umkm->alamat ?? '-' }}</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Konten Toko -->
                <div class="col-xl-8 col-lg-8 col-md-7 mb-4">
                    <div class="profile-card">
                        @if(session('success'))
                            <div class="alert alert-success">
                                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                            </div>
                        @endif

                        <ul class="nav nav-tabs" id="profileTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="toko-tab" data-bs-toggle="tab" data-bs-target="#toko"
                                    type="button" role="tab">
                                    <i class="fas fa-store me-2"></i>Informasi Toko
                                </button>
                            </li>
                            @if($umkm && $umkm->status === 'approved')
                                <li class="nav-item ms-auto" role="presentation">
                                    <a href="{{ route('penjual.profile.edit') }}" class="btn btn-warning">
                                        <i class="fas fa-edit me-2"></i>Edit Toko
                                    </a>
                                </li>
                            @endif
                        </ul>

                        <div class="tab-content mt-4" id="profileTabContent">
                            <!-- Tab Info Toko -->
                            <div class="tab-pane fade show active" id="toko" role="tabpanel" aria-labelledby="toko-tab">
                                @if ($umkm)
                                    @if ($umkm->status === 'pending')
                                        <div class="alert alert-warning">
                                            <i class="fas fa-clock me-2"></i>
                                            <strong>Menunggu Persetujuan</strong><br>
                                            Toko Anda sedang dalam proses review oleh admin. Harap tunggu konfirmasi lebih lanjut.
                                        </div>
                                    @elseif ($umkm->status === 'approved')
                                        <h5 class="text-gold mb-4"><i class="fas fa-store me-2"></i>Informasi Toko</h5>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <ul class="info-list">
                                                    <li>
                                                        <span class="info-label">Nama Toko:</span>
                                                        <span class="info-value">{{ $umkm->nama_toko ?? $user->name }}</span>
                                                    </li>
                                                    <li>
                                                        <span class="info-label">Status:</span>
                                                        <span class="info-value">
                                                            <span class="badge bg-success">Aktif</span>
                                                        </span>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="col-md-6">
                                                <ul class="info-list">
                                                    <li>
                                                        <span class="info-label">Telepon:</span>
                                                        <span class="info-value">{{ $umkm->no_telp ?? '-' }}</span>
                                                    </li>
                                                    <li>
                                                        <span class="info-label">Bergabung:</span>
                                                        <span class="info-value">{{ $umkm->created_at->format('d M Y') }}</span>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>

                                        <div class="mt-4">
                                            <h6 class="text-gold mb-3"><i class="fas fa-map-marker-alt me-2"></i>Alamat Toko</h6>
                                            <div class="bg-dark p-3 rounded" style="background: rgba(10, 22, 40, 0.6) !important;">
                                                <p class="mb-0 text-theme">{{ $umkm->alamat }}</p>
                                            </div>
                                        </div>

                                        @if($umkm->deskripsi)
                                            <div class="mt-4">
                                                <h6 class="text-gold mb-3"><i class="fas fa-align-left me-2"></i>Deskripsi Toko</h6>
                                                <div class="bg-dark p-3 rounded" style="background: rgba(10, 22, 40, 0.6) !important;">
                                                    <p class="mb-0 text-theme">{{ $umkm->deskripsi }}</p>
                                                </div>
                                            </div>
                                        @endif
                                    @elseif ($umkm->status === 'rejected')
                                        <div class="alert alert-danger">
                                            <i class="fas fa-times-circle me-2"></i>
                                            <strong>Toko Ditolak</strong><br>
                                            Toko Anda ditolak oleh admin. Silakan perbaiki data dan daftar ulang.
                                        </div>
                                        <a href="{{ route('penjual.umkm.create') }}" class="btn btn-primary">
                                            <i class="fas fa-redo me-2"></i>Daftarkan Ulang Toko
                                        </a>
                                    @endif
                                @else
                                    <div class="alert alert-secondary text-center py-4">
                                        <i class="fas fa-store fa-3x mb-3" style="color: rgba(255, 215, 0, 0.3);"></i>
                                        <h5 class="text-gold mb-3">Belum Memiliki Toko</h5>
                                        <p class="mb-4">Mulai jualan dengan mendaftarkan toko Anda terlebih dahulu.</p>
                                        <a href="{{ route('penjual.umkm.create') }}" class="btn btn-primary btn-lg">
                                            <i class="fas fa-plus-circle me-2"></i>Daftarkan Toko
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Auto submit form ketika file dipilih
        document.getElementById('avatar').addEventListener('change', function () {
            this.form.submit();
        });

        // Tambahkan loading state saat upload avatar
        document.addEventListener('DOMContentLoaded', function () {
            const avatarForm = document.querySelector('form[action*="avatar"]');
            if (avatarForm) {
                avatarForm.addEventListener('submit', function () {
                    const submitBtn = this.querySelector('button[type="submit"]');
                    if (submitBtn) {
                        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Mengupload...';
                        submitBtn.disabled = true;
                    }
                });
            }
        });
    </script>
@endsection