@extends('layouts.app')

@section('title', 'Dashboard Penjual')

@section('content')
    <style>
        /* Tambahkan style custom jika perlu */
    </style>

    <div class="card-box pd-20 height-100-p mb-30">
        <div class="row align-items-center">
            <div class="col-md-4 text-center">
                @php
                    $avatarPath = auth()->user()->avatar;
                    $fullPath = 'avatar/' . ltrim($avatarPath, '/');
                    $avatarExists = $avatarPath && \Illuminate\Support\Facades\Storage::disk('public')->exists($fullPath);
                    $avatarUrl = $avatarExists
                        ? asset('storage/' . $fullPath)
                        : asset('images/default-avatar.png');
                @endphp
                <img src="{{ $avatarUrl }}" class="rounded-circle img-fluid" style="max-height: 150px;"
                    alt="Avatar Pengguna">
            </div>

            <div class="col-md-8">
                @php
                    $time = now()->format('H');
                    $greeting = match (true) {
                        $time < 12 => 'Selamat pagi',
                        $time < 15 => 'Selamat siang',
                        $time < 18 => 'Selamat sore',
                        default => 'Selamat malam',
                    };
                @endphp
                <h4 class="font-20 weight-500 mb-10 text-capitalize">
                    {{ $greeting }},
                    <div class="weight-600 font-30 text-primary">
                        {{ auth()->user()->name }}!
                    </div>
                </h4>
                <p class="font-18 max-width-600 text-dark">
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
        <x-widget-card color="#00eccf" icon="fa-cubes" title="Total Produk" :value="$totalProduk ?? 0" />

        <!-- Total Kategori -->
        <x-widget-card color="#ff5b5b" icon="fa-tags" title="Kategori Produk" :value="$totalKategori ?? 0" />

        <!-- Total Pembeli -->
        <x-widget-card color="#6c5ce7" icon="fa-users" title="Total Pembeli" :value="$totalPembeliUnik ?? 0" />

        <!-- Pendapatan -->
        <x-widget-card color="#00eccf" icon="fa-money" title="Pendapatan" :value="number_format($pendapatan ?? 0, 0, ',', '.')" />
    </div>

    <!-- Produk Terlaris -->
    <div class="card-box mb-30">
        <h2 class="h4 pd-20">Produk Terlaris</h2>

        @php
            // Fungsi bantu untuk mendapatkan URL gambar produk dengan fallback
            function gambarProduk($path)
            {
                if ($path && \Illuminate\Support\Facades\Storage::disk('public')->exists($path)) {
                    return asset('storage/' . $path);
                }
                return asset('images/no-image.png');
            }
        @endphp

        <div class="table-responsive">
            <table class="data-table table nowrap table-hover">
                <thead>
                    <tr>
                        <th class="table-plus datatable-nosort">Gambar</th>
                        <th>Nama Produk</th>
                        <th>Penjual</th>
                        <th>Harga</th>
                        <th>Jumlah Terjual</th>
                        <th>Total Pendapatan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($produkTerlaris ?? [] as $produk)
                        @php
                            $gambarPath = $produk->gambar ?? '';
                            $gambarUrl = ($gambarPath && \Illuminate\Support\Facades\Storage::disk('public')->exists($gambarPath))
                                ? asset('storage/' . $gambarPath)
                                : asset('images/no-image.png');
                        @endphp
                        <tr>
                            <td class="table-plus">
                                <img src="{{ $gambarUrl }}" width="70" height="70" alt="Produk">
                            </td>
                            <td>{{ $produk->nama ?? '-' }}</td>
                            <td>{{ $produk->penjual_name ?? '-' }}</td>
                            <td>Rp{{ number_format($produk->harga ?? 0, 0, ',', '.') }}</td>
                            <td>{{ $produk->total_unit ?? 0 }} unit</td>
                            <td>Rp{{ number_format($produk->total_penjualan ?? 0, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Belum ada data produk terlaris.</td>
                        </tr>
                    @endforelse

                </tbody>
            </table>
        </div>
    </div>

@endsection