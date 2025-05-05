@extends('layouts.pembeli-navbar')

@section('content')
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- @TODO: replace SET_YOUR_CLIENT_KEY_HERE with your client key -->
    <script type="text/javascript" src="https://app.stg.midtrans.com/snap/snap.js"
        data-client-key="{{config('midtrans.client_key')}}"></script>
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

    {{-- Midtrans Script --}}
    <html>

    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- @TODO: replace SET_YOUR_CLIENT_KEY_HERE with your client key -->
        <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js"
            data-client-key="{{config('midtrans.client_key')}}"></script>
        <!-- Note: replace with src="https://app.midtrans.com/snap/snap.js" for Production environment -->
    </head>

    <body>

        <script type="text/javascript">
            // For example trigger on button clicked, or any time you need
            var payButton = document.getElementById('pay-button');
            payButton.addEventListener('click', function () {
                // Trigger snap popup. @TODO: Replace TRANSACTION_TOKEN_HERE with your transaction token
                window.snap.pay('{{$snapToken}}', {
                    onSuccess: function (result) {
                        /* You may add your own implementation here */
                        //alert("payment success!"); //--
                        window.location.href = '/pembeli/invoice/{{$order->id}}'
                        console.log(result);
                    },
                    onPending: function (result) {
                        /* You may add your own implementation here */
                        alert("wating your payment!"); console.log(result);
                    },
                    onError: function (result) {
                        /* You may add your own implementation here */
                        alert("payment failed!"); console.log(result);
                    },
                    onClose: function () {
                        /* You may add your own implementation here */
                        alert('you closed the popup without finishing the payment');
                    }
                })
            });
        </script>
    </body>

    </html>
@endsection