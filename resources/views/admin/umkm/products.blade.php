@extends('layouts.app')
@section('page_title', 'Produk Toko')

@section('title')
    <i class="fas fa-shopping-bag me-2"></i> Produk Toko
@endsection

@section('content')
    <div class="container mt-5 pt-5">
        <!-- Hero Section untuk Produk Toko -->
        <section class="hero mb-5">
            <div class="sparkle"></div>
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-8">
                        <div class="hero-content">
                            <h1>Produk {{ $umkm->nama_toko }}</h1>
                            <p class="mb-3">Jelajahi berbagai produk berkualitas dari UMKM lokal Indramayu</p>
                            <div class="d-flex flex-wrap gap-3 align-items-center">
                                <span class="badge bg-gold text-dark fs-6 px-3 py-2">
                                    <i class="fas fa-boxes me-2"></i>{{ $products->count() }} Produk
                                </span>
                                <span class="text-gold"><i class="fas fa-store me-2"></i>{{ $umkm->nama_toko }}</span>
                                <span class="text-gold"><i
                                        class="fas fa-user me-2"></i>{{ $umkm->user->name ?? 'Pemilik' }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 text-center">
                        @if($umkm->logo)
                            <div class="logo-container">
                                <img src="{{ asset('storage/' . $umkm->logo) }}" class="store-logo"
                                    alt="Logo {{ $umkm->nama_toko }}">
                            </div>
                        @else
                            <div class="logo-placeholder">
                                <i class="fas fa-store fa-4x text-gold"></i>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>

        <!-- Daftar Produk -->
        <section id="produk-toko" class="container mb-5">
            <div class="section-header mb-4">
                <h2 class="section-title"><i class="fas fa-box-open me-3"></i>Daftar Produk</h2>
                <p class="section-subtitle">Produk-produk unggulan dari {{ $umkm->nama_toko }}</p>
            </div>

            @if($products->count() > 0)
                <div class="row g-4">
                    @foreach ($products as $produk)
                        <div class="col-md-6 col-lg-4 col-xl-3">
                            <div class="card product-card">
                                <div class="product-image">
                                    @if ($produk->gambar && file_exists(public_path('storage/' . $produk->gambar)))
                                        <img src="{{ asset('storage/' . $produk->gambar) }}" class="card-img-top"
                                            alt="{{ $produk->nama }}">
                                    @else
                                        <div class="no-image">
                                            <i class="fas fa-image fa-3x text-gold"></i>
                                            <p class="mt-2 text-gold">No Image</p>
                                        </div>
                                    @endif
                                    <div class="product-overlay">
                                        <button class="btn-view-detail" onclick="showProductDetail({{ $produk->id }})">
                                            <i class="fas fa-eye me-2"></i>Lihat Detail
                                        </button>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title">{{ $produk->nama }}</h5>
                                    <p class="card-description">{{ Str::limit($produk->deskripsi, 80) }}</p>
                                    <div class="product-meta">
                                        <span class="price">Rp{{ number_format($produk->harga, 0, ',', '.') }}</span>
                                        <span class="category-badge">UMKM</span>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <form action="{{ route('admin.produk.destroy', $produk->id) }}" method="POST"
                                        onsubmit="return confirm('Yakin ingin menghapus produk ini?')" class="w-100">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-delete w-100">
                                            <i class="fas fa-trash me-2"></i>Hapus Produk
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="empty-state text-center py-5">
                    <i class="fas fa-box-open fa-5x text-gold mb-3 opacity-50"></i>
                    <h3 class="text-gold mb-3">Belum Ada Produk</h3>
                    <p class="text-muted mb-4">UMKM ini belum menambahkan produk.</p>
                    <a href="{{ route('admin.umkm.index') }}" class="btn btn-back">
                        <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar UMKM
                    </a>
                </div>
            @endif
        </section>

        <!-- Action Buttons -->
        @if($products->count() > 0)
            <section class="container mb-5">
                <div class="text-center">
                    <a href="{{ route('admin.umkm.index') }}" class="btn btn-back me-3">
                        <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar UMKM
                    </a>
                
                </div>
            </section>
        @endif
    </div>

    <!-- Modal untuk Detail Produk -->
    <div class="modal fade" id="productDetailModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content custom-modal">
                <div class="modal-header">
                    <h5 class="modal-title text-gold">Detail Produk</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="productDetailContent">
                    <!-- Konten detail produk akan dimuat di sini -->
                </div>
            </div>
        </div>
    </div>

    <style>
        :root {
            --dark-blue: #0a1628;
            --medium-blue: #1a3a5f;
            --light-blue: #2a4a7f;
            --gold: #ffd700;
            --gold-light: #ffed4e;
            --gold-dark: #d4af37;
        }

        .text-gold {
            color: var(--gold) !important;
        }

        .bg-gold {
            background: linear-gradient(135deg, var(--gold) 0%, var(--gold-light) 100%) !important;
        }

        /* Hero Section */
        .hero {
            position: relative;
            background: linear-gradient(135deg, var(--dark-blue) 0%, var(--medium-blue) 70%, var(--light-blue) 100%);
            min-height: 40vh;
            display: flex;
            align-items: center;
            overflow: hidden;
            padding: 100px 0 60px;
            border-radius: 20px;
            margin: 20px 0;
            border: 1px solid rgba(255, 215, 0, 0.2);
        }

        .hero h1 {
            font-size: 3rem;
            font-weight: 800;
            line-height: 1.2;
            margin-bottom: 1rem;
            background: linear-gradient(135deg, var(--gold) 0%, var(--gold-light) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero p {
            font-size: 1.2rem;
            color: #c0c0c0;
            margin-bottom: 1.5rem;
        }

        /* Logo Store */
        .logo-container {
            width: 150px;
            height: 150px;
            margin: 0 auto;
            border-radius: 50%;
            overflow: hidden;
            border: 4px solid var(--gold);
            box-shadow: 0 0 30px rgba(255, 215, 0, 0.3);
        }

        .store-logo {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .logo-placeholder {
            width: 150px;
            height: 150px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            border: 4px solid var(--gold);
            background: rgba(255, 215, 0, 0.1);
        }

        /* Section Header */
        .section-header {
            text-align: center;
            margin-bottom: 3rem;
        }

        .section-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            background: linear-gradient(135deg, var(--gold) 0%, var(--gold-light) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .section-subtitle {
            color: #c0c0c0;
            font-size: 1.1rem;
        }

        /* Product Cards */
        .product-card {
            background: linear-gradient(135deg, rgba(26, 58, 95, 0.7) 0%, rgba(42, 74, 127, 0.8) 100%);
            border: 1px solid rgba(255, 215, 0, 0.2);
            border-radius: 15px;
            overflow: hidden;
            transition: all 0.4s ease;
            height: 100%;
            backdrop-filter: blur(10px);
        }

        .product-card:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 0 15px 40px rgba(255, 215, 0, 0.3);
            border-color: var(--gold);
        }

        .product-image {
            position: relative;
            overflow: hidden;
        }

        .product-card .card-img-top {
            height: 200px;
            object-fit: cover;
            transition: transform 0.4s ease;
        }

        .product-card:hover .card-img-top {
            transform: scale(1.1);
        }

        .no-image {
            height: 200px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background: rgba(255, 215, 0, 0.1);
        }

        .product-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(10, 22, 40, 0.8);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .product-card:hover .product-overlay {
            opacity: 1;
        }

        .btn-view-detail {
            background: linear-gradient(135deg, var(--gold) 0%, var(--gold-light) 100%);
            border: none;
            color: var(--dark-blue);
            font-weight: 600;
            padding: 10px 20px;
            border-radius: 8px;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .btn-view-detail:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 215, 0, 0.4);
        }

        .card-body {
            padding: 1.5rem;
        }

        .card-title {
            color: var(--gold);
            font-weight: 600;
            font-size: 1.1rem;
            margin-bottom: 0.8rem;
            line-height: 1.4;
        }

        .card-description {
            color: #c0c0c0;
            font-size: 0.9rem;
            margin-bottom: 1rem;
            line-height: 1.5;
        }

        .product-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: auto;
        }

        .price {
            color: var(--gold-light);
            font-weight: 700;
            font-size: 1.2rem;
        }

        .category-badge {
            background: rgba(255, 215, 0, 0.2);
            color: var(--gold);
            padding: 4px 8px;
            border-radius: 6px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .card-footer {
            background: rgba(10, 22, 40, 0.5);
            border-top: 1px solid rgba(255, 215, 0, 0.2);
            padding: 1rem 1.5rem;
        }

        .btn-delete {
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
            border: none;
            color: white;
            font-weight: 600;
            padding: 10px 16px;
            border-radius: 8px;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .btn-delete:hover {
            background: linear-gradient(135deg, #c82333 0%, #bd2130 100%);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(220, 53, 69, 0.4);
        }

        /* Empty State */
        .empty-state {
            background: linear-gradient(135deg, rgba(26, 58, 95, 0.5) 0%, rgba(42, 74, 127, 0.6) 100%);
            border-radius: 15px;
            border: 2px dashed rgba(255, 215, 0, 0.3);
            padding: 4rem 2rem !important;
        }

        /* Buttons */
        .btn-back {
            background: linear-gradient(135deg, var(--medium-blue) 0%, var(--light-blue) 100%);
            color: var(--gold);
            border: 2px solid var(--gold);
            padding: 12px 30px;
            font-weight: 600;
            border-radius: 50px;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .btn-back:hover {
            background: linear-gradient(135deg, var(--gold) 0%, var(--gold-light) 100%);
            color: var(--dark-blue);
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(255, 215, 0, 0.4);
        }

        .btn-add-product {
            background: linear-gradient(135deg, var(--gold) 0%, var(--gold-light) 100%);
            color: var(--dark-blue);
            border: none;
            padding: 12px 30px;
            font-weight: 600;
            border-radius: 50px;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .btn-add-product:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(255, 215, 0, 0.4);
            color: var(--dark-blue);
        }

        /* Badges */
        .badge {
            font-weight: 600;
            padding: 0.5rem 1rem;
            border-radius: 50px;
        }

        /* Modal Custom */
        .custom-modal {
            background: linear-gradient(135deg, rgba(26, 58, 95, 0.95) 0%, rgba(42, 74, 127, 0.98) 100%);
            border: 2px solid var(--gold);
            border-radius: 15px;
            backdrop-filter: blur(10px);
        }

        .custom-modal .modal-header {
            border-bottom: 1px solid rgba(255, 215, 0, 0.2);
            background: rgba(255, 215, 0, 0.1);
        }

        .custom-modal .modal-body {
            color: #c0c0c0;
        }

        .custom-modal .btn-close {
            filter: invert(76%) sepia(92%) saturate(1600%) hue-rotate(1deg) brightness(105%) contrast(105%);
        }

        /* Sparkle effect */
        .sparkle {
            position: absolute;
            width: 100%;
            height: 100%;
            pointer-events: none;
            overflow: hidden;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero h1 {
                font-size: 2rem;
            }

            .hero p {
                font-size: 1rem;
            }

            .logo-container,
            .logo-placeholder {
                width: 120px;
                height: 120px;
            }

            .section-title {
                font-size: 2rem;
            }

            .product-meta {
                flex-direction: column;
                gap: 0.5rem;
                align-items: flex-start;
            }

            .btn-back,
            .btn-add-product {
                width: 100%;
                margin-bottom: 1rem;
                text-align: center;
            }
        }

        /* Animation for sparkle */
        @keyframes sparkleFloat {

            0%,
            100% {
                transform: translateY(0) scale(1);
                opacity: 0;
            }

            50% {
                transform: translateY(-30px) scale(1.5);
                opacity: 1;
            }
        }
    </style>

    <script>
        // Sparkle animation
        document.addEventListener('DOMContentLoaded', function () {
            const hero = document.querySelector('.hero');
            setInterval(() => {
                const sparkle = document.createElement('div');
                sparkle.style.position = 'absolute';
                sparkle.style.width = '3px';
                sparkle.style.height = '3px';
                sparkle.style.background = '#ffd700';
                sparkle.style.borderRadius = '50%';
                sparkle.style.boxShadow = '0 0 10px #ffd700';
                sparkle.style.left = Math.random() * 100 + '%';
                sparkle.style.top = Math.random() * 100 + '%';
                sparkle.style.animation = 'sparkleFloat 2s forwards';
                sparkle.style.pointerEvents = 'none';
                hero.appendChild(sparkle);

                setTimeout(() => sparkle.remove(), 2000);
            }, 500);
        });

        // Function to show product detail (placeholder)
        function showProductDetail(productId) {
            // Ini adalah placeholder - Anda bisa mengimplementasikan AJAX call untuk mengambil detail produk
            const modal = new bootstrap.Modal(document.getElementById('productDetailModal'));
            document.getElementById('productDetailContent').innerHTML = `
            <div class="text-center">
                <i class="fas fa-info-circle fa-3x text-gold mb-3"></i>
                <h4 class="text-gold mb-3">Fitur Detail Produk</h4>
                <p class="mb-4">Fitur detail produk akan menampilkan informasi lengkap tentang produk ini.</p>
                <p class="text-muted">Product ID: ${productId}</p>
            </div>
        `;
            modal.show();
        }
    </script>
@endsection