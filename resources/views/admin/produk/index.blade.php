@extends('layouts.app')
@section('page_title', 'Daftar Produk UMKM')

@section('title')
    <i class="fas fa-tags me-2"></i> Daftar Produk UMKM
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
                            <h1>Daftar Produk UMKM</h1>
                            <p class="mb-3">Kelola semua produk UMKM Indramayu dalam satu platform terpadu</p>
                            <div class="d-flex flex-wrap gap-3 align-items-center">
                                <span class="badge bg-gold text-dark fs-6 px-3 py-2">
                                    <i class="fas fa-boxes me-2"></i>{{ $produks->count() }} Total Produk
                                </span>
                                <span class="text-gold"><i class="fas fa-store me-2"></i>UMKM Indramayu</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 text-center">
                        <div class="feature-icon">
                            <i class="fas fa-tags fa-6x text-gold"></i>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Notifikasi -->
        @if(session('success'))
            <div class="alert-custom success mb-4">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert-custom error mb-4">
                <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            </div>
        @endif

        <!-- Daftar Produk -->
        <section id="daftar-produk" class="container mb-5">
            

            @if($produks->count() > 0)
                <div class="table-container">
                    <table class="custom-table">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th>Produk</th>
                                <th>Harga</th>
                                <th>Gambar</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($produks as $index => $produk)
                                <tr>
                                    <td class="text-center">{{ $index + 1 }}</td>
                                    <td>
                                        <div class="product-info">
                                            <h5 class="product-name">{{ $produk->nama }}</h5>
                                            @if($produk->umkm)
                                                <span class="store-name">{{ $produk->umkm->nama_toko }}</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="price-cell">
                                        <span class="price">Rp{{ number_format($produk->harga, 0, ',', '.') }}</span>
                                    </td>
                                    <td>
                                        <div class="product-image">
                                            @if($produk->gambar)
                                                <img src="{{ asset('storage/' . $produk->gambar) }}" alt="{{ $produk->nama }}"
                                                    class="img-thumbnail">
                                            @else
                                                <div class="no-image-small">
                                                    <i class="fas fa-image text-gold"></i>
                                                </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="text-center">
                                        <div class="action-buttons">
                                            <form action="{{ route('admin.produk.destroy', $produk->id) }}" method="POST"
                                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-delete-table">
                                                    <i class="fas fa-trash me-1"></i>Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="empty-state text-center py-5">
                    <i class="fas fa-box-open fa-5x text-gold mb-3 opacity-50"></i>
                    <h3 class="text-gold mb-3">Belum Ada Produk</h3>
                    <p class="text-muted mb-4">Belum ada produk yang ditambahkan.</p>
                    {{-- <a href="{{ route('admin.produk.create') }}" class="btn btn-add-product">
                    <i class="fas fa-plus me-2"></i>Tambah Produk Pertama
                    </a> --}}
                </div>
            @endif
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

        /* Custom Alerts */
        .alert-custom {
            padding: 1rem 1.5rem;
            border-radius: 10px;
            font-weight: 500;
            display: flex;
            align-items: center;
            border: 1px solid transparent;
        }

        .alert-custom.success {
            background: linear-gradient(135deg, rgba(40, 167, 69, 0.2) 0%, rgba(40, 167, 69, 0.1) 100%);
            border-color: rgba(40, 167, 69, 0.3);
            color: #28a745;
        }

        .alert-custom.error {
            background: linear-gradient(135deg, rgba(220, 53, 69, 0.2) 0%, rgba(220, 53, 69, 0.1) 100%);
            border-color: rgba(220, 53, 69, 0.3);
            color: #dc3545;
        }

        /* Custom Table */
        .table-container {
            background: linear-gradient(135deg, rgba(26, 58, 95, 0.7) 0%, rgba(42, 74, 127, 0.8) 100%);
            border: 1px solid rgba(255, 215, 0, 0.2);
            border-radius: 15px;
            overflow: hidden;
            backdrop-filter: blur(10px);
            padding: 1rem;
        }

        .custom-table {
            width: 100%;
            border-collapse: collapse;
            color: #c0c0c0;
        }

        .custom-table thead {
            background: linear-gradient(135deg, rgba(255, 215, 0, 0.1) 0%, rgba(255, 237, 78, 0.05) 100%);
            border-bottom: 2px solid rgba(255, 215, 0, 0.3);
        }

        .custom-table th {
            padding: 1.2rem 1rem;
            font-weight: 600;
            color: var(--gold);
            text-align: left;
            font-size: 1rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .custom-table td {
            padding: 1.2rem 1rem;
            border-bottom: 1px solid rgba(255, 215, 0, 0.1);
            vertical-align: middle;
        }

        .custom-table tbody tr {
            transition: all 0.3s ease;
            background: transparent;
        }

        .custom-table tbody tr:hover {
            background: rgba(255, 215, 0, 0.05);
            transform: translateX(5px);
        }

        /* Product Info */
        .product-info h5 {
            color: var(--gold);
            margin-bottom: 0.5rem;
            font-weight: 600;
        }

        .store-name {
            color: #c0c0c0;
            font-size: 0.9rem;
            background: rgba(255, 215, 0, 0.1);
            padding: 0.25rem 0.75rem;
            border-radius: 12px;
            display: inline-block;
        }

        /* Price Cell */
        .price-cell {
            font-weight: 700;
        }

        .price {
            color: var(--gold-light);
            font-size: 1.1rem;
            font-weight: 700;
        }

        /* Product Image */
        .product-image {
            display: flex;
            justify-content: center;
        }

        .img-thumbnail {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 10px;
            border: 2px solid rgba(255, 215, 0, 0.3);
            transition: all 0.3s ease;
        }

        .img-thumbnail:hover {
            transform: scale(1.1);
            border-color: var(--gold);
        }

        .no-image-small {
            width: 80px;
            height: 80px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(255, 215, 0, 0.1);
            border-radius: 10px;
            border: 2px dashed rgba(255, 215, 0, 0.3);
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            justify-content: center;
            gap: 0.5rem;
        }

        .btn-delete-table {
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
            border: none;
            color: white;
            font-weight: 600;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            transition: all 0.3s ease;
            cursor: pointer;
            font-size: 0.9rem;
        }

        .btn-delete-table:hover {
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

            .section-title {
                font-size: 2rem;
            }

            .table-container {
                padding: 0.5rem;
                overflow-x: auto;
            }

            .custom-table {
                min-width: 600px;
            }

            .custom-table th,
            .custom-table td {
                padding: 0.8rem 0.5rem;
                font-size: 0.9rem;
            }

            .product-info h5 {
                font-size: 0.9rem;
            }

            .store-name {
                font-size: 0.8rem;
            }

            .price {
                font-size: 1rem;
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
    </script>
@endsection