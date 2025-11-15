@extends('layouts.app')
@section('page_title', 'Edit Akun Penjual')

@section('title')
    <i class="fas fa-user-edit me-2"></i> Edit Akun Penjual
@endsection

@section('content')
<div class="container mt-5 pt-5">
    <!-- Hero Section -->
    <section class="hero mb-5">
        <div class="sparkle"></div>
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <div class="hero-content">
                        <h1>Edit Akun Penjual</h1>
                        <p class="mb-3">Perbarui informasi akun penjual UMKM Indramayu</p>
                        <div class="d-flex flex-wrap gap-3 align-items-center">
                            <span class="badge bg-gold text-dark fs-6 px-3 py-2">
                                <i class="fas fa-edit me-2"></i>Form Edit
                            </span>
                            <span class="text-gold"><i class="fas fa-user me-2"></i>{{ $penjual->name }}</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 text-center">
                    <div class="feature-icon">
                        <i class="fas fa-user-edit fa-6x text-gold"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Form Section -->
    <section class="container mb-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="form-card">
                    <div class="form-header">
                        <h3><i class="fas fa-user-cog me-2"></i>Form Edit Penjual</h3>
                        <p class="mb-0">Perbarui data akun penjual</p>
                    </div>
                    <div class="form-body">
                        <form action="{{ route('admin.penjual.update', $penjual->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <!-- Informasi Akun -->
                            <div class="form-section">
                                <h5 class="section-title">
                                    <i class="fas fa-user-circle me-2"></i>Informasi Akun
                                </h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name" class="form-label">
                                                <i class="fas fa-signature me-2"></i>Nama Lengkap
                                            </label>
                                            <input type="text" name="name" id="name" 
                                                   class="form-control custom-input" 
                                                   value="{{ old('name', $penjual->name) }}" 
                                                   placeholder="Masukkan nama lengkap" required>
                                            @error('name') 
                                                <div class="error-message">
                                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="email" class="form-label">
                                                <i class="fas fa-envelope me-2"></i>Alamat Email
                                            </label>
                                            <input type="email" name="email" id="email" 
                                                   class="form-control custom-input" 
                                                   value="{{ old('email', $penjual->email) }}" 
                                                   placeholder="Masukkan alamat email" required>
                                            @error('email') 
                                                <div class="error-message">
                                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Informasi UMKM (jika ada) -->
                            @if($penjual->umkm)
                            <div class="form-section">
                                <h5 class="section-title">
                                    <i class="fas fa-store me-2"></i>Informasi UMKM
                                </h5>
                                <div class="umkm-info-card">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="info-item">
                                                <label>Nama UMKM</label>
                                                <p class="info-value">{{ $penjual->umkm->nama_toko }}</p>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="info-item">
                                                <label>Status UMKM</label>
                                                <p class="info-value">
                                                    <span class="status-badge {{ $penjual->umkm->status == 'approved' ? 'active' : 'pending' }}">
                                                        {{ ucfirst($penjual->umkm->status) }}
                                                    </span>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-12">
                                            <div class="info-item">
                                                <label>Alamat UMKM</label>
                                                <p class="info-value">{{ $penjual->umkm->alamat }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif

                            <!-- Statistik -->
                            <div class="form-section">
                                <h5 class="section-title">
                                    <i class="fas fa-chart-bar me-2"></i>Statistik Penjual
                                </h5>
                                <div class="stats-grid">
                                    <div class="stat-item">
                                        <i class="fas fa-boxes stat-icon"></i>
                                        <div class="stat-info">
                                            <span class="stat-number">{{ $penjual->produk->count() }}</span>
                                            <span class="stat-label">Total Produk</span>
                                        </div>
                                    </div>
                                    <div class="stat-item">
                                        <i class="fas fa-store stat-icon"></i>
                                        <div class="stat-info">
                                            <span class="stat-number">{{ $penjual->umkm ? '1' : '0' }}</span>
                                            <span class="stat-label">UMKM Terdaftar</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="form-actions">
                                <button type="submit" class="btn btn-save">
                                    <i class="fas fa-save me-2"></i>Simpan Perubahan
                                </button>
                                <a href="{{ route('admin.penjual.index') }}" class="btn btn-cancel">
                                    <i class="fas fa-times me-2"></i>Batal
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
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

.feature-icon {
    padding: 2rem;
    border-radius: 50%;
    background: rgba(255, 215, 0, 0.1);
    border: 3px solid var(--gold);
    width: 200px;
    height: 200px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
}

/* Form Card */
.form-card {
    background: linear-gradient(135deg, rgba(26, 58, 95, 0.7) 0%, rgba(42, 74, 127, 0.8) 100%);
    border: 1px solid rgba(255, 215, 0, 0.2);
    border-radius: 15px;
    overflow: hidden;
    backdrop-filter: blur(10px);
    transition: all 0.3s ease;
}

.form-card:hover {
    border-color: var(--gold);
    box-shadow: 0 10px 30px rgba(255, 215, 0, 0.2);
}

.form-header {
    background: linear-gradient(135deg, rgba(255, 215, 0, 0.1) 0%, rgba(255, 237, 78, 0.05) 100%);
    padding: 2rem;
    border-bottom: 1px solid rgba(255, 215, 0, 0.2);
}

.form-header h3 {
    color: var(--gold);
    margin-bottom: 0.5rem;
    font-weight: 700;
}

.form-header p {
    color: #c0c0c0;
    margin: 0;
}

.form-body {
    padding: 2rem;
}

/* Form Sections */
.form-section {
    margin-bottom: 2.5rem;
    padding-bottom: 2rem;
    border-bottom: 1px solid rgba(255, 215, 0, 0.1);
}

.form-section:last-of-type {
    border-bottom: none;
    margin-bottom: 1rem;
}

.section-title {
    color: var(--gold);
    font-size: 1.2rem;
    font-weight: 600;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
}

/* Form Groups */
.form-group {
    margin-bottom: 1.5rem;
}

.form-label {
    color: var(--gold);
    font-weight: 600;
    margin-bottom: 0.5rem;
    display: flex;
    align-items: center;
}

.custom-input {
    background: rgba(10, 22, 40, 0.8);
    border: 1px solid rgba(255, 215, 0, 0.3);
    border-radius: 10px;
    color: #c0c0c0;
    padding: 0.75rem 1rem;
    transition: all 0.3s ease;
    width: 100%;
}

.custom-input:focus {
    background: rgba(10, 22, 40, 0.9);
    border-color: var(--gold);
    box-shadow: 0 0 0 0.2rem rgba(255, 215, 0, 0.25);
    color: #c0c0c0;
    outline: none;
}

.custom-input::placeholder {
    color: #6c757d;
}

/* Error Messages */
.error-message {
    color: #dc3545;
    font-size: 0.875rem;
    margin-top: 0.5rem;
    display: flex;
    align-items: center;
    font-weight: 500;
}

/* UMKM Info Card */
.umkm-info-card {
    background: rgba(10, 22, 40, 0.5);
    border: 1px solid rgba(255, 215, 0, 0.2);
    border-radius: 10px;
    padding: 1.5rem;
}

.info-item {
    margin-bottom: 1rem;
}

.info-item:last-child {
    margin-bottom: 0;
}

.info-item label {
    color: var(--gold);
    font-weight: 600;
    font-size: 0.9rem;
    margin-bottom: 0.25rem;
    display: block;
}

.info-value {
    color: #c0c0c0;
    margin: 0;
    font-size: 1rem;
}

/* Status Badges */
.status-badge {
    padding: 0.4rem 0.8rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
    display: inline-block;
}

.status-badge.active {
    background: rgba(40, 167, 69, 0.2);
    color: #28a745;
    border: 1px solid rgba(40, 167, 69, 0.3);
}

.status-badge.pending {
    background: rgba(255, 193, 7, 0.2);
    color: #ffc107;
    border: 1px solid rgba(255, 193, 7, 0.3);
}

/* Stats Grid */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 1rem;
}

