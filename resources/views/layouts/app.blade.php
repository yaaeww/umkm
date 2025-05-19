@php
    $role = Auth::user()->role ?? 'guest';
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Dashboard')</title>
    <link rel="stylesheet" href="{{ asset('deskapp/vendors/styles/core.css') }}">
    <link rel="stylesheet" href="{{ asset('deskapp/vendors/styles/icon-font.min.css') }}">
    <link rel="stylesheet" href="{{ asset('deskapp/vendors/styles/style.css') }}">

    <style>
        .text-color{
            color: rgb(255, 0, 0);
        }
        /* Teks di right-sidebar saat tema terang */
        body.theme-light .right-sidebar {
            color: #212529;
            /* Hitam gelap */
        }

        /* Teks di right-sidebar saat tema gelap */
        body.theme-dark .right-sidebar {
            color: #f1f1f1;
            /* Putih */
        }

        /* Optional: tombol dan elemen lain di right-sidebar ikut berubah warna teksnya */
        body.theme-dark .right-sidebar .btn,
        body.theme-dark .right-sidebar a {
            color: #f1f1f1;
        }

        body.theme-light .right-sidebar .btn,
        body.theme-light .right-sidebar a {
            color: #212529;
        }

        /* =========================
        THEME COLORS
        ========================= */

        /* Body warna background dan text untuk tema terang */
        body.theme-light {
            background-color: #ffffff;
            /* Putih */
            color: #212529;
            /* Hitam gelap */
        }

        /* Body warna background dan text untuk tema gelap */
        body.theme-dark {
            background-color: #181818;
            /* Hitam pekat */
            color: #f1f1f1;
            /* Putih terang */
        }

        /* Header dan sidebar warna untuk tema terang */
        body.theme-light .header,
        body.theme-light .right-sidebar {
            background-color: #f8f9fa;
            /* Abu sangat terang */
            color: #212529;
            /* Hitam gelap */
        }

        /* Header dan sidebar warna untuk tema gelap */
        body.theme-dark .header,
        body.theme-dark .right-sidebar {
            background-color: #242424;
            /* Abu gelap */
            color: #f1f1f1;
            /* Putih terang */
        }

        /* =========================
        COMPONENTS WARNA
        ========================= */

        /* Tombol yang aktif di sidebar settings */
        .sidebar-btn-group .btn.active {
            border-color: #007bff;
            /* Biru utama */
            background-color: #007bff;
            /* Biru utama */
            color: white;
            /* Teks putih */
        }

        /* Styling untuk sidebar pengaturan tema (right sidebar) */
        .right-sidebar {
            position: fixed;
            top: 0;
            right: -350px;
            /* Tersembunyi di kanan */
            width: 350px;
            /* Lebar */
            height: 100vh;
            /* Tinggi penuh layar */
            background: #fff;
            /* Putih */
            z-index: 9999;
            /* Di atas elemen lain */
            box-shadow: -2px 0 10px rgba(0, 0, 0, 0.1);
            /* Bayangan */
            transition: right 0.3s ease-in-out;
            /* Animasi geser */
            overflow-y: auto;
            /* Scroll vertikal */

        }

        /* Jika sidebar terlihat, geser ke kiri 0 */
        .right-sidebar.right-sidebar-visible {
            right: 0;
        }

        /* =========================
        WARNA TEKS KHUSUS THEME
        ========================= */

        /* Warna teks untuk elemen dengan kelas text-theme saat tema gelap */
        body.theme-dark .text-theme {
            color: #f1f1f1;
            /* Putih */
            background-color: #212121;
            /* Abu gelap */
        }

        /* Warna teks untuk elemen dengan kelas text-theme saat tema terang */
        body.theme-light .text-theme {
            color: #000000;
            /* Hitam gelap */
            background-color: #ffffff;
            /* Putih */
        }

        /* =========================
        STYLE JUDUL HALAMAN
        ========================= */

        /* Judul halaman utama */
        .page-title {
            font-weight: 600;
            /* Tebal */
            font-size: 1.5rem;
            /* Ukuran font */
            color: inherit;
            /* Warna mengikuti tema */
            display: flex;
            /* Flexbox */
            align-items: center;
            /* Vertikal tengah */
            gap: 0.5rem;
            /* Jarak antar elemen */
        }

        /* Warna judul halaman saat tema terang */
        body.theme-light .page-title {
            color: #000000;
            /* Hitam gelap */
        }

        /* Warna judul halaman saat tema gelap */
        body.theme-dark .page-title {
            color: #000000;
            /* Putih terang */
        }

        /* =========================
        STYLE HEADER TITLE
        ========================= */

        /* Style dasar untuk header title */
        .header-title {
            font-weight: 600;
            /* Tebal */
            font-size: 1.25rem;
            /* Ukuran font */
            margin: 0;
            /* Hapus margin */
            color: inherit;
            /* Warna mengikuti tema */
        }

        /* Warna header title saat tema terang */
        body.theme-light .header-title {
            color: #121213;
            /* Hitam gelap */
        }

        /* Warna header title saat tema gelap */
        body.theme-dark .header-title {
            color: #f8f9fa;
            /* Putih terang */
        }
    </style>
