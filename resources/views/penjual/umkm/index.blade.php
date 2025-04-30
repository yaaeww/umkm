@extends('layouts.app')
@section('title', 'Toko')

@section('content')
<div class="tab-content">
    @if ($umkm)
        @switch($umkm->status)
            @case('pending')
                <h3>Toko Anda masih menunggu persetujuan admin.</h3>
                @break

            @case('approved')
                <h5>Nama Toko: {{ $umkm->nama_toko }}</h5>
                <p>Alamat: {{ $umkm->alamat }}</p>
                <p>No. Telepon: {{ $umkm->no_telp }}</p>
                @break

            @case('rejected')
                <h3>Toko Anda ditolak oleh admin.</h3>
                <p>Silakan perbaiki data Anda dan daftar ulang.</p>
                <a href="{{ route('penjual.umkm.create') }}" class="btn btn-primary">Daftarkan Ulang Toko</a>
                @break

            @default
                <h3>Status toko tidak dikenali.</h3>
        @endswitch
    @else
        <h3>Anda belum memiliki toko.</h3>
        <p>Silakan daftar toko Anda terlebih dahulu.</p>
        <a href="{{ route('penjual.umkm.create') }}" class="btn btn-primary">Daftarkan Toko</a>
    @endif
</div>
@endsection
