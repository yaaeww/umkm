@extends('layouts.app')

@section('title', 'Kelola Akun Penjual')

@section('content')
    <div class="container">
        <h1 class="mb-4">Kelola Akun Penjual</h1>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>UMKM</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($penjual as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->umkm->nama_toko ?? '-' }}</td>
                        <td>
                            @if ($user->produk->count() > 0)
                                <span class="badge bg-success">Aktif</span>
                            @else
                                <span class="badge bg-danger">Tidak Aktif</span>
                            @endif
                        </td>

                        <td>
                            <a href="{{ route('admin.penjual.edit', $user->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        
                            <form action="{{ route('admin.penjual.destroy', $user->id) }}" method="POST"
                            style="display:inline-block;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger"
                                onclick="return confirm('Yakin ingin menghapus akun ini?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection