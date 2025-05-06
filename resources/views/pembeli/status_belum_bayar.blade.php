@extends('layouts.pembeli-navbar')

@section('content')
    <div class="container mt-4">
        <h3>Status Pesanan: Belum Bayar</h3>

        <p>Total pesanan belum bayar: {{ $orders->count() }}</p>

        <table class="table table-bordered table-hover">
            <thead class="table-light">
                <tr>
                    <th>Nama</th>
                    <th>Nomor HP</th>
                    <th>Alamat</th>
                    <th>Jumlah</th>
                    <th>Total Harga</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                    <tr>
                        <td>{{ $order->name }}</td>
                        <td>{{ $order->phone }}</td>
                        <td>{{ $order->alamat }}</td>
                        <td>{{ $order->jumlah }}</td>
                        <td>Rp {{ number_format($order->total_harga, 0, ',', '.') }}</td>
                        <td><span class="badge bg-warning text-dark">{{ $order->status }}</span></td>
                        <td>
                            <a href="{{ route('pembeli.pending', ['order_id_midtrans' => $order->order_id_midtrans]) }}" class="btn btn-sm btn-primary" >Bayar Sekarang</a>
                            <form action="{{ route('pembeli.order.cancelExpired', $order->id) }}" class="btn btn-sm btn-danger" method="POST">
                                @csrf
                                <button type="submit">Batalkan</button>
                            </form>
                        </td>                        
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
