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

        .product-detail-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
            margin-bottom: 3rem;
        }

        .product-image-container {
            background: rgba(30, 30, 46, 0.7);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            overflow: hidden;
            padding: 1.5rem;
            backdrop-filter: blur(10px);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 500px;
        }

        .product-image-container img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
            border-radius: 12px;
        }

        .product-info-container {
            background: rgba(30, 30, 46, 0.7);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            overflow: hidden;
            padding: 2rem;
            backdrop-filter: blur(10px);
            display: flex;
            flex-direction: column;
        }

        .product-title {
            color: var(--gold);
            font-weight: 700;
            font-size: 1.75rem;
            margin-bottom: 1rem;
            line-height: 1.4;
        }

        .product-description {
            color: rgba(255, 255, 255, 0.8);
            font-size: 1rem;
            line-height: 1.6;
            margin-bottom: 1.5rem;
            flex-grow: 1;
        }

        .product-price {
            margin-bottom: 1.5rem;
        }

        .price-original {
            text-decoration: line-through;
            color: #f8d7da;
            font-size: 1rem;
            margin-right: 0.5rem;
        }

        .badge-discount {
            background: linear-gradient(135deg, #dc3545, #c82333);
            color: white;
            font-size: 0.8rem;
            padding: 0.3rem 0.6rem;
            border-radius: 4px;
            margin-left: 0.5rem;
        }

        .current-price {
            font-size: 1.5rem;
            font-weight: 700;
        }

        .price-warning {
            color: var(--gold-light);
        }

        .price-primary {
            color: var(--gold);
        }

        .product-meta {
            margin-bottom: 1.5rem;
        }

        .meta-item {
            display: flex;
            align-items: center;
            margin-bottom: 0.75rem;
            color: rgba(255, 255, 255, 0.8);
        }

        .meta-item i {
            color: var(--gold);
            margin-right: 0.5rem;
            width: 20px;
        }

        .seller-info {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .seller-title {
            color: var(--gold);
            font-weight: 600;
            margin-bottom: 0.75rem;
            font-size: 1.1rem;
        }

        .seller-detail {
            color: rgba(255, 255, 255, 0.8);
            margin-bottom: 0.25rem;
        }

        .btn-add-cart {
            background: linear-gradient(135deg, var(--gold) 0%, var(--gold-light) 100%);
            border: none;
            color: var(--dark-blue);
            font-weight: 600;
            padding: 1rem;
            border-radius: 8px;
            transition: all 0.3s ease;
            width: 100%;
            font-size: 1rem;
            margin-top: auto;
        }

        .btn-add-cart:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(255, 215, 0, 0.4);
            background: linear-gradient(135deg, var(--gold-light) 0%, var(--gold) 100%);
        }

        .section-title {
            background: linear-gradient(135deg, var(--gold) 0%, var(--gold-light) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: 700;
            font-size: 1.75rem;
            margin-bottom: 1.5rem;
            padding-bottom: 0.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .reviews-container {
            background: rgba(30, 30, 46, 0.7);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            overflow: hidden;
            padding: 2rem;
            backdrop-filter: blur(10px);
            margin-bottom: 3rem;
        }

        .review-item {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            border: 1px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
        }

        .review-item:hover {
            background: rgba(255, 255, 255, 0.08);
            border-color: rgba(255, 215, 0, 0.3);
        }

        .review-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.75rem;
        }

        .reviewer-name {
            color: var(--gold);
            font-weight: 600;
        }

        .review-date {
            color: rgba(255, 255, 255, 0.6);
            font-size: 0.85rem;
        }

        .review-rating {
            margin-bottom: 0.75rem;
        }

        .review-star {
            color: var(--gold);
        }

        .review-text {
            color: rgba(255, 255, 255, 0.8);
            line-height: 1.5;
        }

        .rating-summary {
            display: flex;
            align-items: center;
            margin-bottom: 1.5rem;
            padding: 1rem;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 12px;
        }

        .rating-average {
            font-size: 2rem;
            font-weight: 700;
            color: var(--gold);
            margin-right: 1rem;
        }

        .rating-stars {
            margin-right: 1rem;
        }

        .rating-count {
            color: rgba(255, 255, 255, 0.7);
        }

        .related-products-container {
            margin-bottom: 3rem;
        }

        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 2rem;
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

        .product-title-small {
            color: var(--gold);
            font-weight: 600;
            font-size: 1.1rem;
            margin-bottom: 0.75rem;
            line-height: 1.4;
        }

        .product-description-small {
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.9rem;
            line-height: 1.5;
            margin-bottom: 1rem;
            flex-grow: 1;
        }

        .product-price-small {
            margin-bottom: 1.25rem;
        }

        .btn-view-details {
            background: linear-gradient(135deg, var(--gold) 0%, var(--gold-light) 100%);
            border: none;
            color: var(--dark-blue);
            font-weight: 600;
            padding: 0.75rem;
            border-radius: 8px;
            transition: all 0.3s ease;
            width: 100%;
            font-size: 0.9rem;
            text-decoration: none;
            text-align: center;
        }

        .btn-view-details:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(255, 215, 0, 0.4);
            background: linear-gradient(135deg, var(--gold-light) 0%, var(--gold) 100%);
            color: var(--dark-blue);
        }

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

        /* Responsive Design */
        @media (max-width: 1200px) {
            .product-detail-container {
                grid-template-columns: 1fr;
            }

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

            .product-image-container {
                height: 400px;
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

            .product-image-container {
                height: 300px;
                padding: 1rem;
            }

            .product-info-container {
                padding: 1.5rem;
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
        }
    </style>

    <div class="container">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-title">
                <i class="fas fa-box-open me-2"></i>Detail Produk
            </h1>
            <p class="page-subtitle">Informasi lengkap tentang produk pilihan Anda</p>
        </div>

        <!-- Product Detail Section -->
        <div class="product-detail-container">
            <!-- Product Image -->
            <div class="product-image-container">
                @if ($produk->gambar)
                    <img src="{{ asset('storage/' . $produk->gambar) }}" alt="{{ $produk->nama }}" loading="lazy">
                @else
                    <img src="{{ asset('images/default.jpg') }}" alt="Default Image" loading="lazy">
                @endif
            </div>

            <!-- Product Info -->
            <div class="product-info-container">
                <h2 class="product-title">{{ $produk->nama }}</h2>
                <p class="product-description">{{ $produk->deskripsi }}</p>

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

                <!-- Product Meta -->
                <div class="product-meta">
                    <div class="meta-item">
                        <i class="fas fa-box"></i>
                        <span>Stok tersedia: <strong>{{ $produk->stok }}</strong></span>
                    </div>
                    <div class="meta-item">
                        <i class="fas fa-star"></i>
                        <span>Rating:
                            @php
                                $roundedRating = round($produk->rating ?? 0);
                            @endphp
                            @for ($i = 1; $i <= 5; $i++)
                                @if ($i <= $roundedRating)
                                    <i class="review-star fas fa-star"></i>
                                @else
                                    <i class="text-secondary fas fa-star"></i>
                                @endif
                            @endfor
                            <strong>({{ number_format($produk->rating ?? 0, 1) }}/5)</strong>
                        </span>
                    </div>
                </div>

                <!-- Seller Info -->
                <div class="seller-info">
                    <h5 class="seller-title">Informasi Penjual</h5>
                    <p class="seller-detail"><i class="fas fa-store me-2"></i> {{ $produk->user->name ?? 'Penjual' }}</p>
                    <p class="seller-detail"><i class="fas fa-envelope me-2"></i> {{ $produk->user->email ?? '-' }}</p>
                </div>

                <!-- Add to Cart Form -->
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

        <!-- Reviews Section -->
        <div class="reviews-container">
            <h3 class="section-title">
                <i class="fas fa-comments me-2"></i>Ulasan Produk
            </h3>

            <!-- Rating Summary -->
            <div class="rating-summary">
                <div class="rating-average">{{ number_format($produk->rating ?? 0, 1) }}</div>
                <div class="rating-stars">
                    @php
                        $roundedRating = round($produk->rating ?? 0);
                        $jumlahUserUnik = $ulasan->groupBy('user_id')->count();
                    @endphp
                    @for ($i = 1; $i <= 5; $i++)
                        @if ($i <= $roundedRating)
                            <i class="review-star fas fa-star"></i>
                        @else
                            <i class="text-secondary fas fa-star"></i>
                        @endif
                    @endfor
                </div>
                <div class="rating-count">
                    {{ $jumlahUserUnik }} ulasan
                </div>
            </div>

            <!-- Reviews List -->
            @if($ulasan->isEmpty())
                <div class="empty-state">
                    <div class="empty-state-icon">
                        <i class="fas fa-comment-slash"></i>
                    </div>
                    <h5>Belum ada ulasan</h5>
                    <p>Jadilah yang pertama memberikan ulasan untuk produk ini.</p>
                </div>
            @else
                @foreach($ulasan as $review)
                    <div class="review-item">
                        <div class="review-header">
                            <span class="reviewer-name">{{ $review->user->name ?? 'Pengguna' }}</span>
                            <span class="review-date">{{ $review->created_at->format('d M Y') }}</span>
                        </div>
                        <div class="review-rating">
                            @for ($i = 1; $i <= 5; $i++)
                                @if ($i <= $review->rating)
                                    <i class="review-star fas fa-star"></i>
                                @else
                                    <i class="text-secondary fas fa-star"></i>
                                @endif
                            @endfor
                        </div>
                        <p class="review-text">{{ $review->ulasan }}</p>
                    </div>
                @endforeach
            @endif
        </div>

        <!-- Related Products Section -->
        <div class="related-products-container">
            <h3 class="section-title">
                <i class="fas fa-th-large me-2"></i>Produk Lain dari Toko Ini
            </h3>

            <div class="products-grid">
                @forelse ($produkTerkait as $item)
                    <div class="product-card">
                        <!-- Product Image -->
                        <div class="product-image">
                            @if ($item->gambar)
                                <img src="{{ asset('storage/' . $item->gambar) }}" alt="{{ $item->nama }}" loading="lazy">
                            @else
                                <img src="{{ asset('images/default.jpg') }}" alt="Default Image" loading="lazy">
                            @endif

                            <!-- Product Overlay -->
                            <div class="product-overlay">
                                <div class="overlay-content">
                                    <h5>Lihat Detail Produk</h5>
                                    <a href="{{ route('pembeli.produk.show', $item->id) }}" class="btn btn-sm">
                                        <i class="fas fa-eye me-1"></i>Detail
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Product Content -->
                        <div class="product-content">
                            <h5 class="product-title-small">{{ $item->nama }}</h5>
                            <p class="product-description-small">{{ Str::limit($item->deskripsi, 80) }}</p>

                            <!-- Product Price -->
                            <div class="product-price-small">
                                @if(isset($item->harga_setelah_diskon) && $item->harga_setelah_diskon < $item->harga)
                                    @php
                                        $diskon = 100 - round(($item->harga_setelah_diskon / $item->harga) * 100);
                                    @endphp
                                    <div class="d-flex align-items-center mb-1">
                                        <span class="price-original">
                                            Rp{{ number_format($item->harga, 0, ',', '.') }}
                                        </span>
                                        <span class="badge-discount">{{ $diskon }}% OFF</span>
                                    </div>
                                    <span class="current-price price-warning">
                                        Rp{{ number_format($item->harga_setelah_diskon, 0, ',', '.') }}
                                    </span>
                                @else
                                    <span class="current-price price-primary">
                                        Rp{{ number_format($item->harga, 0, ',', '.') }}
                                    </span>
                                @endif
                            </div>

                            <!-- Product Actions -->
                            <div class="product-actions">
                                <a href="{{ route('pembeli.produk.show', $item->id) }}" class="btn-view-details">
                                    <i class="fas fa-eye me-2"></i>Lihat Detail
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="empty-state">
                        <div class="empty-state-icon">
                            <i class="fas fa-search"></i>
                        </div>
                        <h5>Tidak ada produk lain</h5>
                        <p>Belum ada produk lain dari toko ini.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection