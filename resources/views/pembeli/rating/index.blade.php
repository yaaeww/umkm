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

        .ratings-container {
            background: rgba(30, 30, 46, 0.7);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            overflow: hidden;
            padding: 2rem;
            backdrop-filter: blur(10px);
            margin-bottom: 2rem;
        }

        .ratings-table {
            width: 100%;
            border-collapse: collapse;
            color: rgba(255, 255, 255, 0.9);
        }

        .ratings-table thead {
            background: rgba(255, 215, 0, 0.1);
            border-bottom: 2px solid rgba(255, 215, 0, 0.3);
        }

        .ratings-table th {
            color: var(--gold);
            font-weight: 600;
            padding: 1rem 0.75rem;
            text-align: left;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .ratings-table td {
            padding: 1rem 0.75rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            vertical-align: middle;
        }

        .ratings-table tbody tr {
            transition: all 0.3s ease;
        }

        .ratings-table tbody tr:hover {
            background: rgba(255, 255, 255, 0.05);
        }

        .ratings-table tbody tr:last-child td {
            border-bottom: none;
        }

        .badge {
            padding: 0.4rem 0.75rem;
            border-radius: 6px;
            font-weight: 600;
            font-size: 0.75rem;
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
        }

        .badge-success {
            background: linear-gradient(135deg, var(--success-color), #1e7e34);
            color: white;
        }

        .badge-warning {
            background: linear-gradient(135deg, var(--warning-color), #e0a800);
            color: #000;
        }

        .rating-stars {
            color: var(--gold);
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        .review-text {
            color: rgba(255, 255, 255, 0.8);
            line-height: 1.5;
            max-width: 300px;
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }

        .btn {
            border: none;
            border-radius: 8px;
            padding: 0.5rem 1rem;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            cursor: pointer;
            font-size: 0.85rem;
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

        .alert {
            background: rgba(23, 162, 184, 0.1);
            border: 1px solid rgba(23, 162, 184, 0.5);
            border-radius: 12px;
            padding: 1rem 1.5rem;
            margin-bottom: 1.5rem;
            color: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .alert i {
            color: var(--info-color);
            font-size: 1.25rem;
        }

        /* Responsive Design */
        @media (max-width: 992px) {
            .ratings-table {
                display: block;
                overflow-x: auto;
            }

            .ratings-table thead {
                display: none;
            }

            .ratings-table tbody,
            .ratings-table tr,
            .ratings-table td {
                display: block;
                width: 100%;
            }

            .ratings-table tr {
                margin-bottom: 1rem;
                border: 1px solid rgba(255, 255, 255, 0.1);
                border-radius: 12px;
                overflow: hidden;
                background: rgba(255, 255, 255, 0.05);
                padding: 1rem;
            }

            .ratings-table td {
                padding: 0.75rem;
                border-bottom: 1px solid rgba(255, 255, 255, 0.05);
                position: relative;
                padding-left: 50%;
            }

            .ratings-table td:before {
                content: attr(data-label);
                position: absolute;
                left: 0.75rem;
                width: 45%;
                padding-right: 0.5rem;
                font-weight: 600;
                color: var(--gold);
            }
        }

        @media (max-width: 768px) {
            .container {
                padding-top: 70px;
            }

            .page-title {
                font-size: 1.8rem;
            }

            .ratings-container {
                padding: 1.5rem;
            }

            .section-title {
                font-size: 1.3rem;
            }
        }

        @media (max-width: 576px) {
            .container {
                padding-top: 60px;
            }

            .page-title {
                font-size: 1.6rem;
            }

            .ratings-container {
                padding: 1rem;
            }

            .section-title {
                font-size: 1.2rem;
            }

            .ratings-table td {
                padding-left: 40%;
            }

            .ratings-table td:before {
                width: 35%;
            }
        }
    </style>

    <div class="container">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-title">
                <i class="fas fa-star me-2"></i>Rating dan Ulasan Saya
            </h1>
        </div>

        <div class="ratings-container">
            {{-- Produk Belum Dinilai --}}
            <h3 class="section-title">
                <i class="fas fa-clock me-2"></i>Belum Dinilai
            </h3>

            @if(empty($produkBelumDinilai) || count($produkBelumDinilai) === 0)
                <div class="empty-state">
                    <div class="empty-state-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <h5>Tidak ada pesanan yang belum dinilai</h5>
                    <p>Semua pesanan dengan status diterima telah Anda beri rating.</p>
                </div>
            @else
                <table class="ratings-table">
                    <thead>
                        <tr>
                            <th data-label="Nomor Pesanan">Nomor Pesanan</th>
                            <th data-label="Produk">Produk</th>
                            <th data-label="Status Pesanan">Status Pesanan</th>
                            <th data-label="Aksi">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($produkBelumDinilai as $item)
                            @php
                                $order = $item->order;
                                $produk = $item->produk;
                            @endphp
                            <tr>
                                <td data-label="Nomor Pesanan">
                                    <strong>{{ $order->invoice ?? 'INV-' . $order->id }}</strong>
                                </td>
                                <td data-label="Produk">
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="fas fa-cube text-gold"></i>
                                        {{ $produk->nama ?? '-' }}
                                    </div>
                                </td>
                                <td data-label="Status Pesanan">
                                    <span class="badge badge-warning">
                                        <i class="fas fa-clock me-1"></i>
                                        {{ ucfirst(str_replace('_', ' ', $order->status_pesanan ?? 'Unknown')) }}
                                    </span>
                                </td>
                                <td data-label="Aksi">
                                    <a href="{{ route('pembeli.rating.create', ['order' => $order->id, 'product' => $produk->id]) }}"
                                        class="btn btn-primary">
                                        <i class="fas fa-edit me-1"></i>Beri Ulasan
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif

            {{-- Produk Sudah Dinilai --}}
            <h3 class="section-title">
                <i class="fas fa-check-circle me-2"></i>Sudah Dinilai
            </h3>

            @if(empty($produkSudahDinilai) || count($produkSudahDinilai) === 0)
                <div class="empty-state">
                    <div class="empty-state-icon">
                        <i class="fas fa-star"></i>
                    </div>
                    <h5>Belum ada ulasan yang diberikan</h5>
                    <p>Rating dan ulasan yang Anda berikan akan muncul di sini.</p>
                </div>
            @else
                <table class="ratings-table">
                    <thead>
                        <tr>
                            <th data-label="Nomor Pesanan">Nomor Pesanan</th>
                            <th data-label="Produk">Produk</th>
                            <th data-label="Rating">Rating</th>
                            <th data-label="Ulasan">Ulasan</th>
                            <th data-label="Tanggal">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($produkSudahDinilai as $ulasan)
                            @php
                                $produk = $ulasan->produk;
                                $order = $ulasan->order;
                            @endphp
                            <tr>
                                <td data-label="Nomor Pesanan">
                                    <strong>{{ $order->invoice ?? 'INV-' . $order->id }}</strong>
                                </td>
                                <td data-label="Produk">
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="fas fa-cube text-gold"></i>
                                        {{ $produk->nama ?? '-' }}
                                    </div>
                                </td>
                                <td data-label="Rating">
                                    <div class="rating-stars">
                                        <i class="fas fa-star"></i>
                                        <span>{{ $ulasan->bintang }}/5</span>
                                    </div>
                                </td>
                                <td data-label="Ulasan">
                                    <div class="review-text">
                                        {{ $ulasan->ulasan }}
                                    </div>
                                </td>
                                <td data-label="Tanggal">
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="fas fa-calendar text-muted"></i>
                                        {{ $ulasan->created_at->format('d-m-Y') }}
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>

    <script>
        // Responsive table - add data labels for mobile view
        document.addEventListener('DOMContentLoaded', function () {
            if (window.innerWidth <= 992) {
                const tables = document.querySelectorAll('.ratings-table');

                tables.forEach(table => {
                    const headers = table.querySelectorAll('thead th');
                    const rows = table.querySelectorAll('tbody tr');

                    rows.forEach(row => {
                        const cells = row.querySelectorAll('td');
                        cells.forEach((cell, index) => {
                            if (headers[index]) {
                                cell.setAttribute('data-label', headers[index].textContent.trim());
                            }
                        });
                    });
                });
            }
        });
    </script>
@endsection