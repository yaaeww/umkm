@extends('layouts.app')

@section('title', 'Dashboard Penjual')

@section('content')
<div class="card-box pd-20 height-100-p mb-30">
    <div class="row align-items-center">
        <div class="col-md-4">

<div class="col-md-4 text-center">
    @if(auth()->user()->avatar && Storage::disk('public')->exists(auth()->user()->avatar))
        <img src="{{ asset('storage/' . auth()->user()->avatar) }}" class="rounded-circle img-fluid" style="max-height: 150px;" alt="Avatar Pengguna">
    @else
        <img src="{{ asset('images/default-avatar.png') }}" class="rounded-circle img-fluid" style="max-height: 150px;" alt="Default Avatar">
    @endif
</div>
            
            
        </div>
        <div class="col-md-8">
            @php
                $time = now()->format('H');
                if ($time < 12) {
                    $greeting = 'Selamat pagi';
                } elseif ($time < 15) {
                    $greeting = 'Selamat siang';
                } elseif ($time < 18) {
                    $greeting = 'Selamat sore';
                } else {
                    $greeting = 'Selamat malam';
                }
            @endphp

            <h4 class="font-20 weight-500 mb-10 text-capitalize">
                {{ $greeting }},
                <div class="weight-600 font-30 text-blue">
                    {{ auth()->user()->name }}!
                </div>
            </h4>
            <p class="font-18 max-width-600">
                @if(auth()->user()->isAdmin())
                    Selamat datang di dashboard Admin. Anda dapat mengelola seluruh sistem dari sini.
                @elseif(auth()->user()->isPenjual())
                    Selamat berjualan! Pantau produk dan penjualan Anda di dashboard ini.
                @else
                    Selamat berbelanja! Temukan produk terbaik untuk kebutuhan Anda.
                @endif
            </p>
        </div>
    </div>
</div>

<div class="row pb-10">
    <!-- Total Produk -->
    <div class="col-xl-3 col-lg-3 col-md-6 mb-20">
        <div class="card-box height-100-p widget-style3">
            <div class="d-flex flex-wrap">
                <div class="widget-data">
                    <div class="weight-700 font-24 text-dark">{{ $totalProduk ?? 0 }}</div>
                    <div class="font-14 text-secondary weight-500">Total Produk</div>
                </div>
                <div class="widget-icon">
                    <div class="icon" data-color="#00eccf">
                        <i class="icon-copy fa fa-cubes"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Kategori -->
    <div class="col-xl-3 col-lg-3 col-md-6 mb-20">
        <div class="card-box height-100-p widget-style3">
            <div class="d-flex flex-wrap">
                <div class="widget-data">
                    <div class="weight-700 font-24 text-dark">{{ $totalKategori ?? 0 }}</div>
                    <div class="font-14 text-secondary weight-500">Kategori Produk</div>
                </div>                
                <div class="widget-icon">
                    <div class="icon" data-color="#ff5b5b">
                        <i class="icon-copy fa fa-tags"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Total Pembeli -->
    <div class="col-xl-3 col-lg-3 col-md-6 mb-20">
        <div class="card-box height-100-p widget-style3">
            <div class="d-flex flex-wrap">
                <div class="widget-data">
                    <div class="weight-700 font-24 text-dark">{{ $totalPembeli ?? 0 }}</div>
                    <div class="font-14 text-secondary weight-500">Total Pembeli</div>
                </div>
                <div class="widget-icon">
                    <div class="icon">
                        <i class="icon-copy fa fa-users" aria-hidden="true"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pendapatan -->
    <div class="col-xl-3 col-lg-3 col-md-6 mb-20">
        <div class="card-box height-100-p widget-style3">
            <div class="d-flex flex-wrap">
                <div class="widget-data">
                    <div class="weight-700 font-24 text-dark">{{ number_format($pendapatan ?? 0, 0, ',', '.') }}</div>
                    <div class="font-14 text-secondary weight-500">Pendapatan</div>
                </div>
                <div class="widget-icon">
                    <div class="icon" data-color="#00eccf">
                        <i class="icon-copy fa fa-money"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Best Selling Products -->
<div class="card-box mb-30">
    <h2 class="h4 pd-20">Produk Terlaris</h2>
    <div class="table-responsive">
        <table class="data-table table nowrap">
            <thead>
                <tr>
                    <th class="table-plus datatable-nosort">Product</th>
                    <th>Nama Produk</th>
                    <th>Warna</th>
                    <th>Harga</th>
                    <th>Jumlah Terjual</th>
                    <th class="datatable-nosort">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($produkTerlaris ?? [] as $produk)
                    <tr>
                        <td class="table-plus">
                            <img src="{{ asset('storage/' . $produk->gambar) }}" width="70" height="70" alt="Produk">
                        </td>
                        <td>
                            <h5 class="font-16">{{ $produk->nama }}</h5>
                            oleh {{ $produk->penjual->name }}
                        </td>
                        <td>{{ $produk->warna ?? '-' }}</td>
                        <td>Rp {{ number_format($produk->harga, 0, ',', '.') }}</td>
                        <td>{{ $produk->jumlah_terjual ?? 0 }}</td>
                        <td>
                            <div class="dropdown">
                                <a class="btn btn-link font-24 p-0 line-height-1 no-arrow dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                                    <i class="dw dw-more"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                                    <a class="dropdown-item" href="#"><i class="dw dw-eye"></i> Lihat</a>
                                    <a class="dropdown-item" href="#"><i class="dw dw-edit2"></i> Edit</a>
                                    <a class="dropdown-item" href="#"><i class="dw dw-delete-3"></i> Hapus</a>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
                @if(empty($produkTerlaris) || count($produkTerlaris) == 0)
                    <tr>
                        <td colspan="6" class="text-center">Belum ada data produk terlaris.</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection
