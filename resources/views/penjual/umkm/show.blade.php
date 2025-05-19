@extends('penjual.dashboard')
@section('title')
    <i class="bi bi-tags-fill"></i> Toko Saya
@endsection
@section('content')

    @if (session('warning'))
        <div class="alert alert-warning">{{ session('warning') }}</div>
    @endif

    @if ($umkm)
        <div class="card">
            <div class="card-body">
                <h5>{{ $umkm->nama_toko }}</h5>
                <p><strong>Alamat:</strong> {{ $umkm->alamat }}</p>
                <p><strong>No Telp:</strong> {{ $umkm->no_telp ?? '-' }}</p>
                <p><strong>Status:</strong> 
                    @if ($umkm->status == 'approved')
                        <span class="badge bg-success">Disetujui</span>
                    @elseif ($umkm->status == 'pending')
                        <span class="badge bg-warning text-dark">Menunggu Persetujuan</span>
                    @else
                        <span class="badge bg-danger">Ditolak</span>
                    @endif
                </p>
                @if ($umkm->logo)
                    <img src="{{ asset('storage/' . $umkm->logo) }}" width="120">
                @endif
            </div>
        </div>
    @else
        <p class="text-muted">Kamu belum mendaftarkan toko.</p>
        <a href="{{ route('penjual.umkm.create') }}" class="btn btn-primary mt-2">Daftarkan Sekarang</a>
    @endif
@endsection
