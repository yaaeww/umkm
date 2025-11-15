@extends('layouts.app')
@section('page_title', 'Daftar Toko')

@section('title')
    <i class="icon-copy dw dw-groceries-store" style="color: var(--gold);"></i> Daftar Semua Toko
@endsection

@push('style')
    <style>
        :root {
            --dark-blue: #0a1628;
            --medium-blue: #1a3a5f;
            --light-blue: #2a4a7f;
            --gold: #ffd700;
            --gold-light: #ffed4e;
            --gold-dark: #d4af37;
            --text-primary: #ffffff;
            --text-secondary: #a0aec0;
            --success-color: #28a745;
            --warning-color: #ffc107;
            --danger-color: #dc3545;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .container.fade-in>.card:first-child {
            margin-top: 0.5rem;
            /* Biar tidak terlalu turun dari atas */
        }

        .container.fade-in {
            padding-top: 0;
            /* Hilangkan ruang atas tambahan */
        }


        /* Card Styling */
        .card {
            background: linear-gradient(135deg, rgba(10, 22, 40, 0.95) 0%, rgba(26, 58, 95, 0.9) 100%) !important;
            border: 2px solid var(--gold);
            border-radius: 20px;
            box-shadow: 0 8px 32px rgba(255, 215, 0, 0.15);
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
            margin-bottom: 0.75rem;
            overflow: hidden;
        }

        .card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: linear-gradient(90deg, transparent, var(--gold), transparent);
            animation: shimmer 3s infinite;
        }

        @keyframes shimmer {

            0%,
            100% {
                opacity: 0;
            }

            50% {
                opacity: 1;
            }
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 40px rgba(255, 215, 0, 0.25);
        }

        /* Card Header Styling */
        .card-header {
            background: linear-gradient(135deg, var(--dark-blue) 0%, var(--medium-blue) 100%) !important;
            border-bottom: 2px solid var(--gold);
            padding: 1.5rem;
            font-weight: 700;
            font-size: 1.3rem;
        }

        .card-header.bg-success {
            background: linear-gradient(135deg, var(--success-color) 0%, #34c355 100%) !important;
            color: white;
        }

        .card-header.bg-warning {
            background: linear-gradient(135deg, var(--warning-color) 0%, #ffd54f 100%) !important;
            color: var(--dark-blue);
        }

        .card-header.bg-danger {
            background: linear-gradient(135deg, var(--danger-color) 0%, #e74c3c 100%) !important;
            color: white;
        }

        .card-body {
            padding: 0;
        }

        /* Table Styling */
        .table {
            background: white;
            margin-bottom: 0;
            border-radius: 0 0 18px 18px;
            overflow: hidden;
        }

        .table thead {
            background: linear-gradient(135deg, var(--gold) 0%, var(--gold-light) 100%);
        }

        .table thead th {
            color: var(--dark-blue) !important;
            font-weight: 700;
            padding: 1rem;
            text-align: center;
            border: none;
            font-size: 1rem;
            border-bottom: 2px solid var(--gold-dark);
        }

        .table tbody tr {
            transition: all 0.3s ease;
            border-bottom: 1px solid #dee2e6;
        }

        .table tbody tr:hover {
            background: rgba(255, 215, 0, 0.1) !important;
            transform: translateX(5px);
        }

        .table tbody tr:nth-child(even) {
            background: #f8f9fa;
        }

        .table tbody tr:nth-child(odd) {
            background: white;
        }

        .table tbody td {
            color: #000000 !important;
            /* Teks hitam */
            padding: 1rem;
            text-align: center;
            vertical-align: middle;
            font-weight: 500;
            border: none;
        }

        /* Image Styling */
        .table img {
            border-radius: 8px;
            border: 2px solid var(--gold);
            box-shadow: 0 2px 8px rgba(255, 215, 0, 0.3);
            transition: all 0.3s ease;
        }

        .table img:hover {
            transform: scale(1.1);
            box-shadow: 0 4px 15px rgba(255, 215, 0, 0.5);
        }

        /* Button Styling */
        .btn {
            font-weight: 600;
            border: 2px solid transparent;
            border-radius: 8px;
            transition: all 0.3s ease;
            margin: 2px;
        }

        .btn-sm {
            padding: 0.4rem 0.8rem;
            font-size: 0.875rem;
        }

        .btn-info {
            background: linear-gradient(135deg, #17a2b8 0%, #20c4d8 100%);
            color: white;
            border-color: #17a2b8;
        }

        .btn-info:hover {
            background: linear-gradient(135deg, #138496 0%, #1ba9bb 100%);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(23, 162, 184, 0.3);
            color: white;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--gold) 0%, var(--gold-light) 100%);
            color: var(--dark-blue);
            border-color: var(--gold);
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, var(--gold-light) 0%, var(--gold) 100%);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(255, 215, 0, 0.3);
            color: var(--dark-blue);
        }

        .btn-success {
            background: linear-gradient(135deg, var(--success-color) 0%, #34c355 100%);
            color: white;
            border-color: var(--success-color);
        }

        .btn-success:hover {
            background: linear-gradient(135deg, #218838 0%, #28a745 100%);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(40, 167, 69, 0.3);
            color: white;
        }

        .btn-danger {
            background: linear-gradient(135deg, var(--danger-color) 0%, #e74c3c 100%);
            color: white;
            border-color: var(--danger-color);
        }

        .btn-danger:hover {
            background: linear-gradient(135deg, #c82333 0%, #dc3545 100%);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(220, 53, 69, 0.3);
            color: white;
        }

        /* Form Inline Styling */
        form.d-inline-block {
            display: inline-block;
        }

        /* Empty State Styling */
        .text-center {
            color: #6c757d !important;
            font-style: italic;
        }

        /* Animation */
        .fade-in {
            animation: fadeInUp 0.6s ease-out;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Row Hover Animation */
        @keyframes rowHighlight {
            0% {
                background-color: transparent;
            }

            50% {
                background-color: rgba(255, 215, 0, 0.2);
            }

            100% {
                background-color: transparent;
            }
        }

        .table tbody tr {
            animation: rowHighlight 0.5s ease-in-out;
        }

        /* Responsive Design */
        @media (max-width: 1200px) {
            .container {
                padding: 0 15px;
            }

            .table thead th,
            .table tbody td {
                padding: 0.75rem 0.5rem;
                font-size: 0.9rem;
            }
        }

        @media (max-width: 992px) {
            .card-header {
                padding: 1rem;
                font-size: 1.1rem;
            }

            .btn-sm {
                padding: 0.3rem 0.6rem;
                font-size: 0.8rem;
            }
        }

        @media (max-width: 768px) {
            .table-responsive {
                border-radius: 0 0 15px 15px;
                border: 1px solid #dee2e6;
            }

            .table thead {
                display: none;
            }

            .table tbody tr {
                display: block;
                margin-bottom: 1rem;
                border: 2px solid var(--gold);
                border-radius: 10px;
                padding: 1rem;
            }

            .table tbody td {
                display: block;
                text-align: left !important;
                padding: 0.5rem;
                border-bottom: 1px solid #dee2e6;
            }

            .table tbody td:before {
                content: attr(data-label);
                font-weight: bold;
                color: var(--dark-blue);
                display: inline-block;
                width: 120px;
            }

            .table tbody td:last-child {
                border-bottom: none;
                text-align: center !important;
            }

            .table tbody td:last-child:before {
                display: none;
            }

            /* Add data labels for mobile */
            .table tbody td:nth-child(1):before {
                content: "Nama Toko: ";
            }

            .table tbody td:nth-child(2):before {
                content: "Deskripsi: ";
            }

            .table tbody td:nth-child(3):before {
                content: "Alamat: ";
            }

            .table tbody td:nth-child(4):before {
                content: "No Telp: ";
            }

            .table tbody td:nth-child(5):before {
                content: "Logo: ";
            }
        }

        @media (max-width: 576px) {
            .card-header {
                font-size: 1rem;
                padding: 0.75rem;
            }

            .btn-sm {
                display: block;
                width: 100%;
                margin-bottom: 0.5rem;
            }

            form.d-inline-block {
                display: block;
                width: 100%;
            }
        }

        /* Status Badges */
        .status-badge {
            padding: 0.25rem 0.5rem;
            border-radius: 15px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        .badge-approved {
            background: linear-gradient(135deg, var(--success-color) 0%, #34c355 100%);
            color: white;
        }

        .badge-pending {
            background: linear-gradient(135deg, var(--warning-color) 0%, #ffd54f 100%);
            color: var(--dark-blue);
        }

        .badge-rejected {
            background: linear-gradient(135deg, var(--danger-color) 0%, #e74c3c 100%);
            color: white;
        }
    </style>
@endpush

@section('content')
    <div class="container fade-in">
        {{-- Box UMKM Approved --}}
        <div class="card">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">
                    <i class="bi bi-check-circle-fill me-2"></i>UMKM Terdaftar (Approved)
                    <span class="badge badge-approved ms-2">{{ $approvedUmkms->count() }}</span>
                </h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Nama Toko</th>
                                <th>Deskripsi</th>
                                <th>Alamat</th>
                                <th>No Telp</th>
                                <th>Logo</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($approvedUmkms as $umkm)
                                <tr>
                                    <td data-label="Nama Toko">
                                        <strong>{{ $umkm->nama_toko }}</strong>
                                    </td>
                                    <td data-label="Deskripsi">{{ Str::limit($umkm->deskripsi, 50) }}</td>
                                    <td data-label="Alamat">{{ Str::limit($umkm->alamat, 30) }}</td>
                                    <td data-label="No Telp">{{ $umkm->no_telp }}</td>
                                    <td data-label="Logo">
                                        @if($umkm->logo)
                                            <img src="{{ asset('storage/' . $umkm->logo) }}" width="50" height="50" alt="Logo"
                                                style="object-fit: cover;">
                                        @else
                                            <span class="text-muted">Tidak Ada</span>
                                        @endif
                                    </td>
                                    <td data-label="Aksi">
                                        <div class="d-flex flex-wrap justify-content-center">
                                            <a href="{{ route('admin.umkm.show', $umkm->id) }}"
                                                class="btn btn-info btn-sm mb-1">
                                                <i class="bi bi-eye me-1"></i>Detail
                                            </a>
                                            <a href="{{ route('admin.umkm.products', $umkm->id) }}"
                                                class="btn btn-primary btn-sm mb-1">
                                                <i class="bi bi-box me-1"></i>Produk
                                            </a>
                                            <form action="{{ route('admin.umkm.destroy', $umkm->id) }}" method="POST"
                                                onsubmit="return confirm('Apakah yakin ingin menghapus toko {{ $umkm->nama_toko }}?')"
                                                class="d-inline-block mb-1">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger btn-sm">
                                                    <i class="bi bi-trash me-1"></i>Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4">
                                        <i class="bi bi-inbox me-2"></i>Belum ada UMKM yang disetujui.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Box UMKM Pending --}}
        <div class="card">
            <div class="card-header bg-warning">
                <h5 class="mb-0">
                    <i class="bi bi-clock-fill me-2"></i>UMKM Menunggu Persetujuan
                    <span class="badge badge-pending ms-2">{{ $pendingUmkms->count() }}</span>
                </h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Nama Toko</th>
                                <th>Deskripsi</th>
                                <th>Alamat</th>
                                <th>No Telp</th>
                                <th>Logo</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pendingUmkms as $umkm)
                                <tr>
                                    <td data-label="Nama Toko">
                                        <strong>{{ $umkm->nama_toko }}</strong>
                                    </td>
                                    <td data-label="Deskripsi">{{ Str::limit($umkm->deskripsi, 50) }}</td>
                                    <td data-label="Alamat">{{ Str::limit($umkm->alamat, 30) }}</td>
                                    <td data-label="No Telp">{{ $umkm->no_telp }}</td>
                                    <td data-label="Logo">
                                        @if($umkm->logo)
                                            <img src="{{ asset('storage/' . $umkm->logo) }}" width="50" height="50" alt="Logo"
                                                style="object-fit: cover;">
                                        @else
                                            <span class="text-muted">Tidak Ada</span>
                                        @endif
                                    </td>
                                    <td data-label="Aksi">
                                        <div class="d-flex flex-wrap justify-content-center">
                                            <form action="{{ route('admin.umkm.approve', $umkm->id) }}" method="POST"
                                                class="d-inline-block mb-1">
                                                @csrf
                                                <button class="btn btn-success btn-sm" type="submit">
                                                    <i class="bi bi-check-lg me-1"></i>Approve
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.umkm.reject', $umkm->id) }}" method="POST"
                                                class="d-inline-block mb-1">
                                                @csrf
                                                <button class="btn btn-danger btn-sm" type="submit">
                                                    <i class="bi bi-x-lg me-1"></i>Reject
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4">
                                        <i class="bi bi-inbox me-2"></i>Tidak ada UMKM yang menunggu persetujuan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Box UMKM Rejected --}}
        <div class="card">
            <div class="card-header bg-danger text-white">
                <h5 class="mb-0">
                    <i class="bi bi-x-circle-fill me-2"></i>UMKM Ditolak
                    <span class="badge badge-rejected ms-2">{{ $rejectedUmkms->count() }}</span>
                </h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Nama Toko</th>
                                <th>Deskripsi</th>
                                <th>Alamat</th>
                                <th>No Telp</th>
                                <th>Logo</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($rejectedUmkms as $umkm)
                                <tr>
                                    <td data-label="Nama Toko">
                                        <strong>{{ $umkm->nama_toko }}</strong>
                                    </td>
                                    <td data-label="Deskripsi">{{ Str::limit($umkm->deskripsi, 50) }}</td>
                                    <td data-label="Alamat">{{ Str::limit($umkm->alamat, 30) }}</td>
                                    <td data-label="No Telp">{{ $umkm->no_telp }}</td>
                                    <td data-label="Logo">
                                        @if($umkm->logo)
                                            <img src="{{ asset('storage/' . $umkm->logo) }}" width="50" height="50" alt="Logo"
                                                style="object-fit: cover;">
                                        @else
                                            <span class="text-muted">Tidak Ada</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4">
                                        <i class="bi bi-inbox me-2"></i>Tidak ada UMKM yang ditolak.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Add confirmation for delete actions
            const deleteForms = document.querySelectorAll('form[onsubmit]');
            deleteForms.forEach(form => {
                form.onsubmit = function (e) {
                    e.preventDefault();
                    const storeName = this.closest('tr').querySelector('td:first-child strong').textContent;
                    Swal.fire({
                        title: 'Hapus Toko?',
                        text: `Yakin ingin menghapus toko "${storeName}"? Tindakan ini tidak dapat dibatalkan!`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#ffd700',
                        cancelButtonColor: '#dc3545',
                        confirmButtonText: 'Ya, Hapus!',
                        cancelButtonText: 'Batal',
                        background: '#0a1628',
                        color: '#ffffff'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            this.submit();
                        }
                    });
                };
            });

            // Add row highlight animation on load
            const tableRows = document.querySelectorAll('tbody tr');
            tableRows.forEach((row, index) => {
                row.style.animationDelay = `${index * 0.1}s`;
            });
        });
    </script>
@endpush