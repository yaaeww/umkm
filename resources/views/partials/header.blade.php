<div class="header">
    <div class="header-left">
        <div class="menu-icon bi bi-list"></div>
        <div class="header-search">
            <h4 class="text-capitalize header-title">@yield('title', 'Dashboard')</h4>
        </div>
    </div>

    <!-- Theme Settings Icon -->
    <div class="dashboard-setting user-notification">
        <div class="dropdown">
            <a class="dropdown-toggle no-arrow" href="javascript:;" data-toggle="right-sidebar">
                <i class="icon-copy bi bi-cloud-moon-fill"></i>
            </a>
        </div>
    </div>

    <!-- Right Sidebar Settings -->
    <div class="right-sidebar text">
        <div class="sidebar-title">
            <h3 class="weight-600 font-16 text-color">
                Layout Settings
                <span class="btn-block font-weight-400 font-12">User Interface Settings</span>
            </h3>
            <div class="close-sidebar" data-toggle="right-sidebar-close">
                <i class="icon-copy ion-close-round"></i>
            </div>
        </div>

        <div class="right-sidebar-body customscroll">
            <div class="right-sidebar-body-content">
                <h4 class="weight-600 font-18 pb-10 text-color">Header Background</h4>
                <div class="sidebar-btn-group pb-30 mb-10">
                    <a href="javascript:void(0);" class="btn btn-outline-primary header-white active">Terang</a>
                    <a href="javascript:void(0);" class="btn btn-outline-primary header-dark">Gelap</a>
                </div>

                <h4 class="weight-600 font-18 pb-10 text-color">Sidebar Background</h4>
                <div class="sidebar-btn-group pb-30 mb-10">
                    <a href="javascript:void(0);" class="btn btn-outline-primary sidebar-light active">Terang</a>
                    <a href="javascript:void(0);" class="btn btn-outline-primary sidebar-dark">Gelap</a>
                </div>

                <div class="reset-options pt-30 text-center">
                    <button class="btn btn-danger" id="reset-settings">Reset Settings</button>
                </div>
            </div>
        </div>
    </div>

    <!-- User Dropdown -->
    <div class="user-info-dropdown">
        <div class="dropdown">
            <a class="dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                <span class="user-name">{{ Auth::user()->name }}</span>
            </a>
            <div class="dropdown-menu dropdown-menu-right">
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
