@extends('layouts.pembeli-navbar')

@section('content')
    <style>
        :root {
            --dark-blue: #0a1628;
            --medium-blue: #1a3a5f;
            --light-blue: #2a4a7f;
            --gold: #ffd700;
            --gold-light: #ffed4e;
            --gold-dark: #d4af37;
        }

        .container {
            padding-top: 5px;
            max-width: relative;
        }

        .page-header {
            margin-bottom: 3rem;
            text-align: center;
        }

        .page-title {
            background: linear-gradient(135deg, var(--gold) 0%, var(--gold-light) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: 700;
            font-size: 2.5rem;
            margin-bottom: 0.5rem;
        }

        .page-subtitle {
            color: rgba(255, 255, 255, 0.8);
            font-size: 1.1rem;
            margin-bottom: 0;
        }

        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 2rem;
            margin-bottom: 3rem;
        }

        .product-card {
            background: rgba(30, 30, 46, 0.7);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            overflow: hidden;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
            position: relative;
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 30px rgba(255, 215, 0, 0.25);
            border-color: var(--gold);
        }

        .product-image {
            height: 220px;
            overflow: hidden;
            position: relative;
        }

        .product-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.4s ease;
        }

        .product-card:hover .product-image img {
            transform: scale(1.08);
        }

        .product-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(255, 215, 0, 0.9), rgba(255, 237, 78, 0.9));
            opacity: 0;
            transition: opacity 0.3s ease;
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 2;
        }

        .product-card:hover .product-overlay {
            opacity: 1;
        }

        .overlay-content {
            text-align: center;
            color: var(--dark-blue);
        }

        .overlay-content h5 {
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .overlay-content .btn {
            background: var(--dark-blue);
            color: var(--gold);
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 6px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .overlay-content .btn:hover {
            background: var(--medium-blue);
            transform: translateY(-2px);
        }

        .product-content {
            padding: 1.5rem;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .product-title {
            color: var(--gold);
            font-weight: 600;
            font-size: 1.1rem;
            margin-bottom: 0.75rem;
            line-height: 1.4;
        }

        .product-description {
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.9rem;
            line-height: 1.5;
            margin-bottom: 1rem;
            flex-grow: 1;
        }

        .product-price {
            margin-bottom: 1.25rem;
        }

        .price-original {
            text-decoration: line-through;
            color: #f8d7da;
            font-size: 0.85rem;
            margin-right: 0.5rem;
        }

        .badge-discount {
            background: linear-gradient(135deg, #dc3545, #c82333);
            color: white;
            font-size: 0.7rem;
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
            margin-left: 0.5rem;
        }

        .current-price {
            font-size: 1.1rem;
            font-weight: 700;
        }

        .price-warning {
            color: var(--gold-light);
        }

        .price-primary {
            color: var(--gold);
        }

        .product-actions {
            margin-top: auto;
        }

        .btn-add-cart {
            background: linear-gradient(135deg, var(--gold) 0%, var(--gold-light) 100%);
            border: none;
            color: var(--dark-blue);
            font-weight: 600;
            padding: 0.75rem;
            border-radius: 8px;
            transition: all 0.3s ease;
            width: 100%;
            font-size: 0.9rem;
        }

        .btn-add-cart:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(255, 215, 0, 0.4);
            background: linear-gradient(135deg, var(--gold-light) 0%, var(--gold) 100%);
        }

        /* Empty State */
        .empty-state {
            text-align: center;
            padding: 3rem 2rem;
            background: rgba(30, 30, 46, 0.5);
            border-radius: 16px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            grid-column: 1 / -1;
        }

        .empty-state-icon {
            font-size: 3rem;
            color: var(--gold);
            margin-bottom: 1rem;
        }

        .empty-state h5 {
            color: var(--gold);
            margin-bottom: 0.5rem;
        }

        .empty-state p {
            color: rgba(255, 255, 255, 0.7);
            margin-bottom: 0;
        }

        /* Pagination - Professional Style */
        .pagination-container {
            display: flex;
            justify-content: center;
            margin-top: 3rem;
        }

        .custom-pagination {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .page-item {
            margin: 0;
        }

        .page-link {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: rgba(255, 255, 255, 0.7);
            padding: 0.5rem 0.75rem;
            border-radius: 8px;
            transition: all 0.3s ease;
            font-size: 0.85rem;
            min-width: 2.5rem;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            cursor: pointer;
        }

        .page-link:hover {
            background: rgba(255, 215, 0, 0.1);
            border-color: var(--gold);
            color: var(--gold);
            transform: translateY(-1px);
        }

        .page-item.active .page-link {
            background: linear-gradient(135deg, var(--gold) 0%, var(--gold-light) 100%);
            border-color: var(--gold);
            color: var(--dark-blue);
            font-weight: 600;
        }

        .page-item.disabled .page-link {
            background: rgba(255, 255, 255, 0.02);
            border-color: rgba(255, 255, 255, 0.05);
            color: rgba(255, 255, 255, 0.3);
            cursor: not-allowed;
            transform: none;
        }

        .pagination-info {
            text-align: center;
            margin-top: 1rem;
            color: rgba(255, 255, 255, 0.6);
            font-size: 0.85rem;
        }

        /* Responsive Design */
        @media (max-width: 1200px) {
            .products-grid {
                grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
                gap: 1.5rem;
            }
        }

        @media (max-width: 768px) {
            .container {
                padding-top: 70px;
            }

            .page-title {
                font-size: 2rem;
            }

            .products-grid {
                grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
                gap: 1.25rem;
            }

            .product-image {
                height: 200px;
            }

            .product-content {
                padding: 1.25rem;
            }

            .custom-pagination {
                flex-wrap: wrap;
                justify-content: center;
            }
        }

        @media (max-width: 576px) {
            .container {
                padding-top: 60px;
            }

            .page-title {
                font-size: 1.75rem;
            }

            .page-subtitle {
                font-size: 1rem;
            }

            .products-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            .product-image {
                height: 180px;
            }

            .product-content {
                padding: 1rem;
            }

            .page-link {
                padding: 0.4rem 0.6rem;
                min-width: 2.2rem;
                font-size: 0.8rem;
            }
        }
    </style>

    <div class="container">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-title">
                <i class="fas fa-boxes me-2"></i>Semua Produk
            </h1>
            <p class="page-subtitle">Temukan produk terbaik dari UMKM Indramayu</p>
        </div>

        <!-- Products Grid -->
        <div class="products-grid">
            @forelse ($produks as $produk)
                <div class="product-card">
                    <!-- Product Image -->
                    <div class="product-image">
                        @if ($produk->gambar)
                            <img src="{{ asset('storage/' . $produk->gambar) }}" alt="{{ $produk->nama }}" loading="lazy">
                        @else
                            <img src="{{ asset('images/default.jpg') }}" alt="Default Image" loading="lazy">
                        @endif

                        <!-- Product Overlay -->
                        <div class="product-overlay">
                            <div class="overlay-content">
                                <h5>Lihat Detail Produk</h5>
                                <a href="{{ route('pembeli.produk.show', $produk->id) }}" class="btn btn-sm">
                                    <i class="fas fa-eye me-1"></i>Detail
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Product Content -->
                    <div class="product-content">
                        <h5 class="product-title">{{ $produk->nama }}</h5>
                        <p class="product-description">{{ Str::limit($produk->deskripsi, 80) }}</p>

                        <!-- Product Price -->
                        <div class="product-price">
                            @if(isset($produk->harga_setelah_diskon) && $produk->harga_setelah_diskon < $produk->harga)
                                @php
                                    $diskon = 100 - round(($produk->harga_setelah_diskon / $produk->harga) * 100);
                                @endphp
                                <div class="d-flex align-items-center mb-1">
                                    <span class="price-original">
                                        Rp{{ number_format($produk->harga, 0, ',', '.') }}
                                    </span>
                                    <span class="badge-discount">{{ $diskon }}% OFF</span>
                                </div>
                                <span class="current-price price-warning">
                                    Rp{{ number_format($produk->harga_setelah_diskon, 0, ',', '.') }}
                                </span>
                            @else
                                <span class="current-price price-primary">
                                    Rp{{ number_format($produk->harga, 0, ',', '.') }}
                                </span>
                            @endif
                        </div>

                        <!-- Product Actions -->
                        <div class="product-actions">
                            <form action="{{ route('pembeli.keranjang.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="produk_id" value="{{ $produk->id }}">
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="btn-add-cart">
                                    <i class="fas fa-cart-plus me-2"></i>Tambah ke Keranjang
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="empty-state">
                    <div class="empty-state-icon">
                        <i class="fas fa-search"></i>
                    </div>
                    <h5>Tidak ada produk ditemukan</h5>
                    <p>Silakan coba dengan kata kunci lain atau lihat kategori yang berbeda.</p>
                </div>
            @endforelse
        </div>

        <!-- Custom Pagination -->
        @if($produks->hasPages())
            <div class="pagination-container">
                <nav aria-label="Page navigation">
                    <ul class="custom-pagination">
                        {{-- Previous Page Link --}}
                        @if ($produks->onFirstPage())
                            <li class="page-item disabled">
                                <span class="page-link">
                                    <i class="fas fa-chevron-left"></i>
                                </span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $produks->previousPageUrl() }}" rel="prev">
                                    <i class="fas fa-chevron-left"></i>
                                </a>
                            </li>
                        @endif

                        {{-- Pagination Elements --}}
                        @php
                            $current = $produks->currentPage();
                            $last = $produks->lastPage();
                            $start = max(1, $current - 2);
                            $end = min($last, $current + 2);
                        @endphp

                        {{-- First Page Link --}}
                        @if ($start > 1)
                            <li class="page-item">
                                <a class="page-link" href="{{ $produks->url(1) }}">1</a>
                            </li>
                            @if ($start > 2)
                                <li class="page-item disabled">
                                    <span class="page-link">...</span>
                                </li>
                            @endif
                        @endif

                        {{-- Page Number Links --}}
                        @for ($i = $start; $i <= $end; $i++)
                            <li class="page-item {{ $i == $current ? 'active' : '' }}">
                                <a class="page-link" href="{{ $produks->url($i) }}">{{ $i }}</a>
                            </li>
                        @endfor

                        {{-- Last Page Link --}}
                        @if ($end < $last)
                            @if ($end < $last - 1)
                                <li class="page-item disabled">
                                    <span class="page-link">...</span>
                                </li>
                            @endif
                            <li class="page-item">
                                <a class="page-link" href="{{ $produks->url($last) }}">{{ $last }}</a>
                            </li>
                        @endif

                        {{-- Next Page Link --}}
                        @if ($produks->hasMorePages())
                            <li class="page-item">
                                <a class="page-link" href="{{ $produks->nextPageUrl() }}" rel="next">
                                    <i class="fas fa-chevron-right"></i>
                                </a>
                            </li>
                        @else
                            <li class="page-item disabled">
                                <span class="page-link">
                                    <i class="fas fa-chevron-right"></i>
                                </span>
                            </li>
                        @endif
                    </ul>
                </nav>
            </div>

            <!-- Pagination Info -->
            <div class="pagination-info">
                Menampilkan {{ $produks->firstItem() ?? 0 }} - {{ $produks->lastItem() ?? 0 }} dari {{ $produks->total() }}
                produk
            </div>
        @endif
    </div>
@endsection