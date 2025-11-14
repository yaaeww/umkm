@extends('layouts.pembeli-navbar')

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

        .checkout-container {
            background: rgba(30, 30, 46, 0.7);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            overflow: hidden;
            padding: 2rem;
            backdrop-filter: blur(10px);
            margin-bottom: 2rem;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        }

        .page-title {
            background: linear-gradient(135deg, var(--gold) 0%, var(--gold-light) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: 700;
            font-size: 2.2rem;
            margin-bottom: 2rem;
            text-align: center;
        }

        .section-title {
            color: var(--gold);
            font-weight: 600;
            font-size: 1.3rem;
            margin-bottom: 1.5rem;
            padding-bottom: 0.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .product-card {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .product-card:hover {
            border-color: rgba(255, 215, 0, 0.3);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(255, 215, 0, 0.2);
        }

        .product-image {
            height: 200px;
            overflow: hidden;
        }

        .product-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .product-info {
            padding: 1.5rem;
        }

        .product-name {
            color: var(--gold);
            font-weight: 600;
            font-size: 1.2rem;
            margin-bottom: 0.75rem;
        }

        .product-description {
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.9rem;
            line-height: 1.5;
            margin-bottom: 1rem;
        }

        .price-info {
            margin-bottom: 0.5rem;
        }

        .price-original {
            text-decoration: line-through;
            color: rgba(255, 255, 255, 0.5);
            font-size: 0.9rem;
            margin-right: 0.5rem;
        }

        .price-discounted {
            color: var(--success-color);
            font-weight: 600;
            font-size: 1.1rem;
        }

        .price-normal {
            color: rgba(255, 255, 255, 0.9);
            font-weight: 600;
            font-size: 1.1rem;
        }

        .quantity-info {
            color: rgba(255, 255, 255, 0.8);
            margin-bottom: 0.5rem;
        }

        .total-price {
            color: var(--gold-light);
            font-weight: 700;
            font-size: 1.3rem;
            margin-top: 1rem;
            padding-top: 1rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .form-container {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            padding: 2rem;
            height: 100%;
        }

        .form-label {
            color: var(--gold);
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .form-control {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 8px;
            color: rgba(255, 255, 255, 0.9);
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            background: rgba(255, 255, 255, 0.08);
            border-color: var(--gold);
            color: rgba(255, 255, 255, 0.9);
            box-shadow: 0 0 0 2px rgba(255, 215, 0, 0.2);
            outline: none;
        }

        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }

        textarea.form-control {
            resize: vertical;
            min-height: 100px;
        }

        .alert {
            background: rgba(220, 53, 69, 0.2);
            border: 1px solid rgba(220, 53, 69, 0.5);
            border-radius: 12px;
            padding: 1rem 1.5rem;
            margin-bottom: 1.5rem;
            color: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
        }

        .alert-dismissible .btn-close {
            filter: invert(1);
        }

        .btn {
            border: none;
            border-radius: 8px;
            padding: 1rem 2rem;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            cursor: pointer;
            width: 100%;
            font-size: 1.1rem;
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

        /* Responsive Design */
        @media (max-width: 768px) {
            .container {
                padding-top: 70px;
            }

            .page-title {
                font-size: 1.8rem;
            }

            .checkout-container {
                padding: 1.5rem;
            }

            .form-container {
                padding: 1.5rem;
            }

            .product-image {
                height: 150px;
            }

            .product-info {
                padding: 1rem;
            }
        }

        @media (max-width: 576px) {
            .container {
                padding-top: 60px;
            }

            .page-title {
                font-size: 1.6rem;
            }

            .checkout-container {
                padding: 1rem;
            }

            .form-container {
                padding: 1rem;
            }
        }
    </style>

    <div class="container">
        <!-- Page Header -->
        <h1 class="page-title">
            <i class="fas fa-shopping-bag me-2"></i>Checkout Pesanan
        </h1>

        @if(session('error'))
            <div class="alert alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="checkout-container">
            <div class="row g-4">
                {{-- Kolom Gambar dan Info Produk --}}
                <div class="col-lg-5">
                    <h3 class="section-title">
                        <i class="fas fa-box me-2"></i>Detail Produk
                    </h3>

                    <div class="product-card">
                        <div class="product-image">
                            @if ($produk->gambar)
                                <img src="{{ asset('storage/' . $produk->gambar) }}" alt="{{ $produk->nama }}">
                            @else
                                <img src="{{ asset('images/default.jpg') }}" alt="Default Image">
                            @endif
                        </div>

                        <div class="product-info">
                            <h4 class="product-name">{{ $produk->nama }}</h4>
                            <p class="product-description">{{ $produk->deskripsi }}</p>

                            <div class="price-info">
                                @if($harga_diskon < $produk->harga)
                                    <span class="price-original">
                                        Rp{{ number_format($produk->harga, 0, ',', '.') }}
                                    </span>
                                    <span class="price-discounted">
                                        Rp{{ number_format($harga_diskon, 0, ',', '.') }}
                                    </span>
                                @else
                                    <span class="price-normal">
                                        Rp{{ number_format($produk->harga, 0, ',', '.') }}
                                    </span>
                                @endif
                            </div>

                            <div class="quantity-info">
                                <i class="fas fa-cube me-2"></i>Jumlah: {{ $quantity }}
                            </div>

                            <div class="total-price">
                                <i class="fas fa-receipt me-2"></i>
                                Total: Rp{{ number_format($total_harga, 0, ',', '.') }}
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Kolom Form Pemesanan --}}
                <div class="col-lg-7">
                    <div class="form-container">
                        <h3 class="section-title">
                            <i class="fas fa-user-edit me-2"></i>Data Pemesanan
                        </h3>

                        <form action="{{ route('pembeli.checkout') }}" method="POST">
                            @csrf
                            <input type="hidden" name="produk_id" value="{{ $produk->id }}">
                            <input type="hidden" name="jumlah" value="{{ $quantity }}">

                            <div class="mb-4">
                                <label class="form-label">
                                    <i class="fas fa-user me-2"></i>Nama Lengkap
                                </label>
                                <input type="text" name="name" class="form-control"
                                    placeholder="Masukkan Nama Lengkap Anda!" required value="{{ old('name') }}">
                            </div>

                            <div class="mb-4">
                                <label class="form-label">
                                    <i class="fas fa-phone me-2"></i>Nomor HP
                                </label>
                                <input type="text" name="phone" class="form-control" placeholder="Masukkan Nomor HP/WA!"
                                    required value="{{ old('phone') }}">
                            </div>

                            <div class="mb-4">
                                <label class="form-label">
                                    <i class="fas fa-map-marker-alt me-2"></i>Alamat Pengiriman
                                </label>
                                <textarea name="alamat" class="form-control" rows="4"
                                    placeholder="Masukkan Alamat Lengkap Anda!" required>{{ old('alamat') }}</textarea>
                            </div>

                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-credit-card me-2"></i>Pesan Sekarang
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection