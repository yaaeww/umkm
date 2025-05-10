@extends('layouts.app')

@section('title', 'Detail Pesanan')

@section('content')
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
                        <span
                            class="badge bg-{{ $order->status == 'complete' ? 'success' : ($order->status == 'pending' ? 'warning' : 'danger') }}">
                            {{ ucfirst($order->status) }}
                        </span>
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
                <h5>Total harga: <span class="text-danger">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</span>
                </h5>
            </div>

            {{-- Form untuk mengubah status pesanan --}}
            {{-- Form untuk mengubah status pesanan --}}
            @if($order->status === 'complete')
                <form action="{{ route('penjual.pesanan.updateStatus', $order->id) }}" method="POST" class="mt-4">
                    @csrf
                    @method('PATCH')
                    <div class="form-group">
                        <label class="mb-2">Pilih Status Pengiriman:</label>
                        <div class="btn-group" role="group" aria-label="Status pengiriman">
                            @php
                                // Hanya status yang boleh diubah oleh penjual
                                $pengirimanStatus = ['dikemas' => 'Dikemas', 'dikirim' => 'Dikirim'];
                            @endphp
                            @foreach ($pengirimanStatus as $value => $label)
                                <input type="radio" class="btn-check" name="status_pesanan" id="status-{{ $value }}"
                                    value="{{ $value }}" autocomplete="off"
                                    {{ old('status_pesanan', $order->status_pesanan) === $value ? 'checked' : '' }}>
                                <label class="btn btn-outline-primary" for="status-{{ $value }}">{{ $label }}</label>
                            @endforeach
                        </div>
                    </div>
                    <button type="submit" class="btn btn-success mt-3">Perbarui Status</button>
                </form>
            @endif

            <div class="mt-4 text-center">
                <a href="{{ route('penjual.pesanan.index') }}" class="btn btn-secondary">Kembali ke Daftar Pesanan</a>
            </div>
        </div>
    </div>
@endsection