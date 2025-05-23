@extends('layouts.app')

@section('title')
    <i class="bi bi-tags-fill"></i> Daftar Produk UMKM
@endsection

@section('content')
<div class="container mt-4 text-theme">
    

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="mb-3">
        {{--<a href="{{ route('admin.produk.create') }}" class="btn btn-primary">Tambah Produk Baru</a>--}}
    </div>

    @if($produks->count() > 0)
        <div class="table-responsive text-theme">
            <table class="table table-bordered table-striped text-theme">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Produk</th>
                        <th>Harga</th>
                        <th>Gambar</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody class="text-theme">
                    @foreach($produks as $index => $produk)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $produk->nama }}</td>
                        <td>Rp{{ number_format($produk->harga, 0, ',', '.') }}</td>
                        <td>
                            @if($produk->gambar)
                                <img src="{{ asset('storage/' . $produk->gambar) }}" class="img-thumbnail" style="width: 100px;">
                            @else
                                <img src="{{ asset('images/no-image.png') }}" class="img-thumbnail" style="width: 100px;">
                            @endif
                        </td>
                        <td>
                            <form action="{{ route('admin.produk.destroy', $produk->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="alert alert-info">
            Belum ada produk yang ditambahkan.
        </div>
    @endif
</div>
@endsection
