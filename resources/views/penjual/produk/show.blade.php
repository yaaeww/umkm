@extends('layouts.app')

@section('page_title', 'Detail Produk')

@section('title')
    <i class="fas fa-eye me-2"></i> Detail Produk
@endsection

@section('content')
    <style>
        .product-detail-container {
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

        .text-gold-light {
            color: var(--gold-light) !important;
        }

        .product-image {
            max-width: 100%;
            height: 400px;
            object-fit: cover;
            border: 3px solid rgba(255, 215, 0, 0.3);
            border-radius: 12px;
            padding: 5px;
            background: rgba(26, 58, 95, 0.6);
        }

        .product-info-card {
            background: linear-gradient(135deg, rgba(26, 58, 95, 0.6) 0%, rgba(42, 74, 127, 0.7) 100%);
            border: 2px solid rgba(255, 215, 0, 0.2);
            border-radius: 12px;
            padding: 25px;
            backdrop-filter: blur(10px);
            height: 100%;
        }

        .product-title {
            font-size: 2rem;
            font-weight: 700;
            background: linear-gradient(135deg, var(--gold) 0%, var(--gold-light) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 20px;
        }

        .info-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .info-list li {
            padding: 12px 0;
            border-bottom: 1px solid rgba(255, 215, 0, 0.2);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .info-list li:last-child {
            border-bottom: none;
        }

        .info-label {
            font-weight: 600;
            color: var(--gold);
            min-width: 150px;
        }

        .info-value {
            color: #e0e0e0;
            text-align: right;
            flex: 1;
        }

        .discount-badge {
            background: linear-gradient(135deg, #dc3545, #e83e8c);
            color: white;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 600;
            margin-left: 10px;
        }

        .description-box {
            background: rgba(26, 58, 95, 0.4);
            border: 1px solid rgba(255, 215, 0, 0.2);
            border-radius: 8px;
            padding: 20px;
            margin-top: 20px;
        }

        .reviews-section {
            background: linear-gradient(135deg, rgba(26, 58, 95, 0.6) 0%, rgba(42, 74, 127, 0.7) 100%);
            border: 2px solid rgba(255, 215, 0, 0.2);
            border-radius: 12px;
            padding: 25px;
            backdrop-filter: blur(10px);
            margin-top: 30px;
        }

        .section-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--gold);
            margin-bottom: 20px;
            border-bottom: 2px solid rgba(255, 215, 0, 0.3);
            padding-bottom: 10px;
        }

        .review-card {
            background: rgba(10, 22, 40, 0.6);
            border: 1px solid rgba(255, 215, 0, 0.2);
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 15px;
            transition: all 0.3s ease;
        }

        .review-card:hover {
            border-color: rgba(255, 215, 0, 0.4);
            transform: translateX(5px);
        }

        

        .rating-stars {
            color: var(--gold);
            margin-bottom: 8px;
        }

        .review-date {
            color: #c0c0c0;
            font-size: 0.85rem;
        }

        .action-buttons {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid rgba(255, 215, 0, 0.2);
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }

        .btn-warning {
            background: linear-gradient(135deg, var(--gold) 0%, var(--gold-light) 100%);
            border: none;
            color: var(--dark-blue);
            font-weight: 700;
            padding: 12px 25px;
            border-radius: 8px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(255, 215, 0, 0.3);
        }

        .btn-warning:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(255, 215, 0, 0.5);
            color: var(--dark-blue);
        }

        .btn-danger {
            background: linear-gradient(135deg, #dc3545, #e83e8c);
            border: none;
            color: white;
            font-weight: 700;
            padding: 12px 25px;
            border-radius: 8px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(220, 53, 69, 0.3);
        }

        .btn-danger:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(220, 53, 69, 0.5);
            color: white;
        }

        .btn-secondary {
            background: linear-gradient(135deg, #6c757d, #868e96);
            border: none;
            color: white;
            font-weight: 700;
            padding: 12px 25px;
            border-radius: 8px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(108, 117, 125, 0.3);
        }

        .btn-secondary:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(108, 117, 125, 0.5);
            color: white;
        }

        .no-reviews {
            text-align: center;
            padding: 40px 20px;
            color: #c0c0c0;
        }

        .no-reviews i {
            font-size: 3rem;
            color: rgba(255, 215, 0, 0.3);
            margin-bottom: 15px;
        }

        /* Mobile responsiveness */
        @media (max-width: 768px) {
            .product-detail-container {
                padding: 20px 15px;
            }

            .product-title {
                font-size: 1.5rem;
            }

            .info-list li {
                flex-direction: column;
                align-items: flex-start;
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

            .btn-warning,
            .btn-danger,
            .btn-secondary {
                width: 100%;
                text-align: center;
            }

            .product-image {
                height: 300px;
            }
        }
    </style>

    <div class="container">
        <h2 class="section-title text-center mb-4"><i class="fas fa-eye me-3"></i>Detail Produk</h2>

        <div class="product-detail-container">
            <div class="row">
                {{-- Gambar Produk --}}
                <div class="col-lg-5 col-md-6 mb-4">
                    <div class="text-center">
                        @if($produk->gambar)
                            <img src="{{ asset('storage/' . $produk->gambar) }}" alt="{{ $produk->nama }}"
                                class="product-image">
                        @else
                            <div class="product-image d-flex align-items-center justify-content-center">
                                <i class="fas fa-image fa-5x text-gold" style="opacity: 0.5;"></i>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Informasi Produk --}}
                <div class="col-lg-7 col-md-6">
                    <div class="product-info-card">
                        <h1 class="product-title">{{ $produk->nama }}</h1>

                        <ul class="info-list">
                            <li>
                                <span class="info-label"><i class="fas fa-tags me-2"></i>Kategori:</span>
                                <span class="info-value">{{ $produk->kategoriProduk->nama ?? '-' }}</span>
                            </li>

                            @php
                                $hargaSetelahDiskon = $produk->harga;
                                $diskon = $produk->diskon;
                                $today = \Carbon\Carbon::now();

                                if ($diskon && $today->between($diskon->tanggal_mulai, $diskon->tanggal_berakhir)) {
                                    $hargaSetelahDiskon = round($produk->harga * (1 - ($diskon->persen_diskon / 100)), 2);
                                }
                            @endphp

                            <li>
                                <span class="info-label"><i class="fas fa-tag me-2"></i>Harga Normal:</span>
                                <span class="info-value">Rp{{ number_format($produk->harga, 0, ',', '.') }}</span>
                            </li>

                            @if ($hargaSetelahDiskon < $produk->harga)
                                <li>
                                    <span class="info-label"><i class="fas fa-percentage me-2"></i>Harga Diskon:</span>
                                    <span class="info-value">
                                        <span
                                            class="text-danger fw-bold">Rp{{ number_format($hargaSetelahDiskon, 0, ',', '.') }}</span>
                                        <span class="discount-badge">{{ $diskon->persen_diskon }}% OFF</span>
                                    </span>
                                </li>
                                <li>
                                    <span class="info-label"><i class="fas fa-calendar me-2"></i>Periode Diskon:</span>
                                    <span class="info-value">
                                        {{ \Carbon\Carbon::parse($diskon->tanggal_mulai)->format('d M Y') }} -
                                        {{ \Carbon\Carbon::parse($diskon->tanggal_berakhir)->format('d M Y') }}
                                    </span>
                                </li>
                            @endif

                            <li>
                                <span class="info-label"><i class="fas fa-box me-2"></i>Stok Tersedia:</span>
                                <span class="info-value">{{ $produk->stok }} unit</span>
                            </li>

                            <li>
                                <span class="info-label"><i class="fas fa-star me-2"></i>Rating:</span>
                                <span class="info-value">
                                    <span class="rating-stars">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <i class="fas fa-star{{ $i <= ($produk->rating ?? 0) ? '' : '-half-alt' }}"></i>
                                        @endfor
                                    </span>
                                    {{ number_format($produk->rating ?? 0, 1) }} / 5
                                </span>
                            </li>

                            <li>
                                <span class="info-label"><i class="fas fa-eye me-2"></i>Dilihat:</span>
                                <span class="info-value">{{ $produk->views ?? 0 }} kali</span>
                            </li>
                        </ul>

                        <div class="description-box">
                            <h5 class="text-gold mb-3"><i class="fas fa-align-left me-2"></i>Deskripsi Produk</h5>
                            <p class="text-theme mb-0" style="line-height: 1.6;">
                                {{ $produk->deskripsi ?? 'Tidak ada deskripsi untuk produk ini.' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Ulasan Produk --}}
            <div class="reviews-section">
                <h3 class="section-title"><i class="fas fa-comments me-2"></i>Ulasan Pelanggan</h3>

                @if($ulasan->count())
                    <div class="reviews-list">
                        @foreach($ulasan as $u)
                            <div class="review-card">
                                <div class="d-flex align-items-start">
                                    <div class="user-avatar">
                                        {{ strtoupper(substr($u->user->name ?? 'U', 0, 1)) }}
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <h6 class="text-gold mb-0">{{ $u->user->name ?? 'Pelanggan' }}</h6>
                                            <span class="review-date">
                                                <i class="fas fa-clock me-1"></i>
                                                {{ $u->created_at->format('d M Y H:i') }}
                                            </span>
                                        </div>

                                        <div class="rating-stars mb-2">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <i class="fas fa-star{{ $i <= $u->bintang ? '' : '-half-alt' }}"></i>
                                            @endfor
                                            <span class="ms-2 text-theme">({{ $u->bintang }}/5)</span>
                                        </div>

                                        <p class="text-theme mb-0" style="line-height: 1.5;">
                                            {{ $u->ulasan ?? 'Tidak ada ulasan teks.' }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="no-reviews">
                        <i class="fas fa-comment-slash"></i>
                        <h5 class="text-gold mb-2">Belum Ada Ulasan</h5>
                        <p class="text-theme">Produk ini belum memiliki ulasan dari pelanggan.</p>
                    </div>
                @endif
            </div>

            {{-- Aksi Edit dan Hapus --}}
            <div class="action-buttons">
                <a href="{{ route('penjual.produk.edit', $produk->id) }}" class="btn btn-warning">
                    <i class="fas fa-edit me-2"></i> Edit Produk
                </a>
                <form action="{{ route('penjual.produk.destroy', $produk->id) }}" method="POST"
                    onsubmit="return confirm('Yakin ingin menghapus produk {{ $produk->nama }}?');" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash me-2"></i> Hapus Produk
                    </button>
                </form>
                <a href="{{ route('penjual.produk.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i> Kembali ke Daftar
                </a>
            </div>
        </div>
    </div>

    <script>
        // Konfirmasi sebelum menghapus produk
        document.addEventListener('DOMContentLoaded', function () {
            const deleteForm = document.querySelector('form[action*="destroy"]');
            if (deleteForm) {
                deleteForm.addEventListener('submit', function (e) {
                    const productName = '{{ $produk->nama }}';
                    if (!confirm(`Apakah Anda yakin ingin menghapus produk "${productName}"? Tindakan ini tidak dapat dibatalkan.`)) {
                        e.preventDefault();
                    }
                });
            }
        });
    </script>
@endsection