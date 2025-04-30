@php
    $role = Auth::user()->role ?? 'guest';
@endphp

<aside class="sidebar">
    <div class="sidebar-header">
        <h4>{{ ucfirst($role) }} Panel</h4>
    </div>

    <ul class="nav">

        @if ($role === 'admin')
            <li><a href="{{ route('admin.dashboard') }}">Dashboard Admin</a></li>
            <li><a href="#">Manajemen User</a></li>
            <li><a href="#">Laporan</a></li>

        @elseif ($role === 'penjual')
            <li><a href="{{ route('penjual.dashboard') }}">Dashboard Penjual</a></li>
            <li><a href="{{ route('produk.create') }}">Tambah Produk</a></li>
            <li><a href="{{ route('penjual.dashboard') }}">Daftar Produk</a></li>

        @elseif ($role === 'pembeli')
            <li><a href="{{ route('produk.index') }}">Lihat Produk</a></li>
            <li><a href="#">Pesanan Saya</a></li>

        @else
            <li><a href="{{ route('login') }}">Login</a></li>
        @endif

        <li><a href="{{ route('profile.edit') }}">Profil</a></li>
        <li><form action="{{ route('logout') }}" method="POST">@csrf <button type="submit">Logout</button></form></li>
    </ul>
</aside>
