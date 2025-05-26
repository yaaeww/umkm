@extends('layouts.pembeli-navbar')

@section('content')
<style>
    body {
        background-color: black !important;
    }
</style>

<div class="container py-5">
    <h2 class="mb-4 text-center text-light">Status Pembayaran</h2>

    <div class="card shadow-lg border-0 rounded-4 mx-auto" style="max-width: 600px;">
        <div class="card-body p-4">
            <h5 class="card-title mb-4 text-warning">
                <i class="bi bi-clock-history"></i> Menunggu Pembayaran
            </h5>

            <p class="text-muted">Silakan lanjutkan pembayaran Anda melalui Midtrans.</p>

            <table class="table table-borderless mt-4">
                <tr>
                    <td><strong>Nama</strong></td>
                    <td>: {{ $order->name }}</td>
                </tr>
                <tr>
                    <td><strong>Nomor HP</strong></td>
                    <td>: {{ $order->phone }}</td>
                </tr>
                <tr>
                    <td><strong>Alamat</strong></td>
                    <td>: {{ $order->alamat }}</td>
                </tr>
                <tr>
                    <td><strong>Jumlah Barang</strong></td>
                    <td>: {{ $order->jumlah }}</td>
                </tr>
                <tr>
                    <td><strong>Total Harga</strong></td>
                    <td class="text-success fw-bold">: Rp {{ number_format($order->total_harga, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td><strong>Status</strong></td>
                    <td><span class="badge bg-warning text-dark">Pending</span></td>
                </tr>
            </table>

            <div class="text-center mt-4">
                <button class="btn btn-success btn-lg rounded-pill px-5" id="pay-button">
                    <i class="bi bi-credit-card"></i> Lanjutkan Pembayaran
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Midtrans Snap Script -->
<script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js"
    data-client-key="{{ config('midtrans.client_key') }}"></script>

<script type="text/javascript">
        var payButton = document.getElementById('pay-button');
        payButton.addEventListener('click', function () {
            window.snap.pay('{{$snapToken}}', {
                onSuccess: function (result) {
                    console.log('Payment success result:', result);
                    // Pastikan order_id yang dipakai benar
                    window.location.href = '/pembeli/invoice/{{ $order->id }}';
                },

                onPending: function (result) {
                    alert("Menunggu pembayaran Anda.");
                },
                onError: function (result) {
                    alert("Pembayaran gagal. Coba lagi.");
                },
                onClose: function () {
                    alert('Anda menutup popup sebelum menyelesaikan pembayaran.');
                }
            });
        });
    </script>
@endsection
