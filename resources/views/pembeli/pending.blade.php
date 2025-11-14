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

        .payment-card {
            background: rgba(30, 30, 46, 0.7);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            overflow: hidden;
            padding: 2.5rem;
            backdrop-filter: blur(10px);
            margin: 0 auto;
            max-width: 600px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
        }

        .card-title {
            color: var(--gold);
            font-weight: 600;
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
            padding-bottom: 0.75rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
        }

        .status-message {
            text-align: center;
            color: rgba(255, 255, 255, 0.8);
            margin-bottom: 2rem;
            font-size: 1.1rem;
            line-height: 1.6;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
            color: rgba(255, 255, 255, 0.9);
            margin: 2rem 0;
        }

        .info-table tr {
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .info-table tr:last-child {
            border-bottom: none;
        }

        .info-table td {
            padding: 1rem 0.5rem;
            vertical-align: top;
        }

        .info-table td:first-child {
            color: var(--gold);
            font-weight: 600;
            width: 40%;
            padding-left: 0;
        }

        .info-table td:last-child {
            padding-right: 0;
        }

        .total-price {
            color: var(--gold-light);
            font-weight: 700;
            font-size: 1.2rem;
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

        .badge-warning {
            background: linear-gradient(135deg, var(--warning-color), #e0a800);
            color: #000;
        }

        .btn {
            border: none;
            border-radius: 12px;
            padding: 1rem 2rem;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
            cursor: pointer;
            font-size: 1.1rem;
            min-width: 250px;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--gold) 0%, var(--gold-light) 100%);
            color: var(--dark-blue);
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(255, 215, 0, 0.4);
            background: linear-gradient(135deg, var(--gold-light) 0%, var(--gold) 100%);
        }

        .payment-section {
            text-align: center;
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .payment-info {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 12px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            border: 1px solid rgba(255, 215, 0, 0.2);
        }

        .payment-info p {
            margin-bottom: 0.5rem;
            color: rgba(255, 255, 255, 0.8);
        }

        .payment-info .highlight {
            color: var(--gold);
            font-weight: 600;
        }

        .security-notice {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            color: rgba(255, 255, 255, 0.6);
            font-size: 0.9rem;
            margin-top: 1rem;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .container {
                padding-top: 70px;
            }

            .page-title {
                font-size: 1.8rem;
            }

            .payment-card {
                padding: 2rem;
                margin: 0 1rem;
            }

            .info-table td:first-child {
                width: 35%;
            }

            .btn {
                width: 100%;
                min-width: auto;
            }
        }

        @media (max-width: 576px) {
            .container {
                padding-top: 60px;
            }

            .page-title {
                font-size: 1.6rem;
            }

            .payment-card {
                padding: 1.5rem;
            }

            .info-table td {
                padding: 0.75rem 0.25rem;
                display: block;
                width: 100%;
                border-bottom: none;
            }

            .info-table td:first-child {
                width: 100%;
                padding-bottom: 0.25rem;
                border-bottom: none;
            }

            .info-table tr {
                border-bottom: 1px solid rgba(255, 255, 255, 0.1);
                padding: 0.5rem 0;
                display: block;
            }

            .info-table tr:last-child {
                border-bottom: none;
            }

            .card-title {
                font-size: 1.3rem;
            }
        }
    </style>

    <div class="container">
        <!-- Page Header -->
        <h1 class="page-title">
            <i class="fas fa-credit-card me-2"></i>Status Pembayaran
        </h1>

        <!-- Payment Card -->
        <div class="payment-card">
            <h3 class="card-title">
                <i class="fas fa-clock me-2"></i>Menunggu Pembayaran
            </h3>

            <div class="status-message">
                <p>Silakan lanjutkan pembayaran Anda melalui Midtrans untuk menyelesaikan pesanan.</p>
            </div>

            <table class="info-table">
                <tr>
                    <td>Nama</td>
                    <td>{{ $order->name }}</td>
                </tr>
                <tr>
                    <td>Nomor HP</td>
                    <td>{{ $order->phone }}</td>
                </tr>
                <tr>
                    <td>Alamat</td>
                    <td>{{ $order->alamat }}</td>
                </tr>
                <tr>
                    <td>Jumlah Barang</td>
                    <td>{{ $order->jumlah }}</td>
                </tr>
                <tr>
                    <td>Total Harga</td>
                    <td class="total-price">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td>Status</td>
                    <td>
                        <span class="badge badge-warning">
                            <i class="fas fa-clock me-1"></i>Pending
                        </span>
                    </td>
                </tr>
            </table>

            <!-- Payment Section -->
            <div class="payment-section">
                <div class="payment-info">
                    <p><span class="highlight">Langkah selanjutnya:</span> Klik tombol di bawah untuk melanjutkan pembayaran
                    </p>
                    <p><i class="fas fa-shield-alt me-2"></i>Pembayaran diproses dengan aman oleh Midtrans</p>
                </div>

                <button class="btn btn-primary" id="pay-button">
                    <i class="fas fa-credit-card me-2"></i> Lanjutkan Pembayaran
                </button>

                <div class="security-notice">
                    <i class="fas fa-lock"></i>
                    <span>Transaksi Anda aman dan terenkripsi</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Midtrans Snap Script -->
    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('midtrans.client_key') }}"></script>

    <script type="text/javascript">
        var payButton = document.getElementById('pay-button');
        payButton.addEventListener('click', function () {
            // Show loading state
            payButton.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Memproses...';
            payButton.disabled = true;

            window.snap.pay('{{$snapToken}}', {
                onSuccess: function (result) {
                    console.log('Payment success result:', result);
                    window.location.href = '/pembeli/invoice/{{ $order->id }}';
                },
                onPending: function (result) {
                    alert("Menunggu pembayaran Anda.");
                    // Reset button
                    payButton.innerHTML = '<i class="fas fa-credit-card me-2"></i> Lanjutkan Pembayaran';
                    payButton.disabled = false;
                },
                onError: function (result) {
                    alert("Pembayaran gagal. Silakan coba lagi.");
                    // Reset button
                    payButton.innerHTML = '<i class="fas fa-credit-card me-2"></i> Lanjutkan Pembayaran';
                    payButton.disabled = false;
                },
                onClose: function () {
                    alert('Anda menutup popup sebelum menyelesaikan pembayaran.');
                    // Reset button
                    payButton.innerHTML = '<i class="fas fa-credit-card me-2"></i> Lanjutkan Pembayaran';
                    payButton.disabled = false;
                }
            });
        });
    </script>
@endsection