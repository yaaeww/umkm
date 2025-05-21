<table>
    <thead>
        <tr>
            <th>Nama Produk</th>
            <th>Total Terjual</th>
            <th>Total Pendapatan</th>
        </tr>
    </thead>
    <tbody>
        @foreach($pendapatanPerProduk as $item)
        <tr>
            <td>{{ $item->nama }}</td>
            <td>{{ $item->total_terjual }}</td>
            <td>{{ $item->total_pendapatan }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
