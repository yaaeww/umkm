@extends('layouts.app')

@section('page_title', 'Pendapatan')

@section('title')
    <i class="fas fa-chart-line me-2"></i> Detail Pendapatan
@endsection

@section('content')
    <style>
        .revenue-container {
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

        .product-header {
            background: linear-gradient(135deg, rgba(26, 58, 95, 0.7) 0%, rgba(42, 74, 127, 0.8) 100%);
            border: 2px solid rgba(255, 215, 0, 0.2);
            border-radius: 12px;
            padding: 20px;
            backdrop-filter: blur(10px);
            margin-bottom: 25px;
        }

        .product-info {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .product-image {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 8px;
            border: 2px solid rgba(255, 215, 0, 0.3);
        }

        .product-details h4 {
            color: var(--gold);
            margin-bottom: 5px;
        }

        .product-details p {
            color: #c0c0c0;
            margin-bottom: 0;
        }

        .export-buttons {
            display: flex;
            gap: 15px;
            margin-bottom: 25px;
            flex-wrap: wrap;
        }

        .btn-success {
            background: linear-gradient(135deg, #28a745, #20c997);
            border: none;
            color: white;
            font-weight: 600;
            padding: 10px 20px;
            border-radius: 8px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
        }

        .btn-success:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(40, 167, 69, 0.5);
            background: linear-gradient(135deg, #20c997, #28a745);
            color: white;
        }

        .btn-danger {
            background: linear-gradient(135deg, #dc3545, #e83e8c);
            border: none;
            color: white;
            font-weight: 600;
            padding: 10px 20px;
            border-radius: 8px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(220, 53, 69, 0.3);
        }

        .btn-danger:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(220, 53, 69, 0.5);
            background: linear-gradient(135deg, #e83e8c, #dc3545);
            color: white;
        }

        .btn-secondary {
            background: linear-gradient(135deg, #6c757d, #868e96);
            border: none;
            color: white;
            font-weight: 600;
            padding: 10px 25px;
            border-radius: 8px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(108, 117, 125, 0.3);
        }

        .btn-secondary:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(108, 117, 125, 0.5);
            background: linear-gradient(135deg, #868e96, #6c757d);
            color: white;
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
            color: #000000;
            font-weight: 600;
            padding: 15px 12px;
            border: none;
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

        .alert-warning {
            background: linear-gradient(135deg, rgba(255, 193, 7, 0.2) 0%, rgba(255, 215, 0, 0.3) 100%);
            border: 2px solid rgba(255, 193, 7, 0.5);
            border-radius: 12px;
            backdrop-filter: blur(10px);
            color: #e0e0e0;
            padding: 25px;
            text-align: center;
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

        .stats-card {
            background: linear-gradient(135deg, rgba(26, 58, 95, 0.7) 0%, rgba(42, 74, 127, 0.8) 100%);
            border: 2px solid rgba(255, 215, 0, 0.2);
            border-radius: 8px;
            padding: 20px;
            backdrop-filter: blur(10px);
            margin-bottom: 20px;
        }

        .stats-title {
            font-size: 1rem;
            color: var(--gold);
            margin-bottom: 10px;
            font-weight: 600;
        }

        .stats-value {
            font-size: 1.5rem;
            color: var(--gold-light);
            font-weight: 700;
        }

        .price-amount {
            color: #000000;
            font-weight: 600;
        }

        .customer-name {
            color: #000000;
            font-weight: 500;
        }

        .order-id {
            color: #000000;
            font-family: monospace;
            font-size: 0.9rem;
        }

        /* Mobile responsiveness */
        @media (max-width: 768px) {
            .revenue-container {
                padding: 20px 15px;
            }

            .product-info {
                flex-direction: column;
                text-align: center;
                gap: 15px;
            }

            .export-buttons {
                flex-direction: column;
            }

            .btn-success,
            .btn-danger,
            .btn-secondary {
                width: 100%;
                text-align: center;
            }

            .table-custom {
                font-size: 0.9rem;
            }

            .table-custom th,
            .table-custom td {
                padding: 8px 6px;
            }

            .section-title {
                font-size: 1.8rem;
            }
        }

        @media (max-width: 576px) {
            .table-responsive {
                border: 1px solid rgba(255, 215, 0, 0.2);
                border-radius: 8px;
            }
        }

        .summary-section {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-bottom: 25px;
        }

        .action-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 30px;
            flex-wrap: wrap;
            gap: 15px;
        }
    </style>

    <div class="container">
        <h2 class="section-title"><i class="fas fa-chart-line me-3"></i>Detail Pendapatan</h2>

        <div class="revenue-container">
            <!-- Header Produk -->
            <div class="product-header">
                <div class="product-info">
                    @if($produk->gambar)
                        <img src="{{ asset('storage/' . $produk->gambar) }}" alt="{{ $produk->nama }}" class="product-image">
                    @else
                        <div class="product-image d-flex align-items-center justify-content-center bg-dark">
                            <i class="fas fa-image fa-2x text-gold" style="opacity: 0.5;"></i>
                        </div>
                    @endif
                    <div class="product-details">
                        <h4>{{ $produk->nama }}</h4>
                        <p><i class="fas fa-tag me-2"></i>Harga: Rp {{ number_format($produk->harga, 0, ',', '.') }}</p>
                        <p><i class="fas fa-box me-2"></i>Stok Tersedia: {{ $produk->stok }}</p>
                    </div>
                </div>
            </div>

            <!-- Ringkasan Statistik -->
            @if(!$detail->isEmpty())
                @php
                    $totalPendapatan = $detail->sum('total_harga');
                    $totalTerjual = $detail->sum('jumlah');
                    $totalTransaksi = $detail->count();
                    $rataRata = $totalTransaksi > 0 ? $totalPendapatan / $totalTransaksi : 0;
                @endphp

                <div class="summary-section">
                    <div class="stats-card">
                        <div class="stats-title"><i class="fas fa-money-bill-wave me-2"></i>Total Pendapatan</div>
                        <div class="stats-value">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</div>
                    </div>
                    <div class="stats-card">
                        <div class="stats-title"><i class="fas fa-shopping-cart me-2"></i>Total Terjual</div>
                        <div class="stats-value">{{ $totalTerjual }} unit</div>
                    </div>
                    <div class="stats-card">
                        <div class="stats-title"><i class="fas fa-receipt me-2"></i>Total Transaksi</div>
                        <div class="stats-value">{{ $totalTransaksi }} transaksi</div>
                    </div>
                    <div class="stats-card">
                        <div class="stats-title"><i class="fas fa-chart-bar me-2"></i>Rata-rata/Transaksi</div>
                        <div class="stats-value">Rp {{ number_format($rataRata, 0, ',', '.') }}</div>
                    </div>
                </div>
            @endif

            <!-- Tombol Export -->
            @if(!$detail->isEmpty())
                <div class="export-buttons">
                    <a href="{{ route('penjual.pendapatan.detail.export.excel', $produk->id) }}" class="btn btn-success">
                        <i class="fas fa-file-excel me-2"></i> Export Excel
                    </a>
                    <a href="{{ route('penjual.pendapatan.detail.export.pdf', $produk->id) }}" class="btn btn-danger">
                        <i class="fas fa-file-pdf me-2"></i> Export PDF
                    </a>
                </div>
            @endif

            <!-- Tabel Transaksi -->
            @if($detail->isEmpty())
                <div class="alert alert-warning">
                    <div class="empty-state">
                        <i class="fas fa-chart-line"></i>
                        <h5>Belum Ada Transaksi</h5>
                        <p>Belum ada transaksi untuk produk ini.</p>
                    </div>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-custom">
                        <thead>
                            <tr>
                                <th>ID ORDER</th>
                                <th>NAMA PEMBELI</th>
                                <th>JUMLAH</th>
                                <th>TOTAL HARGA</th>
                                <th>TANGGAL TRANSAKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($detail as $item)
                                <tr>
                                    <td>
                                        <span class="order-id">#{{ $item->id }}</span>
                                    </td>
                                    <td>
                                        <span class="customer-name">{{ $item->nama_pemesan ?? 'Tidak diketahui' }}</span>
                                    </td>
                                    <td>{{ $item->jumlah }}</td>
                                    <td>
                                        <span class="price-amount">Rp {{ number_format($item->total_harga, 0, ',', '.') }}</span>
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('d F Y H:i') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif

            <!-- Tombol Aksi -->
            <div class="action-section">
                <a href="{{ route('penjual.pendapatan.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i> Kembali ke Daftar Pendapatan
                </a>

                @if(!$detail->isEmpty())
                    <div class="text-theme">
                        <small>
                            <i class="fas fa-info-circle me-1"></i>
                            Menampilkan {{ $detail->count() }} transaksi
                        </small>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        // Tambahkan efek loading pada tombol export
        document.addEventListener('DOMContentLoaded', function () {
            const exportButtons = document.querySelectorAll('a[href*="export"]');

            exportButtons.forEach(button => {
                button.addEventListener('click', function (e) {
                    const originalText = this.innerHTML;
                    const isExcel = this.href.includes('excel');

                    this.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>' +
                        (isExcel ? 'Mengekspor Excel...' : 'Mengekspor PDF...');
                    this.style.pointerEvents = 'none';

                    // Reset setelah 3 detik jika masih di halaman yang sama
                    setTimeout(() => {
                        this.innerHTML = originalText;
                        this.style.pointerEvents = 'auto';
                    }, 3000);
                });
            });
        });
    </script>
@endsection