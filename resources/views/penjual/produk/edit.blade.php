@extends('layouts.app')

@section('page_title', 'Edit Produk')

@section('title')
    <i class="fas fa-edit me-2"></i> Edit Produk
@endsection

@section('content')
    <style>
        .product-form-container {
            background: linear-gradient(135deg, rgba(10, 22, 40, 0.8) 0%, rgba(26, 58, 95, 0.9) 100%);
            border: 2px solid rgba(255, 215, 0, 0.3);
            border-radius: 15px;
            padding: 30px;
            backdrop-filter: blur(10px);
            margin-bottom: 50px;
            position: relative;
            min-height: auto;
            overflow: visible;
        }

        .page-container {
            padding-bottom: 80px;
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

        .btn-primary {
            background: linear-gradient(135deg, var(--gold) 0%, var(--gold-light) 100%);
            border: none;
            color: var(--dark-blue);
            font-weight: 700;
            padding: 12px 35px;
            border-radius: 8px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(255, 215, 0, 0.4);
            font-size: 1.1rem;
            margin: 10px 5px;
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(255, 215, 0, 0.6);
            color: var(--dark-blue);
        }

        .btn-secondary {
            background: linear-gradient(135deg, #6c757d, #868e96);
            border: none;
            color: white;
            font-weight: 700;
            padding: 12px 35px;
            border-radius: 8px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(108, 117, 125, 0.4);
            font-size: 1.1rem;
            margin: 10px 5px;
        }

        .btn-secondary:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(108, 117, 125, 0.6);
            background: linear-gradient(135deg, #868e96, #6c757d);
            color: white;
        }

        .discount-section {
            background: linear-gradient(135deg, rgba(26, 58, 95, 0.6) 0%, rgba(42, 74, 127, 0.7) 100%);
            border: 2px solid rgba(255, 215, 0, 0.3);
            border-radius: 12px;
            padding: 20px;
            margin: 25px 0;
            backdrop-filter: blur(10px);
        }

        .discount-section legend {
            font-weight: 600;
            color: var(--gold);
            font-size: 1.1rem;
            padding: 0 10px;
            width: auto;
        }

        .image-preview {
            max-width: 100%;
            max-height: 300px;
            border: 2px solid rgba(255, 215, 0, 0.3);
            border-radius: 8px;
            padding: 5px;
            background: rgba(26, 58, 95, 0.6);
            margin-top: 10px;
        }

        .image-preview-container {
            text-align: center;
        }

        .current-image {
            border: 2px solid var(--gold);
            border-radius: 8px;
            padding: 5px;
            background: rgba(26, 58, 95, 0.6);
            max-width: 200px;
            margin-top: 10px;
        }

        .file-input-label {
            background: linear-gradient(135deg, var(--gold) 0%, var(--gold-light) 100%);
            color: var(--dark-blue);
            padding: 10px 25px;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-block;
            font-weight: 600;
            margin-bottom: 10px;
            font-size: 1rem;
        }

        .file-input-label:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(255, 215, 0, 0.4);
        }

        .form-group {
            margin-bottom: 25px;
        }

        select.form-control {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%23ffd700' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 15px center;
            background-size: 16px;
            padding-right: 40px;
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

        .button-container {
            margin-top: 40px;
            padding-top: 25px;
            border-top: 1px solid rgba(255, 215, 0, 0.2);
            text-align: center;
            position: relative;
            z-index: 10;
        }

        .image-info {
            color: #c0c0c0;
            font-size: 0.9rem;
            margin-top: 5px;
        }

        /* Mobile responsiveness */
        @media (max-width: 768px) {
            .product-form-container {
                padding: 20px 15px;
                margin-bottom: 40px;
            }

            .button-container {
                margin-top: 30px;
                padding-top: 20px;
            }

            .btn-primary,
            .btn-secondary {
                padding: 12px 25px;
                font-size: 1rem;
                display: block;
                width: 100%;
                margin: 8px 0;
            }

            .page-container {
                padding-bottom: 60px;
            }

            .current-image {
                max-width: 150px;
            }
        }
    </style>

    <div class="container page-container">
        <h2 class="section-title"><i class="fas fa-edit me-3"></i>Edit Produk</h2>

        <div class="product-form-container">
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

            <div class="form-content">
                <form action="{{ route('penjual.produk.update', $produk->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- Kategori Utama --}}
                    <div class="form-group">
                        <label for="kategori_utama" class="form-label">
                            <i class="fas fa-tags me-2"></i>Kategori Utama
                        </label>
                        <select id="kategori_utama" class="form-control">
                            <option value="">-- Pilih Kategori Utama --</option>
                            @foreach($kategoriUtamas as $kategori)
                                <option value="{{ $kategori->id }}"
                                    {{ $produk->kategori->parent_id == $kategori->id ? 'selected' : '' }}>
                                    {{ $kategori->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Subkategori --}}
                    <div class="form-group">
                        <label for="subkategori" class="form-label">
                            <i class="fas fa-tag me-2"></i>Subkategori
                        </label>
                        <select name="kategori_produk_id" id="subkategori" class="form-control" required>
                            <option value="">-- Pilih Subkategori --</option>
                            @foreach($subkategoris as $sub)
                                <option value="{{ $sub->id }}" {{ $produk->kategori_produk_id == $sub->id ? 'selected' : '' }}>
                                    {{ $sub->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Nama Produk --}}
                    <div class="form-group">
                        <label for="nama" class="form-label">
                            <i class="fas fa-cube me-2"></i>Nama Produk
                        </label>
                        <input type="text" name="nama" id="nama" class="form-control"
                            value="{{ old('nama', $produk->nama) }}" placeholder="Masukkan nama produk" required>
                    </div>

                    {{-- Deskripsi Produk --}}
                    <div class="form-group">
                        <label for="deskripsi" class="form-label">
                            <i class="fas fa-align-left me-2"></i>Deskripsi Produk
                        </label>
                        <textarea name="deskripsi" id="deskripsi" class="form-control" rows="5"
                            placeholder="Deskripsikan produk Anda...">{{ old('deskripsi', $produk->deskripsi) }}</textarea>
                    </div>

                    <div class="row">
                        {{-- Harga Produk --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="harga" class="form-label">
                                    <i class="fas fa-tag me-2"></i>Harga Produk (Rp)
                                </label>
                                <input type="number" name="harga" id="harga" class="form-control"
                                    value="{{ old('harga', $produk->harga) }}" min="0" placeholder="0" required>
                            </div>
                        </div>

                        {{-- Stok Produk --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="stok" class="form-label">
                                    <i class="fas fa-boxes me-2"></i>Stok Produk
                                </label>
                                <input type="number" name="stok" id="stok" class="form-control"
                                    value="{{ old('stok', $produk->stok) }}" min="0" placeholder="0" required>
                            </div>
                        </div>
                    </div>

                    {{-- Gambar Produk --}}
                    <div class="form-group">
                        <label class="form-label d-block">
                            <i class="fas fa-image me-2"></i>Gambar Produk
                        </label>

                        @if($produk->gambar)
                            <div class="mb-3">
                                <p class="text-gold mb-2"><i class="fas fa-image me-2"></i>Gambar Saat Ini:</p>
                                <img src="{{ asset('storage/' . $produk->gambar) }}" class="current-image" alt="Gambar Produk">
                                <p class="image-info">Kosongkan jika tidak ingin mengubah gambar</p>
                            </div>
                        @endif

                        <label for="gambar" class="file-input-label">
                            <i class="fas fa-upload me-2"></i>Pilih Gambar Baru
                        </label>
                        <input type="file" name="gambar" id="gambar" class="d-none" accept="image/*"
                            onchange="previewImage(event)">
                        <div class="image-preview-container">
                            <img id="preview" src="#" alt="Preview Gambar Baru" class="image-preview"
                                style="display: none;">
                        </div>
                        <small class="text-muted d-block mt-2">Format: JPG, PNG, JPEG | Maksimal: 2MB</small>
                    </div>

                    {{-- Diskon Produk --}}
                    <fieldset class="discount-section">
                        <legend><i class="fas fa-percentage me-2"></i>Diskon (Opsional)</legend>

                        <div class="form-group">
                            <label for="persen_diskon" class="form-label">Persen Diskon (%)</label>
                            <input type="number" name="persen_diskon" id="persen_diskon" class="form-control" min="0"
                                max="100" value="{{ old('persen_diskon', optional($produk->diskon)->persen_diskon) }}"
                                placeholder="Contoh: 10">
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tanggal_mulai" class="form-label">Tanggal Mulai Diskon</label>
                                    <input type="date" name="tanggal_mulai" id="tanggal_mulai" class="form-control"
                                        value="{{ old('tanggal_mulai', optional($produk->diskon)->tanggal_mulai ? \Carbon\Carbon::parse($produk->diskon->tanggal_mulai)->format('Y-m-d') : '') }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tanggal_berakhir" class="form-label">Tanggal Berakhir Diskon</label>
                                    <input type="date" name="tanggal_berakhir" id="tanggal_berakhir" class="form-control"
                                        value="{{ old('tanggal_berakhir', optional($produk->diskon)->tanggal_berakhir ? \Carbon\Carbon::parse($produk->diskon->tanggal_berakhir)->format('Y-m-d') : '') }}">
                                </div>
                            </div>
                        </div>

                        <small class="text-muted">
                            <i class="fas fa-info-circle me-1"></i>
                            Isi semua field diskon jika ingin memberikan diskon pada produk ini.
                        </small>
                    </fieldset>

                    <div class="button-container">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-save me-2"></i>Update Produk
                        </button>
                        <a href="{{ route('penjual.produk.index') }}" class="btn btn-secondary btn-lg">
                            <i class="fas fa-arrow-left me-2"></i>Kembali
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Preview Gambar Script --}}
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

        // JavaScript untuk meng-handle perubahan kategori utama
        document.addEventListener('DOMContentLoaded', function () {
            const kategoriUtamaSelect = document.getElementById('kategori_utama');
            const subkategoriSelect = document.getElementById('subkategori');

            if (kategoriUtamaSelect) {
                kategoriUtamaSelect.addEventListener('change', function () {
                    const kategoriId = this.value;

                    // Reset subkategori
                    subkategoriSelect.innerHTML = '<option value="">-- Pilih Subkategori --</option>';

                    if (kategoriId) {
                        // Di sini Anda bisa menambahkan AJAX call untuk mengambil subkategori
                        // berdasarkan kategori utama yang dipilih
                        // Contoh:
                        // fetch(`/api/subkategoris/${kategoriId}`)
                        //     .then(response => response.json())
                        //     .then(data => {
                        //         data.forEach(sub => {
                        //             const option = document.createElement('option');
                        //             option.value = sub.id;
                        //             option.textContent = sub.nama;
                        //             subkategoriSelect.appendChild(option);
                        //         });
                        //     });
                    }
                });
            }
        });
    </script>
@endsection