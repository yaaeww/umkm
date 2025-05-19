@extends('layouts.app')

@section('title')
    <i class="bi bi-money"></i> Pendapatan
@endsection

@section('content')
<div class="container mt-4 text-theme">
    @php
        use Illuminate\Support\Number;
    @endphp

    @if($pendapatanPerProduk->isEmpty())
        <div class="alert alert-info">Belum ada pendapatan dari produk.</div>
    @else
        <div class="table-responsive">
            <table class="table table-bordered text-theme">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Produk</th>
                        <th>Total Terjual</th>
                        <th>Total Pendapatan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pendapatanPerProduk as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $item->nama_produk }}</td>
                            <td>{{ $item->total_terjual }}</td>
                            <td>{{ Number::currency($item->total_pendapatan, 'IDR', locale: 'id_ID') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
