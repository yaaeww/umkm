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
                    <a href="{{ route('admin.dashboard') }}" class="dropdown-toggle no-arrow">
                        <span class="micon bi bi-house"></span><span class="mtext">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.kategori.index') }}" class="dropdown-toggle no-arrow">
                        <span class="micon bi bi-plus-square"></span><span class="mtext">Tambah Kategori</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.umkm.index') }}" class="dropdown-toggle no-arrow">
                        <span class="micon fa fa-university"></span><span class="mtext">Toko</span>
                    </a>
                </li>

                <li>
                    <div class="sidebar-small-cap">Extra</div>
                </li>
                <li>
                    <a href="javascript:;" class="dropdown-toggle" data-option="off">
                        <span class="micon fa fa-gear"></span><span class="mtext">Setting</span>
                    </a>
                    <ul class="submenu">
                        <li>
                            <a href="{{ route('admin.penjual.index') }}">
                                <i class="bi bi-shop me-2"></i> Akun Penjual
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.pembeli.index') }}">
                                <i class="bi bi-person-badge me-2"></i> Akun Pembeli
                            </a>
                        </li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="btn btn-danger mtext" style="padding-left: 38px;">
                                    <i class="bi bi-box-arrow-left me-2"></i> Logout
                                </button>
                            </form>
                        </li>
                    </ul>

                </li>

            </ul>
        </div>
    </div>
</div>