<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Aktivitas Pengguna</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
            color: #000;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #aaa;
            padding: 6px 8px;
            text-align: left;
        }

        th {
            background-color: #eee;
        }

        .text-center {
            text-align: center;
        }

        .small {
            font-size: 10px;
            color: #666;
        }
    </style>
</head>

<body>
    <h2>LAPORAN AKTIVITAS PENGGUNA</h2>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Waktu</th>
                <th>Nama User</th>
                <th>Role</th>
                <th>Aktivitas</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($logs as $index => $log)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($log['timestamp'])->format('d-m-Y H:i:s') }}</td>
                    <td>{{ $log['user'] ?? '-' }}</td>
                    <td>{{ $log['role'] ?? '-' }}</td>
                    <td>{{ $log['activity'] ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">Tidak ada data aktivitas</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <p class="small text-center" style="margin-top: 20px;">
        Dicetak pada {{ now()->format('d-m-Y H:i:s') }}
    </p>
</body>

</html>