@extends('layouts.app')
@section('page_title', 'Invoice')

@section('title')
    <i class="fas fa-file-invoice me-2"></i> Detail Pesanan
@endsection

@section('content')
@php
    use Illuminate\Support\Number;
@endphp

<style>
    .invoice-container {
        background: linear-gradient(135deg, rgba(10, 22, 40, 0.8) 0%, rgba(26, 58, 95, 0.9) 100%);
        border: 2px solid rgba(255, 215, 0, 0.3);
        border-radius: 15px;
        padding: 30px;
        backdrop-filter: blur(10px);
        margin-bottom: 30px;
    }

    .invoice-card {
        background: linear-gradient(135deg, rgba(26, 58, 95, 0.7) 0%, rgba(42, 74, 127, 0.8) 100%);
        border: 2px solid rgba(255, 215, 0, 0.2);
        border-radius: 12px;
        padding: 30px;
        backdrop-filter: blur(10px);
    }

    .text-theme {
        color: #e0e0e0 !important;
    }

    .text-gold {
        color: var(--gold) !important;
    }

    .invoice-header {
        text-align: center;
        margin-bottom: 30px;
        padding-bottom: 20px;
        border-bottom: 2px solid rgba(255, 215, 0, 0.3);
    }

    .invoice-title {
        font-size: 2.5rem;
        font-weight: 700;
        background: linear-gradient(135deg, var(--gold) 0%, var(--gold-light) 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 10px;
    }

    .invoice-subtitle {
        color: #c0c0c0;
        font-size: 1.1rem;
    }

    .info-section {
        background: rgba(10, 22, 40, 0.6);
        border: 1px solid rgba(255, 215, 0, 0.2);
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 25px;
    }

    .info-title {
        font-size: 1.2rem;
        font-weight: 600;
        color: var(--gold);
        margin-bottom: 15px;
        border-bottom: 1px solid rgba(255, 215, 0, 0.2);
        padding-bottom: 8px;
    }

    .info-item {
        display: flex;
        justify-content: space-between;
        margin-bottom: 8px;
        padding: 5px 0;
    }

    .info-label {
        color: var(--gold);
        font-weight: 500;
        min-width: 150px;
    }

    .info-value {
        color: #e0e0e0;
        text-align: right;
        flex: 1;
    }

    .table-custom {
        background: rgba(26, 58, 95, 0.6);
        border: 2px solid rgba(255, 215, 0, 0.2);
        border-radius: 8px;
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
        font-size: 1rem;
    }

    .table-custom td {
        color: #000000;
        padding: 12px;
        border-bottom: 1px solid rgba(255, 215, 0, 0.1);
        vertical-align: middle;
    }

    .table-custom tbody tr:last-child td {
        border-bottom: none;
    }

    .total-section {
        background: linear-gradient(135deg, rgba(255, 215, 0, 0.1) 0%, rgba(255, 237, 78, 0.05) 100%);
        border: 2px solid rgba(255, 215, 0, 0.2);
        border-radius: 8px;
        padding: 20px;
        margin-top: 20px;
    }

    .total-amount {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--gold-light);
        text-align: right;
    }

    .btn-outline-primary {
        background: transparent;
        border: 2px solid var(--gold);
        color: var(--gold);
        font-weight: 600;
        padding: 10px 25px;
        border-radius: 8px;
        transition: all 0.3s ease;
    }

    .btn-outline-primary:hover {
        background: linear-gradient(135deg, var(--gold) 0%, var(--gold-light) 100%);
        color: var(--dark-blue);
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(255, 215, 0, 0.3);
    }

    .badge-status {
        padding: 6px 12px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.8rem;
    }

    .badge-success {
        background: linear-gradient(135deg, #28a745, #20c997);
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

    .invoice-number {
        font-size: 1.1rem;
        font-weight: 600;
        color: var(--gold-light);
        background: rgba(255, 215, 0, 0.1);
        padding: 8px 15px;
        border-radius: 20px;
        display: inline-block;
        margin-bottom: 15px;
    }

    .action-buttons {
        display: flex;
        gap: 15px;
        justify-content: center;
        margin-top: 30px;
        flex-wrap: wrap;
    }

    /* Mobile responsiveness */
    @media (max-width: 768px) {
        .invoice-container {
            padding: 20px 15px;
        }
        
        .invoice-card {
            padding: 20px;
        }
        
        .invoice-title {
            font-size: 2rem;
        }
        
        .info-item {
            flex-direction: column;
        }
        
        .info-label {
            min-width: auto;
            margin-bottom: 5px;
        }
        
        .info-value {
            text-align: left;
        }
        
        .action-buttons {
            flex-direction: column;
        }
        
        .btn-outline-primary {
            width: 100%;
            text-align: center;
        }
        
        .table-custom {
            font-size: 0.9rem;
        }
    }

    .customer-info {
        background: rgba(10, 22, 40, 0.6);
        border: 1px solid rgba(255, 215, 0, 0.2);
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 25px;
    }

    .payment-info {
        background: rgba(10, 22, 40, 0.6);
        border: 1px solid rgba(0, 0, 0, 0.2);
        border-radius: 8px;
        padding: 20px;
    }

    .product-image {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 6px;
        border: 1px solid rgba(7, 7, 7, 0.3);
        margin-right: 10px;
    }
</style>

<div class="container">
    <div class="invoice-container">
        <div class="invoice-card">
            <div class="invoice-header">
                <h1 class="invoice-title">INVOICE PEMESANAN</h1>
                <p class="invoice-subtitle">Detail transaksi dan informasi pesanan</p>
                <div class="invoice-number">
                    <i class="fas fa-receipt me-2"></i>INV-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}
                </div>
            </div>

            <!-- Informasi Pesanan -->
            <div class="row mb-4">
                <div class="col-lg-6 mb-3">
                    <div class="customer-info">
                        <h5 class="info-title"><i class="fas fa-user me-2"></i>Data Pembeli</h5>
                        <div class="info-item">
                            <span class="info-label">Nama:</span>
                            <span class="info-value">{{ $order->name }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Alamat:</span>
                            <span class="info-value">{{ $order->alamat }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">No. HP:</span>
                            <span class="info-value">{{ $order->phone }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Tanggal Pesanan:</span>
                            <span class="info-value">{{ $order->created_at->format('d M Y H:i') }}</span>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-6 mb-3">
                    <div class="info-section">
                        <h5 class="info-title"><i class="fas fa-info-circle me-2"></i>Status Pesanan</h5>
                        <div class="info-item">
                            <span class="info-label">Status Pembayaran:</span>
                            <span class="info-value">
                                <span class="badge-status badge-{{ $order->status === 'paid' ? 'success' : ($order->status === 'pending' ? 'warning' : 'danger') }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Status Pesanan:</span>
                            <span class="info-value">
                                <span class="badge-status badge-info">
                                    {{ ucfirst(str_replace('_', ' ', $order->status_pesanan)) }}
                                </span>
                            </span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Jatuh Tempo:</span>
                            <span class="info-value">{{ $order->created_at->addDays(1)->format('d M Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detail Produk -->
            <div class="mb-4">
                <h5 class="info-title mb-3"><i class="fas fa-box me-2"></i>Detail Produk</h5>
                <div class="table-responsive">
                    <table class="table table-custom">
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th>Harga Satuan</th>
                                <th>Jumlah</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($order->produk->gambar)
                                            <img src="{{ asset('storage/' . $order->produk->gambar) }}" 
                                                 alt="{{ $order->produk->nama }}" 
                                                 class="product-image">
                                        @else
                                            <div class="product-image d-flex align-items-center justify-content-center bg-dark">
                                                <i class="fas fa-image text-gold" style="opacity: 0.5;"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <strong class="text-black">{{ $order->produk->nama }}</strong>
                                            @if($order->produk->deskripsi)
                                                <br><small class="text-muted">{{ Str::limit($order->produk->deskripsi, 50) }}</small>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td>{{ Number::currency($order->produk->harga, 'IDR', locale: 'id_ID') }}</td>
                                <td>{{ $order->jumlah }}</td>
                                <td><strong class="text-gold-light">{{ Number::currency($order->total_harga, 'IDR', locale: 'id_ID') }}</strong></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Informasi Pembayaran -->
            <div class="row">
                <div class="col-lg-6 mb-3">
                    <div class="payment-info">
                        <h5 class="info-title"><i class="fas fa-credit-card me-2"></i>Informasi Pembayaran</h5>
                        <div class="info-item">
                            <span class="info-label">Metode Pembayaran:</span>
                            <span class="info-value">Transfer Bank</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Bank Tujuan:</span>
                            <span class="info-value">BCA - 123456789</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Atas Nama:</span>
                            <span class="info-value">UMKM Indramayu</span>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-6 mb-3">
                    <div class="total-section">
                        <div class="info-item">
                            <span class="info-label">Subtotal:</span>
                            <span class="info-value">{{ Number::currency($order->total_harga, 'IDR', locale: 'id_ID') }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Biaya Admin:</span>
                            <span class="info-value">Rp 0</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Diskon:</span>
                            <span class="info-value">Rp 0</span>
                        </div>
                        <div class="info-item" style="border-top: 1px solid rgba(255, 215, 0, 0.3); padding-top: 10px;">
                            <span class="info-label" style="font-size: 1.2rem;">Total:</span>
                            <span class="total-amount">{{ Number::currency($order->total_harga, 'IDR', locale: 'id_ID') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tombol Aksi -->
            <div class="action-buttons">
                <a href="{{ route('penjual.pesanan.index') }}" class="btn btn-outline-primary">
                    <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar Pesanan
                </a>
                <a href="{{ route('penjual.pesanan.invoice.pdf', $order->id) }}" class="btn btn-outline-primary">
                    <i class="fas fa-print me-2"></i>Cetak PDF
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    // Tambahkan efek loading pada tombol cetak PDF
    document.addEventListener('DOMContentLoaded', function() {
        const printBtn = document.querySelector('a[href*="invoice.pdf"]');
        if (printBtn) {
            printBtn.addEventListener('click', function(e) {
                const originalText = this.innerHTML;
                this.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Membuat PDF...';
                this.style.pointerEvents = 'none';
                
                // Reset setelah 3 detik jika masih di halaman yang sama
                setTimeout(() => {
                    this.innerHTML = originalText;
                    this.style.pointerEvents = 'auto';
                }, 3000);
            });
        }
    });
</script>
@endsection