@extends('layouts.app')

@section('title')
    <i class="fas fa-edit me-2"></i> Edit Profil Toko
@endsection

@section('content')
    <style>
        .edit-profile-container {
            background: linear-gradient(135deg, rgba(10, 22, 40, 0.8) 0%, rgba(26, 58, 95, 0.9) 100%);
            border: 2px solid rgba(255, 215, 0, 0.3);
            border-radius: 15px;
            padding: 30px;
            backdrop-filter: blur(10px);
            margin-bottom: 30px;
        }

        .text-theme {
            color: #e0e0e0 !important;
        }

        .text-gold {
            color: var(--gold) !important;
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

        .form-control::placeholder {
            color: #a0a0a0;
        }

        .form-label {
            font-weight: 600;
            color: var(--gold);
            margin-bottom: 8px;
            font-size: 1rem;
        }

        .alert-danger {
            background: linear-gradient(135deg, rgba(220, 53, 69, 0.2) 0%, rgba(232, 62, 140, 0.3) 100%);
            border: 2px solid rgba(220, 53, 69, 0.5);
            border-radius: 12px;
            backdrop-filter: blur(10px);
            color: #e0e0e0;
            margin-bottom: 25px;
        }

        .alert-danger ul {
            margin-bottom: 0;
        }

        .alert-danger li {
            list-style-type: none;
            position: relative;
            padding-left: 20px;
        }

        .alert-danger li::before {
            content: "⚠";
            position: absolute;
            left: 0;
            color: #ff6b6b;
        }

        .btn-success {
            background: linear-gradient(135deg, #28a745, #20c997);
            border: none;
            color: white;
            font-weight: 700;
            padding: 12px 30px;
            border-radius: 8px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
        }

        .btn-success:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(40, 167, 69, 0.5);
            background: linear-gradient(135deg, #20c997, #28a745);
            color: white;
        }

        .btn-secondary {
            background: linear-gradient(135deg, #6c757d, #868e96);
            border: none;
            color: white;
            font-weight: 700;
            padding: 12px 30px;
            border-radius: 8px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(108, 117, 125, 0.3);
        }

        .btn-secondary:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(108, 117, 125, 0.5);
            background: linear-gradient(135deg, #868e96, #6c757d);
            color: white;
        }

        .section-title {
            font-size: 2.2rem;
            font-weight: 700;
            margin-bottom: 30px;
            background: linear-gradient(135deg, var(--gold) 0%, var(--gold-light) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-align: center;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .avatar-preview {
            max-width: 150px;
            max-height: 150px;
            border: 2px solid rgba(255, 215, 0, 0.3);
            border-radius: 8px;
            padding: 5px;
            background: rgba(26, 58, 95, 0.6);
            margin-top: 10px;
        }

        .current-avatar {
            border: 2px solid var(--gold);
            border-radius: 8px;
            padding: 5px;
            background: rgba(26, 58, 95, 0.6);
            max-width: 150px;
            margin-top: 10px;
        }

        .file-input-label {
            background: linear-gradient(135deg, var(--gold) 0%, var(--gold-light) 100%);
            color: var(--dark-blue);
            padding: 10px 20px;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-block;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .file-input-label:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(255, 215, 0, 0.4);
        }

        .button-container {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid rgba(255, 215, 0, 0.2);
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }

        /* Mobile responsiveness */
        @media (max-width: 768px) {
            .edit-profile-container {
                padding: 20px 15px;
            }

            .button-container {
                flex-direction: column;
            }

            .btn-success,
            .btn-secondary {
                width: 100%;
                text-align: center;
            }

            .section-title {
                font-size: 1.8rem;
            }
        }

        .form-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .form-header h5 {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--gold);
            margin-bottom: 10px;
        }

        .form-header p {
            color: #c0c0c0;
            margin-bottom: 0;
        }
    </style>

    <div class="container">
        <h2 class="section-title"><i class="fas fa-edit me-3"></i>Edit Profil Toko</h2>

        <div class="edit-profile-container">
            <div class="form-header">
                <h5><i class="fas fa-store me-2"></i>Perbarui Informasi Toko Anda</h5>
                <p>Lengkapi data toko untuk pengalaman berjualan yang lebih baik</p>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <h5 class="text-gold mb-3"><i class="fas fa-exclamation-triangle me-2"></i>Terjadi Kesalahan</h5>
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

                <div class="row">
                    <!-- Informasi Akun -->
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="name" class="form-label">
                                <i class="fas fa-store me-2"></i>Nama Toko
                            </label>
                            <input type="text" name="name" id="name" class="form-control"
                                value="{{ old('name', $user->name) }}" placeholder="Masukkan nama toko Anda" required>
                        </div>

                        <div class="form-group">
                            <label for="email" class="form-label">
                                <i class="fas fa-envelope me-2"></i>Email
                            </label>
                            <input type="email" name="email" id="email" class="form-control"
                                value="{{ old('email', $user->email) }}" placeholder="email@example.com" required>
                        </div>
                    </div>

                    <!-- Informasi Kontak -->
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="no_telp" class="form-label">
                                <i class="fas fa-phone me-2"></i>No. Telepon
                            </label>
                            <input type="text" name="no_telp" id="no_telp" class="form-control"
                                value="{{ old('no_telp', $umkm->no_telp ?? '') }}" placeholder="Contoh: 081234567890">
                        </div>

                        <div class="form-group">
                            <label for="alamat" class="form-label">
                                <i class="fas fa-map-marker-alt me-2"></i>Alamat Toko
                            </label>
                            <textarea name="alamat" id="alamat" class="form-control" rows="3"
                                placeholder="Masukkan alamat lengkap toko Anda">{{ old('alamat', $umkm->alamat ?? '') }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Avatar -->
                <div class="form-group">
                    <label class="form-label d-block">
                        <i class="fas fa-image me-2"></i>Foto Profil
                    </label>

                    @if($user->avatar)
                        <div class="mb-3">
                            <p class="text-gold mb-2"><i class="fas fa-image me-2"></i>Foto Saat Ini:</p>
                            <img src="{{ asset('storage/avatar/' . $user->avatar) }}" alt="Avatar" class="current-avatar">
                            <p class="text-muted mt-2">Kosongkan jika tidak ingin mengubah foto</p>
                        </div>
                    @endif

                    <label for="avatar" class="file-input-label">
                        <i class="fas fa-upload me-2"></i>Pilih Foto Baru
                    </label>
                    <input type="file" name="avatar" id="avatar" class="d-none" accept="image/*"
                        onchange="previewImage(event)">
                    <div class="mt-2 text-center">
                        <img id="preview" src="#" alt="Preview Foto Baru" class="avatar-preview" style="display: none;">
                    </div>
                    <small class="text-muted d-block mt-2">Format: JPG, PNG, JPEG | Maksimal: 2MB</small>
                </div>

                <div class="button-container">
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-save me-2"></i>Simpan Perubahan
                    </button>
                    <a href="{{ route('penjual.profile.show') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function () {
                const output = document.getElementById('preview');
                output.src = reader.result;
                output.style.display = 'block';
            };
            reader.readAsDataURL(event.target.files[0]);
        }

        // Tambahkan konfirmasi sebelum meninggalkan halaman jika ada perubahan
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.querySelector('form');
            let formChanged = false;

            // Deteksi perubahan pada form
            const inputs = form.querySelectorAll('input, textarea, select');
            inputs.forEach(input => {
                input.addEventListener('input', function () {
                    formChanged = true;
                });
            });

            // Reset flag ketika form disubmit
            form.addEventListener('submit', function () {
                formChanged = false;
            });

            // Konfirmasi sebelum meninggalkan halaman
            window.addEventListener('beforeunload', function (e) {
                if (formChanged) {
                    e.preventDefault();
                    e.returnValue = '';
                }
            });
        });
    </script>
@endsection