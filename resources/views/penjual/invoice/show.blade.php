@extends ('layouts.app')
@section('title', 'Detail Pembayaran')
@section('content')

<link rel="stylesheet" href="{{ asset('vendors/styles/invoice.css') }}"> {{-- pastikan file ini ada --}}
<div class="card shadow-sm p-4 bg-white rounded">
    <div class="text-center mb-4">
        <h4 class="mt-3">INVOICE PEMESANAN</h4>
    </div>

    <div class="row mb-4">
        <div class="col-md-6">
            <h6>Data Pembeli</h6>
            <p class="mb-1">Tanggal Pesanan: <strong>{{ $order->created_at->format('d M Y') }}</strong></p>
            <p class="mb-1">Invoice: <strong>INV-{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</strong></p>
            <p class="mb-1">Status: <strong>{{ ucfirst($order->status) }}</strong></p>
        </div>
        <div class="col-md-6 text-md-end">
            <p class="mb-1">Nama: {{ $order->name}}</p>
            <p class="mb-1">Alamat: {{ $order->alamat }}</p>
            <p class="mb-1">No. HP: {{ $order->phone }}</p>
        </div>
    </div>

    <div class="table-responsive mb-4">
        <table class="table table-bordered">
            <thead class="table-light">
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

    <div class="row mb-4">
        <div class="col-md-6">
            <h6>Info Tambahan</h6>
            <p class="mb-1">Metode Pembayaran: <strong>Transfer Bank</strong></p>
            <p class="mb-1">Bank Tujuan: <strong>BCA - 123456789</strong></p>
        </div>
        <div class="col-md-6 text-md-end">
            <p class="mb-1">Jatuh Tempo: <strong>{{ $order->created_at->addDays(1)->format('d M Y') }}</strong></p>
            <h5 class="text-dark mt-2">Total: Rp {{ number_format($order->total_harga, 0, ',', '.') }}</h5>
        </div>
    </div>

    
    <div class="mt-4 text-center">
        <a href="{{ route('penjual.pesanan.index') }}" class="btn btn-secondary">Kembali ke Daftar Pesanan</a>
    </div>
</div>

@endsection