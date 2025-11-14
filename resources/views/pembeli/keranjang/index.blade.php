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
            text-align: center;
        }

        .page-title {
            background: linear-gradient(135deg, var(--gold) 0%, var(--gold-light) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: 700;
            font-size: 2.2rem;
            margin-bottom: 0.5rem;
        }

        .cart-container {
            background: rgba(30, 30, 46, 0.7);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            overflow: hidden;
            padding: 2rem;
            backdrop-filter: blur(10px);
            margin-bottom: 2rem;
        }

        .cart-table {
            width: 100%;
            border-collapse: collapse;
            color: rgba(255, 255, 255, 0.9);
        }

        .cart-table thead {
            background: rgba(255, 215, 0, 0.1);
            border-bottom: 2px solid rgba(255, 215, 0, 0.3);
        }

        .cart-table th {
            color: var(--gold);
            font-weight: 600;
            padding: 1rem 0.75rem;
            text-align: left;
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .cart-table td {
            padding: 1.5rem 0.75rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            vertical-align: middle;
        }

        .cart-table tbody tr {
            transition: all 0.3s ease;
        }

        .cart-table tbody tr:hover {
            background: rgba(255, 255, 255, 0.05);
        }

        .cart-table tbody tr:last-child td {
            border-bottom: none;
        }

        .product-info {
            display: flex;
            flex-direction: column;
        }

        .product-name {
            color: var(--gold);
            font-weight: 600;
            font-size: 1.1rem;
            margin-bottom: 0.5rem;
        }

        .badge {
            padding: 0.4rem 0.75rem;
            border-radius: 6px;
            font-weight: 600;
            font-size: 0.75rem;
            display: inline-block;
            margin-bottom: 0.5rem;
        }

        .badge-danger {
            background: linear-gradient(135deg, var(--danger-color), #c82333);
            color: white;
        }

        .badge-warning {
            background: linear-gradient(135deg, var(--warning-color), #e0a800);
            color: #000;
        }

        .discount-info {
            font-size: 0.8rem;
            color: var(--gold-light);
            margin-top: 0.25rem;
        }

        .stock-warning {
            color: var(--warning-color);
            font-size: 0.8rem;
            margin-top: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        .price-original {
            text-decoration: line-through;
            color: rgba(255, 255, 255, 0.5);
            font-size: 0.9rem;
        }

        .price-discounted {
            color: var(--success-color);
            font-weight: 600;
            font-size: 1rem;
        }

        .price-normal {
            color: rgba(255, 255, 255, 0.9);
            font-weight: 600;
        }

        .quantity-form {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .quantity-input {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 6px;
            color: rgba(255, 255, 255, 0.9);
            padding: 0.5rem;
            width: 80px;
            text-align: center;
            font-size: 0.9rem;
        }

        .quantity-input:focus {
            outline: none;
            border-color: var(--gold);
            box-shadow: 0 0 0 2px rgba(255, 215, 0, 0.2);
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

        .btn-danger {
            background: linear-gradient(135deg, var(--danger-color), #c82333);
            color: white;
        }

        .btn-danger:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(220, 53, 69, 0.4);
            background: linear-gradient(135deg, #c82333, var(--danger-color));
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

        .btn-success:disabled {
            background: rgba(255, 255, 255, 0.1);
            color: rgba(255, 255, 255, 0.5);
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        .action-buttons {
            display: flex;
            gap: 0.5rem;
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
            background: rgba(220, 53, 69, 0.2);
            border: 1px solid rgba(220, 53, 69, 0.5);
            border-radius: 12px;
            padding: 1rem 1.5rem;
            margin-bottom: 1.5rem;
            color: rgba(255, 255, 255, 0.9);
            text-align: center;
            backdrop-filter: blur(10px);
        }

        /* Responsive Design */
        @media (max-width: 992px) {
            .cart-table {
                display: block;
                overflow-x: auto;
            }

            .cart-table thead {
                display: none;
            }

            .cart-table tbody,
            .cart-table tr,
            .cart-table td {
                display: block;
                width: 100%;
            }

            .cart-table tr {
                margin-bottom: 1.5rem;
                border: 1px solid rgba(255, 255, 255, 0.1);
                border-radius: 12px;
                overflow: hidden;
                background: rgba(255, 255, 255, 0.05);
                padding: 1rem;
            }

            .cart-table td {
                padding: 0.75rem;
                border-bottom: 1px solid rgba(255, 255, 255, 0.05);
                position: relative;
                padding-left: 50%;
            }

            .cart-table td:before {
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

            .cart-container {
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

            .cart-container {
                padding: 1rem;
            }

            .cart-table td {
                padding-left: 40%;
            }

            .cart-table td:before {
                width: 35%;
            }
        }
    </style>

    <div class="container">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="page-title">
                <i class="fas fa-shopping-cart me-2"></i>Keranjang Belanja
            </h1>
        </div>

        <!-- Cart Container -->
        <div class="cart-container">
            {{-- Tampilkan pesan error validasi stok --}}
            @if(session('error'))
                <div class="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>{{ session('error') }}
                </div>
            @endif

            @if ($keranjangs->isEmpty())
                <div class="empty-state">
                    <div class="empty-state-icon">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <h5>Keranjang kamu kosong</h5>
                    <p>Yuk, tambahkan produk favoritmu ke keranjang!</p>
                </div>
            @else
                <table class="cart-table">
                    <thead>
                        <tr>
                            <th data-label="Produk">Produk</th>
                            <th data-label="Harga">Harga</th>
                            <th data-label="Jumlah">Jumlah</th>
                            <th data-label="Subtotal">Subtotal</th>
                            <th data-label="Aksi">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($keranjangs as $item)
                            @if ($item->produk)
                                <tr>
                                    <td data-label="Produk">
                                        <div class="product-info">
                                            <span class="product-name">{{ $item->produk->nama }}</span>

                                            @if (
                                                    $item->produk->diskon &&
                                                    now()->between($item->produk->diskon->tanggal_mulai, $item->produk->diskon->tanggal_berakhir)
                                                )
                                                <span class="badge badge-danger">
                                                    <i class="fas fa-tag me-1"></i>Diskon {{ $item->produk->diskon->persen_diskon }}%
                                                </span>
                                                <span class="discount-info">
                                                    <i class="fas fa-clock me-1"></i>
                                                    Berakhir:
                                                    {{ \Carbon\Carbon::parse($item->produk->diskon->tanggal_berakhir)->translatedFormat('d M Y H:i') }}
                                                </span>
                                            @endif

                                            {{-- Notifikasi stok kurang --}}
                                            @if ($item->jumlah > $item->produk->stok)
                                                <div class="stock-warning">
                                                    <i class="fas fa-exclamation-triangle"></i>
                                                    Stok kurang! (Tersedia: {{ $item->produk->stok }})
                                                </div>
                                            @endif
                                        </div>
                                    </td>

                                    {{-- Harga --}}
                                    <td data-label="Harga">
                                        @if (isset($item->harga_setelah_diskon) && $item->harga_setelah_diskon < $item->produk->harga)
                                            <div class="price-original">
                                                Rp {{ number_format($item->produk->harga, 0, ',', '.') }}
                                            </div>
                                            <div class="price-discounted">
                                                Rp {{ number_format($item->harga_setelah_diskon, 0, ',', '.') }}
                                            </div>
                                        @else
                                            <div class="price-normal">
                                                Rp {{ number_format($item->produk->harga, 0, ',', '.') }}
                                            </div>
                                        @endif
                                    </td>

                                    {{-- Jumlah & Form --}}
                                    <td data-label="Jumlah">
                                        <form action="{{ route('pembeli.keranjang.update', $item->id) }}" method="POST"
                                            class="quantity-form">
                                            @csrf
                                            @method('PUT')
                                            <input type="number" name="jumlah" value="{{ $item->jumlah }}" min="1"
                                                max="{{ $item->produk->stok }}" class="quantity-input">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fas fa-sync-alt"></i>
                                            </button>
                                        </form>
                                    </td>

                                    {{-- Subtotal --}}
                                    <td data-label="Subtotal">
                                        @if (isset($item->subtotal_setelah_diskon) && $item->harga_setelah_diskon < $item->produk->harga)
                                            <div class="price-original">
                                                Rp {{ number_format($item->produk->harga * $item->jumlah, 0, ',', '.') }}
                                            </div>
                                            <div class="price-discounted">
                                                Rp {{ number_format($item->subtotal_setelah_diskon, 0, ',', '.') }}
                                            </div>
                                        @else
                                            <div class="price-normal">
                                                Rp {{ number_format($item->produk->harga * $item->jumlah, 0, ',', '.') }}
                                            </div>
                                        @endif
                                    </td>

                                    {{-- Aksi --}}
                                    <td data-label="Aksi">
                                        <div class="action-buttons">
                                            {{-- Tombol Hapus --}}
                                            <form action="{{ route('pembeli.keranjang.destroy', $item->id) }}" method="POST"
                                                onsubmit="return confirm('Hapus produk ini dari keranjang?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger" title="Hapus dari keranjang">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>

                                            {{-- Tombol Checkout per Produk --}}
                                            <a href="{{ route('pembeli.order', ['produk_id' => $item->produk->id, 'quantity' => $item->jumlah]) }}"
                                                class="btn btn-success
                                                            {{ $item->jumlah > $item->produk->stok ? 'disabled' : '' }}"
                                                @if($item->jumlah > $item->produk->stok) title="Stok tidak mencukupi untuk checkout"
                                                onclick="return false;" @else title="Checkout produk ini" @endif>
                                                <i class="fas fa-credit-card"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endif
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
                const headers = document.querySelectorAll('.cart-table thead th');
                const rows = document.querySelectorAll('.cart-table tbody tr');

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

        // Handle disabled checkout buttons
        document.addEventListener('DOMContentLoaded', function () {
            const checkoutButtons = document.querySelectorAll('.btn-success');

            checkoutButtons.forEach(button => {
                if (button.classList.contains('disabled')) {
                    button.addEventListener('click', function (e) {
                        e.preventDefault();
                        alert('Stok tidak mencukupi untuk melakukan checkout. Silakan kurangi jumlah pesanan atau hapus produk dari keranjang.');
                    });
                }
            });
        });
    </script>
@endsection