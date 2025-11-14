@extends('layouts.app')

@section('page_title', 'Pendapatan')

@section('title')
    <i class="fas fa-chart-bar me-2"></i> Pendapatan
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
        color: #e0e0e0 !important;
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

    .filter-section {
        background: linear-gradient(135deg, rgba(26, 58, 95, 0.7) 0%, rgba(42, 74, 127, 0.8) 100%);
        border: 2px solid rgba(255, 215, 0, 0.2);
        border-radius: 12px;
        padding: 20px;
        backdrop-filter: blur(10px);
        margin-bottom: 25px;
    }

    .form-control, .form-select {
        background: rgba(26, 58, 95, 0.6);
        border: 2px solid rgba(255, 215, 0, 0.2);
        border-radius: 8px;
        color: #e0e0e0;
        padding: 10px 15px;
        transition: all 0.3s ease;
    }

    .form-control:focus, .form-select:focus {
        background: rgba(26, 58, 95, 0.8);
        border-color: var(--gold);
        color: #e0e0e0;
        box-shadow: 0 0 15px rgba(255, 215, 0, 0.3);
        outline: none;
    }

    .form-label {
        font-weight: 600;
        color: var(--gold);
        margin-bottom: 8px;
    }

    .alert-secondary {
        background: linear-gradient(135deg, rgba(108, 117, 125, 0.2) 0%, rgba(134, 142, 150, 0.3) 100%);
        border: 2px solid rgba(108, 117, 125, 0.5);
        border-radius: 12px;
        backdrop-filter: blur(10px);
        color: #e0e0e0;
        padding: 20px;
        margin-bottom: 25px;
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

    .alert-info {
        background: linear-gradient(135deg, rgba(23, 162, 184, 0.2) 0%, rgba(32, 201, 151, 0.3) 100%);
        border: 2px solid rgba(23, 162, 184, 0.5);
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

    .price-amount {
        color: #000000;
        font-weight: 600;
    }

    .product-name {
        color: #000000;
        font-weight: 500;
    }

    .stats-highlight {
        font-size: 1.1rem;
        font-weight: 700;
        color: var(--gold-light);
    }

    .period-info {
        color: #c0c0c0;
        font-size: 0.9rem;
        margin-top: 5px;
    }

    /* Mobile responsiveness */
    @media (max-width: 768px) {
        .revenue-container {
            padding: 20px 15px;
        }
        
        .filter-section {
            padding: 15px;
        }
        
        .export-buttons {
            flex-direction: column;
        }
        
        .btn-success, .btn-danger {
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
        
        .filter-section .row {
            flex-direction: column;
            gap: 10px;
        }
        
        .filter-section .col-auto {
            width: 100%;
        }
    }

    .summary-card {
        background: linear-gradient(135deg, rgba(26, 58, 95, 0.7) 0%, rgba(42, 74, 127, 0.8) 100%);
        border: 2px solid rgba(255, 215, 0, 0.2);
        border-radius: 8px;
        padding: 15px;
        backdrop-filter: blur(10px);
        margin-bottom: 20px;
    }

    .summary-value {
        font-size: 1.3rem;
        font-weight: 700;
        color: var(--gold-light);
        margin-bottom: 5px;
    }

    .summary-label {
        font-size: 0.9rem;
        color: var(--gold);
        font-weight: 600;
    }
</style>

<div class="container">
    <h2 class="section-title"><i class="fas fa-chart-bar me-3"></i>Ringkasan Pendapatan</h2>
    
    <div class="revenue-container">
        <!-- Filter Section -->
        <div class="filter-section">
            <form method="GET" class="mb-0">
                <div class="row g-3 align-items-center">
                    <div class="col-md-auto">
                        <label for="filter" class="form-label mb-0"><i class="fas fa-filter me-2"></i>Filter Waktu:</label>
                    </div>
                    <div class="col-md-auto">
                        <select name="filter" id="filter" class="form-select" onchange="this.form.submit()">
                            <option value="minggu" {{ request('filter') == 'minggu' ? 'selected' : '' }}>Minggu Ini</option>
                            <option value="bulan" {{ request('filter', 'bulan') == 'bulan' ? 'selected' : '' }}>Bulan Ini</option>
                            <option value="tahun" {{ request('filter') == 'tahun' ? 'selected' : '' }}>Tahun Ini</option>
                        </select>
                    </div>
                    <div class="col-md-auto ms-auto">
                        <small class="period-info">
                            @php
                                $periodText = [
                                    'minggu' => 'Minggu Ini',
                                    'bulan' => 'Bulan Ini', 
                                    'tahun' => 'Tahun Ini'
                                ][request('filter', 'bulan')];
                            @endphp
                            <i class="fas fa-calendar me-1"></i>Menampilkan data: {{ $periodText }}
                        </small>
                    </div>
                </div>
            </form>
        </div>

        <!-- Info Pendapatan Bulan Lalu -->
        <div class="alert alert-secondary">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <i class="fas fa-chart-line me-2"></i>
                    <strong>Pendapatan Bulan Lalu:</strong>
                </div>
                <div class="stats-highlight">
                    {{ isset($totalPendapatanBulanLalu) ? 'Rp ' . number_format($totalPendapatanBulanLalu, 0, ',', '.') : '-' }}
                </div>
            </div>
        </div>

        <!-- Quick Stats -->
        @if(!$pendapatanPerProduk->isEmpty())
            @php
                $totalPendapatan = $pendapatanPerProduk->sum('total_pendapatan');
                $totalTerjual = $pendapatanPerProduk->sum('total_terjual');
                $totalProduk = $pendapatanPerProduk->count();
            @endphp
            
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="summary-card text-center">
                        <div class="summary-value">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</div>
                        <div class="summary-label">Total Pendapatan</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="summary-card text-center">
                        <div class="summary-value">{{ $totalTerjual }}</div>
                        <div class="summary-label">Total Terjual</div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="summary-card text-center">
                        <div class="summary-value">{{ $totalProduk }}</div>
                        <div class="summary-label">Produk Terjual</div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Tombol Export -->
        <div class="export-buttons">
            <a href="{{ route('penjual.pendapatan.export.summary.excel', request()->all()) }}" class="btn btn-success">
                <i class="fas fa-file-excel me-2"></i> Export Excel
            </a>
            <a href="{{ route('penjual.pendapatan.export.summary.pdf', request()->all()) }}" class="btn btn-danger">
                <i class="fas fa-file-pdf me-2"></i> Export PDF
            </a>
        </div>

        <!-- Tabel Pendapatan -->
        @if($pendapatanPerProduk->isEmpty())
            <div class="alert alert-info">
                <div class="empty-state">
                    <i class="fas fa-chart-bar"></i>
                    <h5>Belum Ada Pendapatan</h5>
                    <p>Belum ada pendapatan dari produk pada periode ini.</p>
                </div>
            </div>
        @else
            <div class="table-responsive">
                <table class="table table-custom">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>PRODUK</th>
                            <th>TOTAL TERJUAL</th>
                            <th>TOTAL PENDAPATAN</th>
                            <th>STOK TERPAKAI</th>
                            <th>STOK SISA</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pendapatanPerProduk as $index => $item)
                            <tr>
                                <td class="fw-bold">{{ $index + 1 }}</td>
                                <td>
                                    <span class="product-name">{{ $item->nama_produk }}</span>
                                </td>
                                <td>{{ $item->total_terjual ?? 0 }}</td>
                                <td>
                                    <span class="price-amount">Rp {{ number_format($item->total_pendapatan ?? 0, 0, ',', '.') }}</span>
                                </td>
                                <td>{{ $item->total_terjual ?? 0 }}</td>
                                <td>{{ $item->stok }}</td>
                                <td>
                                    <a href="{{ route('penjual.pendapatan.detail', $item->id) }}" class="btn btn-primary">
                                        <i class="fas fa-eye me-1"></i> Detail
                                    </a>
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
    // Tambahkan efek loading pada tombol export
    document.addEventListener('DOMContentLoaded', function() {
        const exportButtons = document.querySelectorAll('a[href*="export"]');
        
        exportButtons.forEach(button => {
            button.addEventListener('click', function(e) {
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

        // Tambahkan konfirmasi untuk filter
        const filterSelect = document.getElementById('filter');
        if (filterSelect) {
            filterSelect.addEventListener('change', function() {
                const selectedPeriod = this.options[this.selectedIndex].text;
                // Opsional: tambahkan efek visual saat mengubah filter
                this.style.borderColor = 'var(--gold)';
                this.style.boxShadow = '0 0 10px rgba(255, 215, 0, 0.5)';
                
                setTimeout(() => {
                    this.style.borderColor = '';
                    this.style.boxShadow = '';
                }, 1000);
            });
        }
    });
</script>
@endsection