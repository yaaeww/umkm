{{-- sidebar-admin.blade.php --}}
<style>
    :root {
        --dark-blue: #0a1628;
        --medium-blue: #142b47;
        --gold: #ffd700;
        --gold-light: #ffef8f;
        --text-light: #e7e7e7;
    }

    /* Sidebar Base */
    .left-side-bar {
        background: linear-gradient(180deg, var(--dark-blue), var(--medium-blue));
        border-right: 1px solid rgba(210, 179, 5, 0.885);
        box-shadow: 4px 0 20px rgba(0, 0, 0, 0.5);
    }

    /* Brand Logo */
    .brand-logo {
        padding: 25px 20px;
        border-bottom: 1px solid rgba(210, 179, 5, 0.885);
        text-align: center;
        position: relative;
    }

    .brand-logo img {
        width: 130px;
        transition: transform .25s ease, filter .25s ease;
        filter: drop-shadow(0 0 5px rgba(210, 179, 5, 0.885));
    }

    .brand-logo img:hover {
        transform: scale(1.04);
        filter: drop-shadow(0 0 10px rgba(210, 179, 5, 0.885));
    }

    .close-sidebar {
        position: absolute;
        top: 15px;
        right: 15px;
        color: var(--gold);
        cursor: pointer;
        font-size: 20px;
        transition: all 0.3s ease;
    }

    .close-sidebar:hover {
        color: var(--gold-light);
        transform: scale(1.1);
    }

    /* Menu Items */
    .sidebar-menu ul li a {
        color: var(--text-light);
        padding: 14px 22px;
        display: flex;
        align-items: center;
        gap: 12px;
        transition: background .25s, color .25s, padding-left .25s;
        text-decoration: none;
        border: none;
        background: none;
        width: 100%;
        text-align: left;
        cursor: pointer;
    }

    .sidebar-menu ul li a:hover {
        background: rgba(255, 215, 0, 0.08);
        color: var(--gold);
        padding-left: 28px;
    }

    .sidebar-menu ul li a.active {
        background: rgba(255, 215, 0, 0.15);
        border-left: 4px solid var(--gold);
        color: var(--gold);
    }

    /* Icons */
    .micon {
        font-size: 18px;
        color: var(--gold);
        width: 20px;
        text-align: center;
    }

    .mtext {
        font-weight: 500;
    }

    /* Section Titles */
    .sidebar-small-cap {
        color: var(--gold);
        font-weight: 600;
        padding: 20px 22px 10px;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 1px;
        border-bottom: 1px solid rgba(255, 215, 0, 0.2);
        margin: 10px 0;
    }

    /* Submenu */
    .submenu {
        background: rgba(10, 22, 40, 0.9);
        border-left: 2px solid var(--gold);
        padding: 8px 0;
        margin-left: 10px;
        display: none;
    }

    .submenu.show {
        display: block;
        animation: slideDown 0.3s ease;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .submenu li a {
        padding: 10px 28px !important;
        color: #bfc7d5 !important;
        font-size: 13px !important;
        text-decoration: none;
        display: flex !important;
        align-items: center;
        gap: 8px;
    }

    .submenu li a:hover {
        color: var(--gold) !important;
        background: rgba(255, 215, 0, 0.05) !important;
        padding-left: 32px !important;
    }

    /* Logout Button in Submenu */
    .submenu li form .btn-danger {
        background: #ff4b4b !important;
        color: #fff !important;
        padding: 10px 28px !important;
        width: 100%;
        text-align: left;
        border: none;
        border-radius: 0;
        transition: background .25s, padding-left .25s;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13px;
        cursor: pointer;
    }

    .submenu li form .btn-danger:hover {
        background: #ff3434 !important;
        padding-left: 32px !important;
    }

    /* Scrollbar */
    .customscroll {
        scrollbar-width: thin;
        scrollbar-color: var(--gold) var(--dark-blue);
    }

    .customscroll::-webkit-scrollbar {
        width: 6px;
    }

    .customscroll::-webkit-scrollbar-track {
        background: var(--dark-blue);
    }

    .customscroll::-webkit-scrollbar-thumb {
        background: var(--gold);
        border-radius: 3px;
    }

    .customscroll::-webkit-scrollbar-thumb:hover {
        background: var(--gold-light);
    }

    /* Sparkle Animation */
    .sparkle-sidebar {
        position: absolute;
        width: 100%;
        height: 100%;
        pointer-events: none;
        overflow: hidden;
        z-index: 1;
    }

    @keyframes sparkleFloat {

        0%,
        100% {
            transform: translateY(0) scale(1);
            opacity: 0;
        }

        50% {
            transform: translateY(-20px) scale(1.5);
            opacity: 1;
        }
    }

    /* Floating Animation for Logo */
    .floating-logo {
        animation: float 3s ease-in-out infinite;
    }

    @keyframes float {

        0%,
        100% {
            transform: translateY(0);
        }

        50% {
            transform: translateY(-5px);
        }
    }

    /* Mobile Responsive */
    @media(max-width: 768px) {
        .left-side-bar {
            transform: translateX(-100%);
            transition: transform .3s ease;
            position: fixed;
            z-index: 1000;
            height: 100vh;
        }

        .left-side-bar.show {
            transform: translateX(0);
        }

        .brand-logo img {
            width: 100px;
        }

        .close-sidebar {
            display: block;
        }
    }

    /* Dropdown arrow */
    .dropdown-toggle::after {
        content: '\f107';
        font-family: 'Font Awesome 5 Free';
        font-weight: 900;
        border: none;
        margin-left: auto;
        transition: transform 0.3s ease;
    }

    .dropdown-toggle[data-option="off"]::after {
        display: none;
    }

    .dropdown-toggle.active::after {
        transform: rotate(180deg);
    }
</style>

<div class="left-side-bar">
    <div class="sparkle-sidebar" id="sparkle-container"></div>

    <div class="brand-logo">
        <a href="/">
            <div class="logo" style="margin-left: 30px;">
                <img src="{{ asset('aset/finalisasi logo.png') }}" alt="Logo UMKM Indramayu" style="display:block;"
                    class="floating-logo">
            </div>
        </a>
        <div class="close-sidebar" data-toggle="left-sidebar-close">
            <i class="fas fa-times"></i>
        </div>
    </div>

    <div class="menu-block customscroll">
        <div class="sidebar-menu">
            <ul id="accordion-menu">
                <li>
                    <a href="{{ route('admin.dashboard') }}" class="dropdown-toggle no-arrow">
                        <span class="micon"><i class="fas fa-home"></i></span>
                        <span class="mtext">Dashboard</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.kategori.index') }}" class="dropdown-toggle no-arrow">
                        <span class="micon"><i class="fas fa-layer-group"></i></span>
                        <span class="mtext">Kategori</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.umkm.index') }}" class="dropdown-toggle no-arrow">
                        <span class="micon"><i class="fas fa-store"></i></span>
                        <span class="mtext">Toko</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.produk.index') }}" class="dropdown-toggle no-arrow">
                        <span class="micon"><i class="fas fa-box-open"></i></span>
                        <span class="mtext">Produk</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.pendapatan.index') }}" class="dropdown-toggle no-arrow">
                        <span class="micon"><i class="fas fa-money-bill-wave"></i></span>
                        <span class="mtext">Pendapatan</span>
                    </a>
                </li>

                <li>
                    <div class="sidebar-small-cap">Pengaturan</div>
                </li>

                <li class="dropdown">
                    <a href="javascript:;" class="dropdown-toggle" data-option="on">
                        <span class="micon"><i class="fas fa-cog"></i></span>
                        <span class="mtext">Pengguna</span>
                    </a>
                    <ul class="submenu">
                        <li>
                            <a href="{{ route('admin.penjual.index') }}">
                                <i class="fas fa-user-tie me-2"></i> Akun Penjual
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.pembeli.index') }}">
                                <i class="fas fa-users me-2"></i> Akun Pembeli
                            </a>
                        </li>
                    </ul>
                </li>

                <li>
                    <div class="sidebar-small-cap">Akun</div>
                </li>

                <li>
                    <form method="POST" action="{{ route('logout') }}" class="w-100">
                        @csrf
                        <button type="submit" class="logout-btn btn-danger w-100 d-flex align-items-right">
                            <span class="logout-icon"><i class="fas fa-sign-out-alt"></i></span>
                            <span class="logout-text">Logout</span>
                        </button>

                    </form>
                </li>
            </ul>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Sparkle animation
        function createSparkle() {
            const sparkleContainer = document.getElementById('sparkle-container');
            if (!sparkleContainer) return;

            const sparkle = document.createElement('div');
            sparkle.style.position = 'absolute';
            sparkle.style.width = '4px';
            sparkle.style.height = '4px';
            sparkle.style.background = '#ffd700';
            sparkle.style.borderRadius = '50%';
            sparkle.style.boxShadow = '0 0 10px #ffd700';
            sparkle.style.left = Math.random() * 100 + '%';
            sparkle.style.top = Math.random() * 100 + '%';
            sparkle.style.animation = 'sparkleFloat 2s forwards';
            sparkle.style.pointerEvents = 'none';
            sparkle.style.zIndex = '1';

            sparkleContainer.appendChild(sparkle);

            setTimeout(() => {
                if (sparkle.parentNode) {
                    sparkle.parentNode.removeChild(sparkle);
                }
            }, 2000);
        }

        // Start sparkle animation
        setInterval(createSparkle, 1000);

        // Dropdown functionality
        const dropdownToggles = document.querySelectorAll('.dropdown-toggle[data-option="on"]');
        dropdownToggles.forEach(toggle => {
            toggle.addEventListener('click', function (e) {
                e.preventDefault();
                const submenu = this.nextElementSibling;
                const isActive = this.classList.contains('active');

                // Close all other dropdowns
                document.querySelectorAll('.dropdown-toggle.active').forEach(item => {
                    if (item !== this) {
                        item.classList.remove('active');
                        item.nextElementSibling.classList.remove('show');
                    }
                });

                // Toggle current dropdown
                this.classList.toggle('active');
                if (submenu && submenu.classList.contains('submenu')) {
                    submenu.classList.toggle('show');
                }
            });
        });

        // Close sidebar on mobile
        const closeSidebar = document.querySelector('.close-sidebar');
        if (closeSidebar) {
            closeSidebar.addEventListener('click', function () {
                document.querySelector('.left-side-bar').classList.remove('show');
            });
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function (e) {
            if (!e.target.closest('.dropdown')) {
                document.querySelectorAll('.dropdown-toggle.active').forEach(toggle => {
                    toggle.classList.remove('active');
                    toggle.nextElementSibling.classList.remove('show');
                });
            }
        });

        // Set active menu based on current URL
        function setActiveMenu() {
            const currentUrl = window.location.href;
            const menuLinks = document.querySelectorAll('.sidebar-menu a');

            menuLinks.forEach(link => {
                if (link.href === currentUrl) {
                    link.classList.add('active');
                    // If it's in a dropdown, open the dropdown
                    const dropdown = link.closest('.submenu');
                    if (dropdown) {
                        dropdown.classList.add('show');
                        const toggle = dropdown.previousElementSibling;
                        if (toggle) {
                            toggle.classList.add('active');
                        }
                    }
                }
            });
        }

        setActiveMenu();

        // Add hover effect to logout button
        const logoutButton = document.querySelector('form[action*="logout"] button');
        if (logoutButton) {
            logoutButton.addEventListener('mouseenter', function () {
                this.style.background = 'rgba(255, 215, 0, 0.08)';
                this.style.color = 'var(--gold)';
                this.style.paddingLeft = '28px';
            });

            logoutButton.addEventListener('mouseleave', function () {
                this.style.background = 'none';
                this.style.color = 'var(--text-light)';
                this.style.paddingLeft = '22px';
            });
        }
    });
</script>