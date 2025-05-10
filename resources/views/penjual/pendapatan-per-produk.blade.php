@extends('layouts.app') {{-- Sesuaikan dengan layout yang digunakan penjual --}}

@section('content')
<div class="container mt-4">
    <h4 class="mb-3">Pendapatan per Produk</h4>

    @if($pendapatanPerProduk->isEmpty())
        <div class="alert alert-info">Belum ada pendapatan dari produk.</div>
    @else
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>NO</th>
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
                            <td>Rp{{ number_format($item->total_pendapatan, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
