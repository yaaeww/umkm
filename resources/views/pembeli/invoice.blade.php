@extends('layouts.pembeli-navbar')
@section('title', 'Detail Pembayaran')
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

        .invoice-card {
            background: rgba(30, 30, 46, 0.7);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            overflow: hidden;
            padding: 2rem;
            backdrop-filter: blur(10px);
            margin-bottom: 2rem;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        }

        .section-title {
            color: var(--gold);
            font-weight: 600;
            font-size: 1.2rem;
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .info-group {
            margin-bottom: 1.5rem;
        }

        .info-label {
            color: rgba(255, 255, 255, 0.7);
            font-size: 0.9rem;
            margin-bottom: 0.25rem;
        }

        .info-value {
            color: rgba(255, 255, 255, 0.9);
            font-weight: 600;
            font-size: 1rem;
        }

        .order-table {
            width: 100%;
            border-collapse: collapse;
            color: rgba(255, 255, 255, 0.9);
            margin: 1.5rem 0;
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

        .total-price {
            text-align: right;
            margin-top: 1.5rem;
            padding-top: 1rem;
            border-top: 2px solid rgba(255, 215, 0, 0.3);
        }

        .total-label {
            color: var(--gold);
            font-weight: 600;
            font-size: 1.1rem;
            margin-right: 0.5rem;
        }

        .total-value {
            color: var(--gold-light);
            font-weight: 700;
            font-size: 1.5rem;
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

        .btn {
            border: none;
            border-radius: 8px;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            text-align: center;
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

        .btn-success {
            background: linear-gradient(135deg, var(--success-color), #1e7e34);
            color: white;
        }

        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(40, 167, 69, 0.4);
            background: linear-gradient(135deg, #1e7e34, var(--success-color));
        }

        .status-form {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 12px;
            padding: 1.5rem;
            margin: 2rem 0;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .form-label {
            color: var(--gold);
            font-weight: 600;
            margin-bottom: 1rem;
            display: block;
        }

        .btn-group-vertical {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            width: 100%;
        }

        .btn-radio {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: rgba(255, 255, 255, 0.8);
            padding: 0.75rem 1rem;
            border-radius: 8px;
            text-align: left;
            transition: all 0.3s ease;
            cursor: pointer;
            display: flex;
            align-items: center;
        }

        .btn-radio:hover {
            background: rgba(255, 255, 255, 0.1);
        }

        .btn-radio.active {
            background: linear-gradient(135deg, var(--gold) 0%, var(--gold-light) 100%);
            color: var(--dark-blue);
            border-color: var(--gold);
        }

        .btn-check {
            position: absolute;
            opacity: 0;
        }

        .radio-dot {
            width: 18px;
            height: 18px;
            border-radius: 50%;
            border: 2px solid rgba(255, 255, 255, 0.3);
            margin-right: 0.75rem;
            position: relative;
            transition: all 0.3s ease;
        }

        .btn-radio.active .radio-dot {
            border-color: var(--dark-blue);
            background: var(--dark-blue);
        }

        .btn-radio.active .radio-dot:after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--gold);
        }

        .action-buttons {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-top: 2rem;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .container {
                padding-top: 70px;
            }

            .page-title {
                font-size: 1.8rem;
            }

            .invoice-card {
                padding: 1.5rem;
            }

            .order-table {
                display: block;
                overflow-x: auto;
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

            .invoice-card {
                padding: 1rem;
            }

            .info-group {
                margin-bottom: 1rem;
            }
        }
    </style>

    <div class="container">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-title">
                <i class="fas fa-file-invoice me-2"></i>Detail Pembayaran
            </h1>
        </div>

        <!-- Invoice Card -->
        <div class="invoice-card">
            <!-- Order Information -->
            <div class="row">
                <div class="col-md-6">
                    <h4 class="section-title">
                        <i class="fas fa-user me-2"></i>Informasi Pembeli
                    </h4>
                    <div class="info-group">
                        <div class="info-label">Nama</div>
                        <div class="info-value">{{ $order->name }}</div>
                    </div>
                    <div class="info-group">
                        <div class="info-label">No HP</div>
                        <div class="info-value">{{ $order->phone }}</div>
                    </div>
                    <div class="info-group">
                        <div class="info-label">Alamat</div>
                        <div class="info-value">{{ $order->alamat }}</div>
                    </div>
                </div>
                <div class="col-md-6">
                    <h4 class="section-title">
                        <i class="fas fa-shopping-bag me-2"></i>Informasi Pesanan
                    </h4>
                    <div class="info-group">
                        <div class="info-label">No. Pesanan</div>
                        <div class="info-value">{{ $order->order_id_midtrans }}</div>
                    </div>
                    <div class="info-group">
                        <div class="info-label">Tanggal</div>
                        <div class="info-value">{{ $order->created_at->format('d M Y') }}</div>
                    </div>
                    <div class="info-group">
                        <div class="info-label">Status Pembayaran</div>
                        <div class="info-value">
                            @if ($order->status === 'complete')
                                <span class="badge badge-success">Lunas</span>
                            @elseif ($order->status === 'cancel')
                                <span class="badge badge-danger">Dibatalkan</span>
                            @elseif ($order->status === 'pending')
                                <span class="badge badge-warning">Pending</span>
                            @endif
                        </div>
                    </div>
                    <div class="info-group">
                        <div class="info-label">Status Pesanan</div>
                        <div class="info-value">
                            <span class="badge badge-info">{{ ucfirst(str_replace('_', ' ', $order->status_pesanan)) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Order Details Table -->
            <h4 class="section-title mt-4">
                <i class="fas fa-list me-2"></i>Detail Produk
            </h4>
            <div class="table-responsive">
                <table class="order-table">
                    <thead>
                        <tr>
                            <th>Produk</th>
                            <th>Harga</th>
                            <th>Jumlah</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $order->produk->nama }}</td>
                            <td>Rp {{ number_format($order->produk->harga, 0, ',', '.') }}</td>
                            <td>{{ $order->jumlah }}</td>
                            <td>Rp {{ number_format($order->total_harga, 0, ',', '.') }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Total Price -->
            <div class="total-price">
                <span class="total-label">Total Harga:</span>
                <span class="total-value">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</span>
            </div>

            <!-- Form Update Status Pesanan -->
            @if($order->status === 'complete' && $order->status_pesanan === 'dikirim')
                <div class="status-form">
                    <h4 class="section-title">
                        <i class="fas fa-truck me-2"></i>Konfirmasi Penerimaan Barang
                    </h4>
                    <form action="{{ route('pembeli.pesanan.updateStatus', $order->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <label class="form-label">Silakan konfirmasi status penerimaan barang:</label>
                        
                        <div class="btn-group-vertical">
                            @php
                                $pengirimanStatus = ['diterima' => 'Diterima', 'belum_diterima' => 'Belum Diterima'];
                                $currentStatus = old('status_pesanan', $order->status_pesanan);
                            @endphp
                            
                            @foreach ($pengirimanStatus as $value => $label)
                                <input type="radio" class="btn-check" name="status_pesanan" 
                                       id="status-{{ $value }}" value="{{ $value }}"
                                       {{ $currentStatus === $value ? 'checked' : '' }}>
                                <label class="btn-radio {{ $currentStatus === $value ? 'active' : '' }}" 
                                       for="status-{{ $value }}">
                                    <span class="radio-dot"></span>
                                    {{ $label }}
                                </label>
                            @endforeach
                        </div>
                        
                        <button type="submit" class="btn btn-success mt-3">
                            <i class="fas fa-sync-alt me-2"></i>Perbarui Status
                        </button>
                    </form>
                </div>
            @endif

            <!-- Action Buttons -->
            <div class="action-buttons">
                <a href="{{ route('pembeli.pesanan.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar Pesanan
                </a>
            </div>
        </div>
    </div>

    <script>
        // Handle radio button styling
        document.addEventListener('DOMContentLoaded', function() {
            const radioButtons = document.querySelectorAll('.btn-check');
            
            radioButtons.forEach(radio => {
                radio.addEventListener('change', function() {
                    // Remove active class from all labels
                    document.querySelectorAll('.btn-radio').forEach(label => {
                        label.classList.remove('active');
                    });
                    
                    // Add active class to the selected label
                    const label = document.querySelector(`label[for="${this.id}"]`);
                    if (label) {
                        label.classList.add('active');
                    }
                });
            });
        });
    </script>
@endsection