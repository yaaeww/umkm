<div class="header">
    <div class="header-left">
        <div class="menu-icon bi bi-list"></div>
        <div class="header-search">
            <h4>@yield('title', 'Dashboard')</h4>
        </div>
    </div>
    <div class="header-right">
        <!-- Tombol Settings -->
        <div class="user-info-dropdown mr-2">
            <div class="dropdown">
                <a class="dropdown-toggle" href="{}">
                    <span class="user-icon">
                        <i class="bi bi-gear" style="font-size: 1.5rem;"></i>
                    </span>
                </a>
            </div>
        </div>

        <!-- Dropdown User -->
        <div class="user-info-dropdown">
            <div class="dropdown">
                <a class="dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                    <span class="user-icon">
                        <img src="{{ asset('path/to/default-profile.png') }}" alt="User" style="width:40px; height:40px; object-fit:cover; border-radius:50%;">
                    </span>
                    <span class="user-name">{{ Auth::user()->name }}</span>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <a class="dropdown-item" href="{{ route(Auth::user()->role . '.profile.edit') }}">
                        <i class="bi bi-person"></i> Edit Profile
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="dropdown-item" type="submit">
                            <i class="bi bi-box-arrow-right"></i> Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
