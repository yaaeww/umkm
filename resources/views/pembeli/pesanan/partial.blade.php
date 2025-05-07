<form action="{{ route('pembeli.pesanan.bulkDelete') }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus pesanan yang dipilih?')">
    @csrf
    @method('DELETE')
    <div class="text-end mb-2">
        <button type="submit" class="btn btn-danger btn-sm">Hapus yang Dipilih</button>
    </div>
    <table class="table table-bordered">
        <thead>
            <tr>
                <!-- Checkbox untuk memilih semua -->
                <th><input type="checkbox" id="select-all"></th>
                <th>Produk</th>
                <th>Jumlah</th>
                <th>Total Harga</th>
                <th>Status Pembayaran</th>
                <th>Status Pengiriman</th>
                <th>Tanggal</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $order)
                <tr>
                    <!-- Checkbox untuk memilih setiap pesanan -->
                    <td><input type="checkbox" name="order_ids[]" value="{{ $order->id }}" class="order-checkbox"></td>
                    <td>{{ $order->produk->nama ?? '-' }}</td>
                    <td>{{ $order->jumlah }}</td>
                    <td>Rp{{ number_format($order->total_harga, 0, ',', '.') }}</td>
                    <td><span class="badge bg-{{ $badge }}">{{ $label }}</span></td>
                    <td>
                        @if ($order->status_pesanan)
                            <span class="badge bg-info">{{ ucfirst(str_replace('_', ' ', $order->status_pesanan)) }}</span>
                        @else
                            <span class="badge bg-secondary">Belum Diproses</span>
                        @endif
                    </td>
                    <td>{{ $order->created_at->format('d-m-Y H:i') }}</td>
                    <td>
                        <a href="{{ route('pembeli.invoice.show', $order->id) }}" class="btn btn-sm btn-primary">Invoice</a>
                        @if ($order->status === 'cancel')
                            <form action="{{ route('pembeli.pesanan.destroy', $order->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus pesanan ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-danger">Hapus</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</form>

<!-- Tambahkan skrip untuk checkbox Select All -->
<script>
    // Menangani aksi "Select All" untuk memilih semua checkbox
    document.getElementById('select-all').addEventListener('change', function (e) {
        // Ambil semua checkbox dengan kelas 'order-checkbox'
        const checkboxes = document.querySelectorAll('.order-checkbox');
        
        // Setiap checkbox akan dicentang sesuai dengan status checkbox "Select All"
        checkboxes.forEach(checkbox => {
            checkbox.checked = e.target.checked;
        });
    });
</script>
