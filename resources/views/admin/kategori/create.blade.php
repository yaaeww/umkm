@extends('layouts.app')
@section('page_title', 'Tambah Kategori')

@section('title')
    <i class="bi bi-tags-fill" style="color: var(--gold);"></i> Tambah Kategori
@endsection

@push('style')
    <style>
        :root {
            --dark-blue: #0a1628;
            --medium-blue: #1a3a5f;
            --light-blue: #2a4a7f;
            --gold: #ffd700;
            --gold-light: #ffed4e;
            --gold-dark: #d4af37;
            --text-primary: #ffffff;
            --text-secondary: #a0aec0;
            --success-color: #28a745;
            --danger-color: #dc3545;
        }

        .card {
            background: linear-gradient(135deg, rgba(10, 22, 40, 0.95) 0%, rgba(26, 58, 95, 0.9) 100%) !important;
            border: 2px solid var(--gold);
            border-radius: 20px;
            box-shadow: 0 8px 32px rgba(255, 215, 0, 0.15);
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
        }

        .card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, transparent, var(--gold), transparent);
            animation: shimmer 3s infinite;
        }

        @keyframes shimmer {

            0%,
            100% {
                opacity: 0;
            }

            50% {
                opacity: 1;
            }
        }

        .card-body {
            color: var(--text-primary);
            padding: 2rem;
        }

        /* Form Styling */
        form {
            max-width: 600px;
            margin: 0 auto;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        label {
            color: var(--gold);
            font-weight: 600;
            margin-bottom: 0.5rem;
            display: block;
            font-size: 1rem;
        }

        .form-control {
            background: linear-gradient(135deg, rgba(10, 22, 40, 0.9) 0%, rgba(26, 58, 95, 0.8) 100%);
            border: 2px solid rgba(255, 215, 0, 0.3);
            border-radius: 10px;
            color: var(--text-primary);
            padding: 12px 16px;
            font-size: 1rem;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }

        .form-control:focus {
            background: linear-gradient(135deg, rgba(10, 22, 40, 0.95) 0%, rgba(26, 58, 95, 0.85) 100%);
            border-color: var(--gold);
            box-shadow: 0 0 0 3px rgba(255, 215, 0, 0.2);
            color: var(--text-primary);
            outline: none;
        }

        .form-control::placeholder {
            color: var(--text-secondary);
        }

        /* File Input Styling */
        .form-control[type="file"] {
            padding: 10px;
            background: linear-gradient(135deg, rgba(10, 22, 40, 0.8) 0%, rgba(26, 58, 95, 0.7) 100%);
        }

        .form-control[type="file"]:focus {
            background: linear-gradient(135deg, rgba(10, 22, 40, 0.9) 0%, rgba(26, 58, 95, 0.8) 100%);
        }

        /* Select Dropdown Styling */
        select.form-control {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%23ffd700' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 16px center;
            background-size: 16px;
            padding-right: 40px;
        }

        /* Invalid State */
        .form-control.is-invalid {
            border-color: var(--danger-color);
            background: linear-gradient(135deg, rgba(220, 53, 69, 0.1) 0%, rgba(26, 58, 95, 0.8) 100%);
        }

        .form-control.is-invalid:focus {
            border-color: var(--danger-color);
            box-shadow: 0 0 0 3px rgba(220, 53, 69, 0.2);
        }

        .invalid-feedback {
            color: #ff6b6b;
            font-size: 0.875rem;
            margin-top: 0.5rem;
            font-weight: 500;
        }

        /* Button Styling */
        .btn-primary {
            background: linear-gradient(135deg, var(--gold) 0%, var(--gold-light) 100%);
            border: 2px solid var(--gold);
            color: var(--dark-blue);
            font-weight: 700;
            padding: 12px 30px;
            border-radius: 10px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(255, 215, 0, 0.3);
            font-size: 1.1rem;
            width: 100%;
            margin-top: 1rem;
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(255, 215, 0, 0.4);
            background: linear-gradient(135deg, var(--gold-light) 0%, var(--gold) 100%);
            color: var(--dark-blue);
        }

        .btn-primary:active {
            transform: translateY(-1px);
        }

        /* Image Preview Styling */
        .image-preview-container {
            margin-top: 1rem;
            text-align: center;
            display: none;
        }

        .image-preview {
            max-width: 200px;
            max-height: 200px;
            border: 3px solid var(--gold);
            border-radius: 15px;
            box-shadow: 0 6px 20px rgba(255, 215, 0, 0.3);
            transition: all 0.3s ease;
            object-fit: cover;
        }

        .image-preview:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 25px rgba(255, 215, 0, 0.4);
        }

        .preview-label {
            color: var(--gold);
            font-weight: 600;
            margin-bottom: 0.5rem;
            display: block;
        }

        .remove-preview {
            background: linear-gradient(135deg, var(--danger-color) 0%, #e74c3c 100%);
            border: 2px solid var(--danger-color);
            color: white;
            font-weight: 600;
            padding: 6px 12px;
            border-radius: 6px;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(220, 53, 69, 0.3);
            margin-top: 0.5rem;
            font-size: 0.875rem;
        }

        .remove-preview:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(220, 53, 69, 0.4);
            background: linear-gradient(135deg, #e74c3c 0%, var(--danger-color) 100%);
            color: white;
        }

        /* Form Section Spacing */
        .mt-3 {
            margin-top: 1.5rem !important;
        }

        /* Animation */
        .fade-in {
            animation: fadeInUp 0.6s ease-out;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .slide-down {
            animation: slideDown 0.4s ease-out;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Form Group Hover Effect */
        .form-group {
            transition: transform 0.3s ease;
        }

        .form-group:hover {
            transform: translateX(5px);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .card-body {
                padding: 1.5rem;
            }

            form {
                max-width: 100%;
            }

            .form-control {
                padding: 10px 14px;
                font-size: 0.9rem;
            }

            .btn-primary {
                padding: 10px 20px;
                font-size: 1rem;
            }

            .image-preview {
                max-width: 150px;
                max-height: 150px;
            }
        }

        /* Option Styling for Select */
        select.form-control option {
            background: var(--dark-blue);
            color: var(--text-primary);
            padding: 10px;
        }

        /* File Input Custom Styling */
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
        }

        .file-input-custom {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px 16px;
            background: linear-gradient(135deg, rgba(10, 22, 40, 0.9) 0%, rgba(26, 58, 95, 0.8) 100%);
            border: 2px solid rgba(255, 215, 0, 0.3);
            border-radius: 10px;
            color: var(--text-secondary);
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .file-input-custom:hover {
            border-color: var(--gold);
            color: var(--text-primary);
        }

        .file-input-custom.has-file {
            color: var(--text-primary);
            border-color: var(--gold);
        }

        .file-input-text {
            flex-grow: 1;
        }

        .file-input-icon {
            color: var(--gold);
        }
    </style>
@endpush

@section('content')
    <div class="card fade-in">
        <div class="card-body">
            <form action="{{ route('admin.kategori.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- Nama Kategori --}}
                <div class="form-group">
                    <label for="nama">
                        <i class="bi bi-tag me-2"></i>Nama Kategori
                    </label>
                    <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror"
                        value="{{ old('nama') }}" required placeholder="Masukkan nama kategori">
                    @error('nama')
                        <div class="invalid-feedback">
                            <i class="bi bi-exclamation-circle me-2"></i>{{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- Parent Kategori --}}
                <div class="form-group mt-3">
                    <label for="parent_id">
                        <i class="bi bi-diagram-3 me-2"></i>Kategori Induk (Opsional)
                    </label>
                    <select name="parent_id" class="form-control @error('parent_id') is-invalid @enderror">
                        <option value="">-- Tidak ada (Kategori Utama) --</option>
                        @foreach ($kategoriUtamaFlat as $utama)
                            <option value="{{ $utama->id }}" {{ old('parent_id') == $utama->id ? 'selected' : '' }}>
                                {{ $utama->nama }}
                            </option>
                        @endforeach
                    </select>
                    @error('parent_id')
                        <div class="invalid-feedback">
                            <i class="bi bi-exclamation-circle me-2"></i>{{ $message }}
                        </div>
                    @enderror
                </div>

                {{-- Upload Gambar --}}
                <div class="form-group mt-3">
                    <label for="gambar">
                        <i class="bi bi-image me-2"></i>Upload Gambar
                    </label>
                    <div class="file-input-wrapper">
                        <div class="file-input-custom" id="fileInputCustom">
                            <span class="file-input-text" id="fileInputText">Pilih file gambar...</span>
                            <span class="file-input-icon">
                                <i class="bi bi-upload"></i>
                            </span>
                        </div>
                        <input type="file" name="gambar" id="gambar"
                            class="form-control @error('gambar') is-invalid @enderror" accept="image/*">
                    </div>

                    {{-- Image Preview Container --}}
                    <div class="image-preview-container" id="imagePreviewContainer">
                        <span class="preview-label">
                            <i class="bi bi-eye me-2"></i>Preview Gambar
                        </span>
                        <div class="mt-2">
                            <img id="imagePreview" class="image-preview" src="#" alt="Preview Gambar">
                        </div>
                        <button type="button" class="remove-preview" id="removePreview">
                            <i class="bi bi-x-circle me-2"></i>Hapus Preview
                        </button>
                    </div>

                    @error('gambar')
                        <div class="invalid-feedback d-block">
                            <i class="bi bi-exclamation-circle me-2"></i>{{ $message }}
                        </div>
                    @enderror
                    <small class="text-muted mt-2 d-block">
                        <i class="bi bi-info-circle me-1"></i>Format yang didukung: JPG, PNG, JPEG. Maksimal 2MB.
                    </small>
                </div>

                {{-- Tombol Simpan --}}
                <button type="submit" class="btn btn-primary mt-3">
                    <i class="bi bi-check-circle me-2"></i>Simpan Kategori
                </button>

                {{-- Tombol Kembali --}}
                <a href="{{ route('admin.kategori.index') }}" class="btn btn-outline-secondary mt-2" style="
                            background: transparent;
                            border: 2px solid var(--text-secondary);
                            color: var(--text-secondary);
                            padding: 12px 30px;
                            border-radius: 10px;
                            font-weight: 600;
                            width: 100%;
                            transition: all 0.3s ease;
                        ">
                    <i class="bi bi-arrow-left me-2"></i>Kembali ke Daftar
                </a>
            </form>
        </div>
    </div>
@endsection

@push('script')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // File input custom behavior
            const fileInput = document.getElementById('gambar');
            const fileInputCustom = document.getElementById('fileInputCustom');
            const fileInputText = document.getElementById('fileInputText');
            const imagePreviewContainer = document.getElementById('imagePreviewContainer');
            const imagePreview = document.getElementById('imagePreview');
            const removePreviewBtn = document.getElementById('removePreview');

            fileInput.addEventListener('change', function () {
                if (this.files && this.files[0]) {
                    const fileName = this.files[0].name;
                    fileInputText.textContent = fileName;
                    fileInputCustom.classList.add('has-file');

                    // Preview image
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        imagePreview.src = e.target.result;
                        imagePreviewContainer.style.display = 'block';
                        imagePreviewContainer.classList.add('slide-down');
                    }
                    reader.readAsDataURL(this.files[0]);
                } else {
                    resetFileInput();
                }
            });

            // Remove preview functionality
            removePreviewBtn.addEventListener('click', function () {
                resetFileInput();
                fileInput.value = ''; // Clear the file input
            });

            function resetFileInput() {
                fileInputText.textContent = 'Pilih file gambar...';
                fileInputCustom.classList.remove('has-file');
                imagePreviewContainer.style.display = 'none';
                imagePreviewContainer.classList.remove('slide-down');
                imagePreview.src = '#';
            }

            // Trigger file input when custom div is clicked
            fileInputCustom.addEventListener('click', function () {
                fileInput.click();
            });

            // Form validation enhancement
            const form = document.querySelector('form');
            form.addEventListener('submit', function (e) {
                const namaInput = document.querySelector('input[name="nama"]');
                if (!namaInput.value.trim()) {
                    e.preventDefault();
                    namaInput.focus();
                    // Add shake animation
                    namaInput.classList.add('is-invalid');
                    setTimeout(() => {
                        namaInput.classList.remove('is-invalid');
                    }, 1000);
                }
            });

            // Auto-focus on first input
            const firstInput = document.querySelector('input[name="nama"]');
            if (firstInput) {
                setTimeout(() => {
                    firstInput.focus();
                }, 500);
            }

            // File size validation
            fileInput.addEventListener('change', function () {
                const file = this.files[0];
                if (file) {
                    const fileSize = file.size / 1024 / 1024; // MB
                    const maxSize = 2; // 2MB

                    if (fileSize > maxSize) {
                        alert('Ukuran file terlalu besar! Maksimal 2MB.');
                        resetFileInput();
                        fileInput.value = ''; // Clear the file input
                    }

                    // Check file type
                    const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
                    if (!allowedTypes.includes(file.type)) {
                        alert('Format file tidak didukung! Hanya JPG, JPEG, dan PNG yang diizinkan.');
                        resetFileInput();
                        fileInput.value = ''; // Clear the file input
                    }
                }
            });
        });
    </script>
@endpush