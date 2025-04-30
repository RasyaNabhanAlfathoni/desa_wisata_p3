<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Keuangan PDF</title>
    <style>
        body { font-family: sans-serif; font-size: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #333; padding: 5px; text-align: left; }
        th { background-color: #eee; font-weight: bold; }
        .text-center { text-align: center; }
        .badge {
            padding: 3px 6px;
            border-radius: 3px;
            font-weight: bold;
            color: white;
            font-size: 9px;
        }
        .badge-success { background-color: #28a745; }
        .badge-warning { background-color: #ffc107; color: #212529; }
        .badge-info { background-color: #17a2b8; }
        .badge-danger { background-color: #dc3545; }
    </style>
</head>
<body>

    <h2 class="text-center">Laporan Transaksi Keuangan</h2>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Pelanggan</th>
                <th>Paket Wisata</th>
                <th>Tanggal Mulai</th>
                <th>Tanggal Akhir</th>
                <th>Harga</th>
                <th>Jumlah Peserta</th>
                <th>Diskon (Rp)</th>
                <th>Diskon (%)</th>
                <th>Total Bayar</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($reservasi as $item)
                <tr>
                    <td>{{ $item['No'] }}</td>
                    <td>{{ $item['Nama Pelanggan'] }}</td>
                    <td>{{ $item['Paket Wisata'] }}</td>
                    <td>{{ $item['Tanggal Mulai'] }}</td>
                    <td>{{ $item['Tanggal Akhir'] }}</td>
                    <td>{{ $item['Harga'] }}</td>
                    <td>{{ $item['Jumlah Peserta'] }}</td>
                    <td>{{ $item['Diskon (Rp)'] }}</td>
                    <td>{{ $item['Diskon (%)'] }}</td>
                    <td>{{ $item['Total Bayar'] }}</td>
                    <td>{{ $item['Status'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
