<!DOCTYPE html>
<html>
<head>
    <title>Data Stok</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px;
        }
        th, td {
            border: 1px solid black;
            padding: 5px;
        }
        th {
            background-color: #800080;
            color: white;
            text-align: center;
        }
        tr:nth-child(even) {
            background-color: #FFB6C1;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>LAPORAN DATA STOK</h2>
        <p>Tanggal: {{ $tanggal }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Supplier</th>
                <th>Barang</th>
                <th>User</th>
                <th>Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @foreach($stok as $index => $item)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ date('d/m/Y H:i', strtotime($item->stok_tanggal)) }}</td>
                <td>{{ $item->supplier ? $item->supplier->supplier_nama : '-' }}</td>
                <td>{{ $item->barang ? $item->barang->barang_nama : '-' }}</td>
                <td>{{ $item->user ? $item->user->nama : '-' }}</td>
                <td class="text-right">{{ number_format($item->stok_jumlah, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>