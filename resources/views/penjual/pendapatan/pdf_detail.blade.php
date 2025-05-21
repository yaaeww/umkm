<!DOCTYPE html>
<html>
<head>
    <title>Laporan Pendapatan - {{ $produk->nama }}</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #333;
            padding: 6px;
        }
    </style>
</head>
<body>
    <h3>Detail Pendapatan - {{ $produk->nama }}</h3>
    <table>
        <thead>
            <tr>
                <th>ID Order</th>
                <th>Nama Pembeli</th>
                <th>Jumlah</th>
                <th>Total Harga</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($detail as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td>{{ $item->pengguna->nama ?? '-' }}</td>
                    <td>{{ $item->jumlah }}</td>
                    <td>{{ number_format($item->total_harga, 0, ',', '.') }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d-m-Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
