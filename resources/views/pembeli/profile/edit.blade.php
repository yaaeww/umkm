@extends('layouts.pembeli-navbar')

@section('title', 'Edit Profil')

@section('content')
    <style>
        :root {
            --dark-blue: #0a1628;
            --medium-blue: #1a3a5f;
            --light-blue: #2a4a7f;
            --gold: #ffd700;
            --gold-light: #ffed4e;
            --gold-dark: #d4af37;
            --success-color: #28a745;
            --warning-color: #ffc107;
            --danger-color: #dc3545;
            --info-color: #17a2b8;
            --secondary-color: #6c757d;
        }

        body {
            background-color: #000 !important;
            color: rgba(255, 255, 255, 0.9);
        }

        .container {
            padding-top: 20px;
            max-width: 800px;
        }

        .profile-edit-card {
            background: rgba(30, 30, 46, 0.7);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            overflow: hidden;
            padding: 2.5rem;
            backdrop-filter: blur(10px);
            margin-bottom: 2rem;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        }

        .page-title {
            background: linear-gradient(135deg, var(--gold) 0%, var(--gold-light) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: 700;
            font-size: 2.2rem;
            margin-bottom: 2rem;
            text-align: center;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            color: var(--gold);
            font-weight: 600;
            margin-bottom: 0.75rem;
            display: block;
            font-size: 1rem;
        }

        .form-control {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 8px;
            color: rgba(255, 255, 255, 0.9);
            padding: 0.875rem 1rem;
            transition: all 0.3s ease;
            width: 100%;
            font-size: 1rem;
        }

        .form-control:focus {
            background: rgba(255, 255, 255, 0.08);
            border-color: var(--gold);
            color: rgba(255, 255, 255, 0.9);
            box-shadow: 0 0 0 3px rgba(255, 215, 0, 0.1);
            outline: none;
        }

        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }

        .avatar-preview {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            margin-bottom: 1rem;
            padding: 1rem;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .avatar-image {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid var(--gold);
            box-shadow: 0 0 20px rgba(255, 215, 0, 0.3);
        }

        .avatar-info {
            flex: 1;
        }

        .avatar-info p {
            margin: 0;
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.9rem;
        }

        .file-input-wrapper {
            position: relative;
            overflow: hidden;
            display: inline-block;
            width: 100%;
        }

        .file-input-wrapper input[type=file] {
            position: absolute;
            left: 0;
            top: 0;
            opacity: 0;
            width: 100%;
            height: 100%;
            cursor: pointer;
        }

        .file-input-label {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            background: rgba(255, 255, 255, 0.05);
            border: 2px dashed rgba(255, 255, 255, 0.2);
            border-radius: 8px;
            padding: 1rem;
            color: rgba(255, 255, 255, 0.7);
            transition: all 0.3s ease;
            cursor: pointer;
            text-align: center;
        }

        .file-input-label:hover {
            background: rgba(255, 255, 255, 0.08);
            border-color: var(--gold);
            color: var(--gold);
        }

        .file-input-label i {
            font-size: 1.25rem;
        }

        .btn {
            border: none;
            border-radius: 8px;
            padding: 1rem 2rem;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            cursor: pointer;
            font-size: 1rem;
            min-width: 150px;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--gold) 0%, var(--gold-light) 100%);
            color: var(--dark-blue);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(255, 215, 0, 0.4);
            background: linear-gradient(135deg, var(--gold-light) 0%, var(--gold) 100%);
        }

        .btn-secondary {
            background: rgba(255, 255, 255, 0.1);
            color: rgba(255, 255, 255, 0.9);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.15);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(255, 255, 255, 0.1);
        }

        .alert {
            background: rgba(40, 167, 69, 0.2);
            border: 1px solid rgba(40, 167, 69, 0.5);
            border-radius: 12px;
            padding: 1rem 1.5rem;
            margin-bottom: 2rem;
            color: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .alert i {
            color: var(--success-color);
            font-size: 1.25rem;
        }

        .form-actions {
            display: flex;
            gap: 1rem;
            justify-content: center;
            margin-top: 2rem;
            flex-wrap: wrap;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .container {
                padding-top: 70px;
            }

            .profile-edit-card {
                padding: 2rem;
                margin: 1rem;
            }

            .page-title {
                font-size: 1.8rem;
            }

            .avatar-preview {
                flex-direction: column;
                text-align: center;
                gap: 1rem;
            }

            .form-actions {
                flex-direction: column;
            }

            .btn {
                width: 100%;
                min-width: auto;
            }
        }

        @media (max-width: 576px) {
            .container {
                padding-top: 60px;
            }

            .profile-edit-card {
                padding: 1.5rem;
            }

            .page-title {
                font-size: 1.6rem;
            }

            .avatar-image {
                width: 80px;
                height: 80px;
            }
        }
    </style>

    <div class="container">
        <div class="profile-edit-card">
            <h1 class="page-title">
                <i class="fas fa-user-edit me-2"></i>Edit Profil
            </h1>

            @if(session('success'))
                <div class="alert">
                    <i class="fas fa-check-circle"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <form action="{{ route('pembeli.profile.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                
                <div class="form-group">
                    <label for="name" class="form-label">
                        <i class="fas fa-user me-2"></i>Nama Lengkap
                    </label>
                    <input type="text" class="form-control" name="name" id="name" 
                           value="{{ old('name', $user->name) }}" 
                           placeholder="Masukkan nama lengkap Anda" required>
                </div>

                <div class="form-group">
                    <label for="email" class="form-label">
                        <i class="fas fa-envelope me-2"></i>Alamat Email
                    </label>
                    <input type="email" class="form-control" name="email" id="email" 
                           value="{{ old('email', $user->email) }}" 
                           placeholder="Masukkan alamat email Anda" required>
                </div>

                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-image me-2"></i>Foto Profil
                    </label>
                    
                    @if ($user->avatar)
                        <div class="avatar-preview">
                            <img src="{{ asset('storage/' . $user->avatar) }}" 
                                 class="avatar-image" 
                                 alt="Foto Profil Saat Ini">
                            <div class="avatar-info">
                                <p><strong>Foto profil saat ini</strong></p>
                                <p>Klik area di bawah untuk mengubah foto profil</p>
                            </div>
                        </div>
                    @endif

                    <div class="file-input-wrapper">
                        <label for="avatar" class="file-input-label">
                            <i class="fas fa-cloud-upload-alt"></i>
                            <span>
                                @if ($user->avatar)
                                    Ganti Foto Profil
                                @else
                                    Unggah Foto Profil
                                @endif
                            </span>
                        </label>
                        <input type="file" class="form-control" name="avatar" id="avatar" 
                               accept="image/*">
                    </div>
                    <small style="color: rgba(255, 255, 255, 0.6); display: block; margin-top: 0.5rem;">
                        Format yang didukung: JPG, PNG, GIF. Maksimal 2MB.
                    </small>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i>Perbarui Profil
                    </button>
                    <a href="{{ route('pembeli.profile.show') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Menampilkan nama file yang dipilih untuk upload
        document.getElementById('avatar').addEventListener('change', function(e) {
            const fileName = e.target.files[0]?.name;
            const label = document.querySelector('.file-input-label span');
            if (fileName) {
                label.textContent = 'File dipilih: ' + fileName;
                document.querySelector('.file-input-label').style.borderColor = 'var(--gold)';
                document.querySelector('.file-input-label').style.color = 'var(--gold)';
            } else {
                label.textContent = 'Unggah Foto Profil';
                document.querySelector('.file-input-label').style.borderColor = 'rgba(255, 255, 255, 0.2)';
                document.querySelector('.file-input-label').style.color = 'rgba(255, 255, 255, 0.7)';
            }
        });

        // Validasi file size
        document.querySelector('form').addEventListener('submit', function(e) {
            const fileInput = document.getElementById('avatar');
            if (fileInput.files.length > 0) {
                const fileSize = fileInput.files[0].size / 1024 / 1024; // MB
                if (fileSize > 2) {
                    e.preventDefault();
                    alert('Ukuran file terlalu besar. Maksimal 2MB.');
                    fileInput.value = '';
                }
            }
        });
    </script>
@endsection