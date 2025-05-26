@component('mail::message')
# Terima Kasih {{ $order->name }}

Pesanan Anda dengan ID **{{ $order->order_id_midtrans }}** telah berhasil diproses.

**Produk:** {{ $order->produk->nama }}
**Jumlah:** {{ $order->jumlah }}
**Total Bayar:** Rp{{ number_format($order->total_harga, 0, ',', '.') }}

Kami akan segera memproses pengiriman produk ke alamat Anda:

> {{ $order->alamat }}

@component('mail::button', ['url' => route('pembeli.invoice', $order->id)])
Lihat Invoice
@endcomponent

Terima kasih telah berbelanja di UMKM Indramayu.

@endcomponent
