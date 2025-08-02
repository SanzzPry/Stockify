<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Transaksi Stok</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 6px;
            text-align: left;
        }

        th {
            background-color: #eee;
        }
    </style>
</head>

<body>
    <h2 style="text-align: center;">Laporan Transaksi Stok</h2>


    @if($category)
        <p><strong>Kategori:</strong> {{ $category->name }}</p>
    @endif
    @if($startDate && $endDate)
        <p><strong>Periode:</strong> {{ $startDate }} s/d {{ $endDate }}</p>
    @endif

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Produk</th>
                <th>kategori</th>
                <th>Jumlah</th>
                <th>Catatan</th>
                <th>Supplier</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($stocks as $i => $stock)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $stock->date }}</td>
                    <td>{{ $stock->products->name ?? '-' }}</td>
                    <td>{{ $stock->products->categories->name ?? '-' }}</td>
                    <td>{{ $stock->quantity }}</td>
                    <td>{{ $stock->notes }}</td>
                    <td>{{ $stock->products->suppliers->name }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>