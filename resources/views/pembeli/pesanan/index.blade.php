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

        .order-section {
            background: rgba(30, 30, 46, 0.7);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            overflow: hidden;
            padding: 1.5rem;
            backdrop-filter: blur(10px);
            margin-bottom: 2rem;
        }

        .order-table {
            width: 100%;
            border-collapse: collapse;
            color: rgba(255, 255, 255, 0.9);
        }

        .order-table thead {
            background: rgba(255, 215, 0, 0.1);
            border-bottom: 2px solid rgba(255, 215, 0, 0.3);
        }

        .order-table th {
            color: var(--gold);
            font-weight: 600;
            padding: 1rem 0.75rem;
            text-align: left;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .order-table td {
            padding: 1rem 0.75rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            vertical-align: middle;
        }

        .order-table tbody tr {
            transition: all 0.3s ease;
        }

        .order-table tbody tr:hover {
            background: rgba(255, 255, 255, 0.05);
        }

        .order-table tbody tr:last-child td {
            border-bottom: none;
        }

        .checkbox-cell {
            width: 40px;
            text-align: center;
        }

        .checkbox-cell input[type="checkbox"] {
            width: 18px;
            height: 18px;
            cursor: pointer;
            accent-color: var(--gold);
        }

        .action-cell {
            width: 120px;
        }

        .badge {
            padding: 0.5rem 0.75rem;
            border-radius: 6px;
            font-weight: 600;
            font-size: 0.8rem;
        }

        .badge-success {
            background: linear-gradient(135deg, var(--success-color), #1e7e34);
            color: white;
        }

        .badge-warning {
            background: linear-gradient(135deg, var(--warning-color), #e0a800);
            color: #000;
        }

        .badge-danger {
            background: linear-gradient(135deg, var(--danger-color), #c82333);
            color: white;
        }

        .badge-info {
            background: linear-gradient(135deg, var(--info-color), #138496);
            color: white;
        }

        .badge-secondary {
            background: linear-gradient(135deg, var(--secondary-color), #545b62);
            color: white;
        }

        .btn {
            border: none;
            border-radius: 8px;
            padding: 0.5rem 1rem;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
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
        }

        .btn-danger:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(220, 53, 69, 0.4);
            background: linear-gradient(135deg, #c82333, var(--danger-color));
        }

        .btn-sm {
            padding: 0.4rem 0.8rem;
            font-size: 0.85rem;
        }

        .empty-state {
            text-align: center;
            padding: 2rem;
            background: rgba(30, 30, 46, 0.5);
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
        }

        .empty-state-icon {
            font-size: 2.5rem;
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

        .bulk-actions {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 1rem;
        }

        /* Responsive Design */
        @media (max-width: 992px) {
            .order-table {
                display: block;
                overflow-x: auto;
            }

            .order-table thead {
                display: none;
            }

            .order-table tbody,
            .order-table tr,
            .order-table td {
                display: block;
                width: 100%;
            }

            .order-table tr {
                margin-bottom: 1rem;
                border: 1px solid rgba(255, 255, 255, 0.1);
                border-radius: 12px;
                overflow: hidden;
                background: rgba(255, 255, 255, 0.05);
            }

            .order-table td {
                padding: 0.75rem;
                border-bottom: 1px solid rgba(255, 255, 255, 0.05);
                position: relative;
                padding-left: 50%;
            }

            .order-table td:before {
                content: attr(data-label);
                position: absolute;
                left: 0.75rem;
                width: 45%;
                padding-right: 0.5rem;
                font-weight: 600;
                color: var(--gold);
            }

            .checkbox-cell {
                width: 100%;
                text-align: left;
            }

            .checkbox-cell:before {
                content: "Pilih";
            }

            .action-cell {
                width: 100%;
            }
        }

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

            .order-section {
                padding: 1rem;
            }

            .bulk-actions {
                flex-direction: column;
                gap: 0.5rem;
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

            .order-table td {
                padding-left: 40%;
            }

            .order-table td:before {
                width: 35%;
            }
        }
    </style>

    <div class="container">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-title">
                <i class="fas fa-shopping-bag me-2"></i>Pesanan Saya
            </h1>
        </div>

        @php
            $pesananLunas = $orders->where('status', 'complete');
            $pesananPending = $orders->where('status', 'pending');
            $pesananCancel = $orders->where('status', 'cancel');
        @endphp

        {{-- PESANAN LUNAS --}}
        <h3 class="section-title">
            <i class="fas fa-check-circle me-2"></i>Pesanan Lunas
        </h3>

        <div class="order-section">
            @if ($pesananLunas->isEmpty())
                <div class="empty-state">
                    <div class="empty-state-icon">
                        <i class="fas fa-check"></i>
                    </div>
                    <h5>Tidak ada pesanan lunas</h5>
                    <p>Belum ada pesanan yang telah diselesaikan.</p>
                </div>
            @else
                <form action="{{ route('pembeli.pesanan.bulkDelete') }}" method="POST"
                    onsubmit="return confirm('Yakin ingin menghapus pesanan yang dipilih?')">
                    @csrf
                    @method('DELETE')
                    <div class="bulk-actions">
                        <button type="submit" class="btn btn-danger btn-sm">
                            <i class="fas fa-trash me-1"></i>Hapus yang Dipilih
                        </button>
                    </div>

                    <table class="order-table">
                        <thead>
                            <tr>
                                <th class="checkbox-cell">
                                    <input type="checkbox" id="select-all-lunas">
                                </th>
                                <th data-label="Produk">Produk</th>
                                <th data-label="Jumlah">Jumlah</th>
                                <th data-label="Total Harga">Total Harga</th>
                                <th data-label="Status Pembayaran">Status Pembayaran</th>
                                <th data-label="Status Pengiriman">Status Pengiriman</th>
                                <th data-label="Tanggal">Tanggal</th>
                                <th class="action-cell" data-label="Aksi">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pesananLunas as $order)
                                <tr>
                                    <td class="checkbox-cell" data-label="Pilih">
                                        <input type="checkbox" name="order_ids[]" value="{{ $order->id }}"
                                            class="order-checkbox-lunas">
                                    </td>
                                    <td data-label="Produk">{{ $order->produk->nama ?? '-' }}</td>
                                    <td data-label="Jumlah">{{ $order->jumlah }}</td>
                                    <td data-label="Total Harga">Rp{{ number_format($order->total_harga, 0, ',', '.') }}</td>
                                    <td data-label="Status Pembayaran">
                                        <span class="badge badge-success">{{ ucfirst($order->status) }}</span>
                                    </td>
                                    <td data-label="Status Pengiriman">
                                        @if ($order->status_pesanan)
                                            <span
                                                class="badge badge-info">{{ ucfirst(str_replace('_', ' ', $order->status_pesanan)) }}</span>
                                        @else
                                            <span class="badge badge-secondary">Belum Diproses</span>
                                        @endif
                                    </td>
                                    <td data-label="Tanggal">{{ $order->created_at->format('d-m-Y H:i') }}</td>
                                    <td class="action-cell" data-label="Aksi">
                                        <a href="{{ route('pembeli.invoice.show', $order->id) }}" class="btn btn-primary btn-sm">
                                            <i class="fas fa-file-invoice me-1"></i>Invoice
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </form>
            @endif
        </div>

        {{-- PESANAN MENUNGGU PEMBAYARAN --}}
        <h3 class="section-title">
            <i class="fas fa-clock me-2"></i>Pesanan Menunggu Pembayaran
        </h3>

        <div class="order-section">
            @if ($pesananPending->isEmpty())
                <div class="empty-state">
                    <div class="empty-state-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <h5>Tidak ada pesanan menunggu pembayaran</h5>
                    <p>Belum ada pesanan yang menunggu pembayaran.</p>
                </div>
            @else
                <form action="{{ route('pembeli.pesanan.bulkDelete') }}" method="POST"
                    onsubmit="return confirm('Yakin ingin menghapus pesanan yang dipilih?')">
                    @csrf
                    @method('DELETE')
                    <div class="bulk-actions">
                        <button type="submit" class="btn btn-danger btn-sm">
                            <i class="fas fa-trash me-1"></i>Hapus yang Dipilih
                        </button>
                    </div>

                    <table class="order-table">
                        <thead>
                            <tr>
                                <th class="checkbox-cell">
                                    <input type="checkbox" id="select-all-pending">
                                </th>
                                <th data-label="Produk">Produk</th>
                                <th data-label="Jumlah">Jumlah</th>
                                <th data-label="Total Harga">Total Harga</th>
                                <th data-label="Status Pembayaran">Status Pembayaran</th>
                                <th data-label="Status Pengiriman">Status Pengiriman</th>
                                <th data-label="Tanggal">Tanggal</th>
                                <th class="action-cell" data-label="Aksi">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pesananPending as $order)
                                <tr>
                                    <td class="checkbox-cell" data-label="Pilih">
                                        <input type="checkbox" name="order_ids[]" value="{{ $order->id }}"
                                            class="order-checkbox-pending">
                                    </td>
                                    <td data-label="Produk">{{ $order->produk->nama ?? '-' }}</td>
                                    <td data-label="Jumlah">{{ $order->jumlah }}</td>
                                    <td data-label="Total Harga">Rp{{ number_format($order->total_harga, 0, ',', '.') }}</td>
                                    <td data-label="Status Pembayaran">
                                        <span class="badge badge-warning">{{ ucfirst($order->status) }}</span>
                                    </td>
                                    <td data-label="Status Pengiriman">
                                        @if ($order->status_pesanan)
                                            <span
                                                class="badge badge-info">{{ ucfirst(str_replace('_', ' ', $order->status_pesanan)) }}</span>
                                        @else
                                            <span class="badge badge-secondary">Belum Diproses</span>
                                        @endif
                                    </td>
                                    <td data-label="Tanggal">{{ $order->created_at->format('d-m-Y H:i') }}</td>
                                    <td class="action-cell" data-label="Aksi">
                                        <a href="{{ route('pembeli.status.belum-bayar') }}" class="btn btn-primary btn-sm">
                                            <i class="fas fa-credit-card me-1"></i>Bayar
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </form>
            @endif
        </div>

        {{-- PESANAN DIBATALKAN --}}
        <h3 class="section-title">
            <i class="fas fa-times-circle me-2"></i>Pesanan Dibatalkan
        </h3>

        <div class="order-section">
            @if ($pesananCancel->isEmpty())
                <div class="empty-state">
                    <div class="empty-state-icon">
                        <i class="fas fa-ban"></i>
                    </div>
                    <h5>Tidak ada pesanan yang dibatalkan</h5>
                    <p>Belum ada pesanan yang dibatalkan.</p>
                </div>
            @else
                <form action="{{ route('pembeli.pesanan.bulkDelete') }}" method="POST"
                    onsubmit="return confirm('Yakin ingin menghapus pesanan yang dipilih?')">
                    @csrf
                    @method('DELETE')
                    <div class="bulk-actions">
                        <button type="submit" class="btn btn-danger btn-sm">
                            <i class="fas fa-trash me-1"></i>Hapus yang Dipilih
                        </button>
                    </div>

                    <table class="order-table">
                        <thead>
                            <tr>
                                <th class="checkbox-cell">
                                    <input type="checkbox" id="select-all-cancel">
                                </th>
                                <th data-label="Produk">Produk</th>
                                <th data-label="Jumlah">Jumlah</th>
                                <th data-label="Total Harga">Total Harga</th>
                                <th data-label="Status Pembayaran">Status Pembayaran</th>
                                <th data-label="Status Pengiriman">Status Pengiriman</th>
                                <th data-label="Tanggal">Tanggal</th>
                                <th class="action-cell" data-label="Aksi">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pesananCancel as $order)
                                <tr>
                                    <td class="checkbox-cell" data-label="Pilih">
                                        <input type="checkbox" name="order_ids[]" value="{{ $order->id }}"
                                            class="order-checkbox-cancel">
                                    </td>
                                    <td data-label="Produk">{{ $order->produk->nama ?? '-' }}</td>
                                    <td data-label="Jumlah">{{ $order->jumlah }}</td>
                                    <td data-label="Total Harga">Rp{{ number_format($order->total_harga, 0, ',', '.') }}</td>
                                    <td data-label="Status Pembayaran">
                                        <span class="badge badge-danger">{{ ucfirst($order->status) }}</span>
                                    </td>
                                    <td data-label="Status Pengiriman">
                                        @if ($order->status_pesanan)
                                            <span
                                                class="badge badge-info">{{ ucfirst(str_replace('_', ' ', $order->status_pesanan)) }}</span>
                                        @else
                                            <span class="badge badge-secondary">Belum Diproses</span>
                                        @endif
                                    </td>
                                    <td data-label="Tanggal">{{ $order->created_at->format('d-m-Y H:i') }}</td>
                                    <td class="action-cell" data-label="Aksi">
                                        <a href="{{ route('pembeli.invoice.show', $order->id) }}" class="btn btn-primary btn-sm">
                                            <i class="fas fa-file-invoice me-1"></i>Invoice
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </form>
            @endif
        </div>
    </div>

    <script>
        // Menangani aksi "Select All" untuk memilih semua checkbox di bagian lunas
        document.getElementById('select-all-lunas').addEventListener('change', function (e) {
            const checkboxes = document.querySelectorAll('.order-checkbox-lunas');
            checkboxes.forEach(checkbox => {
                checkbox.checked = e.target.checked;
            });
        });

        // Menangani aksi "Select All" untuk memilih semua checkbox di bagian pending
        document.getElementById('select-all-pending').addEventListener('change', function (e) {
            const checkboxes = document.querySelectorAll('.order-checkbox-pending');
            checkboxes.forEach(checkbox => {
                checkbox.checked = e.target.checked;
            });
        });

        // Menangani aksi "Select All" untuk memilih semua checkbox di bagian cancel
        document.getElementById('select-all-cancel').addEventListener('change', function (e) {
            const checkboxes = document.querySelectorAll('.order-checkbox-cancel');
            checkboxes.forEach(checkbox => {
                checkbox.checked = e.target.checked;
            });
        });

        // Responsive table - add data labels for mobile view
        document.addEventListener('DOMContentLoaded', function () {
            if (window.innerWidth <= 992) {
                const headers = document.querySelectorAll('.order-table thead th');
                const rows = document.querySelectorAll('.order-table tbody tr');

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
    </script>
@endsection