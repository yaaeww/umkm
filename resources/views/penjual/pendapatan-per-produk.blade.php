@extends('layouts.app')

@section('page_title', 'Pendapatan')

@section('title')

    <i class="icon-copy bi bi-cash-coin"></i> Pendapatan
@endsection

@section('content')
    <div class="container mt-4 text-theme">
        @php
            use Illuminate\Support\Number;
        @endphp

    

        {{-- Filter Waktu --}}
        <form method="GET" class="mb-3">
            <div class="row g-2 align-items-center">
                <div class="col-auto">
                    <label for="filter" class="col-form-label">Filter Waktu:</label>
                </div>
                <div class="col-auto">
                    <select name="filter" id="filter" class="form-select" onchange="this.form.submit()">
                        <option value="minggu" {{ request('filter') == 'minggu' ? 'selected' : '' }}>Minggu Ini</option>
                        <option value="bulan" {{ request('filter', 'bulan') == 'bulan' ? 'selected' : '' }}>Bulan Ini
                        </option>
                        <option value="tahun" {{ request('filter') == 'tahun' ? 'selected' : '' }}>Tahun Ini</option>
                    </select>
                </div>
            </div>
        </form>

        {{-- Info Pendapatan Bulan Lalu --}}
        <div class="alert alert-secondary">
            <strong>Pendapatan Bulan Lalu:</strong>
            {{ isset($totalPendapatanBulanLalu) ? Number::currency($totalPendapatanBulanLalu, 'IDR', locale: 'id_ID') : '-' }}
        </div>

        {{-- Tombol Export --}}
        <div class="mb-3">
            <a href="{{ route('penjual.pendapatan.export.summary.excel', request()->all()) }}"
                class="btn btn-success btn-sm">
                <i class="bi bi-file-earmark-excel"></i> Export Excel
            </a>
            <a href="{{ route('penjual.pendapatan.export.summary.pdf', request()->all()) }}" class="btn btn-danger btn-sm">
                <i class="bi bi-file-earmark-pdf"></i> Export PDF
            </a>
        </div>

        {{-- Tabel Pendapatan --}}
        @if($pendapatanPerProduk->isEmpty())
            <div class="alert alert-info mt-3">
                Belum ada pendapatan dari produk pada periode ini.
            </div>
        @else
            <div class="table-responsive mt-3">
                <table class="table table-bordered text-theme">
                    <thead class="table-light">
                        <thead class="table-light">
                            <tr>
                                <th>No</th>
                                <th>Nama Produk</th>
                                <th>Total Terjual</th>
                                <th>Total Pendapatan</th>
                                <th>Stok Terpakai</th>
                                <th>Stok Tersisa</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                    </thead>
                    <tbody>
                        @foreach($pendapatanPerProduk as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item->nama_produk }}</td>
                                <td>{{ $item->total_terjual ?? 0 }}</td>
                                <td>{{ Number::currency($item->total_pendapatan ?? 0, 'IDR', locale: 'id_ID') }}</td>
                                <td>{{ $item->total_terjual ?? 0 }}</td>
                                <td>{{ $item->stok }}</td>
                                <td>
                                    <a href="{{ route('penjual.pendapatan.detail', $item->id) }}" class="btn btn-sm btn-primary">
                                        <i class="bi bi-eye"></i> Lihat Detail
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>
        @endif
    </div>
@endsection