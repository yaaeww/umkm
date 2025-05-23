@extends('layouts.app')

@section('page_title', 'Pendapatan')

@section('title')

    <i class="icon-copy bi bi-cash-coin"></i> Detail Pendapatan
@endsection

@section('content')
<div class="container mt-4 text-theme">
    <h4><i class="bi bi-receipt"></i> Detail Pendapatan - {{ $produk->nama }}</h4>

    @if($detail->isEmpty())
        <div class="alert alert-warning">Belum ada transaksi untuk produk ini.</div>
    @else
        {{-- Tombol Export --}}
        <div class="mb-3">
            <a href="{{ route('penjual.pendapatan.detail.export.excel', $produk->id) }}" class="btn btn-success btn-sm">
                <i class="bi bi-file-earmark-excel"></i> Export Excel
            </a>
            <a href="{{ route('penjual.pendapatan.detail.export.pdf', $produk->id) }}" class="btn btn-danger btn-sm">
                <i class="bi bi-file-earmark-pdf"></i> Export PDF
            </a>
        </div>

        {{-- Tabel Transaksi --}}
        <div class="table-responsive mt-3">
            <table class="table table-bordered">
                <thead class="table-light">
                    <tr>
                        <th>ID Order</th>
                        <th>Nama Pembeli</th>
                        <th>Jumlah</th>
                        <th>Total Harga</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($detail as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->nama_pemesan ?? '-' }}</td>
                            <td>{{ $item->jumlah }}</td>
                            <td>{{ Number::currency($item->total_harga, 'IDR', locale: 'id_ID') }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('d F Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

    <a href="{{ route('penjual.pendapatan.index') }}" class="btn btn-secondary mt-3">Kembali</a>
</div>
@endsection
