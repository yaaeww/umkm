@extends('layouts.app')

@section('page_title', 'Detail Pesanan')


@section('title')
    <i class="icon-copy bi bi-cart-fill"></i> Detail Pesanan
@endsection

@section('content')
    <div class="container mt-4 text-theme">
        <h4 class="mb-4 text-theme">Detail Pesanan Pembeli</h4>

        <div class="card shadow-sm p-4 text-theme">
            <div class="row mb-3">
                <div class="col-md-6 text-theme">
                    <h6 class="text-theme">Informasi Pembeli</h6>
                    <p class="text-theme">Nama: <strong>{{ $order->name }}</strong></p>
                    <p class="text-theme">No HP: <strong>{{ $order->phone }}</strong></p>
                    <p class="text-theme">Alamat: <strong>{{ $order->alamat }}</strong></p>
                </div>
                <div class="col-md-6 text-md-end text-theme">
                    <h6 class="text-theme">Informasi Pesanan</h6>
                    <p class="text-theme">No. Pesanan: <strong>{{ $order->order_id_midtrans }}</strong></p>
                    <p class="text-theme">Tanggal: <strong>{{ $order->created_at->format('d M Y') }}</strong></p>
                    <p class="text-theme">Status Pembayaran:
                        <span
                            class="badge bg-{{ $order->status == 'complete' ? 'success' : ($order->status == 'pending' ? 'warning' : 'danger') }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </p>
                    <p class="text-theme">Status Pesanan:
                        <span class="badge bg-info">{{ ucfirst(str_replace('_', ' ', $order->status_pesanan)) }}</span>
                    </p>
                </div>
            </div>

            <div class="table-responsive mb-3 text-theme">
                <table class="table table-bordered text-theme">
                    <thead class="table-light text-theme">
                        <tr>
                            <th>Produk</th>
                            <th>Harga</th>
                            <th>Jumlah</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="text-theme">{{ $order->produk->nama }}</td>
                            <td class="text-theme">Rp {{ number_format($order->produk->harga, 0, ',', '.') }}</td>
                            <td class="text-theme">{{ $order->jumlah }}</td>
                            <td class="text-theme">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="text-end text-theme">
                <h5 class="text-theme">Total harga: <span class="text-theme">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</span></h5>
            </div>

            {{-- Form untuk mengubah status pesanan --}}
            @if($order->status === 'complete')
                <form action="{{ route('penjual.pesanan.updateStatus', $order->id) }}" method="POST" class="mt-4 text-theme">
                    @csrf
                    @method('PATCH')
                    <div class="form-group">
                        <label class="mb-2 text-theme">Pilih Status Pengiriman:</label>
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
