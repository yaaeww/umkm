@extends('layouts.pembeli-navbar')

@section('title', 'Profil Pembeli')

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
        }

        .profile-card {
            background: rgba(30, 30, 46, 0.7);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            overflow: hidden;
            padding: 2rem;
            backdrop-filter: blur(10px);
            margin-bottom: 2rem;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
            height: 100%;
        }

        .profile-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .profile-avatar {
            width: 140px;
            height: 140px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid var(--gold);
            box-shadow: 0 0 20px rgba(255, 215, 0, 0.3);
            margin-bottom: 1.5rem;
            transition: all 0.3s ease;
        }

        .profile-avatar:hover {
            transform: scale(1.05);
            box-shadow: 0 0 30px rgba(255, 215, 0, 0.5);
        }

        .profile-name {
            background: linear-gradient(135deg, var(--gold) 0%, var(--gold-light) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: 700;
            font-size: 1.75rem;
            margin-bottom: 0.5rem;
        }

        .profile-badge {
            display: inline-block;
            background: rgba(255, 215, 0, 0.1);
            color: var(--gold);
            padding: 0.4rem 1rem;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 600;
            border: 1px solid rgba(255, 215, 0, 0.3);
            margin-bottom: 1.5rem;
        }

        .profile-info {
            margin-bottom: 2rem;
        }

        .info-group {
            margin-bottom: 1.5rem;
            padding-bottom: 1.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .info-group:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }

        .info-label {
            color: var(--gold);
            font-weight: 600;
            font-size: 0.9rem;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .info-value {
            color: rgba(255, 255, 255, 0.9);
            font-size: 1rem;
            line-height: 1.5;
        }

        .info-value.empty {
            color: rgba(255, 255, 255, 0.5);
            font-style: italic;
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

        .orders-card {
            background: rgba(30, 30, 46, 0.7);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            overflow: hidden;
            backdrop-filter: blur(10px);
            margin-bottom: 2rem;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
            height: 100%;
        }

        .card-header {
            background: linear-gradient(135deg, var(--dark-blue) 0%, var(--medium-blue) 100%);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            padding: 1.5rem;
        }

        .card-title {
            color: var(--gold);
            font-weight: 600;
            font-size: 1.3rem;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .card-body {
            padding: 2rem;
        }

        .status-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .status-item {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            padding: 1.5rem;
            text-align: center;
            transition: all 0.3s ease;
            text-decoration: none;
            display: block;
        }

        .status-item:hover {
            background: rgba(255, 255, 255, 0.08);
            border-color: var(--gold);
            transform: translateY(-3px);
            box-shadow: 0 4px 12px rgba(255, 215, 0, 0.2);
            text-decoration: none;
        }

        .status-icon {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            display: block;
        }

        .status-icon.waiting {
            color: var(--warning-color);
        }

        .status-icon.packing {
            color: var(--info-color);
        }

        .status-icon.shipping {
            color: var(--accent-primary);
        }

        .status-icon.rating {
            color: var(--gold);
        }

        .status-label {
            color: rgba(255, 255, 255, 0.9);
            font-weight: 600;
            font-size: 1rem;
            margin-bottom: 0.5rem;
        }

        .status-description {
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.85rem;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .container {
                padding-top: 70px;
            }

            .profile-card,
            .orders-card {
                padding: 1.5rem;
            }

            .profile-avatar {
                width: 120px;
                height: 120px;
            }

            .status-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            .card-body {
                padding: 1.5rem;
            }
        }

        @media (max-width: 576px) {
            .container {
                padding-top: 60px;
            }

            .profile-card,
            .orders-card {
                padding: 1rem;
            }

            .profile-avatar {
                width: 100px;
                height: 100px;
            }

            .profile-name {
                font-size: 1.5rem;
            }

            .card-body {
                padding: 1rem;
            }
        }
    </style>

    <div class="container">
        <div class="row">
            <!-- PROFIL -->
            <div class="col-xl-4 col-lg-4 col-md-12 mb-4">
                <div class="profile-card">
                    <div class="profile-header">
                        @if(auth()->user()->avatar && Storage::disk('public')->exists(auth()->user()->avatar))
                            <img src="{{ asset('storage/' . auth()->user()->avatar) }}" class="profile-avatar" alt="Avatar">
                        @else
                            <img src="{{ asset('images/default-avatar.jpg') }}" class="profile-avatar" alt="Default Avatar">
                        @endif

                        <h1 class="profile-name">{{ auth()->user()->name }}</h1>
                        <span class="profile-badge">
                            <i class="fas fa-user me-1"></i>Pengguna
                        </span>
                    </div>

                    <div class="profile-info">
                        <div class="info-group">
                            <div class="info-label">
                                <i class="fas fa-envelope"></i>Email
                            </div>
                            <div class="info-value">{{ auth()->user()->email }}</div>
                        </div>

                        <!-- Menampilkan alamat dan telepon dari order terakhir -->
                        @if(auth()->user()->orders->count() > 0)
                            @php
                                $lastOrder = auth()->user()->orders->last();
                            @endphp
                            <div class="info-group">
                                <div class="info-label">
                                    <i class="fas fa-phone"></i>Telepon
                                </div>
                                <div class="info-value">{{ $lastOrder->phone ?? 'Tidak tersedia' }}</div>
                            </div>
                            <div class="info-group">
                                <div class="info-label">
                                    <i class="fas fa-map-marker-alt"></i>Alamat
                                </div>
                                <div class="info-value">{{ $lastOrder->alamat ?? 'Tidak tersedia' }}</div>
                            </div>
                        @else
                            <div class="info-group">
                                <div class="info-label">
                                    <i class="fas fa-phone"></i>Telepon
                                </div>
                                <div class="info-value empty">Tidak tersedia</div>
                            </div>
                            <div class="info-group">
                                <div class="info-label">
                                    <i class="fas fa-map-marker-alt"></i>Alamat
                                </div>
                                <div class="info-value empty">Tidak tersedia</div>
                            </div>
                        @endif
                    </div>

                    <div class="text-center">
                        <a href="{{ route('pembeli.profile.edit') }}" class="btn btn-primary">
                            <i class="fas fa-edit me-2"></i>Edit Profil
                        </a>
                    </div>
                </div>
            </div>

            <!-- PESANAN DAN STATUS -->
            <div class="col-xl-8 col-lg-8 col-md-12 mb-4">
                <div class="orders-card">
                    <div class="card-header">
                        <h2 class="card-title">
                            <i class="fas fa-shopping-bag"></i>Pesanan Saya
                        </h2>
                    </div>
                    <div class="card-body">
                        <!-- STATUS PESANAN -->
                        <div class="status-grid">
                            <a href="{{ route('pembeli.status.belum-bayar') }}" class="status-item">
                                <i class="status-icon waiting fas fa-credit-card"></i>
                                <div class="status-label">Belum Bayar</div>
                                <div class="status-description">Lihat pesanan yang belum dibayar</div>
                            </a>
                            <a href="{{ route('pembeli.status.dikemas') }}" class="status-item">
                                <i class="status-icon packing fas fa-cube"></i>
                                <div class="status-label">Dikemas</div>
                                <div class="status-description">Pesanan sedang dipersiapkan</div>
                            </a>
                            <a href="{{ route('pembeli.status.dikirim') }}" class="status-item">
                                <i class="status-icon shipping fas fa-truck"></i>
                                <div class="status-label">Dikirim</div>
                                <div class="status-description">Pesanan dalam pengiriman</div>
                            </a>
                            <a href="{{ route('pembeli.rating.index') }}" class="status-item">
                                <i class="status-icon rating fas fa-star"></i>
                                <div class="status-label">Beri Penilaian</div>
                                <div class="status-description">Beri rating untuk produk</div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection