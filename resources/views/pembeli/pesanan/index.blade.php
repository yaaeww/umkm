@extends('layouts.pembeli-navbar')

@section('content')
<div class="container">
    <h1 class="my-4">Pesanan Saya</h1>

    @if ($pesanan->isEmpty())
        <div class="alert alert-info">Belum ada pesanan.</div>
    @else
        <div class="card shadow-sm">
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Produk</th>
                            <th>Jumlah</th>
                            <th>Total Harga</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pesanan as $order)
                            <tr>
                                <td>{{ $order->produk->nama ?? '-' }}</td>
                                <td>{{ $order->jumlah }}</td>
                                <td>Rp{{ number_format($order->total_harga, 0, ',', '.') }}</td>
                                <td>
                                    @if ($order->status == 'complete')
                                        <span class="badge bg-success">Lunas</span>
                                    @elseif ($order->status == 'pending')
                                        <span class="badge bg-warning">Menunggu</span>
                                    @else
                                        <span class="badge bg-secondary">{{ ucfirst($order->status) }}</span>
                                    @endif
                                </td>
                                <td>{{ $order->created_at->format('d-m-Y H:i') }}</td>
                                <td>
                                    <a href="{{ url('/invoice/' . $order->id) }}" class="btn btn-sm btn-primary">Lihat Invoice</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>
@endsection
