@extends('layouts.pembeli-navbar')

@section('title', 'Profil Penjual')

@section('content')
    <!-- Tambahkan CDN Font Awesome jika belum -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <div class="row">
        <!-- PROFIL -->
        <div class="col-xl-4 col-lg-4 col-md-12 mb-3">
            <div class="card">
                <div class="card-body text-center">
                    @if(auth()->user()->avatar && Storage::disk('public')->exists(auth()->user()->avatar))
                        <img src="{{ asset('storage/' . auth()->user()->avatar) }}" class="rounded-circle mb-3" width="120" alt="Avatar">
                    @else
                        <img src="{{ asset('vendors/images/photo1.jpg') }}" class="rounded-circle mb-3" width="120" alt="Default Avatar">
                    @endif
        
                    <h5 class="mb-0">{{ auth()->user()->name }}</h5>
                    <p class="text-muted">Pengguna</p>
                    <hr>
                    <h6>Email</h6>
                    <p>{{ auth()->user()->email }}</p>
                    <p>Telepon: 619-229-0054</p> {{-- Ganti dengan data dari user jika tersedia --}}
                    <p>Alamat: 1807 Holden Street, San Diego, CA 92115</p> {{-- Ganti juga jika datanya disimpan --}}
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
                            <a href="" class="text-decoration-none text-dark">
                                <i class="fa-solid fa-cube fa-2x text-info"></i>
                                <p class="mt-1 small">Dikemas</p>
                            </a>
                        </div>
                        <div>
                            <a href="" class="text-decoration-none text-dark">
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

                    <!-- TIMELINE PESANAN -->
                    <ul class="list-group">
                        <li class="list-group-item">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>12 Juli</strong><br>
                                    Task ditambahkan: Lorem ipsum dolor sit amet.
                                </div>
                                <span class="badge bg-secondary">09:30</span>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>10 Juli</strong><br>
                                    Task ditambahkan: Lorem ipsum dolor sit amet.
                                </div>
                                <span class="badge bg-secondary">09:30</span>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>10 Juni</strong><br>
                                    Event ditambahkan: Lorem ipsum dolor sit amet.
                                </div>
                                <span class="badge bg-secondary">09:30</span>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection