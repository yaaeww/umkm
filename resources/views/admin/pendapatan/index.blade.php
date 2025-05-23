@extends('layouts.app')

@section('page_title', 'Pendapatan Admin')
@section('title')
    <i class="fa fa-money"></i> Pendapatan Admin
@endsection

@section('content')
<div class="container-fluid">

    <div class="row">
        <!-- Total Penjualan -->
        <div class="col-md-6 mb-4">
            <div class="card-box d-flex align-items-center justify-content-between shadow-sm p-3 bg-white rounded">
                <div>
                    <div class="font-14 text-muted">Total Penjualan (Semua UMKM)</div>
                    <h3 class="mb-0 text-primary">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h3>
                </div>
                <div class="icon-box bg-primary text-white rounded-circle p-3">
                    <i class="fa fa-shopping-cart fa-lg"></i>
                </div>
            </div>
        </div>

        <!-- Pendapatan Admin -->
        <div class="col-md-6 mb-4">
            <div class="card-box d-flex align-items-center justify-content-between shadow-sm p-3 bg-white rounded">
                <div>
                    <div class="font-14 text-muted">Pendapatan Admin (20%)</div>
                    <h3 class="mb-0 text-success">Rp {{ number_format($pendapatanAdmin, 0, ',', '.') }}</h3>
                </div>
                <div class="icon-box bg-success text-white rounded-circle p-3">
                    <i class="fa fa-money fa-lg"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabel Rekap per Toko -->
    <div class="card shadow border-0">
        <div class="card-header bg-primary text-white">
            <strong>Rekap Total Penjualan per Toko</strong>
        </div>
        <div class="card-body p-0">
            <table class="table table-striped mb-0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Toko</th>
                        <th>Total Penjualan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($rekapPerToko as $index => $toko)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $toko->nama_toko }}</td>
                            <td>Rp {{ number_format($toko->total_penjualan, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center text-muted">Belum ada penjualan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
