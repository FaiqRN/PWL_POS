<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data User</title>
    <style>
        .container {
            text-align: center;
            font-family: Arial, sans-serif;
            margin-top: 50px;
        }
        table {
            margin: 0 auto;
            border: 1px solid black;
            padding: 10px;
        }
        th, td {
            padding: 10px;
            border: 1px solid black;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Data User</h1>
        <table>
            <tr>
                <th>Jumlah Pengguna</th>
            </tr>
            <tr>
                <td>{{ $data }}</td>
            </tr>
        </table>
    </div>
</body>
</html>
