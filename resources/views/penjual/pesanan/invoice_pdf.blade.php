<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Invoice Pesanan #INV-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #000000;
            margin: 0;
            padding: 20px;
            background: #fff;
        }
        h4 {
            color: #0d6efd; /* biru tema */
            text-align: center;
            margin-bottom: 20px;
        }
        .text-theme {
            color: #0d6efd;
        }
        .text-color {
            color: #000000;
        }
        .invoice-container {
            max-width: 800px;
            margin: 0 auto;
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 6px;
        }
        .row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .col-md-6 {
            width: 48%;
        }
        .text-md-end {
            text-align: right;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            color: #000000;
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        table thead th {
            background-color: #f8f9fa;
            color: #0d6efd;
        }
        a.button {
            display: inline-block;
            padding: 8px 12px;
            margin: 5px;
            border: 1px solid #0d6efd;
            color: #0d6efd;
            text-decoration: none;
            border-radius: 4px;
            font-weight: 600;
        }
        a.button:hover {
            background-color: #0d6efd;
            color: #fff;
        }
        .text-right {
            text-align: right;
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        <h4>INVOICE PEMESANAN</h4>

        <div class="row text-color">
            <div class="col-md-6">
                <h6>Data Pembeli</h6>
                <p class="mb-1">Tanggal Pesanan: <strong>{{ $order->created_at->format('d M Y') }}</strong></p>
                <p class="mb-1">Invoice: <strong>INV-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</strong></p>
                <p class="mb-1">Status: <strong>{{ ucfirst($order->status) }}</strong></p>
            </div>
            <div class="col-md-6 text-md-end text-color">
                <p class="mb-1">Nama: {{ $order->name }}</p>
                <p class="mb-1">Alamat: {{ $order->alamat }}</p>
                <p class="mb-1">No. HP: {{ $order->phone }}</p>
            </div>
        </div>

        <table>
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
                    <td>{{ number_format($order->produk->harga, 0, ',', '.') }}</td>
                    <td>{{ $order->jumlah }}</td>
                    <td>{{ number_format($order->total_harga, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>

        <div class="row text-color">
            <div class="col-md-6">
                <h6>Info Tambahan</h6>
                <p class="mb-1">Metode Pembayaran: <strong>Transfer Bank</strong></p>
                <p class="mb-1">Bank Tujuan: <strong>BCA - 123456789</strong></p>
            </div>
            <div class="col-md-6 text-md-end">
                <p class="mb-1">Jatuh Tempo: <strong>{{ $order->created_at->addDays(1)->format('d M Y') }}</strong></p>
                <h5>Total: {{ number_format($order->total_harga, 0, ',', '.') }}</h5>
            </div>
        </div>
    </div>
</body>
</html>
