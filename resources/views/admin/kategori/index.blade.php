@extends('layouts.app')
@section('page_title', 'Kategori')

@section('title')
    <i class="bi bi-tags-fill" style="color: var(--gold);"></i> Kategori
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
            --text-primary: #100f0f;
            --text-secondary: #a0aec0;
            --success-color: #28a745;
            --danger-color: #dc3545;
            --warning-color: #ffc107;
        }

        .card {
            background: linear-gradient(135deg, rgba(10, 22, 40, 0.95) 0%, rgba(26, 58, 95, 0.9) 100%) !important;
            border: 2px solid var(--gold);
            border-radius: 20px;
            box-shadow: 0 8px 32px rgba(255, 215, 0, 0.15);
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
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
            transform: translateY(-2px);
            box-shadow: 0 12px 40px rgba(255, 215, 0, 0.25);
        }

        .card-body {
            color: var(--text-primary);
        }

        h4.mb-3 {
            color: var(--text-primary);
            font-weight: 700;
            background: linear-gradient(135deg, var(--gold) 0%, var(--gold-light) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Button Styling */
        .btn-primary {
            background: linear-gradient(135deg, var(--gold) 0%, var(--gold-light) 100%);
            border: 2px solid var(--gold);
            color: var(--dark-blue);
            font-weight: 700;
            padding: 10px 20px;
            border-radius: 10px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(255, 215, 0, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255, 215, 0, 0.4);
            background: linear-gradient(135deg, var(--gold-light) 0%, var(--gold) 100%);
            color: var(--dark-blue);
        }

        .btn-warning {
            background: linear-gradient(135deg, var(--warning-color) 0%, #ffd54f 100%);
            border: 2px solid var(--warning-color);
            color: var(--dark-blue);
            font-weight: 600;
            padding: 6px 12px;
            border-radius: 6px;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(255, 193, 7, 0.3);
        }

        .btn-warning:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(255, 193, 7, 0.4);
            background: linear-gradient(135deg, #ffd54f 0%, var(--warning-color) 100%);
            color: var(--dark-blue);
        }

        .btn-danger {
            background: linear-gradient(135deg, var(--danger-color) 0%, #e74c3c 100%);
            border: 2px solid var(--danger-color);
            color: white;
            font-weight: 600;
            padding: 6px 12px;
            border-radius: 6px;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(220, 53, 69, 0.3);
        }

        .btn-danger:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(220, 53, 69, 0.4);
            background: linear-gradient(135deg, #e74c3c 0%, var(--danger-color) 100%);
            color: white;
        }

        /* Alert Styling */
        .alert-success {
            background: linear-gradient(135deg, rgba(40, 167, 69, 0.9) 0%, rgba(52, 195, 85, 0.8) 100%);
            border: 2px solid var(--success-color);
            color: white;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
        }

        .alert-danger {
            background: linear-gradient(135deg, rgba(220, 53, 69, 0.9) 0%, rgba(231, 76, 60, 0.8) 100%);
            border: 2px solid var(--danger-color);
            color: white;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(220, 53, 69, 0.3);
        }

        /* Table Styling */
        .table {
            background: transparent;
            border-radius: 15px;
            overflow: hidden;
            margin-bottom: 0;
        }

        .table-theme {
            background: linear-gradient(135deg, var(--dark-blue) 0%, var(--medium-blue) 100%);
            border-bottom: 2px solid var(--gold);
        }

        .table-theme th {
            color: var(--gold);
            font-weight: 700;
            padding: 15px;
            text-align: center;
            border: none;
            font-size: 1rem;
        }

        .table-hover tbody tr {
            transition: all 0.3s ease;
            background: rgba(10, 22, 40, 0.7);
        }

        .table-hover tbody tr:hover {
            background: rgba(255, 215, 0, 0.1);
            transform: translateX(5px);
        }

        .table-hover tbody tr td {
            color: var(--text-primary);
            padding: 15px;
            text-align: center;
            vertical-align: middle;
            border-bottom: 1px solid rgba(255, 215, 0, 0.2);
        }

        .text-theme {
            color: var(--text-primary) !important;
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

        /* Text Muted */
        .text-muted {
            color: var(--text-secondary) !important;
        }

        /* Form Styling */
        form.d-inline {
            display: inline-block;
        }

        /* Icon Styling in Table */
        .bi-arrow-return-right {
            color: var(--gold);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .table-responsive {
                border-radius: 10px;
                border: 1px solid var(--gold);
            }

            .btn {
                padding: 8px 16px;
                font-size: 0.875rem;
            }

            .table-theme th,
            .table-hover tbody tr td {
                padding: 10px 8px;
                font-size: 0.875rem;
            }
        }

        /* Animation for new elements */
        .fade-in {
            animation: fadeIn 0.5s ease-in;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Badge for hierarchy */
        .hierarchy-level {
            display: inline-block;
            width: 20px;
            height: 20px;
            background: var(--gold);
            color: var(--dark-blue);
            border-radius: 50%;
            text-align: center;
            line-height: 20px;
            font-size: 12px;
            font-weight: bold;
            margin-right: 8px;
        }
    </style>
@endpush

@section('content')
    <div class="card fade-in">
        <div class="card-body">
            <h4 class="mb-3">Daftar Kategori Produk</h4>

            <a href="{{ route('admin.kategori.create') }}" class="btn btn-primary mb-3">
                <i class="bi bi-plus-circle me-2"></i>Tambah Kategori
            </a>

            @if (session('success'))
                <div class="alert alert-success fade-in">{{ session('success') }}</div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger fade-in">{{ session('error') }}</div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered table-hover text-theme">
                    <thead class="table-theme">
                        <tr>
                            <th>Gambar</th>
                            <th>Nama Kategori</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            function tampilkanKategori($kategori, $level = 0)
                            {
                                $indent = str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', $level);
                                echo '<tr class="fade-in">';
                                echo '<td>';
                                if ($kategori->gambar && file_exists(public_path('storage/kategori/' . $kategori->gambar))) {
                                    echo '<img src="' . asset('storage/kategori/' . $kategori->gambar) . '" width="60" height="60" style="object-fit: cover;" alt="gambar kategori">';
                                } else {
                                    echo '<span class="text-muted"><i class="bi bi-image me-1"></i>Tidak ada gambar</span>';
                                }
                                echo '</td>';
                                echo '<td class="text-start">' . $indent;
                                if ($level > 0) {
                                    echo '<i class="bi bi-arrow-return-right me-2" style="color: var(--black);"></i>';
                                }
                                echo '<strong>' . e($kategori->nama) . '</strong>';
                                echo '</td>';
                                echo '<td>';
                                echo '<div class="d-flex gap-2 justify-content-center">';
                                echo '<a href="' . route('admin.kategori.edit', $kategori->id) . '" class="btn btn-warning btn-sm">';
                                echo '<i class="bi bi-pencil me-1"></i>Edit';
                                echo '</a>';
                                echo '<form action="' . route('admin.kategori.destroy', $kategori->id) . '" method="POST" class="d-inline" onsubmit="return confirm(\'Yakin hapus kategori ' . addslashes($kategori->nama) . '?\')">';
                                echo csrf_field();
                                echo method_field('DELETE');
                                echo '<button class="btn btn-danger btn-sm">';
                                echo '<i class="bi bi-trash me-1"></i>Hapus';
                                echo '</button>';
                                echo '</form>';
                                echo '</div>';
                                echo '</td>';
                                echo '</tr>';

                                foreach ($kategori->children as $child) {
                                    tampilkanKategori($child, $level + 1);
                                }
                            }
                        @endphp

                        @foreach ($kategoris as $kategori)
                            @if (is_null($kategori->parent_id))
                                {!! tampilkanKategori($kategori) !!}
                            @endif
                        @endforeach

                        @if($kategoris->isEmpty())
                            <tr>
                                <td colspan="3" class="text-center text-muted py-4">
                                    <i class="bi bi-inbox me-2"></i>Belum ada kategori
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Add fade-in animation to table rows
            const tableRows = document.querySelectorAll('tbody tr');
            tableRows.forEach((row, index) => {
                row.style.animationDelay = `${index * 0.1}s`;
            });

            // Enhanced confirmation for delete
            const deleteForms = document.querySelectorAll('form[onsubmit]');
            deleteForms.forEach(form => {
                form.onsubmit = function (e) {
                    e.preventDefault();
                    const categoryName = this.closest('tr').querySelector('td:nth-child(2) strong').textContent;
                    Swal.fire({
                        title: 'Hapus Kategori?',
                        text: `Yakin ingin menghapus kategori "${categoryName}"?`,
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
        });
    </script>
@endpush