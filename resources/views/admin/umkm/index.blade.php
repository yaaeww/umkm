@extends('layouts.app')
@section('title', 'Daftar Toko')

@section('content')
<div class="container">
    <h1 class="mb-4">Data Semua UMKM</h1>

    {{-- List UMKM Approved --}}
    <h2>UMKM Terdaftar (Approved)</h2>
    <table class="table table-bordered">
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
                <td>{{ $umkm->nama_toko }}</td>
                <td>{{ $umkm->deskripsi }}</td>
                <td>{{ $umkm->alamat }}</td>
                <td>{{ $umkm->no_telp }}</td>
                <td>
                    @if($umkm->logo)
                        <img src="{{ asset('storage/' . $umkm->logo) }}" width="50" height="50" alt="Logo">
                    @else
                        Tidak Ada
                    @endif
                </td>
                <td>
                    <a href="{{ route('admin.umkm.show', $umkm->id) }}" class="btn btn-info btn-sm mb-1">Detail</a>
                    <a href="{{ route('admin.umkm.products', $umkm->id) }}" class="btn btn-primary btn-sm mb-1">Lihat Produk</a>
                    <form action="{{ route('admin.umkm.destroy', $umkm->id) }}" method="POST" onsubmit="return confirm('Apakah yakin ingin menghapus toko ini?')" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center">Belum ada UMKM yang disetujui.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{-- List UMKM Pending --}}
    <h2>UMKM Menunggu Persetujuan</h2>
    <table class="table table-bordered">
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
                <td>{{ $umkm->nama_toko }}</td>
                <td>{{ $umkm->deskripsi }}</td>
                <td>{{ $umkm->alamat }}</td>
                <td>{{ $umkm->no_telp }}</td>
                <td>
                    @if($umkm->logo)
                        <img src="{{ asset('storage/' . $umkm->logo) }}" width="50" height="50" alt="Logo">
                    @else
                        Tidak Ada
                    @endif
                </td>
                <td>
                    <form action="{{ route('admin.umkm.approve', $umkm->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        <button class="btn btn-success btn-sm" type="submit">Approve</button>
                    </form>
                    <form action="{{ route('admin.umkm.reject', $umkm->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        <button class="btn btn-danger btn-sm" type="submit">Reject</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center">Tidak ada UMKM yang menunggu persetujuan.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{-- List UMKM Rejected --}}
    <h2>UMKM Ditolak</h2>
    <table class="table table-bordered">
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
                <td>{{ $umkm->nama_toko }}</td>
                <td>{{ $umkm->deskripsi }}</td>
                <td>{{ $umkm->alamat }}</td>
                <td>{{ $umkm->no_telp }}</td>
                <td>
                    @if($umkm->logo)
                        <img src="{{ asset('storage/' . $umkm->logo) }}" width="50" height="50" alt="Logo">
                    @else
                        Tidak Ada
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center">Tidak ada UMKM yang ditolak.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
