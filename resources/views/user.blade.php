<!DOCTYPE html>
<html>
    <head>
        <title>Data User</title>
    </head>
    <body>
        <h1>Data User</h1>
        @if(session('success'))
            <p style="color: green;">{{ session('success') }}</p>
        @endif
        <a href="{{ url('/user/tambah') }}">+ Tambah User</a>
        <table border="1" cellpadding="2" cellspacing="0">
            <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Nama</th>
                <th>ID Level Pengguna</th>
                <th>Kode Level</th>
                <th>Nama Level</th>
                <th>Aksi</th>
            </tr>
            @foreach ($data as $d)
                <tr>
                    <td>{{ $d->user_id ?? 'N/A' }}</td>
                    <td>{{ $d->username ?? 'N/A' }}</td>
                    <td>{{ $d->nama ?? 'N/A' }}</td>
                    <td>{{ $d->level_id ?? 'N/A' }}</td>
                    <td>{{ optional($d->level)->level_kode ?? 'N/A' }}</td>
                    <td>{{ optional($d->level)->level_nama ?? 'N/A' }}</td>
                    <td>
                        <a href="{{ url('/user/ubah/'.$d->user_id) }}">Ubah</a> | 
                        <a href="{{ url('/user/hapus/'.$d->user_id) }}" onclick="return confirm('Apakah Anda yakin ingin menghapus user ini?')">Hapus</a>
                    </td>
                </tr>
            @endforeach
        </table>

        <h2>Debug Information:</h2>
        <pre>
        @php
            foreach ($data as $user) {
                echo "User ID: " . $user->user_id . "\n";
                echo "Username: " . $user->username . "\n";
                echo "Level ID: " . $user->level_id . "\n";
                echo "Level: " . ($user->level ? "exists" : "does not exist") . "\n";
                if ($user->level) {
                    echo "Level Kode: " . $user->level->level_kode . "\n";
                    echo "Level Nama: " . $user->level->level_nama . "\n";
                }
                echo "\n";
            }
        @endphp
        </pre>
    </body>
</html>