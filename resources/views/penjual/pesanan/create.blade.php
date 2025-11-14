@extends('layouts.app')

@section('page_title', 'Detail Pesanan')

@section('title')
    <i class="fas fa-shopping-cart me-2"></i> Detail Pesanan
@endsection

@section('content')
    <style>
        .order-detail-container {
            background: linear-gradient(135deg, rgba(10, 22, 40, 0.8) 0%, rgba(26, 58, 95, 0.9) 100%);
            border: 2px solid rgba(255, 215, 0, 0.3);
            border-radius: 15px;
            padding: 30px;
            backdrop-filter: blur(10px);
            margin-bottom: 30px;
        }

        .order-card {
            background: linear-gradient(135deg, rgba(26, 58, 95, 0.7) 0%, rgba(42, 74, 127, 0.8) 100%);
            border: 2px solid rgba(255, 215, 0, 0.2);
            border-radius: 12px;
            padding: 25px;
            backdrop-filter: blur(10px);
        }

        .text-theme {
            color: #e0e0e0 !important;
        }

        .text-gold {
            color: var(--gold) !important;
        }

        .section-title {
            font-size: 2.2rem;
            font-weight: 700;
            margin-bottom: 30px;
            background: linear-gradient(135deg, var(--gold) 0%, var(--gold-light) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-align: center;
        }

        .info-section {
            background: rgba(10, 22, 40, 0.6);
            border: 1px solid rgba(255, 215, 0, 0.2);
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 25px;
        }

        .info-title {
            font-size: 1.2rem;
            font-weight: 600;
            color: var(--gold);
            margin-bottom: 15px;
            border-bottom: 1px solid rgba(255, 215, 0, 0.2);
            padding-bottom: 8px;
        }

        .info-item {
            margin-bottom: 10px;
            padding: 5px 0;
        }

        .info-label {
            color: var(--gold);
            font-weight: 500;
            display: inline-block;
            min-width: 150px;
        }

        .info-value {
            color: #e0e0e0;
        }

        .table-custom {
            background: rgba(26, 58, 95, 0.6);
            border: 2px solid rgba(255, 215, 0, 0.2);
            border-radius: 8px;
            overflow: hidden;
            backdrop-filter: blur(10px);
        }

        .table-custom thead {
            background: linear-gradient(135deg, rgba(255, 215, 0, 0.1) 0%, rgba(255, 237, 78, 0.05) 100%);
            border-bottom: 2px solid rgba(255, 215, 0, 0.3);
        }

        .table-custom th {
            color: var(--gold);
            font-weight: 600;
            padding: 15px 12px;
            border: none;
        }

        .table-custom td {
            color: #000000;
            padding: 12px;
            border-bottom: 1px solid rgba(255, 215, 0, 0.1);
            vertical-align: middle;
        }

        .table-custom tbody tr:last-child td {
            border-bottom: none;
        }

        .total-section {
            background: linear-gradient(135deg, rgba(255, 215, 0, 0.1) 0%, rgba(255, 237, 78, 0.05) 100%);
            border: 2px solid rgba(255, 215, 0, 0.2);
            border-radius: 8px;
            padding: 20px;
            margin-top: 20px;
            text-align: right;
        }

        .total-amount {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--gold-light);
        }

        .btn-success {
            background: linear-gradient(135deg, #28a745, #20c997);
            border: none;
            color: white;
            font-weight: 700;
            padding: 10px 25px;
            border-radius: 8px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
        }

        .btn-success:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(40, 167, 69, 0.5);
            background: linear-gradient(135deg, #20c997, #28a745);
            color: white;
        }

        .btn-secondary {
            background: linear-gradient(135deg, #6c757d, #868e96);
            border: none;
            color: white;
            font-weight: 700;
            padding: 10px 25px;
            border-radius: 8px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(108, 117, 125, 0.3);
        }

        .btn-secondary:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(108, 117, 125, 0.5);
            background: linear-gradient(135deg, #868e96, #6c757d);
            color: white;
        }

        .badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.8rem;
        }

        .badge-success {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
        }

        .badge-warning {
            background: linear-gradient(135deg, #ffc107, #fd7e14);
            color: white;
        }

        .badge-danger {
            background: linear-gradient(135deg, #dc3545, #e83e8c);
            color: white;
        }

        .badge-info {
            background: linear-gradient(135deg, #17a2b8, #20c997);
            color: white;
        }

        .status-form {
            background: rgba(10, 22, 40, 0.6);
            border: 1px solid rgba(255, 215, 0, 0.2);
            border-radius: 8px;
            padding: 20px;
            margin-top: 25px;
        }

        .btn-group-custom {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-top: 10px;
        }

        .btn-check:checked+.btn-outline-primary {
            background: linear-gradient(135deg, var(--gold) 0%, var(--gold-light) 100%);
            color: var(--dark-blue);
            border-color: var(--gold);
        }

        .btn-outline-primary {
            background: transparent;
            border: 2px solid var(--gold);
            color: var(--gold);
            font-weight: 600;
            padding: 8px 16px;
            border-radius: 6px;
            transition: all 0.3s ease;
        }

        .btn-outline-primary:hover {
            background: rgba(255, 215, 0, 0.1);
            color: var(--gold-light);
        }

        .action-buttons {
            display: flex;
            gap: 15px;
            justify-content: center;
            margin-top: 30px;
            flex-wrap: wrap;
        }

        /* Mobile responsiveness */
        @media (max-width: 768px) {
            .order-detail-container {
                padding: 20px 15px;
            }

            .order-card {
                padding: 20px;
            }

            .section-title {
                font-size: 1.8rem;
            }

            .info-label {
                min-width: 120px;
            }

            .btn-group-custom {
                flex-direction: column;
            }

            .btn-outline-primary {
                width: 100%;
                text-align: center;
            }

            .action-buttons {
                flex-direction: column;
            }

            .btn-success,
            .btn-secondary {
                width: 100%;
                text-align: center;
            }
        }

        .order-id {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--gold-light);
            background: rgba(255, 215, 0, 0.1);
            padding: 8px 15px;
            border-radius: 20px;
            display: inline-block;
            margin-bottom: 10px;
        }
    </style>

    <div class="container">
        <h2 class="section-title"><i class="fas fa-shopping-cart me-3"></i>Detail Pesanan Pembeli</h2>

        <div class="order-detail-container">
            <div class="order-card">
                <!-- Informasi Pesanan -->
                <div class="order-id">
                    <i class="fas fa-receipt me-2"></i>No. Pesanan: {{ $order->order_id_midtrans }}
                </div>

                <div class="row">
                    <!-- Informasi Pembeli -->
                    <div class="col-lg-6 mb-4">
                        <div class="info-section">
                            <h5 class="info-title"><i class="fas fa-user me-2"></i>Informasi Pembeli</h5>
                            <div class="info-item">
                                <span class="info-label">Nama:</span>
                                <span class="info-value"><strong>{{ $order->name }}</strong></span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">No. HP:</span>
                                <span class="info-value"><strong>{{ $order->phone }}</strong></span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Alamat:</span>
                                <span class="info-value"><strong>{{ $order->alamat }}</strong></span>
                            </div>
                        </div>
                    </div>

                    <!-- Informasi Pesanan -->
                    <div class="col-lg-6 mb-4">
                        <div class="info-section">
                            <h5 class="info-title"><i class="fas fa-info-circle me-2"></i>Informasi Pesanan</h5>
                            <div class="info-item">
                                <span class="info-label">Tanggal:</span>
                                <span
                                    class="info-value"><strong>{{ $order->created_at->format('d M Y H:i') }}</strong></span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Status Pembayaran:</span>
                                <span class="info-value">
                                    <span
                                        class="badge badge-{{ $order->status == 'complete' ? 'success' : ($order->status == 'pending' ? 'warning' : 'danger') }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Status Pesanan:</span>
                                <span class="info-value">
                                    <span
                                        class="badge badge-info">{{ ucfirst(str_replace('_', ' ', $order->status_pesanan)) }}</span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Detail Produk -->
                <div class="mb-4">
                    <h5 class="info-title mb-3"><i class="fas fa-box me-2"></i>Detail Produk</h5>
                    <div class="table-responsive">
                        <table class="table table-custom">
                            <thead>
                                <tr>
                                    <th>Produk</th>
                                    <th>Harga Satuan</th>
                                    <th>Jumlah</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            @if($order->produk->gambar)
                                                <img src="{{ asset('storage/' . $order->produk->gambar) }}"
                                                    alt="{{ $order->produk->nama }}" class="me-3"
                                                    style="width: 50px; height: 50px; object-fit: cover; border-radius: 6px; border: 1px solid rgba(255, 215, 0, 0.3);">
                                            @endif
                                            <div>
                                                <strong class="text-black">{{ $order->produk->nama }}</strong>
                                                @if($order->produk->deskripsi)
                                                    <br><small
                                                        class="text-muted">{{ Str::limit($order->produk->deskripsi, 50) }}</small>
                                                @endif
                                            </div>
                                        </div>
                                    </td>
                                    <td>Rp {{ number_format($order->produk->harga, 0, ',', '.') }}</td>
                                    <td>{{ $order->jumlah }}</td>
                                    <td><strong class="text-black">Rp
                                            {{ number_format($order->total_harga, 0, ',', '.') }}</strong></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Total Harga -->
                <div class="total-section">
                    <h4 class="total-amount">
                        Total Harga: Rp {{ number_format($order->total_harga, 0, ',', '.') }}
                    </h4>
                </div>

                <!-- Form Update Status Pesanan -->
                @if($order->status === 'complete')
                    <form action="{{ route('penjual.pesanan.updateStatus', $order->id) }}" method="POST" class="status-form">
                        @csrf
                        @method('PATCH')

                        <h5 class="info-title mb-3"><i class="fas fa-truck me-2"></i>Update Status Pengiriman</h5>

                        <div class="mb-3">
                            <label class="form-label text-gold mb-3">Pilih Status Pengiriman:</label>
                            <div class="btn-group-custom">
                                @php
                                    $pengirimanStatus = ['dikemas' => 'Dikemas', 'dikirim' => 'Dikirim'];
                                @endphp

                                @foreach ($pengirimanStatus as $value => $label)
                                    <input type="radio" class="btn-check" name="status_pesanan" id="status-{{ $value }}"
                                        value="{{ $value }}" autocomplete="off"
                                        {{ old('status_pesanan', $order->status_pesanan) === $value ? 'checked' : '' }}>
                                    <label class="btn btn-outline-primary" for="status-{{ $value }}">
                                        <i class="fas fa-{{ $value === 'dikemas' ? 'box' : 'shipping-fast' }} me-2"></i>{{ $label }}
                                    </label>
                                @endforeach
                            </div>

                            @error('status_pesanan')
                                <div class="text-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save me-2"></i>Perbarui Status
                        </button>
                    </form>
                @else
                    <div class="status-form">
                        <h5 class="info-title mb-3"><i class="fas fa-info-circle me-2"></i>Informasi Status</h5>
                        <p class="text-theme mb-0">
                            Status pesanan hanya dapat diubah setelah pembayaran selesai (complete).
                            Saat ini status pembayaran adalah:
                            <span
                                class="badge badge-{{ $order->status == 'complete' ? 'success' : ($order->status == 'pending' ? 'warning' : 'danger') }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </p>
                    </div>
                @endif

                <!-- Tombol Aksi -->
                <div class="action-buttons">
                    <a href="{{ route('penjual.pesanan.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar Pesanan
                    </a>

                    @if($order->status === 'complete')
                        <a href="{{ route('penjual.invoice.show', $order->id) }}" class="btn btn-outline-primary">
                            <i class="fas fa-file-invoice me-2"></i>Lihat Invoice
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script>
        // Tambahkan efek konfirmasi sebelum mengupdate status
        document.addEventListener('DOMContentLoaded', function () {
            const statusForm = document.querySelector('form[action*="updateStatus"]');
            if (statusForm) {
                statusForm.addEventListener('submit', function (e) {
                    const selectedStatus = document.querySelector('input[name="status_pesanan"]:checked');
                    if (selectedStatus) {
                        const statusLabel = selectedStatus.nextElementSibling.textContent;
                        if (!confirm(`Apakah Anda yakin ingin mengubah status pesanan menjadi "${statusLabel}"?`)) {
                            e.preventDefault();
                        } else {
                            const submitBtn = this.querySelector('button[type="submit"]');
                            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Memperbarui...';
                            submitBtn.disabled = true;
                        }
                    }
                });
            }
        });
    </script>
@endsection