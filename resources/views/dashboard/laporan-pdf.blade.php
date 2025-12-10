<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Harga Komoditas</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 5px;
            text-align: center;
        }

        th {
            background-color: #f2f2f2;
        }

        h2 {
            text-align: center;
        }
    </style>
</head>

<body>
    <h2>Laporan Harga Komoditas</h2>
    <table>
        <thead>
            <tr>
                <th>Tanggal / Bulan</th>
                <th>Komoditas</th>
                <th>Pasar</th>
                <th>Harga Rata-Rata</th>
                <th>Perubahan (%)</th>
                <th>Admin</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $row)
                <tr>
                    <td>{{ $row->tanggal }}</td>
                    <td>{{ $row->nama_commodity }}</td>
                    <td>{{ $row->nama_pasar }}</td>
                    <td>{{ $row->harga_rata ?? '-' }}</td>
                    <td>{{ $row->perubahan }}</td>
                    <td>{{ $row->admin }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
