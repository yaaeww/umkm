@extends('layouts.app')
@section('page_title', 'Kelola Akun Penjual')

@section('title')
    <i class="fas fa-users-cog me-2"></i> Kelola Akun Penjual
@endsection

@section('content')
    <div class="container mt-5 pt-5">
        <!-- Hero Section -->
        <section class="hero mb-5">
            <div class="sparkle"></div>
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-8">
                        <div class="hero-content">
                            <h1>Kelola Akun Penjual</h1>
                            <p class="mb-3">Kelola semua akun penjual UMKM dalam platform Indramayu</p>
                            <div class="d-flex flex-wrap gap-3 align-items-center">
                                <span class="badge bg-gold text-dark fs-6 px-3 py-2">
                                    <i class="fas fa-user-shield me-2"></i>Admin Dashboard
                                </span>
                                <span class="text-gold"><i class="fas fa-store me-2"></i>{{ $penjual->count() }} Akun
                                    Penjual</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 text-center">
                        <div class="feature-icon">
                            <i class="fas fa-users-cog fa-6x text-gold"></i>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Tabel Akun Penjual -->
        <section class="container mb-5">
            
            <div class="table-container">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>Penjual</th>
                            <th>Kontak</th>
                            <th>UMKM</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($penjual as $user)
                            <tr>
                                <td>
                                    <div class="user-info">
                                        <div class="user-avatar">
                                            <i class="fas fa-user-circle"></i>
                                        </div>
                                        <div class="user-details">
                                            <h5 class="user-name">{{ $user->name }}</h5>
                                            <span class="user-role">Penjual</span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="contact-info">
                                        <div class="email">
                                            <i class="fas fa-envelope me-2 text-gold"></i>
                                            {{ $user->email }}
                                        </div>
                                        @if($user->umkm && $user->umkm->no_telp)
                                            <div class="phone mt-1">
                                                <i class="fas fa-phone me-2 text-gold"></i>
                                                {{ $user->umkm->no_telp }}
                                            </div>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div class="umkm-info">
                                        @if($user->umkm)
                                            <h6 class="umkm-name">{{ $user->umkm->nama_toko }}</h6>
                                            <span class="umkm-address">{{ Str::limit($user->umkm->alamat, 30) }}</span>
                                        @else
                                            <span class="no-umkm">Belum ada UMKM</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="text-center">
                                    @if ($user->produk->count() > 0)
                                        <span class="status-badge active">
                                            <i class="fas fa-check-circle me-1"></i>Aktif
                                        </span>
                                        <div class="product-count mt-1">
                                            <small>{{ $user->produk->count() }} produk</small>
                                        </div>
                                    @else
                                        <span class="status-badge inactive">
                                            <i class="fas fa-clock me-1"></i>Tidak Aktif
                                        </span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="action-buttons">
                                        <a href="{{ route('admin.penjual.edit', $user->id) }}" class="btn-edit">
                                            <i class="fas fa-edit me-1"></i>Edit
                                        </a>
                                        <form action="{{ route('admin.penjual.destroy', $user->id) }}" method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus akun ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-delete">
                                                <i class="fas fa-trash me-1"></i>Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    <div class="empty-table">
                                        <i class="fas fa-users fa-4x text-gold mb-3 opacity-50"></i>
                                        <h4 class="text-gold mb-2">Belum Ada Akun Penjual</h4>
                                        <p class="text-muted">Belum ada akun penjual yang terdaftar.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </div>

    <style>
        :root {
            --dark-blue: #0a1628;
            --medium-blue: #1a3a5f;
            --light-blue: #447bd3;
            --gold: #ffd700;
            --gold-light: #ffed4e;
            --gold-dark: #d4af37;
        }

        .text-gold {
            color: var(--gold) !important;
        }

        .bg-gold {
            background: linear-gradient(135deg, var(--gold) 0%, var(--gold-light) 100%) !important;
        }

        /* Hero Section */
        .hero {
            position: relative;
            background: linear-gradient(135deg, var(--dark-blue) 0%, var(--medium-blue) 70%, var(--light-blue) 100%);
            min-height: 40vh;
            display: flex;
            align-items: center;
            overflow: hidden;
            padding: 100px 0 60px;
            border-radius: 20px;
            margin: 20px 0;
            border: 1px solid rgba(255, 215, 0, 0.2);
        }

        .hero h1 {
            font-size: 3rem;
            font-weight: 800;
            line-height: 1.2;
            margin-bottom: 1rem;
            background: linear-gradient(135deg, var(--gold) 0%, var(--gold-light) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero p {
            font-size: 1.2rem;
            color: #c0c0c0;
            margin-bottom: 1.5rem;
        }

        .feature-icon {
            padding: 2rem;
            border-radius: 50%;
            background: rgba(255, 215, 0, 0.1);
            border: 3px solid var(--gold);
            width: 200px;
            height: 200px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
        }

        /* Section Header */
        .section-header {
            text-align: center;
            margin-bottom: 3rem;
        }

        .section-title {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            background: linear-gradient(135deg, var(--gold) 0%, var(--gold-light) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .section-subtitle {
            color: #c0c0c0;
            font-size: 1.1rem;
        }

        /* Table Container */
        .table-container {
            background: linear-gradient(135deg, rgba(26, 58, 95, 0.7) 0%, rgba(42, 74, 127, 0.8) 100%);
            border: 1px solid rgba(255, 215, 0, 0.2);
            border-radius: 15px;
            overflow: hidden;
            backdrop-filter: blur(10px);
            padding: 1rem;
        }

        .custom-table {
            width: 100%;
            border-collapse: collapse;
            color: #c0c0c0;
        }

        .custom-table thead {
            background: linear-gradient(135deg, rgba(255, 215, 0, 0.1) 0%, rgba(255, 237, 78, 0.05) 100%);
            border-bottom: 2px solid rgba(255, 215, 0, 0.3);
        }

        .custom-table th {
            padding: 1.2rem 1rem;
            font-weight: 600;
            color: var(--gold);
            text-align: left;
            font-size: 1rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .custom-table td {
            padding: 1.2rem 1rem;
            border-bottom: 1px solid rgba(255, 215, 0, 0.1);
            vertical-align: middle;
        }

        .custom-table tbody tr {
            transition: all 0.3s ease;
            background: transparent;
        }

        .custom-table tbody tr:hover {
            background: rgba(255, 215, 0, 0.05);
            transform: translateX(5px);
        }

        

        /* Contact Info */
        .contact-info .email,
        .contact-info .phone {
            color: #c0c0c0;
            font-size: 0.9rem;
        }

        /* UMKM Info */
        .umkm-info h6 {
            color: var(--gold);
            margin-bottom: 0.3rem;
            font-weight: 600;
        }

        .umkm-address {
            color: #c0c0c0;
            font-size: 0.8rem;
        }

        .no-umkm {
            color: #c0c0c0;
            font-style: italic;
            font-size: 0.9rem;
        }

        /* Status Badges */
        .status-badge {
            padding: 0.4rem 0.8rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
        }

        .status-badge.active {
            background: rgba(40, 167, 69, 0.2);
            color: #28a745;
            border: 1px solid rgba(40, 167, 69, 0.3);
        }

        .status-badge.inactive {
            background: rgba(108, 117, 125, 0.2);
            color: #6c757d;
            border: 1px solid rgba(108, 117, 125, 0.3);
        }

        .product-count small {
            color: #c0c0c0;
            font-size: 0.7rem;
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            align-items: center;
        }

        .btn-edit {
            background: linear-gradient(135deg, var(--gold) 0%, var(--gold-light) 100%);
            color: var(--dark-blue);
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.8rem;
            text-decoration: none;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 100px;
        }

        .btn-edit:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 215, 0, 0.4);
            color: var(--dark-blue);
        }

        .btn-delete {
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
            color: white;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            font-weight: 600;
            font-size: 0.8rem;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 100px;
            cursor: pointer;
        }

        .btn-delete:hover {
            background: linear-gradient(135deg, #c82333 0%, #bd2130 100%);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(220, 53, 69, 0.4);
        }

        /* Empty Table */
        .empty-table {
            padding: 2rem;
        }

        /* Badges */
        .badge {
            font-weight: 600;
            padding: 0.5rem 1rem;
            border-radius: 50px;
        }

        /* Sparkle effect */
        .sparkle {
            position: absolute;
            width: 100%;
            height: 100%;
            pointer-events: none;
            overflow: hidden;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero h1 {
                font-size: 2rem;
            }

            .hero p {
                font-size: 1rem;
            }

            .feature-icon {
                width: 150px;
                height: 150px;
            }

            .feature-icon i {
                font-size: 4rem !important;
            }

            .section-title {
                font-size: 2rem;
            }

            .table-container {
                padding: 0.5rem;
                overflow-x: auto;
            }

            .custom-table {
                min-width: 800px;
            }

            .custom-table th,
            .custom-table td {
                padding: 0.8rem 0.5rem;
                font-size: 0.9rem;
            }

            .user-info {
                flex-direction: column;
                text-align: center;
                gap: 0.5rem;
            }

            .user-avatar {
                width: 40px;
                height: 40px;
            }

            .user-avatar i {
                font-size: 1.2rem;
            }

            .action-buttons {
                flex-direction: row;
                gap: 0.3rem;
            }

            .btn-edit,
            .btn-delete {
                width: auto;
                padding: 0.4rem 0.8rem;
                font-size: 0.7rem;
            }
        }

        /* Animation for sparkle */
        @keyframes sparkleFloat {

            0%,
            100% {
                transform: translateY(0) scale(1);
                opacity: 0;
            }

            50% {
                transform: translateY(-30px) scale(1.5);
                opacity: 1;
            }
        }
    </style>

    <script>
        // Sparkle animation
        document.addEventListener('DOMContentLoaded', function () {
            const hero = document.querySelector('.hero');
            setInterval(() => {
                const sparkle = document.createElement('div');
                sparkle.style.position = 'absolute';
                sparkle.style.width = '3px';
                sparkle.style.height = '3px';
                sparkle.style.background = '#ffd700';
                sparkle.style.borderRadius = '50%';
                sparkle.style.boxShadow = '0 0 10px #ffd700';
                sparkle.style.left = Math.random() * 100 + '%';
                sparkle.style.top = Math.random() * 100 + '%';
                sparkle.style.animation = 'sparkleFloat 2s forwards';
                sparkle.style.pointerEvents = 'none';
                hero.appendChild(sparkle);

                setTimeout(() => sparkle.remove(), 2000);
            }, 500);
        });
    </script>
@endsection