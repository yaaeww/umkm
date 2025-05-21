@extends('layouts.app')

@section('title', 'Dashboard Penjual')
    


@section('content')

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
                <img src="{{ $avatarUrl }}" class="rounded-circle img-fluid" style="max-height: 150px;" alt="Avatar Pengguna">
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
        <x-widget-card color="#00eccf" icon="fa-money" title="Pendapatan"
            :value="number_format($pendapatan ?? 0, 0, ',', '.')" />
    </div>

    <!-- Produk Terlaris -->
    <div class="card-box mb-30">
        <h2 class="h4 pd-20">Produk Terlaris</h2>
        <div class="table-responsive">
            <table class="data-table table nowrap table-hover">
                <thead>
                    <tr>
                        <th class="table-plus datatable-nosort">Gambar</th>
                        <th>Nama Produk</th>
                        <th>Penjual</th>
                        <th>Harga</th>
                        <th>Jumlah Terjual</th>
                        <th class="datatable-nosort">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($produkTerlaris ?? [] as $produk)
                        <tr>
                            <td class="table-plus">
                                @if(Storage::disk('public')->exists($produk->gambar))
                                    <img src="{{ asset('storage/' . $produk->gambar) }}" width="70" height="70" alt="Produk">
                                @else
                                    <img src="{{ asset('images/no-image.png') }}" width="70" height="70" alt="Produk">
                                @endif
                            </td>
                            <td>{{ $produk->nama }}</td>
                            <td>{{ $produk->penjual_name }}</td>
                            <td>Rp{{ number_format($produk->harga, 0, ',', '.') }}</td>
                            <td>{{ $produk->jumlah_terjual ?? 0 }}</td>
                            <td>
                                <div class="dropdown">
                                    <a class="btn btn-link p-0" href="#" role="button" id="dropdownMenuButton{{ $produk->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="dw dw-more fs-4"></i>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton{{ $produk->id }}">
                                        <li><a class="dropdown-item" href="#"><i class="dw dw-eye me-2"></i> Lihat</a></li>
                                        <li><a class="dropdown-item" href="#"><i class="dw dw-edit2 me-2"></i> Edit</a></li>
                                        <li><a class="dropdown-item text-danger" href="#"><i class="dw dw-delete-3 me-2"></i> Hapus</a></li>
                                    </ul>
                                </div>
                            </td>
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
