@extends('layouts.app')

@section('page_title', 'Dashboard')

@section('title')

    <i class="icon-copy bi bi-house-fill"></i> Home Admin
@endsection

@section('content')

    <div class="card-box pd-20 height-100-p mb-30">
        <div class="row align-items-center">
            <div class="col-md-4">
                <img src="{{ asset('vendors/images/banner-img.png') }}" alt="">
            </div>

            </h4>
            @php
                $time = now()->format('H');
                if ($time < 12) {
                    $greeting = 'Selamat pagi';
                } elseif ($time < 15) {
                    $greeting = 'Selamat siang';
                } elseif ($time < 18) {
                    $greeting = 'Selamat malam';
                } else {
                    $greeting = 'Selamat malam';
                }
            @endphp

            <h4 class="font-20 weight-500 mb-10 text-capitalize">
                {{ $greeting }},
                <div class="weight-600 font-30 text-blue">
                    {{ auth()->user()->name }}!
                </div>
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
    @php
        use App\Models\Produk;
        use App\Models\KategoriProduk;
        use App\Models\User;
        use App\Models\Umkm;

        // Jumlah semua produk yang dimiliki UMKM
        $totalProduk = Produk::whereHas('umkm')->count();

        // Jumlah kategori produk
        $jumlahKategori = KategoriProduk::count();

        // Jumlah penjual yang sudah punya data di UMKM
        $totalPenjual = User::where('role', 'penjual')
            ->whereHas('umkm')
            ->count();
    @endphp

    <div class="row pb-10">
        <div class="col-xl-3 col-lg-3 col-md-6 mb-20">
            <div class="card-box height-100-p widget-style3">
                <div class="d-flex flex-wrap">
                    <div class="widget-data">
                        <div class="weight-700 font-24 text-dark">{{ $totalProduk }}</div>
                        <div class="font-14 text-secondary weight-500">Total Produk</div>
                    </div>
                    <div class="widget-icon">
                        <div class="icon" data-color="#00eccf" style="color: rgb(0, 236, 207);">
                            <i class="icon-copy fa fa-cubes"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-3 col-md-6 mb-20">
            <div class="card-box height-100-p widget-style3">
                <div class="d-flex flex-wrap">
                    <div class="widget-data">
                        <div class="weight-700 font-24 text-dark">{{ $jumlahKategori }}</div>
                        <div class="font-14 text-secondary weight-500">Kategori Produk</div>
                    </div>
                    <div class="widget-icon">
                        <div class="icon" data-color="#ff5b5b" style="color: rgb(255, 91, 91);">
                            <span class="icon-copy fa fa-tags"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-3 col-md-6 mb-20">
            <div class="card-box height-100-p widget-style3">
                <div class="d-flex flex-wrap">
                    <div class="widget-data">
                        <div class="weight-700 font-24 text-dark">{{ $totalPenjual }}</div>
                        <div class="font-14 text-secondary weight-500">Total Penjual</div>
                    </div>
                    <div class="widget-icon">
                        <div class="icon">
                            <i class="icon-copy fa fa-users" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @php
            use App\Models\Order;

            // Ambil total harga dari semua order yang status-nya 'complete'
            $totalPendapatan = Order::where('status', 'complete')->sum('total_harga');
            $pendapatanAdmin = $totalPendapatan * 0.2;
        @endphp

        <div class="col-xl-3 col-lg-3 col-md-6 mb-20">
            <div class="card-box height-100-p widget-style3">
                <div class="d-flex flex-wrap">
                    <div class="widget-data">
                        <div class="weight-700 font-24 text-dark">
                            Rp {{ number_format($pendapatanAdmin, 0, ',', '.') }}
                        </div>
                        <div class="font-14 text-secondary weight-500">Pendapatan Admin</div>
                    </div>
                    <div class="widget-icon">
                        <div class="icon" data-color="#3a86ff" style="color: #3a86ff;">
                            <i class="fa fa-money" aria-hidden="true"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>



    </div>

@endsection