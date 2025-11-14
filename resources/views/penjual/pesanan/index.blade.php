@extends('layouts.app')

@section('page_title', 'Pesanan')

@section('title')
    <i class="fas fa-shopping-cart me-2"></i> Daftar Pesanan
@endsection

@section('content')
    <style>
        .orders-container {
            background: linear-gradient(135deg, rgba(10, 22, 40, 0.8) 0%, rgba(26, 58, 95, 0.9) 100%);
            border: 2px solid rgba(255, 215, 0, 0.3);
            border-radius: 15px;
            padding: 30px;
            backdrop-filter: blur(10px);
            margin-bottom: 30px;
        }

        .text-theme {
            color: #000000 !important;
        }

        .text-gold {
            color: var(--gold) !important;
        }

        .section-header {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--gold);
            margin: 30px 0 20px 0;
            padding-bottom: 10px;
            border-bottom: 2px solid rgba(255, 215, 0, 0.3);
        }

        .section-header:first-child {
            margin-top: 0;
        }

        .table-custom {
            background: rgba(26, 58, 95, 0.6);
            border: 2px solid rgba(255, 215, 0, 0.2);
            border-radius: 10px;
            overflow: hidden;
            backdrop-filter: blur(10px);
        }

        .table-custom thead {
            background: linear-gradient(135deg, rgba(255, 215, 0, 0.1) 0%, rgba(255, 237, 78, 0.05) 100%);
            border-bottom: 2px solid rgba(255, 215, 0, 0.3);
        }

        .table-custom th {
            color: var(--gold);
            font-weight: 600;
            padding: 15px 12px;
            border: none;
            font-size: 0.9rem;
        }

        .table-custom td {
            color: #000000;
            padding: 12px;
            border-bottom: 1px solid rgba(255, 215, 0, 0.1);
            vertical-align: middle;
        }

        .table-custom tbody tr {
            transition: all 0.3s ease;
        }

        .table-custom tbody tr:hover {
            background: rgba(255, 215, 0, 0.05);
            transform: translateX(5px);
        }

        .table-custom tbody tr:last-child td {
            border-bottom: none;
        }

        .badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.8rem;
        }

        .badge-success {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
        }

        .badge-info {
            background: linear-gradient(135deg, #17a2b8, #20c997);
            color: white;
        }

        .badge-warning {
            background: linear-gradient(135deg, #ffc107, #fd7e14);
            color: white;
        }

        .badge-danger {
            background: linear-gradient(135deg, #dc3545, #e83e8c);
            color: white;
        }

        .badge-secondary {
            background: linear-gradient(135deg, #6c757d, #868e96);
            color: white;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--gold) 0%, var(--gold-light) 100%);
            border: none;
            color: var(--dark-blue);
            font-weight: 600;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 0.85rem;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(255, 215, 0, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(255, 215, 0, 0.4);
            color: var(--dark-blue);
        }

        .btn-success {
            background: linear-gradient(135deg, #28a745, #20c997);
            border: none;
            color: white;
            font-weight: 600;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 0.85rem;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(40, 167, 69, 0.3);
        }

        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(40, 167, 69, 0.4);
            color: white;
        }

        .alert {
            background: linear-gradient(135deg, rgba(23, 162, 184, 0.2) 0%, rgba(32, 201, 151, 0.3) 100%);
            border: 2px solid rgba(23, 162, 184, 0.5);
            border-radius: 12px;
            backdrop-filter: blur(10px);
            color: #e0e0e0;
            padding: 20px;
            text-align: center;
        }

        .alert-warning {
            background: linear-gradient(135deg, rgba(255, 193, 7, 0.2) 0%, rgba(255, 215, 0, 0.3) 100%);
            border: 2px solid rgba(255, 193, 7, 0.5);
        }

        .alert-info {
            background: linear-gradient(135deg, rgba(23, 162, 184, 0.2) 0%, rgba(32, 201, 151, 0.3) 100%);
            border: 2px solid rgba(23, 162, 184, 0.5);
        }

        .empty-state {
            text-align: center;
            padding: 40px 20px;
            color: #c0c0c0;
        }

        .empty-state i {
            font-size: 3rem;
            color: rgba(255, 215, 0, 0.3);
            margin-bottom: 15px;
        }

        .empty-state h5 {
            color: var(--gold);
            margin-bottom: 10px;
        }

        .order-actions {
            display: flex;
            gap: 5px;
            flex-wrap: wrap;
        }

        .price-amount {
            font-weight: 600;
            color: #000000;
        }

        .customer-name {
            font-weight: 500;
            color: #000000;
        }

        .product-name {
            color: #000000;
            font-weight: 500;
        }

        .order-time {
            color: #000000;
            font-size: 0.85rem;
        }

        /* Mobile responsiveness */
        @media (max-width: 768px) {
            .orders-container {
                padding: 20px 15px;
            }

            .table-custom {
                font-size: 0.8rem;
            }

            .table-custom th,
            .table-custom td {
                padding: 8px 6px;
            }

            .order-actions {
                flex-direction: column;
                gap: 3px;
            }

            .btn-primary,
            .btn-success {
                padding: 5px 8px;
                font-size: 0.75rem;
                width: 100%;
            }

            .section-header {
                font-size: 1.3rem;
            }
        }

        @media (max-width: 576px) {
            .table-responsive {
                border: 1px solid rgba(255, 215, 0, 0.2);
                border-radius: 8px;
            }

            .table-custom th:nth-child(4),
            .table-custom td:nth-child(4),
            .table-custom th:nth-child(6),
            .table-custom td:nth-child(6),
            .table-custom th:nth-child(7),
            .table-custom td:nth-child(7) {
                display: none;
            }
        }

        .status-badges {
            display: flex;
            flex-direction: column;
            gap: 3px;
        }

        .main-title {
            font-size: 2.2rem;
            font-weight: 700;
            margin-bottom: 30px;
            background: linear-gradient(135deg, var(--gold) 0%, var(--gold-light) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-align: center;
        }
    </style>

    <div class="container">
        <h2 class="main-title"><i class="fas fa-shopping-cart me-3"></i>Daftar Pesanan</h2>

        <div class="orders-container">
            <!-- Pesanan Selesai -->
            <h4 class="section-header">
                <i class="fas fa-check-circle me-2"></i>Pesanan Selesai
            </h4>

            @if($pesananComplete->isEmpty())
                <div class="alert alert-info">
                    <div class="empty-state">
                        <i class="fas fa-check-circle"></i>
                        <h5>Belum Ada Pesanan Selesai</h5>
                        <p>Semua pesanan yang telah selesai akan muncul di sini.</p>
                    </div>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-custom">
                        <thead>
                            <tr>
                                <th>NO</th>
                                <th>PRODUK</th>
                                <th>PEMBELI</th>
                                <th>JUMLAH</th>
                                <th>TOTAL HARGA</th>
                                <th>STATUS BAYAR</th>
                                <th>STATUS PESANAN</th>
                                <th>PENERIMAAN</th>
                                <th>WAKTU</th>
                                <th>AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pesananComplete as $key => $order)
                                <tr>
                                    <td class="fw-bold">{{ $key + 1 }}</td>
                                    <td>
                                        <span class="product-name">{{ $order->produk->nama ?? '-' }}</span>
                                    </td>
                                    <td>
                                        <span class="customer-name">{{ $order->user->name ?? '-' }}</span>
                                    </td>
                                    <td>{{ $order->jumlah }}</td>
                                    <td>
                                        <span class="price-amount">Rp{{ number_format($order->total_harga, 0, ',', '.') }}</span>
                                    </td>
                                    <td>
                                        <span class="badge badge-success">{{ ucfirst($order->status) }}</span>
                                    </td>
                                    <td>
                                        <span
                                            class="badge badge-info">{{ ucfirst(str_replace('_', ' ', $order->status_pesanan)) }}</span>
                                    </td>
                                    <td>
                                        @if($order->status_pesanan === 'diterima')
                                            <span class="badge badge-success">Diterima</span>
                                        @elseif($order->status_pesanan === 'belum_diterima')
                                            <span class="badge badge-warning">Belum Diterima</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="order-time">{{ $order->created_at->format('d M Y H:i') }}</span>
                                    </td>
                                    <td>
                                        <div class="order-actions">
                                            <a href="{{ route('penjual.invoice.show', $order->id) }}" class="btn btn-primary">
                                                <i class="fas fa-eye me-1"></i>Detail
                                            </a>
                                            <a href="{{ route('penjual.pesanan.create', $order->id) }}" class="btn btn-success">
                                                <i class="fas fa-edit me-1"></i>Update
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

            <!-- Pesanan Dibatalkan -->
            <h4 class="section-header">
                <i class="fas fa-times-circle me-2"></i>Pesanan Dibatalkan
            </h4>

            @if($pesananCancel->isEmpty())
                <div class="alert alert-warning">
                    <div class="empty-state">
                        <i class="fas fa-ban"></i>
                        <h5>Tidak Ada Pesanan Dibatalkan</h5>
                        <p>Semua pesanan yang dibatalkan akan muncul di sini.</p>
                    </div>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-custom">
                        <thead>
                            <tr>
                                <th>NO</th>
                                <th>PRODUK</th>
                                <th>PEMBELI</th>
                                <th>JUMLAH</th>
                                <th>TOTAL HARGA</th>
                                <th>STATUS BAYAR</th>
                                <th>STATUS PESANAN</th>
                                <th>PENERIMAAN</th>
                                <th>WAKTU</th>
                                <th>AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pesananCancel as $key => $order)
                                <tr>
                                    <td class="fw-bold">{{ $key + 1 }}</td>
                                    <td>
                                        <span class="product-name">{{ $order->produk->nama ?? '-' }}</span>
                                    </td>
                                    <td>
                                        <span class="customer-name">{{ $order->user->name ?? '-' }}</span>
                                    </td>
                                    <td>{{ $order->jumlah }}</td>
                                    <td>
                                        <span class="price-amount">Rp{{ number_format($order->total_harga, 0, ',', '.') }}</span>
                                    </td>
                                    <td>
                                        <span class="badge badge-danger">{{ ucfirst($order->status) }}</span>
                                    </td>
                                    <td>
                                        <span
                                            class="badge badge-secondary">{{ ucfirst(str_replace('_', ' ', $order->status_pesanan)) }}</span>
                                    </td>
                                    <td>
                                        @if($order->status_pesanan === 'diterima')
                                            <span class="badge badge-success">Diterima</span>
                                        @elseif($order->status_pesanan === 'belum_diterima')
                                            <span class="badge badge-warning">Belum Diterima</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="order-time">{{ $order->created_at->format('d M Y H:i') }}</span>
                                    </td>
                                    <td>
                                        <span class="text-muted">-</span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    <script>
        // Tambahkan efek loading pada tombol aksi
        document.addEventListener('DOMContentLoaded', function () {
            const actionButtons = document.querySelectorAll('.btn-primary, .btn-success');

            actionButtons.forEach(button => {
                button.addEventListener('click', function () {
                    const originalText = this.innerHTML;
                    this.innerHTML = '<i class="fas fa-spinner fa-spin me-1"></i>Loading...';
                    this.disabled = true;

                    // Reset setelah 2 detik (untuk demo)
                    setTimeout(() => {
                        this.innerHTML = originalText;
                        this.disabled = false;
                    }, 2000);
                });
            });
        });
    </script>
@endsection