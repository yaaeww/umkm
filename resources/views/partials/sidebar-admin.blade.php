{{-- sidebar-penjual.blade.php --}}
<div class="left-side-bar">
    <div class="brand-logo">
        <a href="/">
            <div class="logo" style="margin-left: 30px;">
                <img src="{{ asset('aset\finalisasi logo.png') }}" alt="" class="light-logo">
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
                    <a href="invoice.html" class="dropdown-toggle no-arrow">
                        <span class="micon fa fa-bell"></span
                        ><span class="mtext">Notifikasi</span>
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
                        <li><a href="introduction.html">Introduction</a></li>
                        <li><a href="getting-started.html">Getting Started</a></li>
                        <li><a href="color-settings.html">Color Settings</a></li>
                        <li>
                            <a href="third-party-plugins.html">Third Party Plugins</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-toggle no-arrow btn btn-link mtext" style="padding-left: 38px;">
                            <span class="micon bi bi-box-arrow-left"></span> Logout
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</div>
