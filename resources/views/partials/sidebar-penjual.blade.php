{{-- sidebar-penjual.blade.php --}}
<div class="left-side-bar">
    <div class="brand-logo">
        <a href="/">
            <div class="logo" style="margin-left: 30px;">
                <!-- Logo warna gelap, selalu tampil -->
                <img src="{{ asset('aset/finalisasi logo.png') }}" alt="Logo Gelap" class="logo-dark"
                    style="display:block;">
                <!-- Logo warna terang, sembunyikan -->
                <img src="{{ asset('aset/finalisasi logo-white.png') }}" alt="Logo Terang" class="logo-light"
                    style="display:none;">
            </div>
        </a>
        <div class="close-sidebar" data-toggle="left-sidebar-close">
            <i class="ion-close-round"></i>
        </div>
    </div>
    <div class="menu-block customscroll">
        <div class="sidebar-menu">
            <ul id="accordion-menu">
                <li>
                    <a href="{{ route('penjual.dashboard') }}" class="dropdown-toggle no-arrow">
                        <span class="micon bi bi-house"></span><span class="mtext">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('penjual.umkm.index') }}" class="dropdown-toggle no-arrow">
                        <span class="micon fa fa-university"></span><span class="mtext">Toko</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('penjual.produk.create') }}" class="dropdown-toggle no-arrow">
                        <span class="micon bi bi-plus-square"></span><span class="mtext">Tambah Produk</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('penjual.produk.index') }}" class="dropdown-toggle no-arrow">

                        <span class="micon fa fa-cubes"></span><span class="mtext">Produk Toko</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('penjual.profile.show') }}" class="dropdown-toggle no-arrow">
                        <span class="micon bi bi-person"></span><span class="mtext">Profil</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('penjual.pesanan.index') }}" class="dropdown-toggle no-arrow">
                        <span class="micon bi bi-cart"></span><span class="mtext">Pesanan</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('penjual.pendapatan.index') }}" class="dropdown-toggle no-arrow">
                        <span class="micon fa fa-money"></span><span class="mtext">Pendapatan</span>
                    </a>
                </li>
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-toggle no-arrow btn btn-danger mtext"
                            style="padding-left: 38px;">
                            <span class="micon bi bi-box-arrow-left"></span>>Logout
                        </button>
                    </form>

                </li>
            </ul>
        </div>
    </div>
</div>