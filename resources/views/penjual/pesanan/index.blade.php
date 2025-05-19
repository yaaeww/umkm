@extends('layouts.app') {{-- Sesuaikan dengan layout penjual Anda --}}
@section('title')
    <i class="bi bi-tags-fill"></i> Daftar Pesanan pembeli
@endsection
@section('content')
<div class="container mt-4 text-theme">
    
    <h5 class="mt-4 text-theme">Pesanan Selesai (Complete)</h5>
    @if($pesananComplete->isEmpty())
        <div class="alert alert-info text-theme">Belum ada pesanan yang selesai.</div>
    @else
        <div class="table-responsive mb-4 text-theme">
            <table class="table table-bordered text-theme">
                <thead>
                    <tr>
                        <th>NO</th>
                        <th>Nama Produk</th>
                        <th>Pembeli</th>
                        <th>Jumlah</th>
                        <th>Total Harga</th>
                        <th>Status Pembayaran</th>
                        <th>Status Pesanan</th>
                        <th>Status Penerimaan</th>
                        <th>Waktu Pesanan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pesananComplete as $key => $order)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $order->produk->nama ?? '-' }}</td>
                            <td>{{ $order->user->name ?? '-' }}</td>
                            <td>{{ $order->jumlah }}</td>
                            <td>Rp{{ number_format($order->total_harga, 0, ',', '.') }}</td>
                            <td><span class="badge bg-success">{{ ucfirst($order->status) }}</span></td>
                            <td><span class="badge bg-info">{{ ucfirst(str_replace('_', ' ', $order->status_pesanan)) }}</span></td>
                            <td>
                                @if($order->status_pesanan === 'diterima')
                                    <span class="badge bg-success">Diterima</span>
                                @elseif($order->status_pesanan === 'belum_diterima')
                                    <span class="badge bg-warning text-dark">Belum Diterima</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>{{ $order->created_at->format('d M Y H:i') }}</td>
                            <td>
                                <a href="{{ route('penjual.invoice.show', $order->id) }}" class="btn btn-sm btn-primary">Detail</a>
                                <a href="{{ route('penjual.pesanan.create', $order->id) }}" class="btn btn-sm btn-success">Update</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    {{-- Pesanan Cancel --}}
    <h5 class="mt-4 text-theme">Pesanan Dibatalkan (Cancel)</h5>
    @if($pesananCancel->isEmpty())
        <div class="alert alert-warning text-theme">Tidak ada pesanan yang dibatalkan.</div>
    @else
        <div class="table-responsive text-theme">
            <table class="table table-bordered text-theme">
                <thead>
                    <tr>
                        <th>NO</th>
                        <th>Nama Produk</th>
                        <th>Pembeli</th>
                        <th>Jumlah</th>
                        <th>Total Harga</th>
                        <th>Status Pembayaran</th>
                        <th>Status Pesanan</th>
                        <th>Status Penerimaan</th>
                        <th>Waktu Pesanan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pesananCancel as $key => $order)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $order->produk->nama ?? '-' }}</td>
                            <td>{{ $order->user->name ?? '-' }}</td>
                            <td>{{ $order->jumlah }}</td>
                            <td>Rp{{ number_format($order->total_harga, 0, ',', '.') }}</td>
                            <td><span class="badge bg-danger">{{ ucfirst($order->status) }}</span></td>
                            <td><span class="badge bg-secondary">{{ ucfirst(str_replace('_', ' ', $order->status_pesanan)) }}</span></td>
                            <td>
                                @if($order->status_pesanan === 'diterima')
                                    <span class="badge bg-success">Diterima</span>
                                @elseif($order->status_pesanan === 'belum_diterima')
                                    <span class="badge bg-warning text-dark">Belum Diterima</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>{{ $order->created_at->format('d M Y H:i') }}</td>
                            <td>
                                {{-- Tidak ada aksi untuk pesanan cancel --}}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
