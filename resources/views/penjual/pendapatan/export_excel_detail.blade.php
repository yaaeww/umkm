<table>
    <thead>
        <tr>
            <th>ID Order</th>
            <th>Nama Pembeli</th>
            <th>Jumlah</th>
            <th>Total Harga</th>
            <th>Tanggal</th>
        </tr>
    </thead>
    <tbody>
        @foreach($detail as $item)
            <tr>
                <td>{{ $item->id }}</td>
                <td>{{ $item->pengguna->nama ?? '-' }}</td>
                <td>{{ $item->jumlah }}</td>
                <td>{{ $item->total_harga }}</td>
                <td>{{ \Carbon\Carbon::parse($item->created_at)->format('d-m-Y') }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
