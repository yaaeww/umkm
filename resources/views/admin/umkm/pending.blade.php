@extends('layouts.app')
@section('page_title', 'pending')

@section('content')
<div class="container">
    <h1>UMKM Menunggu Persetujuan</h1>

    <table class="table">
        <thead>
            <tr>
                <th>Nama Toko</th>
                <th>Alamat</th>
                <th>Logo</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($umkms as $umkm)
            <tr>
                <td>{{ $umkm->nama_toko }}</td>
                <td>{{ $umkm->alamat }}</td>
                <td>
                    @if($umkm->logo)
                        <img src="{{ asset('storage/' . $umkm->logo) }}" width="50" height="50" alt="Logo">
                    @else
                        Tidak Ada
                    @endif
                </td>
                <td>
                    <form action="{{ route('admin.umkm.approve', $umkm) }}" method="POST" class="d-inline">
                        @csrf
                        @method('PATCH')
                        <button class="btn btn-success btn-sm">Approve</button>
                    </form>

                    <form action="{{ route('admin.umkm.reject', $umkm) }}" method="POST" class="d-inline">
                        @csrf
                        @method('PATCH')
                        <button class="btn btn-danger btn-sm">Reject</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>