<form action="{{ route('pembeli.pesanan.bulkDelete') }}" method="POST"
    onsubmit="return confirm('Yakin ingin menghapus pesanan yang dipilih?')">
    @csrf
    @method('DELETE')

    <div class="bulk-actions">
        <button type="submit" class="btn btn-danger">
            <i class="fas fa-trash me-2"></i>Hapus yang Dipilih
        </button>
    </div>

    <div class="orders-table-container">
        <table class="orders-table">
            <thead>
                <tr>
                    <th class="checkbox-cell">
                        <input type="checkbox" id="select-all">
                    </th>
                    <th>Produk</th>
                    <th>Jumlah</th>
                    <th>Total Harga</th>
                    <th>Status Pembayaran</th>
                    <th>Status Pengiriman</th>
                    <th>Tanggal</th>
                    <th class="action-cell">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $order)
                    <tr>
                        <td class="checkbox-cell">
                            <input type="checkbox" name="order_ids[]" value="{{ $order->id }}" class="order-checkbox">
                        </td>
                        <td>
                            <div class="product-info">
                                <i class="fas fa-cube me-2 text-gold"></i>
                                {{ $order->produk->nama ?? '-' }}
                            </div>
                        </td>
                        <td>{{ $order->jumlah }}</td>
                        <td class="price-value">Rp{{ number_format($order->total_harga, 0, ',', '.') }}</td>
                        <td>
                            <span class="badge badge-{{ $badge }}">
                                <i class="fas fa-credit-card me-1"></i>{{ $label }}
                            </span>
                        </td>
                        <td>
                            @if ($order->status_pesanan)
                                <span class="badge badge-info">
                                    <i class="fas fa-truck me-1"></i>
                                    {{ ucfirst(str_replace('_', ' ', $order->status_pesanan)) }}
                                </span>
                            @else
                                <span class="badge badge-secondary">
                                    <i class="fas fa-clock me-1"></i>Belum Diproses
                                </span>
                            @endif
                        </td>
                        <td>
                            <div class="date-info">
                                <i class="fas fa-calendar me-2 text-muted"></i>
                                {{ $order->created_at->format('d-m-Y H:i') }}
                            </div>
                        </td>
                        <td class="action-cell">
                            <div class="action-buttons">
                                <a href="{{ route('pembeli.invoice.show', $order->id) }}" class="btn btn-primary btn-sm"
                                    title="Lihat Invoice">
                                    <i class="fas fa-file-invoice"></i>
                                </a>
                                @if ($order->status === 'cancel')
                                    <form action="{{ route('pembeli.pesanan.destroy', $order->id) }}" method="POST"
                                        onsubmit="return confirm('Hapus pesanan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" title="Hapus Pesanan">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</form>

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

    .bulk-actions {
        display: flex;
        justify-content: flex-end;
        margin-bottom: 1.5rem;
    }

    .orders-table-container {
        background: rgba(30, 30, 46, 0.7);
        border: 1px solid rgba(255, 255, 255, 0.1);
        border-radius: 16px;
        overflow: hidden;
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

    .product-info {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .price-value {
        color: var(--gold-light);
        font-weight: 600;
    }

    .date-info {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: rgba(255, 255, 255, 0.8);
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

    .action-buttons {
        display: flex;
        gap: 0.5rem;
        justify-content: center;
    }

    .btn {
        border: none;
        border-radius: 8px;
        padding: 0.5rem 0.75rem;
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

    .btn-sm {
        padding: 0.4rem 0.6rem;
        font-size: 0.8rem;
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

        .action-buttons {
            justify-content: flex-start;
        }
    }

    @media (max-width: 768px) {
        .bulk-actions {
            flex-direction: column;
            gap: 0.5rem;
        }

        .btn {
            width: 100%;
            justify-content: center;
        }
    }

    @media (max-width: 576px) {
        .orders-table td {
            padding-left: 40%;
        }

        .orders-table td:before {
            width: 35%;
        }
    }
</style>

<script>
    // Menangani aksi "Select All" untuk memilih semua checkbox
    document.getElementById('select-all').addEventListener('change', function (e) {
        const checkboxes = document.querySelectorAll('.order-checkbox');
        checkboxes.forEach(checkbox => {
            checkbox.checked = e.target.checked;
        });
    });

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
</script>