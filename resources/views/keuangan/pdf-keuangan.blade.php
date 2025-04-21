<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Keuangan PDF</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #333; padding: 5px; text-align: left; }
        th { background-color: #eee; }
    </style>
</head>
<body>
    <h2>Laporan Keuangan</h2>
    <table>
        <thead>
            <tr>
                <th>Nama Pelanggan</th>
                <th>Paket Wisata</th>
                <th>Tanggal Mulai</th>
                <th>Jumlah Peserta</th>
                <th>Total Bayar</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($reservasi as $r)
                <tr>
                    <td>{{ $r['Nama Pelanggan'] }}</td>
                    <td>{{ $r['Paket Wisata'] }}</td>
                    <td>{{ $r['Tanggal Mulai'] }}</td>
                    <td>{{ $r['Jumlah Peserta'] }}</td>
                    <td>Rp{{ number_format($r['Total Bayar'], 0, ',', '.') }}</td>
                    <td>{{ ucfirst($r['Status']) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
