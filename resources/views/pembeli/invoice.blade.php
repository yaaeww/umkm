@extends('layouts.pembeli-navbar')

@section('content')
<div class="container">
    <h1 class="my-4">Invoice</h1>


    <div class="card shadow rounded border-0 p-4" style="max-width: 500px">
        <h5 class="card-title fw-bold">Detail Pesanan</h5>
        <table class="table">
            <tr>
                <td>Nama</td>
                <td>: {{ $order->name }}</td>
            </tr>
            <tr>
                <td>Nomor Hp</td>
                <td>: {{ $order->phone }}</td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td>: {{ $order->alamat }}</td>
            </tr>
            <tr>
                <td>Jumlah</td>
                <td>: {{ $order->jumlah }}</td>
            </tr>
            <tr>
                <td>Total Harga</td>
                <td>: Rp {{ number_format($order->total_harga, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td>Status</td>
                <td>: {{ $order->status }}</td>
            </tr>
        </table>
    </div>
</div>
@endsection
