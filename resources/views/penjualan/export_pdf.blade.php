<!DOCTYPE html>
<html>
<head>
    <title>Data Penjualan</title>
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
            background-color: #FF69B4;
            color: black;
            text-align: center;
        }
        tr:nth-child(even) {
            background-color: #FFE6F3;
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
        <h2>LAPORAN DATA PENJUALAN</h2>
        <p>Tanggal: {{ $tanggal }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Kode Penjualan</th>
                <th>Pembeli</th>
                <th>Nama Barang</th>
                <th>Jumlah</th>
                <th>Harga</th>
                <th>Subtotal</th>
                <th>Total</th>
                <th>User</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @foreach($penjualan as $p)
                @php $firstRow = true; $totalPenjualan = 0; @endphp
                @foreach($p->details as $detail)
                    @php 
                        $subtotal = $detail->jumlah * $detail->harga;
                        $totalPenjualan += $subtotal;
                    @endphp
                    <tr>
                        <td class="text-center">{{ $no }}</td>
                        <td>{{ date('d/m/Y H:i', strtotime($p->penjualan_tanggal)) }}</td>
                        <td>{{ $p->penjualan_kode }}</td>
                        <td>{{ $p->pembeli }}</td>
                        <td>{{ $detail->barang->barang_nama }}</td>
                        <td class="text-center">{{ $detail->jumlah }}</td>
                        <td class="text-right">{{ number_format($detail->harga, 0, ',', '.') }}</td>
                        <td class="text-right">{{ number_format($subtotal, 0, ',', '.') }}</td>
                        <td class="text-right">{{ $firstRow ? number_format($totalPenjualan, 0, ',', '.') : '' }}</td>
                        <td>{{ $firstRow ? $p->user->nama : '' }}</td>
                    </tr>
                    @php $firstRow = false; @endphp
                @endforeach
                @php $no++; @endphp
            @endforeach
        </tbody>
    </table>
</body>
</html>