</head>

<body id="body">
    @include('partials.header')
    @includeIf('partials.sidebar-' . $role)

    <div class="main-container">
        <div class="pd-ltr-20">
            <div class="page-header d-flex justify-content-between align-items-center mb-3">
                <h4 class="page-title">@yield('title', 'Dashboard')</h4>
            </div>

            @yield('content')
        </div>
    </div>

    @include('partials.footer')

    <script src="{{ asset('deskapp/vendors/scripts/core.js') }}"></script>
    <script src="{{ asset('deskapp/vendors/scripts/script.min.js') }}"></script>
    <script src="{{ asset('deskapp/vendors/scripts/process.js') }}"></script>
    <script src="{{ asset('deskapp/vendors/scripts/layout-settings.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const body = document.getElementById('body');
            const savedTheme = localStorage.getItem('theme') || 'theme-light';
            body.classList.add(savedTheme);

            const toggleBtn = document.querySelector('[data-toggle="right-sidebar"]');
            const closeBtn = document.querySelector('[data-toggle="right-sidebar-close"]');
            const sidebar = document.querySelector('.right-sidebar');

            const btnHeaderWhite = document.querySelector('.header-white');
            const btnHeaderDark = document.querySelector('.header-dark');
            const btnSidebarLight = document.querySelector('.sidebar-light');
            const btnSidebarDark = document.querySelector('.sidebar-dark');
            const resetBtn = document.getElementById('reset-settings');

            // Sidebar toggle
            toggleBtn?.addEventListener('click', () => {
                sidebar?.classList.toggle('right-sidebar-visible');
            });
            closeBtn?.addEventListener('click', () => {
                sidebar?.classList.remove('right-sidebar-visible');
            });

            // Theme Switch Header
            btnHeaderWhite?.addEventListener('click', () => {
                setTheme('theme-light');
                setActive(btnHeaderWhite, [btnHeaderWhite, btnHeaderDark]);
            });

            btnHeaderDark?.addEventListener('click', () => {
                setTheme('theme-dark');
                setActive(btnHeaderDark, [btnHeaderWhite, btnHeaderDark]);
            });

            // Sidebar (visual only toggle active state)
            btnSidebarLight?.addEventListener('click', () => {
                setActive(btnSidebarLight, [btnSidebarLight, btnSidebarDark]);
            });

            btnSidebarDark?.addEventListener('click', () => {
                setActive(btnSidebarDark, [btnSidebarLight, btnSidebarDark]);
            });

            // Reset to default theme
            resetBtn?.addEventListener('click', () => {
                setTheme('theme-light');
                setActive(btnHeaderWhite, [btnHeaderWhite, btnHeaderDark]);
                setActive(btnSidebarLight, [btnSidebarLight, btnSidebarDark]);
            });

            function setTheme(theme) {
                body.classList.remove('theme-light', 'theme-dark');
                body.classList.add(theme);
                localStorage.setItem('theme', theme);
            }

            function setActive(activeBtn, allBtns) {
                allBtns.forEach(btn => btn?.classList.remove('active'));
                activeBtn?.classList.add('active');
            }
        });
    </script>
</body>

</html>