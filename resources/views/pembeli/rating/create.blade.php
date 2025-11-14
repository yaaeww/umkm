@extends('layouts.pembeli-navbar')

@section('title', 'Beri Ulasan Produk')

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

        .page-header {
            margin-bottom: 2rem;
        }

        .page-title {
            background: linear-gradient(135deg, var(--gold) 0%, var(--gold-light) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: 700;
            font-size: 2.2rem;
            margin-bottom: 0.5rem;
        }

        .page-subtitle {
            color: rgba(255, 255, 255, 0.8);
            font-size: 1.1rem;
            margin-bottom: 0;
        }

        .review-card {
            background: rgba(30, 30, 46, 0.7);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            overflow: hidden;
            padding: 2.5rem;
            backdrop-filter: blur(10px);
            margin-bottom: 2rem;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        }

        .product-info {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 2rem;
            border: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .product-image {
            width: 80px;
            height: 80px;
            border-radius: 12px;
            object-fit: cover;
            border: 2px solid var(--gold);
        }

        .product-details {
            flex: 1;
        }

        .product-name {
            color: var(--gold);
            font-weight: 600;
            font-size: 1.3rem;
            margin-bottom: 0.5rem;
        }

        .product-meta {
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.9rem;
        }

        .form-group {
            margin-bottom: 2rem;
        }

        .form-label {
            color: var(--gold);
            font-weight: 600;
            margin-bottom: 1rem;
            display: block;
            font-size: 1.1rem;
        }

        .star-rating {
            display: flex;
            gap: 0.5rem;
            margin-bottom: 1rem;
            flex-direction: row-reverse;
            justify-content: flex-end;
        }

        .star-rating input {
            display: none;
        }

        .star-rating label {
            font-size: 2.5rem;
            color: rgba(255, 255, 255, 0.3);
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
        }

        .star-rating label:hover,
        .star-rating label:hover~label,
        .star-rating input:checked~label {
            color: var(--gold);
            transform: scale(1.1);
        }

        .star-rating input:checked+label {
            color: var(--gold);
        }

        .rating-value {
            color: var(--gold);
            font-weight: 600;
            font-size: 1.1rem;
            margin-top: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .form-control {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 8px;
            color: rgba(255, 255, 255, 0.9);
            padding: 1rem 1.25rem;
            transition: all 0.3s ease;
            width: 100%;
            font-size: 1rem;
            resize: vertical;
            min-height: 120px;
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

        .char-count {
            text-align: right;
            color: rgba(255, 255, 255, 0.6);
            font-size: 0.85rem;
            margin-top: 0.5rem;
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
            min-width: 140px;
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

        .form-actions {
            display: flex;
            gap: 1rem;
            justify-content: center;
            margin-top: 2rem;
            flex-wrap: wrap;
        }

        .error-message {
            color: var(--danger-color);
            font-size: 0.9rem;
            margin-top: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .error-message i {
            font-size: 1rem;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .container {
                padding-top: 70px;
            }

            .page-title {
                font-size: 1.8rem;
            }

            .review-card {
                padding: 2rem;
            }

            .product-info {
                flex-direction: column;
                text-align: center;
                gap: 1rem;
            }

            .star-rating {
                justify-content: center;
            }

            .star-rating label {
                font-size: 2rem;
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

            .page-title {
                font-size: 1.6rem;
            }

            .review-card {
                padding: 1.5rem;
            }

            .product-image {
                width: 60px;
                height: 60px;
            }

            .star-rating label {
                font-size: 1.75rem;
            }
        }
    </style>

    <div class="container">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-title">
                <i class="fas fa-star me-2"></i>Beri Ulasan Produk
            </h1>
            <p class="page-subtitle">Bagikan pengalaman Anda tentang produk ini</p>
        </div>

        <div class="review-card">
            <!-- Product Information -->
            <div class="product-info">
                @if($produk->gambar)
                    <img src="{{ asset('storage/' . $produk->gambar) }}" class="product-image" alt="{{ $produk->nama }}">
                @else
                    <div class="product-image d-flex align-items-center justify-content-center bg-secondary">
                        <i class="fas fa-cube text-white"></i>
                    </div>
                @endif
                <div class="product-details">
                    <h3 class="product-name">{{ $produk->nama }}</h3>
                    <div class="product-meta">
                        <p><i class="fas fa-receipt me-2"></i>Pesanan: {{ $order->invoice ?? 'INV-' . $order->id }}</p>
                        <p><i class="fas fa-calendar me-2"></i>Diterima: {{ $order->updated_at->format('d M Y') }}</p>
                    </div>
                </div>
            </div>

            <!-- Review Form -->
            <form action="{{ route('pembeli.rating.store') }}" method="POST">
                @csrf
                <input type="hidden" name="orders_id" value="{{ $order->id }}">
                <input type="hidden" name="produks_id" value="{{ $produk->id }}">

                <!-- Star Rating -->
                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-star me-2"></i>Rating Produk
                    </label>
                    <div class="star-rating">
                        @for($i = 5; $i >= 1; $i--)
                            <input type="radio" id="star{{ $i }}" name="bintang" value="{{ $i }}"
                                {{ old('bintang') == $i ? 'checked' : '' }} required>
                            <label for="star{{ $i }}">★</label>
                        @endfor
                    </div>
                    <div class="rating-value" id="ratingValue">
                        <i class="fas fa-info-circle"></i>
                        <span>Pilih rating dengan mengklik bintang di atas</span>
                    </div>
                    @error('bintang')
                        <div class="error-message">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Review Text -->
                <div class="form-group">
                    <label for="ulasan" class="form-label">
                        <i class="fas fa-edit me-2"></i>Ulasan Anda
                    </label>
                    <textarea id="ulasan" name="ulasan" class="form-control"
                        placeholder="Bagikan pengalaman Anda menggunakan produk ini. Apa yang Anda sukai? Apakah ada saran untuk perbaikan?"
                        required>{{ old('ulasan') }}</textarea>
                    <div class="char-count">
                        <span id="charCount">0</span> karakter
                    </div>
                    @error('ulasan')
                        <div class="error-message">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Form Actions -->
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-paper-plane me-2"></i>Kirim Ulasan
                    </button>
                    <a href="{{ route('pembeli.rating.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Kembali
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Star rating interaction
        document.addEventListener('DOMContentLoaded', function () {
            const starInputs = document.querySelectorAll('.star-rating input');
            const ratingValue = document.getElementById('ratingValue');
            const textarea = document.getElementById('ulasan');
            const charCount = document.getElementById('charCount');

            // Update character count
            textarea.addEventListener('input', function () {
                charCount.textContent = this.value.length;
            });

            // Initialize character count
            charCount.textContent = textarea.value.length;

            // Star rating labels
            const ratingLabels = {
                1: 'Tidak Puas - Produk tidak sesuai harapan',
                2: 'Kurang Puas - Ada beberapa kekurangan',
                3: 'Cukup - Produk sesuai ekspektasi',
                4: 'Puas - Produk bagus dan memuaskan',
                5: 'Sangat Puas - Produk luar biasa dan melebihi ekspektasi'
            };

            // Update rating value display
            starInputs.forEach(star => {
                star.addEventListener('change', function () {
                    const value = this.value;
                    ratingValue.innerHTML = `
                            <i class="fas fa-star"></i>
                            <span>${value}/5 - ${ratingLabels[value]}</span>
                        `;
                });
            });

            // Set initial rating if exists
            const checkedStar = document.querySelector('.star-rating input:checked');
            if (checkedStar) {
                const value = checkedStar.value;
                ratingValue.innerHTML = `
                        <i class="fas fa-star"></i>
                        <span>${value}/5 - ${ratingLabels[value]}</span>
                    `;
            }

            // Add hover effects for stars
            const stars = document.querySelectorAll('.star-rating label');
            stars.forEach((star, index) => {
                star.addEventListener('mouseenter', function () {
                    const starIndex = 4 - index; // Reverse order
                    ratingValue.innerHTML = `
                            <i class="fas fa-star"></i>
                            <span>${starIndex + 1}/5 - ${ratingLabels[starIndex + 1]}</span>
                        `;
                });

                star.addEventListener('mouseleave', function () {
                    const checkedStar = document.querySelector('.star-rating input:checked');
                    if (checkedStar) {
                        const value = checkedStar.value;
                        ratingValue.innerHTML = `
                                <i class="fas fa-star"></i>
                                <span>${value}/5 - ${ratingLabels[value]}</span>
                            `;
                    } else {
                        ratingValue.innerHTML = `
                                <i class="fas fa-info-circle"></i>
                                <span>Pilih rating dengan mengklik bintang di atas</span>
                            `;
                    }
                });
            });
        });
    </script>
@endsection