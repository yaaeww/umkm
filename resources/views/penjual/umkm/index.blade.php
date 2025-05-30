@extends('layouts.app')

@section('page_title', 'Toko Saya')

@section('title')
    <i class="icon-copy bi bi-shop"></i> Toko Saya
@endsection

@section('content')
<div class="row">
    {{-- Jika UMKM belum terdaftar --}}
    @if (!$umkm)
        <div class="col-12">
            <div class="alert alert-warning text-theme">
                <h5 class="text-theme">Toko Anda belum terdaftar!</h5>
                <p class="text-theme">Silakan daftar toko terlebih dahulu agar dapat melanjutkan.</p>
                <a href="{{ route('penjual.umkm.create') }}" class="btn btn-primary">Daftar Toko</a>
            </div>
        </div>
    @else
        {{-- Kartu Profil Toko --}}
        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-30">
            <div class="pd-20 card-box height-100-p text-theme">
                <div class="profile-photo text-center">
                    @if ($umkm->logo)
                        <img src="{{ asset('storage/' . $umkm->logo) }}" alt="Logo Toko" class="avatar-photo" style="max-height: 120px;">
                    @else
                        <img src="{{ asset('vendors/images/default-logo.png') }}" alt="Logo Default" class="avatar-photo" style="max-height: 120px;">
                    @endif
                </div>

                <h5 class="text-center h5 mt-3 mb-0 text-theme">{{ $umkm->nama_toko }}</h5>
                <p class="text-center text-muted font-14 text-theme">{{ $umkm->deskripsi ?? 'Tidak ada deskripsi' }}</p>

                <div class="profile-info mt-3">
                    <h5 class="mb-20 h5 text-blue text-theme">Informasi Toko</h5>
                    <ul class="text-theme">
                        <li><span>Alamat:</span><br><p>{{ $umkm->alamat }}</p></li>
                        <li class="mt-2"><span>No. Telepon:</span><br>{{ $umkm->no_telp ?? '-' }}</li>
                        <li class="mt-2">
                            <span>Status:</span><br>
                            <span class="badge badge-{{ $umkm->status == 'approved' ? 'success' : ($umkm->status == 'pending' ? 'warning' : 'danger') }}">
                                {{ ucfirst($umkm->status) }}
                            </span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        {{-- Kartu Status atau Aksi --}}
        <div class="col-xl-8 col-lg-8 col-md-6 col-sm-12 mb-30">
            <div class="pd-20 card-box height-100-p text-theme">
                @switch($umkm->status)
                    @case('pending')
                        <h3 class="text-theme">Toko Anda masih menunggu persetujuan admin.</h3>
                        <p class="text-theme">Nama Toko: {{ $umkm->nama_toko }}</p>
                        @break

                    @case('approved')
                        <h5 class="text-theme">Nama Toko: {{ $umkm->nama_toko }}</h5>
                        <p class="text-theme">Alamat: {{ $umkm->alamat }}</p>
                        <p class="text-theme">No. Telepon: {{ $umkm->no_telp }}</p>
                        <div class="text-center mt-3">
                            <a href="{{ route('penjual.umkm.edit', $umkm->id) }}" class="btn btn-sm btn-primary">Edit Toko</a>
                        </div>
                        @break

                    @case('rejected')
                        <h3 class="text-theme">Toko Anda ditolak oleh admin.</h3>
                        <p class="text-theme">Silakan perbaiki data Anda dan daftar ulang.</p>
                        <a href="{{ route('penjual.umkm.edit', $umkm->id) }}" class="btn btn-primary">Perbaiki Data Toko</a>
                        @break

                    @default
                        <h3 class="text-theme">Status toko tidak dikenali.</h3>
                @endswitch
            </div>
        </div>
    @endif
</div>
@endsection
