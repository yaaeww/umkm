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
            max-width: relative;
        }

        .page-header {
            margin-bottom: 2rem;
            text-align: center;
        }

        .page-title {
            background: linear-gradient(135deg, var(--gold) 0%, var(--gold-light) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: 700;
            font-size: 2.2rem;
            margin-bottom: 0.5rem;
        }

        .order-container {
            background: rgba(30, 30, 46, 0.7);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            overflow: hidden;
            padding: 2.5rem;
            backdrop-filter: blur(10px);
            margin-bottom: 2rem;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        }

        .order-summary {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 12px;
            padding: 2rem;
            margin-bottom: 2rem;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .summary-title {
            color: var(--gold);
            font-weight: 600;
            font-size: 1.3rem;
            margin-bottom: 1.5rem;
            padding-bottom: 0.75rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
        }

        .info-item {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .info-label {
            color: var(--gold);
            font-weight: 600;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .info-value {
            color: rgba(255, 255, 255, 0.9);
            font-size: 1rem;
        }

        .price-value {
            color: var(--gold-light);
            font-weight: 600;
            font-size: 1.1rem;
        }

        .badge {
            padding: 0.5rem 0.75rem;
            border-radius: 6px;
            font-weight: 600;
            font-size: 0.8rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .badge-info {
            background: linear-gradient(135deg, var(--info-color), #138496);
            color: white;
        }

        .products-section {
            margin-top: 2rem;
        }

        .section-title {
            background: linear-gradient(135deg, var(--gold) 0%, var(--gold-light) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: 600;
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
            padding-bottom: 0.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 1.5rem;
        }

        .product-card {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .product-card:hover {
            border-color: rgba(255, 215, 0, 0.3);
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
        }

        .product-image {
            height: 200px;
            overflow: hidden;
        }

        .product-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .product-card:hover .product-image img {
            transform: scale(1.05);
        }

        .product-content {
            padding: 1.5rem;
        }

        .product-name {
            color: var(--gold);
            font-weight: 600;
            font-size: 1.1rem;
            margin-bottom: 1rem;
            line-height: 1.4;
        }

        .product-details {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .product-detail {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.25rem 0;
        }

        .detail-label {
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.9rem;
        }

        .detail-value {
            color: rgba(255, 255, 255, 0.9);
            font-weight: 500;
        }

        .btn {
            border: none;
            border-radius: 8px;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            cursor: pointer;
            font-size: 0.9rem;
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

        .action-section {
            text-align: center;
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .container {
                padding-top: 70px;
            }

            .page-title {
                font-size: 1.8rem;
            }

            .order-container {
                padding: 2rem;
            }

            .order-summary {
                padding: 1.5rem;
            }

            .info-grid {
                grid-template-columns: 1fr;
            }

            .products-grid {
                grid-template-columns: 1fr;
            }

            .product-image {
                height: 180px;
            }
        }

        @media (max-width: 576px) {
            .container {
                padding-top: 60px;
            }

            .page-title {
                font-size: 1.6rem;
            }

            .order-container {
                padding: 1.5rem;
            }

            .order-summary {
                padding: 1rem;
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
                <i class="fas fa-receipt me-2"></i>Detail Pesanan
            </h1>
        </div>

        <div class="order-container">
            <!-- Order Summary -->
            <div class="order-summary">
                <h3 class="summary-title">
                    <i class="fas fa-info-circle"></i>Informasi Pesanan
                </h3>

                <div class="info-grid">
                    <div class="info-item">
                        <span class="info-label">
                            <i class="fas fa-barcode"></i>Kode Pesanan
                        </span>
                        <span class="info-value">{{ $pesanan->kode_pesanan }}</span>
                    </div>

                    <div class="info-item">
                        <span class="info-label">
                            <i class="fas fa-tag"></i>Status
                        </span>
                        <span class="badge badge-info">
                            <i class="fas fa-info-circle me-1"></i>
                            {{ ucfirst($pesanan->status) }}
                        </span>
                    </div>

                    <div class="info-item">
                        <span class="info-label">
                            <i class="fas fa-map-marker-alt"></i>Alamat Pengiriman
                        </span>
                        <span class="info-value">{{ $pesanan->alamat_pengiriman }}</span>
                    </div>

                    <div class="info-item">
                        <span class="info-label">
                            <i class="fas fa-credit-card"></i>Metode Pembayaran
                        </span>
                        <span class="info-value">{{ strtoupper($pesanan->metode_pembayaran) }}</span>
                    </div>

                    <div class="info-item">
                        <span class="info-label">
                            <i class="fas fa-money-bill-wave"></i>Total Harga
                        </span>
                        <span class="info-value price-value">Rp
                            {{ number_format($pesanan->total_harga, 0, ',', '.') }}</span>
                    </div>

                    <div class="info-item">
                        <span class="info-label">
                            <i class="fas fa-calendar"></i>Tanggal Pesan
                        </span>
                        <span class="info-value">{{ $pesanan->created_at->format('d M Y H:i') }}</span>
                    </div>
                </div>
            </div>

            <!-- Products Section -->
            <div class="products-section">
                <h3 class="section-title">
                    <i class="fas fa-boxes me-2"></i>Produk yang Dipesan
                </h3>

                @if($pesanan->pesananDetails && $pesanan->pesananDetails->count() > 0)
                    <div class="products-grid">
                        @foreach ($pesanan->pesananDetails as $detail)
                            <div class="product-card">
                                <div class="product-image">
                                    @if ($detail->produk && $detail->produk->gambar)
                                        <img src="{{ asset('storage/' . $detail->produk->gambar) }}" alt="{{ $detail->produk->nama }}">
                                    @else
                                        <img src="{{ asset('images/default.jpg') }}" alt="Default Image">
                                    @endif
                                </div>
                                <div class="product-content">
                                    <h4 class="product-name">{{ $detail->produk->nama ?? 'Produk Tidak Tersedia' }}</h4>
                                    <div class="product-details">
                                        <div class="product-detail">
                                            <span class="detail-label">Harga Satuan</span>
                                            <span class="detail-value">Rp {{ number_format($detail->harga, 0, ',', '.') }}</span>
                                        </div>
                                        <div class="product-detail">
                                            <span class="detail-label">Jumlah</span>
                                            <span class="detail-value">{{ $detail->jumlah }} item</span>
                                        </div>
                                        <div class="product-detail">
                                            <span class="detail-label">Subtotal</span>
                                            <span class="detail-value price-value">
                                                Rp {{ number_format($detail->harga * $detail->jumlah, 0, ',', '.') }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="empty-state">
                        <div class="empty-state-icon">
                            <i class="fas fa-box-open"></i>
                        </div>
                        <h5>Tidak ada produk dalam pesanan ini</h5>
                        <p>Detail produk tidak tersedia untuk pesanan ini.</p>
                    </div>
                @endif
            </div>

            <!-- Action Section -->
            <div class="action-section">
                <a href="{{ route('pembeli.pesanan.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Kembali ke Pesanan Saya
                </a>
            </div>
        </div>
    </div>
@endsection