@extends('layouts.app')
@section('page_title', 'Kategori')

@section('title')

    <i class="bi bi-tags-fill"></i> Kategori
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <h4 class="mb-3">Daftar Kategori Produk</h4>

            <a href="{{ route('admin.kategori.create') }}" class="btn btn-primary mb-3">+ Tambah Kategori</a>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
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
                            function tampilkanKategori($kategori, $level = 0) {
                                $indent = str_repeat('&nbsp;&nbsp;&nbsp;&nbsp;', $level);
                                echo '<tr>';
                                echo '<td>';
                                if ($kategori->gambar && file_exists(public_path('storage/kategori/' . $kategori->gambar))) {
                                    echo '<img src="' . asset('storage/kategori/' . $kategori->gambar) . '" width="60" height="60" style="object-fit: cover;" alt="gambar kategori">';
                                } else {
                                    echo '<span class="text-muted">Tidak ada gambar</span>';
                                }
                                echo '</td>';
                                echo '<td>' . $indent . ($level > 0 ? '<i class="bi bi-arrow-return-right me-1"></i>' : '') . e($kategori->nama) . '</td>';
                                echo '<td>';
                                echo '<a href="' . route('admin.kategori.edit', $kategori->id) . '" class="btn btn-sm btn-warning me-1">Edit</a>';
                                echo '<form action="' . route('admin.kategori.destroy', $kategori->id) . '" method="POST" class="d-inline" onsubmit="return confirm(\'Yakin hapus?\')">';
                                echo csrf_field();
                                echo method_field('DELETE');
                                echo '<button class="btn btn-sm btn-danger">Hapus</button>';
                                echo '</form>';
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
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
