@extends('layouts.pembeli-navbar')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4 text-center">Daftar Pesanan Anda</h1>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if ($pesanans->isEmpty())
        <div class="alert alert-warning text-center">
            Anda belum memiliki pesanan.
        </div>
    @else
        <div class="table-responsive">
            <table class="table table-bordered align-middle text-center">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>Alamat Pengiriman</th>
                        <th>Total Harga</th>
                        <th>Status</th>
                        <th>Detail</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pesanans as $index => $pesanan)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $pesanan->alamat_pengiriman }}</td>
                            <td>Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</td>
                            <td>
                                <span class="badge bg-success">Berhasil</span>
                            </td>
                            <td>
                                <a href="{{ route('pembeli.pesanan.show', $pesanan->id) }}" class="btn btn-info btn-sm">
                                    Lihat
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
