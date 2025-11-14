@extends('layouts.app')

@section('page_title', 'Dashboard')

@section('title')
    <i class="bi bi-house-fill" style="color: var(--gold);"></i> Home Admin
@endsection

@push('style')
    <style>
        :root {
            --dark-blue: #0a1628;
            --medium-blue: #1a3a5f;
            --light-blue: #2a4a7f;
            --gold: #ffd700;
            --gold-light: #ffed4e;
            --gold-dark: #d4af37;
            --text-primary: #ffffff;
            --text-secondary: #a0aec0;
        }

        body {
            background: linear-gradient(135deg, var(--dark-blue) 0%, var(--medium-blue) 70%, var(--light-blue) 100%) !important;
            color: var(--text-primary);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        /* Card Styling */
        .card-box {
            background: linear-gradient(135deg, rgba(10, 22, 40, 0.95) 0%, rgba(26, 58, 95, 0.9) 100%) !important;
            border: 2px solid var(--gold);
            border-radius: 20px;
            box-shadow: 0 8px 32px rgba(255, 215, 0, 0.15);
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .card-box::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, transparent, var(--gold), transparent);
            animation: shimmer 3s infinite;
        }

        @keyframes shimmer {

            0%,
            100% {
                opacity: 0;
            }

            50% {
                opacity: 1;
            }
        }

        .card-box:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 40px rgba(255, 215, 0, 0.25);
            border-color: var(--gold-light);
        }

        /* Welcome Banner */
        .welcome-banner {
            background: linear-gradient(135deg, rgba(10, 22, 40, 0.95) 0%, rgba(26, 58, 95, 0.9) 100%);
            border: 2px solid var(--gold);
            border-radius: 20px;
            box-shadow: 0 8px 32px rgba(255, 215, 0, 0.15);
            backdrop-filter: blur(10px);
            position: relative;
            overflow: hidden;
        }

        .welcome-banner::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, transparent, var(--gold), transparent);
            animation: shimmer 3s infinite;
        }

        .banner-img {
            filter: drop-shadow(0 0 20px rgba(255, 215, 0, 0.3));
            border-radius: 15px;
            transition: transform 0.3s ease;
        }

        .banner-img:hover {
            transform: scale(1.05);
        }

        /* Widget Styling */
        .widget-style3 {
            background: linear-gradient(135deg, rgba(10, 22, 40, 0.95) 0%, rgba(26, 58, 95, 0.9) 100%) !important;
            border: 2px solid var(--gold);
            border-radius: 15px;
            box-shadow: 0 6px 25px rgba(255, 215, 0, 0.15);
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .widget-style3::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 1px;
            background: linear-gradient(90deg, transparent, var(--gold), transparent);
        }

        .widget-style3:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 30px rgba(255, 215, 0, 0.25);
        }

        /* Text Styling */
        .font-20 {
            font-size: 1.25rem !important;
            font-weight: 600;
        }

        .font-24 {
            font-size: 1.5rem !important;
            font-weight: 700;
        }

        .font-30 {
            font-size: 1.875rem !important;
            font-weight: 800;
        }

        .font-18 {
            font-size: 1.125rem !important;
        }

        .font-14 {
            font-size: 0.875rem !important;
        }

        .weight-500 {
            font-weight: 500 !important;
        }

        .weight-600 {
            font-weight: 600 !important;
        }

        .weight-700 {
            font-weight: 700 !important;
        }

        .text-blue {
            background: linear-gradient(135deg, var(--gold) 0%, var(--gold-light) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .text-dark {
            color: var(--text-primary) !important;
            background: linear-gradient(135deg, var(--gold) 0%, var(--gold-light) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .text-secondary {
            color: var(--text-secondary) !important;
        }

        /* Icon Styling */
        .widget-icon .icon {
            background: linear-gradient(135deg, var(--gold) 0%, var(--gold-light) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-size: 2.5rem;
            opacity: 0.9;
        }

        .icon-copy {
            background: linear-gradient(135deg, var(--gold) 0%, var(--gold-light) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Greeting Text */
        .greeting-text {
            background: linear-gradient(135deg, var(--gold) 0%, var(--gold-light) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: 700;
        }

        .user-name {
            background: linear-gradient(135deg, var(--gold) 0%, var(--gold-light) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: 800;
            text-shadow: 0 0 30px rgba(255, 215, 0, 0.3);
        }

        .welcome-message {
            color: var(--text-secondary);
            line-height: 1.6;
        }

        /* Sparkle Effect */
        .sparkle {
            position: absolute;
            width: 3px;
            height: 3px;
            background: var(--gold);
            border-radius: 50%;
            box-shadow: 0 0 10px var(--gold);
            animation: sparkleFloat 2s forwards;
            pointer-events: none;
            z-index: 1;
        }

        @keyframes sparkleFloat {

            0%,
            100% {
                transform: translateY(0) scale(1);
                opacity: 0;
            }

            50% {
                transform: translateY(-20px) scale(1.5);
                opacity: 1;
            }
        }

        /* Responsive Design */
        @media (max-width: 768px) {

            .card-box,
            .widget-style3 {
                margin-bottom: 1rem !important;
            }

            .font-30 {
                font-size: 1.5rem !important;
            }

            .font-24 {
                font-size: 1.25rem !important;
            }

            .banner-img {
                max-width: 200px;
                margin-bottom: 1rem;
            }
        }

        /* Grid Layout */
        .row {
            margin: 0 -10px;
        }

        .col-xl-3,
        .col-lg-3,
        .col-md-6 {
            padding: 0 10px;
        }

        /* Height adjustments */
        .height-100-p {
            height: auto !important;
            min-height: 200px;
        }

        .mb-30 {
            margin-bottom: 2rem !important;
        }

        .mb-20 {
            margin-bottom: 1.5rem !important;
        }

        .pb-10 {
            padding-bottom: 1rem !important;
        }

        .pd-20 {
            padding: 2rem !important;
        }

        /* Flex alignment */
        .d-flex {
            display: flex !important;
        }

        .flex-wrap {
            flex-wrap: wrap !important;
        }

        .align-items-center {
            align-items: center !important;
        }

        .text-capitalize {
            text-transform: capitalize !important;
        }

        .max-width-600 {
            max-width: 600px !important;
        }
    </style>
@endpush

@section('content')
    <div class="welcome-banner pd-20 height-100-p mb-30">
        <div class="row align-items-center">
            <div class="col-md-4">
                <img src="{{ asset('aset/admin.png') }}" alt="Admin Banner" class="banner-img"
                    style="max-width: 100%;">
            </div>
            <div class="col-md-8">
                @php
                    $time = now()->format('H');
                    if ($time < 12) {
                        $greeting = 'Selamat pagi';
                    } elseif ($time < 15) {
                        $greeting = 'Selamat siang';
                    } elseif ($time < 18) {
                        $greeting = 'Selamat sore';
                    } else {
                        $greeting = 'Selamat malam';
                    }
                @endphp

                <h4 class="font-20 weight-500 mb-3 text-capitalize greeting-text">
                    {{ $greeting }},
                </h4>
                <div class="weight-600 font-30 user-name mb-3">
                    {{ auth()->user()->name }}!
                </div>
                <p class="font-18 max-width-600 welcome-message">
                    @if(auth()->user()->isAdmin())
                        Selamat datang di dashboard Admin. Anda dapat mengelola seluruh sistem dari sini dengan mudah dan
                        efisien.
                    @elseif(auth()->user()->isPenjual())
                        Selamat berjualan! Pantau produk dan penjualan Anda di dashboard ini.
                    @else
                        Selamat berbelanja! Temukan produk terbaik untuk kebutuhan Anda.
                    @endif
                </p>
            </div>
        </div>
    </div>

    @php
        use App\Models\Produk;
        use App\Models\KategoriProduk;
        use App\Models\User;
        use App\Models\Umkm;
        use App\Models\Order;

        // Jumlah semua produk yang dimiliki UMKM
        $totalProduk = Produk::whereHas('umkm')->count();

        // Jumlah kategori produk
        $jumlahKategori = KategoriProduk::count();

        // Jumlah penjual yang sudah punya data di UMKM
        $totalPenjual = User::where('role', 'penjual')
            ->whereHas('umkm')
            ->count();

        // Ambil total harga dari semua order yang status-nya 'complete'
        $totalPendapatan = Order::where('status', 'complete')->sum('total_harga');
        $pendapatanAdmin = $totalPendapatan * 0.2;
    @endphp

    <div class="row pb-10">
        <div class="col-xl-3 col-lg-3 col-md-6 mb-20">
            <div class="card-box height-100-p widget-style3">
                <div class="d-flex flex-wrap">
                    <div class="widget-data flex-grow-1">
                        <div class="weight-700 font-24 text-dark">{{ number_format($totalProduk) }}</div>
                        <div class="font-14 text-secondary weight-500">Total Produk</div>
                    </div>
                    <div class="widget-icon">
                        <div class="icon">
                            <i class="fa fa-cubes"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-3 col-md-6 mb-20">
            <div class="card-box height-100-p widget-style3">
                <div class="d-flex flex-wrap">
                    <div class="widget-data flex-grow-1">
                        <div class="weight-700 font-24 text-dark">{{ number_format($jumlahKategori) }}</div>
                        <div class="font-14 text-secondary weight-500">Kategori Produk</div>
                    </div>
                    <div class="widget-icon">
                        <div class="icon">
                            <i class="fa fa-tags"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-3 col-md-6 mb-20">
            <div class="card-box height-100-p widget-style3">
                <div class="d-flex flex-wrap">
                    <div class="widget-data flex-grow-1">
                        <div class="weight-700 font-24 text-dark">{{ number_format($totalPenjual) }}</div>
                        <div class="font-14 text-secondary weight-500">Total Penjual</div>
                    </div>
                    <div class="widget-icon">
                        <div class="icon">
                            <i class="fa fa-users"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-3 col-md-6 mb-20">
            <div class="card-box height-100-p widget-style3">
                <div class="d-flex flex-wrap">
                    <div class="widget-data flex-grow-1">
                        <div class="weight-700 font-24 text-dark">
                            Rp {{ number_format($pendapatanAdmin, 0, ',', '.') }}
                        </div>
                        <div class="font-14 text-secondary weight-500">Pendapatan Admin</div>
                    </div>
                    <div class="widget-icon">
                        <div class="icon">
                            <i class="fa fa-money"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Sparkle animation for cards
            function createSparkle() {
                const cards = document.querySelectorAll('.card-box, .widget-style3');
                cards.forEach(card => {
                    if (Math.random() > 0.7) { // 30% chance to create sparkle
                        const sparkle = document.createElement('div');
                        sparkle.className = 'sparkle';
                        sparkle.style.left = Math.random() * 100 + '%';
                        sparkle.style.top = Math.random() * 100 + '%';
                        sparkle.style.animationDelay = Math.random() * 2 + 's';

                        card.appendChild(sparkle);

                        setTimeout(() => {
                            if (sparkle.parentNode) {
                                sparkle.parentNode.removeChild(sparkle);
                            }
                        }, 2000);
                    }
                });
            }

            // Create sparkles every second
            setInterval(createSparkle, 1000);

            // Initial sparkles
            createSparkle();
        });
    </script>
@endpush