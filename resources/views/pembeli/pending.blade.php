@extends('layouts.pembeli-navbar')

@section('content')
<style>
    body {
        background-color: black !important;
    }
</style>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Midtrans Snap.js --}}
    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('midtrans.client_key') }}"></script>

    <div class="container">
        <h1 class="my-4">Detail Pesanan</h1>

        {{-- Card Produk --}}
        <div class="card shadow rounded border-0 mb-4" style="max-width: 500px">
            <div class="card-body">
                <table class="table">
                    <tr>
                        <td>Nama</td>
                        <td>: {{ $order->name }}</td>
                    </tr>
                    <tr>
                        <td>Nomor Hp</td>
                        <td>: {{ $order->phone }}</td>
                    </tr>
                    <tr>
                        <td>Alamat</td>
                        <td>: {{ $order->alamat }}</td>
                    </tr>
                    <tr>
                        <td>Jumlah</td>
                        <td>: {{ $order->jumlah }}</td>
                    </tr>
                    <tr>
                        <td>Total Harga</td>
                        <td>: Rp {{ number_format($order->total_harga, 0, ',', '.') }}</td>
                    </tr>
                </table>
                <button class="btn btn-primary" id="pay-button">Bayar Sekarang</button>
            </div>
        </div>
    </div>

    {{-- Midtrans Trigger --}}
    <script type="text/javascript">
        var payButton = document.getElementById('pay-button');
        payButton.addEventListener('click', function () {
            window.snap.pay('{{ $snapToken }}', {
                onSuccess: function (result) {
                    window.location.href = '/pembeli/invoice/{{ $order->id }}';
                    console.log(result);
                },
                onPending: function (result) {
                    alert("Menunggu pembayaran...");
                    console.log(result);
                },
                onError: function (result) {
                    alert("Pembayaran gagal!");
                    console.log(result);

                    // Cek status error
                    if (result.status_code === "400" && result.error_message === "Transaction expired") {
                        alert("Token transaksi kadaluarsa, pesanan akan dibatalkan.");

                        // Kirim request ke server untuk membatalkan pesanan
                        fetch('/pembeli/order/cancel/{{ $order->id }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            },
                            body: JSON.stringify({})
                        })
                        .then(response => response.json())
                        .then(data => {
                            console.log(data);
                            alert("Pesanan telah dibatalkan.");
                            window.location.reload();
                        })
                        .catch(error => console.error('Error:', error));
                    } else if (result.status_code === "400" && result.error_message === "Payment failed") {
                        alert("Pembayaran ditolak, coba gunakan metode pembayaran lain.");
                    } else {
                        alert("Terjadi kesalahan dalam proses pembayaran. Coba lagi.");
                    }
                },
                onClose: function () {
                    alert('Kamu menutup popup tanpa menyelesaikan pembayaran');
                }
            });
        });
    </script>
@endsection
