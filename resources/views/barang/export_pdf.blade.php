<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Data Barang</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            line-height: 1.3;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .logo {
            width: 80px;
            height: auto;
        }
        .title {
            font-size: 18px;
            font-weight: bold;
            margin: 10px 0;
        }
        .subtitle {
            font-size: 14px;
            margin: 5px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            border: 1px solid #000;
            padding: 8px;
            font-size: 12px;
        }
        th {
            background-color: #f0f0f0;
        }
        .text-center {
            text-align: center;
        }
        .text-right {
            text-align: right;
        }
        .page-break {
            page-break-after: always;
        }
        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
            font-size: 10px;
            padding: 10px 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <table style="border: none; margin-bottom: 0;">
            <tr>
                <td style="border: none; width: 15%; text-align: center;">
                    <img src="{{ public_path('polinem-png.png') }}" class="logo">
                </td>
                <td style="border: none; width: 70%; text-align: center;">
                    <div class="title">KEMENTERIAN PENDIDIKAN, KEBUDAYAAN, RISET, DAN TEKNOLOGI</div>
                    <div class="title">POLITEKNIK NEGERI MALANG</div>
                    <div class="subtitle">Jl. Soekarno-Hatta No. 9 Malang 65141</div>
                    <div class="subtitle">Telp. (0341) 404424-404425 Fax. (0341) 404420</div>
                    <div class="subtitle">http://www.polinema.ac.id</div>
                </td>
                <td style="border: none; width: 15%; text-align: center;">
                    <img src="{{ public_path('polinema-png.png') }}" class="logo">
                </td>
            </tr>
        </table>
        <hr style="border-top: 3px solid #000; margin: 20px 0;">
    </div>

    <h2 class="text-center">LAPORAN DATA BARANG</h2>
    <p class="text-center">Tanggal: {{ date('d/m/Y H:i:s') }}</p>

    <table>
        <thead>
            <tr>
                <th class="text-center" width="5%">No</th>
                <th width="15%">Kode Barang</th>
                <th width="25%">Nama Barang</th>
                <th width="20%">Kategori</th>
                <th class="text-right" width="15%">Harga Beli</th>
                <th class="text-right" width="15%">Harga Jual</th>
            </tr>
        </thead>
        <tbody>
            @php $total_beli = 0; $total_jual = 0; @endphp
            @foreach($barang as $item)
            <tr>
                <td class="text-center">{{ $loop->iteration }}</td>
                <td>{{ $item->barang_kode }}</td>
                <td>{{ $item->barang_nama }}</td>
                <td>{{ $item->kategori->kategori_nama }}</td>
                <td class="text-right">Rp {{ number_format($item->harga_beli, 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($item->harga_jual, 0, ',', '.') }}</td>
            </tr>
            @php 
                $total_beli += $item->harga_beli;
                $total_jual += $item->harga_jual;
            @endphp
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th colspan="4" class="text-right">Total</th>
                <th class="text-right">Rp {{ number_format($total_beli, 0, ',', '.') }}</th>
                <th class="text-right">Rp {{ number_format($total_jual, 0, ',', '.') }}</th>
            </tr>
        </tfoot>
    </table>

    <div class="footer">
        Dicetak pada: {{ date('d/m/Y H:i:s') }}
    </div>
</body>
</html>