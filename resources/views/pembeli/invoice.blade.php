@extends ('layouts.pembeli-navbar')
@section('title', 'Detail Pembayaran')
@section('content')
<style>
    body {
        background-color: black !important;
    }
</style>

<link rel="stylesheet" href="{{ asset('vendors/styles/invoice.css') }}"> {{-- pastikan file ini ada --}}

<div class="container mt-4">
    <h4 class="mb-4">Detail Pesanan Pembeli</h4>

    <div class="card shadow-sm p-4">
        <div class="row mb-3">
            <div class="col-md-6">
                <h6>Informasi Pembeli</h6>
                <p>Nama: <strong>{{ $order->name }}</strong></p>
                <p>No HP: <strong>{{ $order->phone }}</strong></p>
                <p>Alamat: <strong>{{ $order->alamat }}</strong></p>
            </div>
            <div class="col-md-6 text-md-end">
                <h6>Informasi Pesanan</h6>
                <p>No. Pesanan: <strong>{{ $order->order_id_midtrans }}</strong></p>
                <p>Tanggal: <strong>{{ $order->created_at->format('d M Y') }}</strong></p>
                <p>Status Pembayaran: 
                    @if ($order->status === 'complete')
                        <span class="badge bg-success">Lunas</span>
                    @elseif ($order->status === 'cancel')
                        <span class="badge bg-danger">Dibatalkan</span>
                    @elseif ($order->status === 'pending')
                        <span class="badge bg-warning text-dark">Pending</span>
                    @endif
                </p>
                <p>Status Pesanan:
                    <span class="badge bg-info">{{ ucfirst(str_replace('_', ' ', $order->status_pesanan)) }}</span>
                </p>
            </div>
        </div>

        <div class="table-responsive mb-3">
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

        <div class="text-end">
            <h5>Total harga: <span class="text-danger">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</span></h5>
        </div>

        {{-- Form Update Status Pesanan --}}
        @if($order->status === 'complete' && $order->status_pesanan === 'dikirim')
            <form action="{{ route('pembeli.pesanan.updateStatus', $order->id) }}" method="POST" class="mt-4">
                @csrf
                @method('PATCH')
                <div class="form-group">
                    <label class="mb-2">Konfirmasi Penerimaan Barang:</label>
                    <div class="btn-group" role="group" aria-label="Status pengiriman">
                        @php
                            $pengirimanStatus = ['diterima' => 'Diterima', 'belum_diterima' => 'Belum Diterima'];
                        @endphp
                        @foreach ($pengirimanStatus as $value => $label)
                            <input type="radio" class="btn-check" name="status_pesanan" id="status-{{ $value }}" value="{{ $value }}"
                                autocomplete="off"
                                {{ old('status_pesanan', $order->status_pesanan) === $value ? 'checked' : '' }}>
                            <label class="btn btn-outline-primary" for="status-{{ $value }}">{{ $label }}</label>
                        @endforeach
                    </div>
                </div>
                <button type="submit" class="btn btn-success mt-3">Perbarui Status</button>
            </form>
        @endif

        <div class="mt-4 text-center">
            <a href="{{ route('pembeli.pesanan.index') }}" class="btn btn-secondary">Kembali ke Daftar Pesanan</a>
        </div>
    </div>
</div>

@endsection