.stat-item {
    background: rgba(10, 22, 40, 0.5);
    border: 1px solid rgba(255, 215, 0, 0.2);
    border-radius: 10px;
    padding: 1.5rem;
    text-align: center;
    transition: all 0.3s ease;
}

.stat-item:hover {
    border-color: var(--gold);
    transform: translateY(-5px);
}

.stat-icon {
    font-size: 2rem;
    color: var(--gold);
    margin-bottom: 0.5rem;
}

.stat-number {
    display: block;
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--gold);
    margin-bottom: 0.25rem;
}

.stat-label {
    color: #c0c0c0;
    font-size: 0.9rem;
}

/* Form Actions */
.form-actions {
    display: flex;
    gap: 1rem;
    justify-content: flex-end;
    margin-top: 2rem;
    padding-top: 2rem;
    border-top: 1px solid rgba(255, 215, 0, 0.1);
}

.btn-save {
    background: linear-gradient(135deg, var(--gold) 0%, var(--gold-light) 100%);
    color: var(--dark-blue);
    border: none;
    padding: 0.75rem 2rem;
    font-weight: 600;
    border-radius: 10px;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
}

.btn-save:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(255, 215, 0, 0.4);
    color: var(--dark-blue);
}

.btn-cancel {
    background: transparent;
    color: var(--gold);
    border: 2px solid var(--gold);
    padding: 0.75rem 2rem;
    font-weight: 600;
    border-radius: 10px;
    transition: all 0.3s ease;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
}

.btn-cancel:hover {
    background: rgba(255, 215, 0, 0.1);
    transform: translateY(-3px);
    color: var(--gold);
}

/* Badges */
.badge {
    font-weight: 600;
    padding: 0.5rem 1rem;
    border-radius: 50px;
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
    
    .feature-icon {
        width: 150px;
        height: 150px;
    }
    
    .feature-icon i {
        font-size: 4rem !important;
    }
    
    .form-header {
        padding: 1.5rem;
    }
    
    .form-body {
        padding: 1.5rem;
    }
    
    .form-actions {
        flex-direction: column;
        gap: 0.75rem;
    }
    
    .btn-save,
    .btn-cancel {
        width: 100%;
        justify-content: center;
    }
    
    .stats-grid {
        grid-template-columns: 1fr;
    }
}

/* Animation for sparkle */
@keyframes sparkleFloat {
    0%, 100% {
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