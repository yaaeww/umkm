@extends('layouts.pembeli-navbar')
@section('title', 'Pesanan Dikirim & Diterima')

@section('content')
    @php use App\Models\Ulasan; @endphp

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

        .section-title {
            background: linear-gradient(135deg, var(--gold) 0%, var(--gold-light) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: 600;
            font-size: 1.5rem;
            margin: 2.5rem 0 1.5rem 0;
            padding-bottom: 0.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .order-card {
            background: rgba(30, 30, 46, 0.7);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            overflow: hidden;
            padding: 2rem;
            backdrop-filter: blur(10px);
            margin-bottom: 2rem;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
            transition: all 0.3s ease;
        }

        .order-card:hover {
            border-color: rgba(255, 215, 0, 0.3);
            transform: translateY(-2px);
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.4);
        }

        .order-card.delivered {
            border-left: 4px solid var(--success-color);
        }

        .order-card.shipping {
            border-left: 4px solid var(--info-color);
        }

        .order-info {
            margin-bottom: 1.5rem;
        }

        .info-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75rem 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .info-item:last-child {
            border-bottom: none;
        }

        .info-label {
            color: var(--gold);
            font-weight: 600;
            font-size: 0.9rem;
        }

        .info-value {
            color: rgba(255, 255, 255, 0.9);
            font-weight: 500;
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

        .badge-primary {
            background: linear-gradient(135deg, var(--info-color), #138496);
            color: white;
        }

        .badge-success {
            background: linear-gradient(135deg, var(--success-color), #1e7e34);
            color: white;
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

        .btn-success {
            background: linear-gradient(135deg, var(--success-color), #1e7e34);
            color: white;
        }

        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(40, 167, 69, 0.4);
            background: linear-gradient(135deg, #1e7e34, var(--success-color));
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

        .product-item {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 1rem;
        }

        .product-name {
            color: var(--gold);
            font-weight: 600;
            font-size: 1.1rem;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .rating-form {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 12px;
            padding: 1.5rem;
            margin-top: 1rem;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .form-label {
            color: var(--gold);
            font-weight: 600;
            margin-bottom: 0.5rem;
            display: block;
        }

        .form-control,
        .form-select {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 8px;
            color: rgba(255, 255, 255, 0.9);
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
            width: 100%;
        }

        .form-control:focus,
        .form-select:focus {
            background: rgba(255, 255, 255, 0.08);
            border-color: var(--gold);
            color: rgba(255, 255, 255, 0.9);
            box-shadow: 0 0 0 3px rgba(255, 215, 0, 0.1);
            outline: none;
        }

        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.5);
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

        .alert {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            padding: 1rem 1.5rem;
            margin-bottom: 1rem;
            color: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
        }

        .alert-info {
            border-color: rgba(23, 162, 184, 0.5);
            background: rgba(23, 162, 184, 0.1);
        }

        .alert-success {
            border-color: rgba(40, 167, 69, 0.5);
            background: rgba(40, 167, 69, 0.1);
        }

        .alert-warning {
            border-color: rgba(255, 193, 7, 0.5);
            background: rgba(255, 193, 7, 0.1);
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

        .section-divider {
            height: 2px;
            background: linear-gradient(90deg, transparent, var(--gold), transparent);
            margin: 3rem 0;
            border: none;
        }

        /* Star Rating */
        .star-rating {
            display: flex;
            gap: 0.25rem;
            margin-bottom: 1rem;
        }

        .star-rating input {
            display: none;
        }

        .star-rating label {
            font-size: 1.5rem;
            color: rgba(255, 255, 255, 0.3);
            cursor: pointer;
            transition: color 0.3s ease;
        }

        .star-rating input:checked~label,
        .star-rating label:hover,
        .star-rating label:hover~label {
            color: var(--gold);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .container {
                padding-top: 70px;
            }

            .page-title {
                font-size: 1.8rem;
            }

            .section-title {
                font-size: 1.3rem;
            }

            .order-card {
                padding: 1.5rem;
            }

            .info-item {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.25rem;
            }

            .btn {
                width: 100%;
                justify-content: center;
            }
        }

        @media (max-width: 576px) {
            .container {
                padding-top: 60px;
            }

            .page-title {
                font-size: 1.6rem;
            }

            .section-title {
                font-size: 1.2rem;
            }

            .order-card {
                padding: 1rem;
            }

            .product-item {
                padding: 1rem;
            }

            .rating-form {
                padding: 1rem;
            }
        }
    </style>

    <div class="container">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-title">
                <i class="fas fa-truck me-2"></i>Pesanan Dikirim & Diterima
            </h1>
        </div>

        @php
            $dikirimOrders = $orders->where('status_pesanan', 'dikirim');
            $diterimaOrders = $orders->where('status_pesanan', 'diterima');
        @endphp

        <!-- Pesanan Sedang Dikirim -->
        <h3 class="section-title">
            <i class="fas fa-shipping-fast me-2"></i>Pesanan Sedang Dikirim
        </h3>

        @if($dikirimOrders->count())
            @foreach($dikirimOrders as $order)
                <div class="order-card shipping">
                    <div class="order-info">
                        <div class="info-item">
                            <span class="info-label">Nomor Pesanan</span>
                            <span class="info-value">{{ $order->invoice ?? 'INV-' . $order->id }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Status</span>
                            <span class="badge badge-primary">
                                <i class="fas fa-truck me-1"></i>{{ ucfirst($order->status_pesanan) }}
                            </span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Total</span>
                            <span class="info-value">Rp{{ number_format($order->total_harga, 0, ',', '.') }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Tanggal</span>
                            <span class="info-value">{{ $order->created_at->format('d-m-Y') }}</span>
                        </div>
                    </div>

                    <form action="{{ route('pembeli.pesanan.updateStatus', $order->id) }}" method="POST"
                        onsubmit="return confirm('Yakin ingin mengonfirmasi pesanan ini sudah diterima?')">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-check-circle me-2"></i>Konfirmasi Diterima
                        </button>
                    </form>
                </div>
            @endforeach
        @else
            <div class="empty-state">
                <div class="empty-state-icon">
                    <i class="fas fa-truck-loading"></i>
                </div>
                <h5>Tidak ada pesanan yang sedang dikirim</h5>
                <p>Belum ada pesanan yang sedang dalam proses pengiriman.</p>
            </div>
        @endif

        <hr class="section-divider">

        <!-- Pesanan Diterima -->
        <h3 class="section-title">
            <i class="fas fa-check-circle me-2"></i>Pesanan Diterima
        </h3>

        @if($diterimaOrders->count())
            @foreach($diterimaOrders as $order)
                <div class="order-card delivered">
                    <div class="order-info">
                        <div class="info-item">
                            <span class="info-label">Nomor Pesanan</span>
                            <span class="info-value">{{ $order->invoice ?? 'INV-' . $order->id }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Status</span>
                            <span class="badge badge-success">
                                <i class="fas fa-check me-1"></i>{{ ucfirst($order->status_pesanan) }}
                            </span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Total</span>
                            <span class="info-value">Rp{{ number_format($order->total_harga, 0, ',', '.') }}</span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Tanggal Diterima</span>
                            <span class="info-value">{{ $order->updated_at->format('d-m-Y H:i') }}</span>
                        </div>
                    </div>

                    <div class="mt-4">
                        <h6 class="text-gold mb-3">
                            <i class="fas fa-box me-2"></i>Produk dalam Pesanan
                        </h6>

                        @if($order->produks && $order->produks->count())
                            @foreach($order->produks as $produk)
                                @php
                                    $sudahDinilai = Ulasan::where('users_id', auth()->id())
                                        ->where('orders_id', $order->id)
                                        ->where('produks_id', $produk->id)
                                        ->exists();
                                @endphp

                                <div class="product-item">
                                    <div class="product-name">
                                        <i class="fas fa-box-open"></i>{{ $produk->nama }}
                                    </div>

                                    @if(!$sudahDinilai)
                                        <div class="rating-form">
                                            <form action="{{ route('pembeli.rating.store') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="orders_id" value="{{ $order->id }}">
                                                <input type="hidden" name="produks_id" value="{{ $produk->id }}">

                                                <div class="mb-3">
                                                    <label class="form-label">Rating Produk</label>
                                                    <div class="star-rating">
                                                        @for($i = 5; $i >= 1; $i--)
                                                            <input type="radio" id="star{{ $i }}-{{ $produk->id }}" name="bintang" value="{{ $i }}"
                                                                required>
                                                            <label for="star{{ $i }}-{{ $produk->id }}">★</label>
                                                        @endfor
                                                    </div>
                                                </div>

                                                <div class="mb-3">
                                                    <label class="form-label">Ulasan</label>
                                                    <textarea name="ulasan" class="form-control" rows="3" required
                                                        placeholder="Bagikan pengalaman Anda menggunakan produk ini..."></textarea>
                                                </div>

                                                <button type="submit" class="btn btn-primary">
                                                    <i class="fas fa-paper-plane me-2"></i>Kirim Ulasan
                                                </button>
                                            </form>
                                        </div>
                                    @else
                                        <div class="alert alert-success">
                                            <i class="fas fa-check-circle me-2"></i>
                                            Anda sudah memberikan ulasan untuk produk ini.
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        @else
                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                Tidak ada produk terkait dengan pesanan ini.
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        @else
            <div class="empty-state">
                <div class="empty-state-icon">
                    <i class="fas fa-clipboard-check"></i>
                </div>
                <h5>Tidak ada pesanan yang sudah diterima</h5>
                <p>Belum ada pesanan yang telah Anda konfirmasi sebagai diterima.</p>
            </div>
        @endif

        <div class="text-center mt-4">
            <a href="{{ route('pembeli.profile.show') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i>Kembali ke Profil
            </a>
        </div>
    </div>

    <script>
        // Star rating interaction
        document.addEventListener('DOMContentLoaded', function () {
            const starRatings = document.querySelectorAll('.star-rating');

            starRatings.forEach(rating => {
                const stars = rating.querySelectorAll('input[type="radio"]');
                const labels = rating.querySelectorAll('label');

                stars.forEach((star, index) => {
                    star.addEventListener('change', function () {
                        // Reset all stars
                        labels.forEach(label => {
                            label.style.color = 'rgba(255, 255, 255, 0.3)';
                        });

                        // Color stars up to the selected one
                        for (let i = 0; i <= index; i++) {
                            labels[4 - i].style.color = 'var(--gold)';
                        }
                    });
                });

                // Hover effect
                labels.forEach((label, index) => {
                    label.addEventListener('mouseenter', function () {
                        for (let i = 0; i <= index; i++) {
                            labels[4 - i].style.color = 'var(--gold)';
                        }
                    });

                    label.addEventListener('mouseleave', function () {
                        const checkedStar = rating.querySelector('input:checked');
                        if (checkedStar) {
                            const checkedIndex = Array.from(stars).indexOf(checkedStar);
                            for (let i = 0; i <= checkedIndex; i++) {
                                labels[4 - i].style.color = 'var(--gold)';
                            }
                            for (let i = checkedIndex + 1; i < 5; i++) {
                                labels[4 - i].style.color = 'rgba(255, 255, 255, 0.3)';
                            }
                        } else {
                            labels.forEach(l => {
                                l.style.color = 'rgba(255, 255, 255, 0.3)';
                            });
                        }
                    });
                });
            });
        });
    </script>
@endsection