@extends('layouts.pembeli-navbar')

@section('content')
<div class="container">
    <h1 class="my-4">Pesanan Saya</h1>

    @php
        $pesananLunas = $pesanan->where('status', 'complete');
        $pesananPending = $pesanan->where('status', 'pending');
        $pesananCancel = $pesanan->where('status', 'cancel');
    @endphp

    {{-- PESANAN LUNAS --}}
    <h4 class="mt-5">Pesanan Lunas</h4>
    @if ($pesananLunas->isEmpty())
        <div class="alert alert-success">Tidak ada pesanan lunas.</div>
    @else
        <form action="{{ route('pembeli.pesanan.bulkDelete') }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus pesanan yang dipilih?')">
            @csrf
            @method('DELETE')
            <div class="text-end mb-2">
                <button type="submit" class="btn btn-danger btn-sm">Hapus yang Dipilih</button>
            </div>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th><input type="checkbox" id="select-all-lunas"></th>
                        <th>Produk</th>
                        <th>Jumlah</th>
                        <th>Total Harga</th>
                        <th>Status Pembayaran</th>
                        <th>Status Pengiriman</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pesananLunas as $order)
                        <tr>
                            <td><input type="checkbox" name="order_ids[]" value="{{ $order->id }}" class="order-checkbox-lunas"></td>
                            <td>{{ $order->produk->nama ?? '-' }}</td>
                            <td>{{ $order->jumlah }}</td>
                            <td>Rp{{ number_format($order->total_harga, 0, ',', '.') }}</td>
                            <td><span class="badge bg-success">{{ ucfirst($order->status) }}</span></td>
                            <td>
                                @if ($order->status_pesanan)
                                    <span class="badge bg-info">{{ ucfirst(str_replace('_', ' ', $order->status_pesanan)) }}</span>
                                @else
                                    <span class="badge bg-secondary">Belum Diproses</span>
                                @endif
                            </td>
                            <td>{{ $order->created_at->format('d-m-Y H:i') }}</td>
                            <td>
                                <a href="{{ route('pembeli.invoice.show', $order->id) }}" class="btn btn-sm btn-primary">Invoice</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </form>
    @endif

    {{-- PESANAN MENUNGGU PEMBAYARAN --}}
    <h4 class="mt-5">Pesanan Menunggu Pembayaran</h4>
    @if ($pesananPending->isEmpty())
        <div class="alert alert-warning">Tidak ada pesanan yang menunggu pembayaran.</div>
    @else
        <form action="{{ route('pembeli.pesanan.bulkDelete') }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus pesanan yang dipilih?')">
        
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th><input type="checkbox" id="select-all-pending"></th>
                        <th>Produk</th>
                        <th>Jumlah</th>
                        <th>Total Harga</th>
                        <th>Status Pembayaran</th>
                        <th>Status Pengiriman</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pesananPending as $order)
                        <tr>
                            <td><input type="checkbox" name="order_ids[]" value="{{ $order->id }}" class="order-checkbox-pending"></td>
                            <td>{{ $order->produk->nama ?? '-' }}</td>
                            <td>{{ $order->jumlah }}</td>
                            <td>Rp{{ number_format($order->total_harga, 0, ',', '.') }}</td>
                            <td><span class="badge bg-warning">{{ ucfirst($order->status) }}</span></td>
                            <td>
                                @if ($order->status_pesanan)
                                    <span class="badge bg-info">{{ ucfirst(str_replace('_', ' ', $order->status_pesanan)) }}</span>
                                @else
                                    <span class="badge bg-secondary">Belum Diproses</span>
                                @endif
                            </td>
                            <td>{{ $order->created_at->format('d-m-Y H:i') }}</td>
                            <td>
                                <a href="{{ route('pembeli.status.belum-bayar') }}" class="btn btn-sm btn-primary">Bayar</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </form>
    @endif

    {{-- PESANAN DIBATALKAN --}}
    <h4 class="mt-5">Pesanan Dibatalkan</h4>
    @if ($pesananCancel->isEmpty())
        <div class="alert alert-danger">Tidak ada pesanan yang dibatalkan.</div>
    @else
        <form action="{{ route('pembeli.pesanan.bulkDelete') }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus pesanan yang dipilih?')">
            @csrf
            @method('DELETE')
            <div class="text-end mb-2">
                <button type="submit" class="btn btn-danger btn-sm">Hapus yang Dipilih</button>
            </div>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th><input type="checkbox" id="select-all-cancel"></th>
                        <th>Produk</th>
                        <th>Jumlah</th>
                        <th>Total Harga</th>
                        <th>Status Pembayaran</th>
                        <th>Status Pengiriman</th>
                        <th>Tanggal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pesananCancel as $order)
                        <tr>
                            <td><input type="checkbox" name="order_ids[]" value="{{ $order->id }}" class="order-checkbox-cancel"></td>
                            <td>{{ $order->produk->nama ?? '-' }}</td>
                            <td>{{ $order->jumlah }}</td>
                            <td>Rp{{ number_format($order->total_harga, 0, ',', '.') }}</td>
                            <td><span class="badge bg-danger">{{ ucfirst($order->status) }}</span></td>
                            <td>
                                @if ($order->status_pesanan)
                                    <span class="badge bg-info">{{ ucfirst(str_replace('_', ' ', $order->status_pesanan)) }}</span>
                                @else
                                    <span class="badge bg-secondary">Belum Diproses</span>
                                @endif
                            </td>
                            <td>{{ $order->created_at->format('d-m-Y H:i') }}</td>
                            <td>
                                <a href="{{ route('pembeli.invoice.show', $order->id) }}" class="btn btn-sm btn-primary">Invoice</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </form>
    @endif
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
</script>
@endsection
