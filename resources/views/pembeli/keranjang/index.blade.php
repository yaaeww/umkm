@extends('layouts.pembeli-navbar')

@section('content')
<div class="container mt-5">
    <h2 class="text-center mb-4">Keranjang Belanja</h2>

    @if ($keranjangs->isEmpty())
        <p class="text-center">Keranjang kamu kosong.</p>
    @else
        <table class="table table-bordered text-center align-middle">
            <thead class="table-light">
                <tr>
                    <th>Produk</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Subtotal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($keranjangs as $item)
                    @if ($item->produk)
                    <tr>
                        <td>{{ $item->produk->nama }}</td>
                        <td>Rp {{ number_format($item->produk->harga, 0, ',', '.') }}</td>
                        <td>
                            <form action="{{ route('pembeli.keranjang.update', $item->id) }}" method="POST" class="d-flex justify-content-center align-items-center gap-2">
                                @csrf
                                @method('PUT')
                                <input type="number" name="jumlah" value="{{ $item->jumlah }}" min="1" class="form-control form-control-sm text-center" style="width: 70px;">
                                <button type="submit" class="btn btn-sm btn-secondary">Ubah</button>
                            </form>
                        </td>
                        <td>Rp {{ number_format($item->produk->harga * $item->jumlah, 0, ',', '.') }}</td>
                        <td>
                            <div class="d-flex justify-content-center gap-2">
                                {{-- Tombol Hapus --}}
                                <form action="{{ route('pembeli.keranjang.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus produk ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                </form>

                                {{-- Tombol Checkout per Produk --}}
                                <a href="{{ route('pembeli.order', ['produk_id' => $item->produk->id, 'quantity' => $item->jumlah]) }}" class="btn btn-sm btn-success">Checkout</a>
                            </div>
                        </td>
                    </tr>
                    @endif
                @endforeach
            </tbody>
        </table>

    
    @endif
</div>
@endsection
