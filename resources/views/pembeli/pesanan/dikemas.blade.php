@extends('layouts.pembeli-navbar')

@section('title', 'Pesanan Dikemas')

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

        .orders-container {
            background: rgba(30, 30, 46, 0.7);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            overflow: hidden;
            padding: 2rem;
            backdrop-filter: blur(10px);
            margin-bottom: 2rem;
        }

        .order-card {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            transition: all 0.3s ease;
            border-left: 4px solid var(--info-color);
        }

        .order-card:hover {
            background: rgba(255, 255, 255, 0.08);
            border-color: rgba(255, 215, 0, 0.3);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
        }

        .order-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 1rem;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .order-title {
            color: var(--gold);
            font-weight: 600;
            font-size: 1.2rem;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 0.5rem;
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

        .order-details {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .detail-item {
            display: flex;
            flex-direction: column;
            gap: 0.25rem;
        }

        .detail-label {
            color: var(--gold);
            font-weight: 600;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .detail-value {
            color: rgba(255, 255, 255, 0.9);
            font-size: 1rem;
        }

        .price-value {
            color: var(--gold-light);
            font-weight: 600;
            font-size: 1.1rem;
        }

        .empty-state {
            text-align: center;
            padding: 3rem 2rem;
            background: rgba(30, 30, 46, 0.5);
            border-radius: 16px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
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

        .btn-primary {
            background: linear-gradient(135deg, var(--gold) 0%, var(--gold-light) 100%);
            color: var(--dark-blue);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(255, 215, 0, 0.4);
            background: linear-gradient(135deg, var(--gold-light) 0%, var(--gold) 100%);
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

            .orders-container {
                padding: 1.5rem;
            }

            .order-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .order-details {
                grid-template-columns: 1fr;
            }

            .order-card {
                padding: 1.25rem;
            }
        }

        @media (max-width: 576px) {
            .container {
                padding-top: 60px;
            }

            .page-title {
                font-size: 1.6rem;
            }

            .orders-container {
                padding: 1rem;
            }

            .order-card {
                padding: 1rem;
            }

            .btn {
                width: 100%;
                justify-content: center;
            }
        }
    </style>

    <div class="container">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-title">
                <i class="fas fa-cube me-2"></i>Pesanan Sedang Dikemas
            </h1>
            <p class="page-subtitle">Pesanan Anda sedang dipersiapkan oleh penjual</p>
        </div>

        <div class="orders-container">
            @if($orders->count() > 0)
                @foreach($orders as $order)
                    <div class="order-card">
                        <div class="order-header">
                            <h3 class="order-title">
                                <i class="fas fa-receipt"></i>
                                Invoice: {{ $order->invoice ?? 'INV-' . $order->id }}
                            </h3>
                            <span class="badge badge-info">
                                <i class="fas fa-box me-1"></i>
                                {{ ucfirst($order->status_pesanan ?? '-') }}
                            </span>
                        </div>

                        <div class="order-details">
                            <div class="detail-item">
                                <span class="detail-label">
                                    <i class="fas fa-cube"></i>Produk
                                </span>
                                <span class="detail-value">{{ $order->produk->nama ?? 'Tidak tersedia' }}</span>
                            </div>

                            <div class="detail-item">
                                <span class="detail-label">
                                    <i class="fas fa-shopping-cart"></i>Jumlah
                                </span>
                                <span class="detail-value">{{ $order->jumlah ?? 0 }} item</span>
                            </div>

                            <div class="detail-item">
                                <span class="detail-label">
                                    <i class="fas fa-money-bill-wave"></i>Total Harga
                                </span>
                                <span class="detail-value price-value">
                                    Rp{{ number_format($order->total_harga ?? 0, 0, ',', '.') }}
                                </span>
                            </div>

                            <div class="detail-item">
                                <span class="detail-label">
                                    <i class="fas fa-calendar"></i>Tanggal Pesanan
                                </span>
                                <span class="detail-value">
                                    {{ $order->created_at ? $order->created_at->format('d-m-Y H:i') : '-' }}
                                </span>
                            </div>
                        </div>

                        <div class="progress-info">
                            <div class="detail-label mb-2">
                                <i class="fas fa-tasks"></i>Status Pengemasan
                            </div>
                            <div class="progress" style="height: 8px; background: rgba(255,255,255,0.1); border-radius: 4px;">
                                <div class="progress-bar bg-info" role="progressbar" style="width: 75%; border-radius: 4px;" 
                                     aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <small class="text-muted mt-1 d-block">Pesanan sedang dikemas dan akan segera dikirim</small>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="empty-state">
                    <div class="empty-state-icon">
                        <i class="fas fa-box-open"></i>
                    </div>
                    <h5>Belum ada pesanan yang sedang dikemas</h5>
                    <p>Semua pesanan Anda telah diproses atau belum ada pesanan yang masuk tahap pengemasan.</p>
                </div>
            @endif

            <div class="action-section">
                <a href="{{ route('pembeli.pesanan.index') }}" class="btn btn-primary">
                    <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar Pesanan
                </a>
            </div>
        </div>
    </div>
@endsection