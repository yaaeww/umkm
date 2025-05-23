@extends('layouts.pembeli-navbar')

@section('content')
<style>
    body {
        background-color: black !important;
    }
    .text-color{
        color: white;
    }
</style>

<div class="container mt-5 text-white">
    <h2 class="text-center text-dark mb-4">Keranjang Belanja</h2>

    {{-- Tampilkan pesan error validasi stok --}}
    @if(session('error'))
        <div class="alert alert-danger text-center">
            {{ session('error') }}
        </div>
    @endif

    @if ($keranjangs->isEmpty())
        <p class="text-center">Keranjang kamu kosong.</p>
    @else
        <table class="table table-bordered text-center align-middle table-dark">
            <thead class="table-light text-color">
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
                        <td>
                            {{ $item->produk->nama }}
                            @if ($item->produk->diskon &&
                                now()->between($item->produk->diskon->tanggal_mulai, $item->produk->diskon->tanggal_berakhir))
                                <span class="badge bg-danger ms-2">Diskon {{ $item->produk->diskon->persen_diskon }}%</span><br>
                                <small class="text-warning">
                                    Berakhir: {{ \Carbon\Carbon::parse($item->produk->diskon->tanggal_berakhir)->translatedFormat('d M Y H:i') }}
                                </small>
                            @endif

                            {{-- Notifikasi stok kurang --}}
                            @if ($item->jumlah > $item->produk->stok)
                                <div class="text-warning small mt-1">
                                    Stok kurang! (Tersedia: {{ $item->produk->stok }})
                                </div>
                            @endif
                        </td>

                        {{-- Harga --}}
                        <td>
                            @if (isset($item->harga_setelah_diskon) && $item->harga_setelah_diskon < $item->produk->harga)
                                <span class="text-decoration-line-through text-color">Rp {{ number_format($item->produk->harga, 0, ',', '.') }}</span><br>
                                <span class="text-success">Rp {{ number_format($item->harga_setelah_diskon, 0, ',', '.') }}</span>
                            @else
                                Rp {{ number_format($item->produk->harga, 0, ',', '.') }}
                            @endif
                        </td>

                        {{-- Jumlah & Form --}}
                        <td>
                            <form action="{{ route('pembeli.keranjang.update', $item->id) }}" method="POST" class="d-flex justify-content-center align-items-center gap-2">
                                @csrf
                                @method('PUT')
                                <input type="number" name="jumlah" value="{{ $item->jumlah }}" min="1" max="{{ $item->produk->stok }}" class="form-control form-control-sm text-center" style="width: 70px;">
                                <button type="submit" class="btn btn-sm btn-primary">Ubah</button>
                            </form>
                        </td>

                        {{-- Subtotal --}}
                        <td>
                            @if (isset($item->subtotal_setelah_diskon) && $item->harga_setelah_diskon < $item->produk->harga)
                                <span class="text-decoration-line-through text-color">Rp {{ number_format($item->produk->harga * $item->jumlah, 0, ',', '.') }}</span><br>
                                <span class="text-warning">Rp {{ number_format($item->subtotal_setelah_diskon, 0, ',', '.') }}</span>
                            @else
                                Rp {{ number_format($item->produk->harga * $item->jumlah, 0, ',', '.') }}
                            @endif
                        </td>

                        {{-- Aksi --}}
                        <td>
                            <div class="d-flex justify-content-center gap-2">
                                {{-- Tombol Hapus --}}
                                <form action="{{ route('pembeli.keranjang.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Hapus produk ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                </form>

                                {{-- Tombol Checkout per Produk --}}
                                <a href="{{ route('pembeli.order', ['produk_id' => $item->produk->id, 'quantity' => $item->jumlah]) }}" 
                                    class="btn btn-sm btn-success
                                    {{ $item->jumlah > $item->produk->stok ? 'disabled' : '' }}"
                                    @if($item->jumlah > $item->produk->stok) 
                                        title="Stok tidak mencukupi untuk checkout" 
                                        onclick="return false;"
                                    @endif
                                >Checkout</a>
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
