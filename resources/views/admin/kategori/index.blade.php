@extends('layouts.app')
@section('title', 'Tambah Kategori')

@section('content')
    <h4>Daftar Kategori Produk</h4>
    <a href="{{ route('admin.kategori.create') }}" class="btn btn-primary mb-3">+ Tambah Kategori</a>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table">
        <thead>
            <tr>
                <th>Gambar</th>
                <th>Nama Kategori</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($kategoris as $kategori)
                <tr>
                    <td>
                        @if ($kategori->gambar)
                            <img src="{{ asset($kategori->gambar) }}" width="60" height="60" style="object-fit: cover;" alt="gambar kategori">
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </td>
                    <td>{{ $kategori->nama }}</td>
                    <td>
                        
                        <form action="{{ route('admin.kategori.destroy', $kategori->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin hapus?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
