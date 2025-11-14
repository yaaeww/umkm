@extends('layouts.app')

@section('page_title', 'Dashboard Penjual')

@section('title')
    <i class="fas fa-tachometer-alt me-2"></i> Dashboard Penjual
@endsection

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

        /* Main Background */
        body {
            background: linear-gradient(135deg, var(--dark-blue) 0%, var(--medium-blue) 100%);
            color: #e0e0e0;
        }

        /* Card Styles */
        .card-box {
            background: linear-gradient(135deg, rgba(26, 58, 95, 0.9) 0%, rgba(42, 74, 127, 0.9) 100%);
            border: 2px solid rgba(255, 215, 0, 0.3);
            border-radius: 15px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(10px);
            transition: all 0.4s ease;
        }

        .card-box:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 35px rgba(255, 215, 0, 0.2);
            border-color: var(--gold);
        }

        /* Welcome Card */
        .welcome-card {
            background: linear-gradient(135deg, var(--dark-blue) 0%, var(--medium-blue) 100%);
            border: 2px solid var(--gold);
            border-radius: 20px;
            box-shadow: 0 8px 30px rgba(255, 215, 0, 0.3);
        }

        .welcome-card .rounded-circle {
            border: 4px solid var(--gold);
            box-shadow: 0 0 25px rgba(255, 215, 0, 0.4);
            transition: all 0.3s ease;
        }

        .welcome-card .rounded-circle:hover {
            transform: scale(1.05);
            box-shadow: 0 0 35px rgba(255, 215, 0, 0.6);
        }

        /* Text Colors */
        .text-dark {
            color: #b0b8c1 !important;
        }

        .text-primary {
            color: var(--gold) !important;
        }

        .text-gold {
            color: var(--gold) !important;
        }

        h4,
        h2 {
            color: #e0e0e0;
        }

        /* Welcome Text */
        .greeting-text {
            font-weight: 600;
            font-size: 1.3rem;
            color: #e0e0e0;
        }

        .user-name-text {
            font-weight: 700;
            font-size: 2.2rem;
            background: linear-gradient(135deg, var(--gold) 0%, var(--gold-light) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-shadow: 0 0 30px rgba(255, 215, 0, 0.3);
        }

        .welcome-message {
            font-size: 1.1rem;
            line-height: 1.6;
            color: #b0b8c1;
        }

        /* Table Dark Theme */
        .table {
            background: transparent;
            color: #e0e0e0;
            border-radius: 12px;
            overflow: hidden;
        }

        .table thead th {
            background: linear-gradient(135deg, var(--gold) 0%, var(--gold-light) 100%);
            color: var(--dark-blue);
            border-bottom: 3px solid var(--gold);
            font-weight: 700;
            text-transform: uppercase;
            font-size: 0.9rem;
            letter-spacing: 0.5px;
            padding: 15px 12px;
        }

        .table tbody tr {
            background: rgba(26, 58, 95, 0.6);
            border-bottom: 1px solid rgba(255, 215, 0, 0.2);
            transition: all 0.3s ease;
        }

        .table tbody tr:hover {
            background: rgba(255, 215, 0, 0.1);
            transform: translateX(5px);
        }

        .table tbody td {
            color: #060606;
            vertical-align: middle;
            padding: 15px 12px;
            font-weight: 500;
        }

        .table tbody td img {
            border-radius: 10px;
            border: 2px solid var(--gold);
            box-shadow: 0 4px 15px rgba(255, 215, 0, 0.3);
            transition: all 0.3s ease;
        }

        .table tbody td img:hover {
            transform: scale(1.1);
            box-shadow: 0 6px 20px rgba(255, 215, 0, 0.5);
        }

        /* Widget Cards Enhancement */
        .widget-style-3 {
            background: linear-gradient(135deg, rgba(26, 58, 95, 0.9) 0%, rgba(42, 74, 127, 0.9) 100%) !important;
            border: 2px solid rgba(255, 215, 0, 0.3);
            border-radius: 15px;
            transition: all 0.4s ease;
            backdrop-filter: blur(10px);
        }

        .widget-style-3:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 15px 40px rgba(255, 215, 0, 0.3);
            border-color: var(--gold);
        }

        .widget-style-3 .widget-data h4 {
            color: var(--gold);
            font-weight: 700;
            font-size: 1.1rem;
        }

        .widget-style-3 .widget-data p {
            color: #b0b8c1;
            font-weight: 600;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 10px;
            height: 10px;
        }

        ::-webkit-scrollbar-track {
            background: var(--dark-blue);
            border-radius: 5px;
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, var(--gold) 0%, var(--gold-light) 100%);
            border-radius: 5px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--gold-light);
        }

        /* DataTable Dark Theme */
        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter,
        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_paginate {
            color: #b0b8c1;
        }

        .dataTables_wrapper .dataTables_length select,
        .dataTables_wrapper .dataTables_filter input {
            background: rgba(26, 58, 95, 0.8);
            color: #e0e0e0;
            border: 2px solid rgba(255, 215, 0, 0.3);
            border-radius: 8px;
            padding: 8px 12px;
        }

        .dataTables_wrapper .dataTables_length select:focus,
        .dataTables_wrapper .dataTables_filter input:focus {
            border-color: var(--gold);
            box-shadow: 0 0 0 0.2rem rgba(255, 215, 0, 0.25);
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button {
            color: var(--gold) !important;
            background: rgba(26, 58, 95, 0.8);
            border: 2px solid rgba(255, 215, 0, 0.3);
            border-radius: 8px;
            margin: 0 3px;
            transition: all 0.3s ease;
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background: var(--gold) !important;
            color: var(--dark-blue) !important;
            border-color: var(--gold);
            transform: translateY(-2px);
        }

        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: var(--gold) !important;
            color: var(--dark-blue) !important;
            border-color: var(--gold);
            font-weight: 700;
        }

        /* Empty State */
        .text-center {
            color: #b0b8c1;
            font-style: italic;
            padding: 30px;
        }

        /* Price Styling */
        .price-text {
            color: var(--gold);
            font-weight: 700;
            font-size: 1.1rem;
        }

        /* Status Badges */
        .badge-best-seller {
            background: linear-gradient(135deg, var(--gold) 0%, var(--gold-light) 100%);
            color: var(--dark-blue);
            font-weight: 700;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
        }

        /* Animation */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in-up {
            animation: fadeInUp 0.6s ease-out;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .user-name-text {
                font-size: 1.8rem;
            }

            .greeting-text {
                font-size: 1.1rem;
            }

            .welcome-message {
                font-size: 1rem;
            }

            .table-responsive {
                border: 1px solid rgba(255, 215, 0, 0.3);
                border-radius: 12px;
            }
        }

        /* Sparkle Effect */
        .sparkle-container {
            position: relative;
            overflow: hidden;
        }

        @keyframes sparkleFloat {

            0%,
            100% {
                transform: translateY(0) scale(1);
                opacity: 0;
            }

            50% {
                transform: translateY(-20px) scale(1.3);
                opacity: 1;
            }
        }
    </style>

    <!-- Welcome Card -->
    <div class="card-box pd-20 height-100-p mb-30 welcome-card sparkle-container fade-in-up">
        <div class="row align-items-center">
            <div class="col-md-4 text-center">
                @php
                    $avatarPath = auth()->user()->avatar;
                    $fullPath = 'avatar/' . ltrim($avatarPath, '/');
                    $avatarExists = $avatarPath && \Illuminate\Support\Facades\Storage::disk('public')->exists($fullPath);
                    $avatarUrl = $avatarExists
                        ? asset('storage/' . $fullPath)
                        : asset('images/default-avatar.png');
                @endphp
                <img src="{{ $avatarUrl }}" class="rounded-circle img-fluid"
                    style="max-height: 150px; width: 150px; object-fit: cover;" alt="Avatar Pengguna">
            </div>

            <div class="col-md-8">
                @php
                    $time = now()->format('H');
                    $greeting = match (true) {
                        $time < 12 => 'Selamat pagi',
                        $time < 15 => 'Selamat siang',
                        $time < 18 => 'Selamat sore',
                        default => 'Selamat malam',
                    };
                @endphp
                <h4 class="greeting-text mb-3">
                    {{ $greeting }},
                </h4>
                <div class="user-name-text mb-3">
                    {{ auth()->user()->name }}!
                </div>
                <p class="welcome-message">
                    @if(auth()->user()->isAdmin())
                        Selamat datang di dashboard Admin. Anda dapat mengelola seluruh sistem dari sini.
                    @elseif(auth()->user()->isPenjual())
                        <i class="fas fa-store me-2" style="color: var(--gold);"></i>
                        Selamat berjualan! Pantau produk dan penjualan Anda di dashboard ini.
                    @else
                        Selamat berbelanja! Temukan produk terbaik untuk kebutuhan Anda.
                    @endif
                </p>
            </div>
        </div>
    </div>

    <!-- Statistics Widgets -->
    <div class="row pb-10 fade-in-up">
        <!-- Total Produk -->
        <x-widget-card color="var(--gold)" icon="fa-cubes" title="Total Produk" :value="$totalProduk ?? 0" />

        <!-- Total Kategori -->
        <x-widget-card color="var(--gold-light)" icon="fa-tags" title="Kategori Produk" :value="$totalKategori ?? 0" />

        <!-- Total Pembeli -->
        <x-widget-card color="var(--gold)" icon="fa-users" title="Total Pembeli" :value="$totalPembeliUnik ?? 0" />

        <!-- Pendapatan -->
        <x-widget-card color="var(--gold-light)" icon="fa-money-bill-wave" title="Total Pendapatan" :value="'Rp ' . number_format($pendapatan ?? 0, 0, ',', '.')" />
    </div>

    <!-- Produk Terlaris -->
    <div class="card-box mb-30 fade-in-up">
        <div class="d-flex justify-content-between align-items-center pb-3">
            <h2 class="h4 mb-0">
                <i class="fas fa-fire me-2 text-gold"></i>
                Produk Terlaris
            </h2>
            <span class="badge-best-seller">
                <i class="fas fa-crown me-1"></i>
                TOP SELLERS
            </span>
        </div>

        @php
            // Fungsi bantu untuk mendapatkan URL gambar produk dengan fallback
            function gambarProduk($path)
            {
                if ($path && \Illuminate\Support\Facades\Storage::disk('public')->exists($path)) {
                    return asset('storage/' . $path);
                }
                return asset('images/no-image.png');
            }
        @endphp

        <div class="table-responsive">
            <table class="data-table table nowrap table-hover">
                <thead>
                    <tr>
                        <th class="table-plus datatable-nosort">Gambar</th>
                        <th>Nama Produk</th>
                        <th>Penjual</th>
                        <th>Harga</th>
                        <th>Jumlah Terjual</th>
                        <th>Total Pendapatan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($produkTerlaris ?? [] as $produk)
                        @php
                            $gambarPath = $produk->gambar ?? '';
                            $gambarUrl = ($gambarPath && \Illuminate\Support\Facades\Storage::disk('public')->exists($gambarPath))
                                ? asset('storage/' . $gambarPath)
                                : asset('images/no-image.png');
                        @endphp
                        <tr style="color: black;">
                            <td class="table-plus text-black">
                                <img src="{{ $gambarUrl }}" width="70" height="70" alt="Produk" style="object-fit: cover;">
                            </td>
                            <td>
                                <strong>{{ $produk->nama ?? '-' }}</strong>
                            </td>
                            <td>{{ $produk->penjual_name ?? '-' }}</td>
                            <td class="price-text">Rp{{ number_format($produk->harga ?? 0, 0, ',', '.') }}</td>
                            <td>
                                <span class="badge-best-seller">
                                    {{ $produk->total_unit ?? 0 }} unit
                                </span>
                            </td>
                            <td class="price-text">Rp{{ number_format($produk->total_penjualan ?? 0, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">
                                <i class="fas fa-box-open fa-3x mb-3" style="color: #b0b8c1; opacity: 0.5;"></i>
                                <p class="mb-0">Belum ada data produk terlaris.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Sparkle animation untuk welcome card
            function createSparkle() {
                const container = document.querySelector('.sparkle-container');
                if (!container) return;

                const sparkle = document.createElement('div');
                sparkle.style.position = 'absolute';
                sparkle.style.width = '4px';
                sparkle.style.height = '4px';
                sparkle.style.background = '#ffd700';
                sparkle.style.borderRadius = '50%';
                sparkle.style.boxShadow = '0 0 10px #ffd700';
                sparkle.style.left = Math.random() * 100 + '%';
                sparkle.style.top = Math.random() * 100 + '%';
                sparkle.style.animation = 'sparkleFloat 2s forwards';
                sparkle.style.pointerEvents = 'none';
                sparkle.style.zIndex = '1';

                container.appendChild(sparkle);

                setTimeout(() => {
                    if (sparkle.parentNode) {
                        sparkle.parentNode.removeChild(sparkle);
                    }
                }, 2000);
            }

            // Start sparkle animation
            setInterval(createSparkle, 1000);

            // Add hover effects to table rows
            const tableRows = document.querySelectorAll('.table tbody tr');
            tableRows.forEach(row => {
                row.addEventListener('mouseenter', function () {
                    this.style.transform = 'translateX(5px)';
                });

                row.addEventListener('mouseleave', function () {
                    this.style.transform = 'translateX(0)';
                });
            });
        });
    </script>
@endsection