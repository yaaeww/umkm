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

        .page-subtitle {
            color: rgba(255, 255, 255, 0.8);
            font-size: 1.1rem;
            margin-bottom: 0;
        }

        .orders-container {
            background: rgba(30, 30, 46, 0.7);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            overflow: hidden;
            padding: 2rem;
            backdrop-filter: blur(10px);
            margin-bottom: 2rem;
        }

        .orders-table {
            width: 100%;
            border-collapse: collapse;
            color: rgba(255, 255, 255, 0.9);
        }

        .orders-table thead {
            background: rgba(255, 215, 0, 0.1);
            border-bottom: 2px solid rgba(255, 215, 0, 0.3);
        }

        .orders-table th {
            color: var(--gold);
            font-weight: 600;
            padding: 1rem 0.75rem;
            text-align: left;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .orders-table td {
            padding: 1rem 0.75rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            vertical-align: middle;
        }

        .orders-table tbody tr {
            transition: all 0.3s ease;
        }

        .orders-table tbody tr:hover {
            background: rgba(255, 255, 255, 0.05);
        }

        .orders-table tbody tr:last-child td {
            border-bottom: none;
        }

        .badge {
            padding: 0.5rem 0.75rem;
            border-radius: 6px;
            font-weight: 600;
            font-size: 0.8rem;
        }

        .badge-warning {
            background: linear-gradient(135deg, var(--warning-color), #e0a800);
            color: #000;
        }

        .action-buttons {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
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
            text-align: center;
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

        .btn-danger {
            background: linear-gradient(135deg, var(--danger-color), #c82333);
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            cursor: pointer;
            font-size: 0.85rem;
        }

        .btn-danger:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(220, 53, 69, 0.4);
            background: linear-gradient(135deg, #c82333, var(--danger-color));
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

        .order-count {
            background: rgba(255, 215, 0, 0.1);
            border: 1px solid rgba(255, 215, 0, 0.3);
            border-radius: 12px;
            padding: 1rem 1.5rem;
            margin-bottom: 1.5rem;
            color: var(--gold);
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        /* Responsive Design */
        @media (max-width: 992px) {
            .orders-table {
                display: block;
                overflow-x: auto;
            }

            .orders-table thead {
                display: none;
            }

            .orders-table tbody,
            .orders-table tr,
            .orders-table td {
                display: block;
                width: 100%;
            }

            .orders-table tr {
                margin-bottom: 1rem;
                border: 1px solid rgba(255, 255, 255, 0.1);
                border-radius: 12px;
                overflow: hidden;
                background: rgba(255, 255, 255, 0.05);
                padding: 1rem;
            }

            .orders-table td {
                padding: 0.75rem;
                border-bottom: 1px solid rgba(255, 255, 255, 0.05);
                position: relative;
                padding-left: 50%;
            }

            .orders-table td:before {
                content: attr(data-label);
                position: absolute;
                left: 0.75rem;
                width: 45%;
                padding-right: 0.5rem;
                font-weight: 600;
                color: var(--gold);
            }

            .action-buttons {
                justify-content: center;
            }
        }

        @media (max-width: 768px) {
            .container {
                padding-top: 70px;
            }

            .page-title {
                font-size: 1.8rem;
            }

            .orders-container {
                padding: 1.5rem;
            }

            .action-buttons {
                flex-direction: column;
            }

            .btn {
                width: 100%;
            }
        }

        @media (max-width: 576px) {
            .container {
                padding-top: 60px;
            }

            .page-title {
                font-size: 1.6rem;
            }

            .orders-container {
                padding: 1rem;
            }

            .orders-table td {
                padding-left: 40%;
            }

            .orders-table td:before {
                width: 35%;
            }
        }
    </style>

    <div class="container">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-title">
                <i class="fas fa-clock me-2"></i>Pesanan Belum Bayar
            </h1>
            <p class="page-subtitle">Pesanan yang menunggu pembayaran</p>
        </div>

        <div class="orders-container">
            @if($orders->count() > 0)
                <div class="order-count">
                    <i class="fas fa-shopping-bag me-2"></i>
                    Total pesanan belum bayar: {{ $orders->count() }}
                </div>

                <table class="orders-table">
                    <thead>
                        <tr>
                            <th data-label="Nama">Nama</th>
                            <th data-label="Nomor HP">Nomor HP</th>
                            <th data-label="Alamat">Alamat</th>
                            <th data-label="Jumlah">Jumlah</th>
                            <th data-label="Total Harga">Total Harga</th>
                            <th data-label="Status">Status</th>
                            <th data-label="Aksi">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $order)
                            <tr>
                                <td data-label="Nama">{{ $order->name }}</td>
                                <td data-label="Nomor HP">{{ $order->phone }}</td>
                                <td data-label="Alamat">{{ $order->alamat }}</td>
                                <td data-label="Jumlah">{{ $order->jumlah }}</td>
                                <td data-label="Total Harga">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</td>
                                <td data-label="Status">
                                    <span class="badge badge-warning">
                                        <i class="fas fa-clock me-1"></i>{{ $order->status }}
                                    </span>
                                </td>
                                <td data-label="Aksi">
                                    <div class="action-buttons">
                                        <a href="{{ route('pembeli.pending', ['order_id_midtrans' => $order->order_id_midtrans]) }}"
                                            class="btn btn-primary">
                                            <i class="fas fa-credit-card me-1"></i>Bayar
                                        </a>
                                        <form action="{{ route('pembeli.order.cancelExpired', $order->id) }}" method="POST"
                                            onsubmit="return confirm('Yakin ingin membatalkan pesanan ini?')">
                                            @csrf
                                            <button type="submit" class="btn btn-danger">
                                                <i class="fas fa-times me-1"></i>Batalkan
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="empty-state">
                    <div class="empty-state-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <h5>Tidak ada pesanan belum bayar</h5>
                    <p>Semua pesanan Anda telah dibayar atau belum ada pesanan yang menunggu pembayaran.</p>
                </div>
            @endif
        </div>
    </div>

    <script>
        // Responsive table - add data labels for mobile view
        document.addEventListener('DOMContentLoaded', function () {
            if (window.innerWidth <= 992) {
                const headers = document.querySelectorAll('.orders-table thead th');
                const rows = document.querySelectorAll('.orders-table tbody tr');

                rows.forEach(row => {
                    const cells = row.querySelectorAll('td');
                    cells.forEach((cell, index) => {
                        if (headers[index]) {
                            cell.setAttribute('data-label', headers[index].textContent.trim());
                        }
                    });
                });
            }
        });

        // Confirm cancellation
        document.addEventListener('DOMContentLoaded', function () {
            const cancelForms = document.querySelectorAll('form[action*="cancelExpired"]');

            cancelForms.forEach(form => {
                form.addEventListener('submit', function (e) {
                    if (!confirm('Yakin ingin membatalkan pesanan ini?')) {
                        e.preventDefault();
                    }
                });
            });
        });
    </script>
@endsection