{{-- sidebar-penjual.blade.php --}}
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
        box-shadow: 4px 0 20px rgba(0,0,0,0.5);
    }

    /* Brand Logo */
    .brand-logo {
        padding: 25px 20px;
        border-bottom: 1px solid rgba(210, 179, 5, 0.885);
        text-align: center;
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

    /* Menu Items */
    .sidebar-menu ul li a {
        color: var(--text-light);
        padding: 14px 22px;
        display: flex;
        align-items: center;
        gap: 12px;
        transition: background .25s, color .25s, padding-left .25s;
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
    }

    /* Badges */
    .badge {
        font-size: 10px;
        padding: 3px 7px;
        border-radius: 10px;
    }

    .badge.bg-danger {
        background: #ff4b4b !important;
    }

    .badge.bg-success {
        background: var(--gold) !important;
        color: #0a1628 !important;
    }

    /* Submenu */
    .submenu {
        background: rgba(10, 22, 40, 0.9);
        border-left: 2px solid var(--gold);
        padding: 8px 0;
        margin-left: 10px;
    }

    .submenu li a {
        padding: 10px 28px;
        color: #bfc7d5;
        font-size: 13px;
    }

    .submenu li a:hover {
        color: var(--gold);
    }

    /* Logout Button */
    .btn-danger.mtext {
        background: #ff4b4b;
        color: #fff;
        padding: 14px 22px;
        width: 100%;
        text-align: left;
        border: none;
        border-radius: 0;
        transition: background .25s, padding-left .25s;
    }

    .btn-danger.mtext:hover {
        background: #ff3434;
        padding-left: 28px;
    }

    /* Mobile Responsive */
    @media(max-width: 768px) {
        .left-side-bar {
            transform: translateX(-100%);
            transition: transform .3s ease;
        }
        .left-side-bar.show {
            transform: translateX(0);
        }
    }
</style>


<div class="left-side-bar">
    <div class="sparkle-sidebar" id="sparkle-container"></div>

    <div class="brand-logo">
        <a href="/">
            <div class="logo" style="margin-left: 30px;">
                <img src="{{ asset('aset/finalisasi logo.png') }}" alt="Logo UMKM Indramayu"
                    style="display:block;" class="floating">
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
                        <span class="micon fas fa-store"></span><span class="mtext">Toko</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('penjual.produk.create') }}" class="dropdown-toggle no-arrow">
                        <span class="micon bi bi-plus-square"></span><span class="mtext">Tambah Produk</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('penjual.produk.index') }}" class="dropdown-toggle no-arrow">
                        <span class="micon fas fa-cubes"></span><span class="mtext">Produk Toko</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('penjual.profile.show') }}" class="dropdown-toggle no-arrow">
                        <span class="micon bi bi-person"></span><span class="mtext">Profil Pribadi</span>
                    </a>
                </li>

                {{-- 🔔 Notifikasi Pesanan Baru --}}
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle">
                        <span class="micon bi bi-bell"></span>
                        <span class="mtext">Notifikasi</span>
                        @php
                            $jumlahNotif = ($notifPesananComplete->count() ?? 0) + ($notifStatusPesanan->count() ?? 0);
                        @endphp
                        @if($jumlahNotif > 0)
                            <span class="badge bg-danger ms-1">{{ $jumlahNotif }}</span>
                        @endif
                    </a>
                    <ul class="submenu">
                        @if($notifPesananComplete->count())
                            <li class="text-success px-3 fw-bold">✅ Pesanan Baru</li>
                            @foreach($notifPesananComplete as $order)
                                <li><a href="{{ route('penjual.pesanan.index') }}" class="small">
                                        {{ $order->name }} memesan {{ $order->jumlah }}x produk
                                    </a></li>
                            @endforeach
                        @endif

                        @if($notifStatusPesanan->count())
                            <li class="text-info px-3 fw-bold mt-2">📦 Status Pesanan</li>
                            @foreach($notifStatusPesanan as $order)
                                <li><a href="{{ route('penjual.pesanan.index') }}" class="small">
                                        Pesanan oleh {{ $order->name }}: <strong>{{ $order->status_pesanan }}</strong>
                                    </a></li>
                            @endforeach
                        @endif

                        @if($jumlahNotif === 0)
                            <li><span class="dropdown-item text-muted">Tidak ada notifikasi</span></li>
                        @endif
                    </ul>
                </li>

                <li>
                    <a href="{{ route('penjual.pesanan.index') }}" class="dropdown-toggle no-arrow">
                        <span class="micon bi bi-cart-check"></span><span class="mtext">Pesanan</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('penjual.pendapatan.index') }}" class="dropdown-toggle no-arrow">
                        <span class="micon fas fa-chart-line"></span><span class="mtext">Pendapatan</span>
                    </a>
                </li>

                {{-- 💬 FITUR CHAT DENGAN PEMBELI --}}
                <li>
                    <a href="{{ route('penjual.chat.index') }}" class="dropdown-toggle no-arrow">
                        <span class="micon bi bi-chat-dots"></span>
                        <span class="mtext">Chat Pembeli</span>
                        @php
                            $jumlahChatBaru = \App\Models\Chat::where('receiver_id', Auth::id())
                                ->where('is_ai', 0)
                                ->where('created_at', '>=', now()->subMinutes(10))
                                ->count();
                        @endphp
                        @if($jumlahChatBaru > 0)
                            <span class="badge bg-success ms-1">{{ $jumlahChatBaru }}</span>
                        @endif
                    </a>
                </li>

                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-toggle no-arrow btn btn-danger mtext"
                            style="padding-left: 38px;">
                            <span class="micon bi bi-box-arrow-left"></span> Logout
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
    });
</script>