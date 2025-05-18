@extends('layouts.pembeli-navbar')

@section('title', 'Profil Penjual')

@section('content')
<style>
    body {
        background-color: black !important;
    }
</style>
    <!-- Tambahkan CDN Font Awesome jika belum -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <div class="row">
        <!-- PROFIL -->
        <div class="col-xl-4 col-lg-4 col-md-12 mb-3">
            <div class="card">
                <div class="card-body text-center">
                    @if(auth()->user()->avatar && Storage::disk('public')->exists(auth()->user()->avatar))
                        <img src="{{ asset('storage/' . auth()->user()->avatar) }}" class="rounded-circle mb-3" width="120"
                            alt="Avatar">
                    @else
                        <img src="{{ asset('images/default-avatar.jpg') }}" class="rounded-circle mb-3" width="120" alt="Default Avatar">

                    @endif

                    <h5 class="mb-0">{{ auth()->user()->name }}</h5>
                    <p class="text-muted">Pengguna</p>
                    <hr>
                    <h6>Email</h6>
                    <p>{{ auth()->user()->email }}</p>

                    <!-- Menampilkan alamat dan telepon dari order terakhir -->
                    @if(auth()->user()->orders->count() > 0)
                        @php
                            $lastOrder = auth()->user()->orders->last(); // Mengambil order terakhir
                        @endphp
                        <p><strong>Telepon:</strong> {{ $lastOrder->phone ?? 'Tidak tersedia' }}</p>
                        <p><strong>Alamat:</strong> {{ $lastOrder->alamat ?? 'Tidak tersedia' }}</p>
                    @else
                        <p><strong>Telepon:</strong> Tidak tersedia</p>
                        <p><strong>Alamat:</strong> Tidak tersedia</p>
                    @endif

                    <div class="text-center mt-3">
                        <a href="{{ route('pembeli.profile.edit') }}" class="btn btn-sm btn-primary">Edit Profil</a>
                    </div>
                </div>
            </div>
        </div>


        <!-- PESANAN DAN STATUS -->
        <div class="col-xl-8 col-lg-8 col-md-12 mb-3">
            <div class="card">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Pesanan Saya</h5>
                </div>
                <div class="card-body">

                    <!-- STATUS PESANAN -->
                    <div class="d-flex justify-content-around text-center mb-4">
                        <div>
                            <a href="{{route('pembeli.status.belum-bayar')}}" class="text-decoration-none text-dark">
                                <i class="fa-solid fa-credit-card fa-2x text-warning"></i>
                                <p class="mt-1 small">Belum Bayar</p>
                            </a>
                        </div>
                        <div>
                            <a href="{{route('pembeli.status.dikemas')}}" class="text-decoration-none text-dark">
                                <i class="fa-solid fa-cube fa-2x text-info"></i>
                                <p class="mt-1 small">Dikemas</p>
                            </a>
                        </div>
                        <div>
                            <a href="{{route('pembeli.status.dikirim')}}" class="text-decoration-none text-dark">
                                <i class="fa-solid fa-truck fa-2x text-primary"></i>
                                <p class="mt-1 small">Dikirim</p>
                            </a>
                        </div>
                        <div>
                            <a href="" class="text-decoration-none text-dark">
                                <i class="fa-solid fa-star fa-2x text-success"></i>
                                <p class="mt-1 small">Beri Penilaian</p>
                            </a>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
@endsection
