<div class="left-side-bar">
    <div class="brand-logo">
        <a href="{{ url('/') }}">
            <img src="{{ asset('') }}" alt="" class="dark-logo"> 
            <img src="{{ asset('') }}" alt="" class="light-logo"> logo samping
        </a>
    </div>
    <div class="menu-block customscroll">
        <div class="sidebar-menu">
            <ul id="accordion-menu">
                <li class="dropdown">
                    <a href="{{ route(Auth::user()->role . '.dashboard') }}" class="dropdown-toggle no-arrow">
                        <span class="micon bi bi-house"></span><span class="mtext">Dashboard</span>
                    </a>
                </li>
                <!-- Tambahkan menu tambahan sesuai role -->
                <li>
                    <a href="{{route('produk.create')}}" class="dropdown-toggle no-arrow">
                        <span class="micon fa fa-cubes"></span
                        ><span class="mtext">Produk</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
