@extends('layouts.app')
@section('page_title', 'Detail Toko')

@section('title')
    <i class="fas fa-store me-2"></i>Detail Toko
@endsection

@section('content')
<div class="container mt-5 pt-5">
    <!-- Hero Section untuk Detail Toko -->
    <section class="hero mb-5">
        <div class="sparkle"></div>
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <div class="hero-content">
                        <h1>{{ $umkm->nama_toko }}</h1>
                        <p class="mb-3">UMKM Lokal Indramayu yang menyediakan berbagai produk berkualitas</p>
                        <div class="d-flex flex-wrap gap-3 align-items-center">
                            <span class="badge 
                                @if($umkm->status == 'approved') bg-success 
                                @elseif($umkm->status == 'pending') bg-warning 
                                @else bg-danger 
                                @endif fs-6 px-3 py-2">
                                {{ ucfirst($umkm->status) }}
                            </span>
                            <span class="text-gold"><i class="fas fa-map-marker-alt me-2"></i>{{ $umkm->alamat }}</span>
                            <span class="text-gold"><i class="fas fa-phone me-2"></i>{{ $umkm->no_telp }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 text-center">
                    @if($umkm->logo)
                        <div class="logo-container">
                            <img src="{{ asset('storage/' . $umkm->logo) }}" class="store-logo" alt="Logo {{ $umkm->nama_toko }}">
                        </div>
                    @else
                        <div class="logo-placeholder">
                            <i class="fas fa-store fa-6x text-gold"></i>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- Informasi UMKM -->
    <section id="informasi" class="container mb-5">
        <div class="row">
            <div class="col-lg-8">
                <div class="card-custom">
                    <div class="card-header-custom">
                        <h3><i class="fas fa-info-circle me-2"></i>Informasi UMKM</h3>
                    </div>
                    <div class="card-body-custom">
                        <div class="info-grid">
                            <div class="info-item">
                                <i class="fas fa-user-tie text-gold"></i>
                                <div>
                                    <h5>Pemilik UMKM</h5>
                                    <p>{{ $umkm->user->name ?? 'Tidak tersedia' }}</p>
                                </div>
                            </div>
                            <div class="info-item">
                                <i class="fas fa-envelope text-gold"></i>
                                <div>
                                    <h5>Email</h5>
                                    <p>{{ $umkm->user->email ?? '-' }}</p>
                                </div>
                            </div>
                            <div class="info-item">
                                <i class="fas fa-map-marked-alt text-gold"></i>
                                <div>
                                    <h5>Alamat Lengkap</h5>
                                    <p>{{ $umkm->alamat }}</p>
                                </div>
                            </div>
                            <div class="info-item">
                                <i class="fas fa-phone-alt text-gold"></i>
                                <div>
                                    <h5>Telepon</h5>
                                    <p>{{ $umkm->no_telp }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card-custom">
                    <div class="card-header-custom">
                        <h3><i class="fas fa-chart-bar me-2"></i>Statistik</h3>
                    </div>
                    <div class="card-body-custom">
                        <div class="stats-grid">
                            <div class="stat-item text-center">
                                <i class="fas fa-boxes fa-2x text-gold mb-2"></i>
                                <h4 class="text-gold">{{ $umkm->produks->count() }}</h4>
                                <p class="mb-0">Total Produk</p>
                            </div>
                            <div class="stat-item text-center">
                                <i class="fas fa-star fa-2x text-gold mb-2"></i>
                                <h4 class="text-gold">4.8</h4>
                                <p class="mb-0">Rating</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Produk UMKM -->
    <section id="produk-umkm" class="container mb-5">
        <h2 class="section-title"><i class="fas fa-boxes me-3"></i>Produk UMKM</h2>
        
        @if($umkm->produks && $umkm->produks->count() > 0)
            <div class="row g-4">
                @foreach($umkm->produks as $produk)
                <div class="col-md-6 col-lg-4 col-xl-3">
                    <div class="card product-card">
                        @if($produk->gambar)
                            <img src="{{ asset('storage/' . $produk->gambar) }}" class="card-img-top" alt="{{ $produk->nama }}">
                        @else
                            <div class="no-image">
                                <i class="fas fa-image fa-3x text-gold"></i>
                            </div>
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $produk->nama }}</h5>
                            <p class="card-description">{{ Str::limit($produk->deskripsi, 100) }}</p>
                            <div class="product-footer">
                                <span class="price">Rp{{ number_format($produk->harga, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <div class="empty-state text-center py-5">
                <i class="fas fa-box-open fa-4x text-gold mb-3 opacity-50"></i>
                <h4 class="text-gold">Belum Ada Produk</h4>
                <p class="text-muted">UMKM ini belum menambahkan produk.</p>
            </div>
        @endif
    </section>

    <!-- Action Buttons -->
    <section class="container mb-5">
        <div class="text-center">
            <a href="{{ route('admin.umkm.index') }}" class="btn btn-back">
                <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar UMKM
            </a>
        </div>
    </section>
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

/* Hero Section untuk Detail Toko */
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
    width: 200px;
    height: 200px;
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
    width: 200px;
    height: 200px;
    margin: 0 auto;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    border: 4px solid var(--gold);
    background: rgba(255, 215, 0, 0.1);
}

/* Custom Cards */
.card-custom {
    background: linear-gradient(135deg, rgba(26, 58, 95, 0.7) 0%, rgba(42, 74, 127, 0.8) 100%);
    border: 1px solid rgba(255, 215, 0, 0.2);
    border-radius: 15px;
    overflow: hidden;
    backdrop-filter: blur(10px);
    transition: all 0.3s ease;
    height: 100%;
}

.card-custom:hover {
    transform: translateY(-5px);
    border-color: var(--gold);
    box-shadow: 0 10px 30px rgba(255, 215, 0, 0.2);
}

.card-header-custom {
    background: linear-gradient(135deg, rgba(255, 215, 0, 0.1) 0%, rgba(255, 237, 78, 0.05) 100%);
    padding: 1.5rem;
    border-bottom: 1px solid rgba(255, 215, 0, 0.2);
}

.card-header-custom h3 {
    color: var(--gold);
    margin: 0;
    font-size: 1.5rem;
}

.card-body-custom {
    padding: 1.5rem;
}

/* Info Grid */
.info-grid {
    display: grid;
    gap: 1.5rem;
}

.info-item {
    display: flex;
    align-items: flex-start;
    gap: 1rem;
}

.info-item i {
    font-size: 1.5rem;
    margin-top: 0.25rem;
    flex-shrink: 0;
}

.info-item h5 {
    color: var(--gold);
    margin-bottom: 0.5rem;
    font-size: 1rem;
}

.info-item p {
    color: #c0c0c0;
    margin: 0;
}

/* Stats Grid */
.stats-grid {
    display: grid;
    gap: 2rem;
}

.stat-item h4 {
    font-size: 2rem;
    font-weight: 700;
}

.stat-item p {
    color: #c0c0c0;
    font-size: 0.9rem;
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
    align-items: center;
    justify-content: center;
    background: rgba(255, 215, 0, 0.1);
}

.card-body {
    padding: 1.5rem;
}

.card-title {
    color: var(--gold);
    font-weight: 600;
    font-size: 1.1rem;
    margin-bottom: 0.8rem;
}

.card-description {
    color: #c0c0c0;
    font-size: 0.9rem;
    margin-bottom: 1rem;
    line-height: 1.5;
}

.product-footer {
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

.btn-view {
    background: linear-gradient(135deg, var(--gold) 0%, var(--gold-light) 100%);
    border: none;
    color: var(--dark-blue);
    font-weight: 600;
    padding: 8px 16px;
    border-radius: 8px;
    transition: all 0.3s ease;
    cursor: pointer;
}

.btn-view:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(255, 215, 0, 0.4);
}

/* Empty State */
.empty-state {
    background: linear-gradient(135deg, rgba(26, 58, 95, 0.5) 0%, rgba(42, 74, 127, 0.6) 100%);
    border-radius: 15px;
    border: 2px dashed rgba(255, 215, 0, 0.3);
}

/* Back Button */
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

/* Section Title */
.section-title {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 3rem;
    text-align: center;
    position: relative;
    background: linear-gradient(135deg, var(--gold) 0%, var(--gold-light) 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.section-title::after {
    content: "";
    position: absolute;
    bottom: -15px;
    left: 50%;
    transform: translateX(-50%);
    width: 80px;
    height: 3px;
    background: linear-gradient(90deg, var(--gold), var(--gold-light));
    border-radius: 2px;
}

/* Badges */
.badge {
    font-size: 0.8rem;
    font-weight: 600;
    padding: 0.5rem 1rem;
    border-radius: 50px;
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
        width: 150px;
        height: 150px;
    }
    
    .info-grid {
        gap: 1rem;
    }
    
    .info-item {
        flex-direction: column;
        text-align: center;
        gap: 0.5rem;
    }
    
    .section-title {
        font-size: 2rem;
    }
    
    .product-footer {
        flex-direction: column;
        gap: 1rem;
        text-align: center;
    }
}

/* Sparkle effect */
.sparkle {
    position: absolute;
    width: 100%;
    height: 100%;
    pointer-events: none;
    overflow: hidden;
}
</style>

<script>
// Sparkle animation
document.addEventListener('DOMContentLoaded', function() {
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
</script>
@endsection