@extends('layouts.app')
@section('page_title', 'Pendapatan Admin')

@section('title')
    <i class="fas fa-money-bill-wave me-2"></i> Pendapatan Admin
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
                            <h1>Pendapatan Admin</h1>
                            <p class="mb-3">Monitor pendapatan dan penjualan seluruh UMKM dalam platform</p>
                            <div class="d-flex flex-wrap gap-3 align-items-center">
                                <span class="badge bg-gold text-dark fs-6 px-3 py-2">
                                    <i class="fas fa-chart-line me-2"></i>Dashboard Keuangan
                                </span>
                                <span class="text-gold"><i class="fas fa-calendar me-2"></i>{{ $periodeInfo }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 text-center">
                        <div class="feature-icon">
                            <i class="fas fa-chart-pie fa-6x text-gold"></i>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Filter Section -->
        <section class="container mb-4">
            <div class="filter-card">
                <div class="filter-header">
                    <h4><i class="fas fa-filter me-2"></i>Filter Laporan</h4>
                </div>
                <div class="filter-body">
                    <form method="GET" action="{{ route('admin.pendapatan.index') }}" class="row g-3 align-items-end">
                        <div class="col-md-3">
                            <label class="form-label text-gold">Bulan</label>
                            <select name="bulan" class="form-select custom-select">
                                <option value="">Pilih Bulan</option>
                                @foreach($bulanList as $key => $namaBulan)
                                    <option value="{{ $key }}" {{ $bulan == $key ? 'selected' : '' }}>
                                        {{ $namaBulan }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label text-gold">Tahun</label>
                            <select name="tahun" class="form-select custom-select">
                                <option value="">Pilih Tahun</option>
                                @foreach($tahunList as $tahunOption)
                                    <option value="{{ $tahunOption }}" {{ $tahun == $tahunOption ? 'selected' : '' }}>
                                        {{ $tahunOption }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="minggu" value="1" id="filterMinggu"
                                    {{ $filterMinggu ? 'checked' : '' }}>
                                <label class="form-check-label text-gold" for="filterMinggu">
                                    Minggu Ini
                                </label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <button type="submit" class="btn btn-filter w-100">
                                <i class="fas fa-search me-2"></i>Terapkan Filter
                            </button>
                            @if($bulan || $tahun || $filterMinggu)
                                <a href="{{ route('admin.pendapatan.index') }}" class="btn btn-reset w-100 mt-2">
                                    <i class="fas fa-times me-2"></i>Reset Filter
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </section>

        <!-- Statistik Cards -->
        <section class="container mb-5">
            <div class="row g-4">
                <!-- Total Penjualan -->
                <div class="col-md-6">
                    <div class="stats-card primary">
                        <div class="stats-content">
                            <div class="stats-info">
                                <h3 class="stats-label">Total Penjualan</h3>
                                <h2 class="stats-value">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h2>
                                <p class="stats-desc">Semua UMKM - {{ $periodeInfo }}</p>
                            </div>
                            <div class="stats-icon">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                        </div>
                        <div class="stats-footer">
                            <i class="fas fa-store me-2"></i>Seluruh Toko UMKM
                        </div>
                    </div>
                </div>

                <!-- Pendapatan Admin -->
                <div class="col-md-6">
                    <div class="stats-card success">
                        <div class="stats-content">
                            <div class="stats-info">
                                <h3 class="stats-label">Pendapatan Admin</h3>
                                <h2 class="stats-value">Rp {{ number_format($pendapatanAdmin, 0, ',', '.') }}</h2>
                                <p class="stats-desc">Komisi 20% - {{ $periodeInfo }}</p>
                            </div>
                            <div class="stats-icon">
                                <i class="fas fa-money-bill-wave"></i>
                            </div>
                        </div>
                        <div class="stats-footer">
                            <i class="fas fa-percentage me-2"></i>20% dari Total Penjualan
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Tabel Rekap per Toko -->
        <section class="container mb-5">
            <div class="section-header mb-4">
                <h2 class="section-title"><i class="fas fa-list-alt me-3"></i>Rekap Penjualan per Toko</h2>
                <p class="section-subtitle">Detail penjualan masing-masing UMKM - {{ $periodeInfo }}</p>
            </div>

            <div class="table-container">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th class="text-center">No</th>
                            <th>Nama Toko</th>
                            <th class="text-right">Total Penjualan</th>
                            <th class="text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($rekapPerToko as $index => $toko)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td>
                                    <div class="store-info">
                                        <h5 class="store-name">{{ $toko->nama_toko }}</h5>
                                        <span class="store-owner">{{ $toko->user->name ?? 'Pemilik' }}</span>
                                    </div>
                                </td>
                                <td class="text-right">
                                    <span class="sale-amount">Rp {{ number_format($toko->total_penjualan, 0, ',', '.') }}</span>
                                </td>
                                <td class="text-center">
                                    @if($toko->total_penjualan > 0)
                                        <span class="status-badge active">
                                            <i class="fas fa-check-circle me-1"></i>Aktif
                                        </span>
                                    @else
                                        <span class="status-badge inactive">
                                            <i class="fas fa-clock me-1"></i>Menunggu
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-5">
                                    <div class="empty-table">
                                        <i class="fas fa-chart-bar fa-4x text-gold mb-3 opacity-50"></i>
                                        <h4 class="text-gold mb-2">Belum Ada Penjualan</h4>
                                        <p class="text-muted">Belum ada transaksi penjualan dari UMKM pada periode ini.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                    @if($rekapPerToko->count() > 0)
                        <tfoot>
                            <tr>
                                <td colspan="2" class="text-end"><strong>Total Keseluruhan:</strong></td>
                                <td class="text-right"><strong class="total-amount">Rp
                                        {{ number_format($totalPendapatan, 0, ',', '.') }}</strong></td>
                                <td></td>
                            </tr>
                        </tfoot>
                    @endif
                </table>
            </div>
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
            --success: #28a745;
            --primary: #007bff;
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

        /* Filter Card */
        .filter-card {
            background: linear-gradient(135deg, rgba(26, 58, 95, 0.7) 0%, rgba(42, 74, 127, 0.8) 100%);
            border: 1px solid rgba(255, 215, 0, 0.2);
            border-radius: 15px;
            overflow: hidden;
            backdrop-filter: blur(10px);
        }

        .filter-header {
            background: linear-gradient(135deg, rgba(255, 215, 0, 0.1) 0%, rgba(255, 237, 78, 0.05) 100%);
            padding: 1.2rem 1.5rem;
            border-bottom: 1px solid rgba(255, 215, 0, 0.2);
        }

        .filter-header h4 {
            color: var(--gold);
            margin: 0;
            font-size: 1.2rem;
        }

        .filter-body {
            padding: 1.5rem;
        }

        .custom-select {
            background: rgba(10, 22, 40, 0.8);
            border: 1px solid rgba(255, 215, 0, 0.3);
            border-radius: 8px;
            color: #c0c0c0;
            padding: 0.75rem;
        }

        .custom-select:focus {
            background: rgba(10, 22, 40, 0.9);
            border-color: var(--gold);
            box-shadow: 0 0 0 0.2rem rgba(255, 215, 0, 0.25);
            color: #c0c0c0;
        }

        .form-check-input:checked {
            background-color: var(--gold);
            border-color: var(--gold);
        }

        .form-label {
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .btn-filter {
            background: linear-gradient(135deg, var(--gold) 0%, var(--gold-light) 100%);
            color: var(--dark-blue);
            border: none;
            font-weight: 600;
            padding: 0.75rem;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .btn-filter:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 215, 0, 0.4);
        }

        .btn-reset {
            background: transparent;
            color: var(--gold);
            border: 1px solid var(--gold);
            font-weight: 600;
            padding: 0.75rem;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .btn-reset:hover {
            background: rgba(255, 215, 0, 0.1);
            transform: translateY(-2px);
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

        /* Stats Cards */
        .stats-card {
            background: linear-gradient(135deg, rgba(26, 58, 95, 0.7) 0%, rgba(42, 74, 127, 0.8) 100%);
            border: 1px solid rgba(255, 215, 0, 0.2);
            border-radius: 15px;
            padding: 2rem;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
            height: 100%;
        }

        .stats-card:hover {
            transform: translateY(-5px);
            border-color: var(--gold);
            box-shadow: 0 10px 30px rgba(255, 215, 0, 0.2);
        }

        .stats-card.primary {
            border-left: 4px solid var(--primary);
        }

        .stats-card.success {
            border-left: 4px solid var(--success);
        }

        .stats-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .stats-info h3 {
            color: #c0c0c0;
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .stats-value {
            color: var(--gold);
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            background: linear-gradient(135deg, var(--gold) 0%, var(--gold-light) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .stats-desc {
            color: #c0c0c0;
            font-size: 0.9rem;
            margin: 0;
        }

        .stats-icon {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
        }

        .stats-card.primary .stats-icon {
            background: rgba(0, 123, 255, 0.2);
            color: var(--primary);
        }

        .stats-card.success .stats-icon {
            background: rgba(40, 167, 69, 0.2);
            color: var(--success);
        }

        .stats-footer {
            border-top: 1px solid rgba(255, 215, 0, 0.2);
            padding-top: 1rem;
            color: #c0c0c0;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
        }

        /* Table Container */
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

        .custom-table tfoot {
            background: rgba(255, 215, 0, 0.1);
            border-top: 2px solid rgba(255, 215, 0, 0.3);
        }

        .custom-table tfoot td {
            padding: 1rem;
            font-weight: 700;
            color: var(--gold);
        }

        /* Store Info */
        .store-info h5 {
            color: var(--gold);
            margin-bottom: 0.3rem;
            font-weight: 600;
        }

        .store-owner {
            color: #c0c0c0;
            font-size: 0.9rem;
            background: rgba(255, 215, 0, 0.1);
            padding: 0.2rem 0.6rem;
            border-radius: 8px;
            display: inline-block;
        }

        /* Sale Amount */
        .sale-amount {
            color: var(--gold-light);
            font-size: 1.1rem;
            font-weight: 700;
        }

        .total-amount {
            color: var(--gold);
            font-size: 1.2rem;
        }

        /* Status Badges */
        .status-badge {
            padding: 0.4rem 0.8rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
        }

        .status-badge.active {
            background: rgba(40, 167, 69, 0.2);
            color: #28a745;
            border: 1px solid rgba(40, 167, 69, 0.3);
        }

        .status-badge.inactive {
            background: rgba(108, 117, 125, 0.2);
            color: #6c757d;
            border: 1px solid rgba(108, 117, 125, 0.3);
        }

        /* Empty Table */
        .empty-table {
            padding: 2rem;
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

            .stats-content {
                flex-direction: column;
                text-align: center;
            }

            .stats-icon {
                margin-top: 1rem;
                width: 60px;
                height: 60px;
                font-size: 1.5rem;
            }

            .stats-value {
                font-size: 1.5rem;
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

            .store-info h5 {
                font-size: 0.9rem;
            }

            .store-owner {
                font-size: 0.8rem;
            }

            .filter-body .row {
                row-gap: 1rem;
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

        // Auto-submit form when checkbox is changed
        document.getElementById('filterMinggu').addEventListener('change', function () {
            if (this.checked) {
                this.form.submit();
            }
        });
    </script>
@endsection