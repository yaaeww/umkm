@extends('layouts.app')

@section('page_title', 'Daftar Produk')

@section('title')
    <i class="fas fa-boxes me-2"></i> Daftar Produk
@endsection

@section('content')
    <style>
        .products-container {
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

        .btn-primary {
            background: linear-gradient(135deg, var(--gold) 0%, var(--gold-light) 100%);
            border: none;
            color: var(--dark-blue);
            font-weight: 700;
            padding: 12px 25px;
            border-radius: 8px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(255, 215, 0, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(255, 215, 0, 0.5);
            color: var(--dark-blue);
        }

        .product-card {
            background: linear-gradient(135deg, rgba(26, 58, 95, 0.7) 0%, rgba(42, 74, 127, 0.8) 100%);
            border: 2px solid rgba(255, 215, 0, 0.2);
            border-radius: 12px;
            overflow: hidden;
            transition: all 0.3s ease;
            height: 100%;
            backdrop-filter: blur(10px);
        }

        .product-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 30px rgba(255, 215, 0, 0.25);
            border-color: var(--gold);
        }

        .product-image {
            height: 200px;
            object-fit: cover;
            width: 100%;
            transition: transform 0.3s ease;
        }

        .product-card:hover .product-image {
            transform: scale(1.05);
        }

        .product-card-body {
            padding: 20px;
            text-align: center;
        }

        .product-title {
            color: var(--gold);
            font-weight: 600;
            font-size: 1.1rem;
            margin-bottom: 10px;
            min-height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .product-price {
            margin-bottom: 15px;
        }

        .original-price {
            color: #c0c0c0;
            text-decoration: line-through;
            font-size: 0.9rem;
        }

        .discount-price {
            color: #ff6b6b;
            font-weight: 700;
            font-size: 1.2rem;
        }

        .normal-price {
            color: var(--gold-light);
            font-weight: 700;
            font-size: 1.2rem;
        }

        .product-actions {
            display: flex;
            gap: 8px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn-info {
            background: linear-gradient(135deg, #17a2b8, #20c997);
            border: none;
            color: white;
            font-weight: 600;
            padding: 8px 15px;
            border-radius: 6px;
            font-size: 0.85rem;
            transition: all 0.3s ease;
        }

        .btn-info:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(23, 162, 184, 0.4);
            color: white;
        }

        .btn-warning {
            background: linear-gradient(135deg, #ffc107, #fd7e14);
            border: none;
            color: white;
            font-weight: 600;
            padding: 8px 15px;
            border-radius: 6px;
            font-size: 0.85rem;
            transition: all 0.3s ease;
        }

        .btn-warning:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(255, 193, 7, 0.4);
            color: white;
        }

        .btn-danger {
            background: linear-gradient(135deg, #dc3545, #e83e8c);
            border: none;
            color: white;
            font-weight: 600;
            padding: 8px 15px;
            border-radius: 6px;
            font-size: 0.85rem;
            transition: all 0.3s ease;
        }

        .btn-danger:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(220, 53, 69, 0.4);
            color: white;
        }

        .alert-success {
            background: linear-gradient(135deg, rgba(40, 167, 69, 0.2) 0%, rgba(32, 201, 151, 0.3) 100%);
            border: 2px solid rgba(40, 167, 69, 0.5);
            border-radius: 12px;
            backdrop-filter: blur(10px);
            color: #e0e0e0;
            margin-bottom: 25px;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #c0c0c0;
        }

        .empty-state i {
            font-size: 4rem;
            color: rgba(255, 215, 0, 0.3);
            margin-bottom: 20px;
        }

        .empty-state h4 {
            color: var(--gold);
            margin-bottom: 15px;
        }

        .pagination-container {
            margin-top: 30px;
        }

        .pagination .page-link {
            background: rgba(26, 58, 95, 0.6);
            border: 1px solid rgba(255, 215, 0, 0.3);
            color: var(--gold);
            padding: 8px 16px;
        }

        .pagination .page-item.active .page-link {
            background: linear-gradient(135deg, var(--gold) 0%, var(--gold-light) 100%);
            border-color: var(--gold);
            color: var(--dark-blue);
            font-weight: 600;
        }

        .pagination .page-link:hover {
            background: rgba(255, 215, 0, 0.1);
            border-color: var(--gold);
            color: var(--gold-light);
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

        .badge-discount {
            position: absolute;
            top: 10px;
            right: 10px;
            background: linear-gradient(135deg, #dc3545, #e83e8c);
            color: white;
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 0.8rem;
            font-weight: 600;
            z-index: 2;
        }

        /* Mobile responsiveness */
        @media (max-width: 768px) {
            .products-container {
                padding: 20px 15px;
            }

            .product-actions {
                flex-direction: column;
                gap: 5px;
            }

            .btn-info,
            .btn-warning,
            .btn-danger {
                width: 100%;
                padding: 10px;
            }

            .product-title {
                min-height: auto;
                font-size: 1rem;
            }
        }
    </style>

    <div class="container">
        <h2 class="section-title"><i class="fas fa-boxes me-3"></i>Daftar Produk Saya</h2>

        <div class="products-container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <a href="{{ route('penjual.produk.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus-circle me-2"></i>Tambah Produk Baru
                </a>

                <div class="text-theme">
                    <small>Total: <strong>{{ $produks->total() }}</strong> produk</small>
                </div>
            </div>

            @if (session('success'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                </div>
            @endif

            <div class="row">
                @forelse($produks as $produk)
                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12 mb-4">
                        <div class="product-card">
                            <div class="position-relative">
                                @if ($produk->gambar)
                                    <img src="{{ asset('storage/' . $produk->gambar) }}" class="product-image" alt="Gambar Produk">
                                @else
                                    <div class="product-image d-flex align-items-center justify-content-center bg-dark">
                                        <i class="fas fa-image fa-3x text-gold" style="opacity: 0.5;"></i>
                                    </div>
                                @endif

                                {{-- Badge diskon jika ada --}}
                                @if ($produk->diskon && now()->between($produk->diskon->tanggal_mulai, $produk->diskon->tanggal_berakhir))
                                    <span class="badge-discount">
                                        <i class="fas fa-tag me-1"></i>{{ $produk->diskon->persen_diskon }}% OFF
                                    </span>
                                @endif
                            </div>

                            <div class="product-card-body">
                                <h5 class="product-title">{{ $produk->nama }}</h5>

                                <div class="product-price">
                                    {{-- Tampilkan harga diskon jika ada dan aktif --}}
                                    @if ($produk->diskon && now()->between($produk->diskon->tanggal_mulai, $produk->diskon->tanggal_berakhir))
                                        <div class="original-price mb-1">
                                            Rp {{ number_format($produk->harga, 0, ',', '.') }}
                                        </div>
                                        <div class="discount-price">
                                            Rp {{ number_format($produk->harga_setelah_diskon, 0, ',', '.') }}
                                        </div>
                                    @else
                                        <div class="normal-price">
                                            Rp {{ number_format($produk->harga, 0, ',', '.') }}
                                        </div>
                                    @endif
                                </div>

                                <div class="product-stats mb-3">
                                    <small class="text-theme">
                                        <i class="fas fa-box me-1"></i>Stok: {{ $produk->stok }} |
                                        <i class="fas fa-eye me-1"></i>Dilihat: {{ $produk->views ?? 0 }}
                                    </small>
                                </div>

                                <div class="product-actions">
                                    <a href="{{ route('penjual.produk.show', $produk->id) }}" class="btn btn-info">
                                        <i class="fas fa-eye me-1"></i>Detail
                                    </a>
                                    <a href="{{ route('penjual.produk.edit', $produk->id) }}" class="btn btn-warning">
                                        <i class="fas fa-edit me-1"></i>Edit
                                    </a>
                                    <form action="{{ route('penjual.produk.destroy', $produk->id) }}" method="POST"
                                        onsubmit="return confirm('Yakin mau hapus produk {{ $produk->nama }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">
                                            <i class="fas fa-trash me-1"></i>Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="empty-state">
                            <i class="fas fa-box-open"></i>
                            <h4>Belum Ada Produk</h4>
                            <p class="mb-4">Mulai jualan dengan menambahkan produk pertama Anda!</p>
                            <a href="{{ route('penjual.produk.create') }}" class="btn btn-primary btn-lg">
                                <i class="fas fa-plus-circle me-2"></i>Tambah Produk Pertama
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>

            @if($produks->hasPages())
                <div class="pagination-container">
                    <div class="d-flex justify-content-center">
                        {{ $produks->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>

    <script>
        // Konfirmasi sebelum menghapus produk
        document.addEventListener('DOMContentLoaded', function () {
            const deleteForms = document.querySelectorAll('form[action*="destroy"]');

            deleteForms.forEach(form => {
                form.addEventListener('submit', function (e) {
                    const productName = this.closest('.product-card').querySelector('.product-title').textContent;
                    if (!confirm(`Apakah Anda yakin ingin menghapus produk "${productName}"?`)) {
                        e.preventDefault();
                    }
                });
            });
        });
    </script>
@endsection