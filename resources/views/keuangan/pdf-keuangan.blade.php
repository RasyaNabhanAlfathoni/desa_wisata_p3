<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Keuangan Reservasi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            margin: 20px;
        }

        .header {
            text-align: center;
            margin-bottom: 10px;
        }

        .header h2 {
            margin: 0;
        }

        .header p {
            margin: 2px 0;
            font-size: 10px;
        }

        .line {
            border-top: 2px solid black;
            margin: 10px 0;
        }

        .info {
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th, td {
            border: 1px solid #333;
            padding: 6px;
        }

        th {
            background-color: #f2f2f2;
            text-align: center;
        }

        td {
            vertical-align: middle;
        }

        .text-center { text-align: center; }
        .text-right { text-align: right; }

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

        .summary {
            margin-top: 15px;
            width: 50%;
        }

        .summary td {
            border: none;
            padding: 5px;
        }

        .footer {
            margin-top: 30px;
            text-align: right;
        }
    </style>
</head>
<body>

    <!-- HEADER PERUSAHAAN -->
    <div class="header">
        <h2>Laporan Keuangan Reservasi Wisata</h2>
        <p><strong>PT PesonaDesa Nusantara</strong></p>
        <p>Periode: {{ $periode ?? 'Semua Data' }}</p>
    </div>

    <div class="line"></div>

    <!-- TABEL DATA -->
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Pelanggan</th>
                <th>Paket Wisata</th>
                <th>Tanggal Mulai</th>
                <th>Tanggal Akhir</th>
                <th>Harga</th>
                <th>Peserta</th>
                <th>Diskon (Rp)</th>
                <th>Diskon (%)</th>
                <th>Total Bayar</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @php
                $totalSemua = 0;
            @endphp

            @foreach ($reservasi as $item)
                @php
                    $totalSemua += $item['Total Bayar'];
                @endphp
                <tr>
                    <td class="text-center">{{ $item['No'] }}</td>
                    <td>{{ $item['Nama Pelanggan'] }}</td>
                    <td>{{ $item['Paket Wisata'] }}</td>
                    <td>{{ $item['Tanggal Mulai'] }}</td>
                    <td>{{ $item['Tanggal Akhir'] }}</td>
                    <td class="text-right">Rp {{ number_format((float)$item['Harga'], 0, ',', '.') }}</td>
                    <td class="text-center">{{ $item['Jumlah Peserta'] }}</td>
                    <td class="text-right">Rp {{ number_format((float)$item['Diskon (Rp)'], 0, ',', '.') }}</td>
                    <td class="text-center">{{ $item['Diskon (%)'] }}%</td>
                    <td class="text-right">Rp {{ number_format((float)$item['Total Bayar'], 0, ',', '.') }}</td>
                    <td class="text-center">
                        {{ $item['Status'] }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- RINGKASAN -->
    <table class="summary">
        <tr>
            <td><strong>Total Transaksi</strong></td>
            <td>: {{ count($reservasi) }}</td>
        </tr>
        <tr>
            <td><strong>Total Pendapatan</strong></td>
            <td>: Rp {{ number_format($totalSemua, 0, ',', '.') }}</td>
        </tr>
    </table>

    <!-- FOOTER -->
    <div class="footer">
        <p>{{ date('d M Y') }}</p>
        <br><br><br>
        <p><strong>Penanggung Jawab</strong></p>
    </div>

</body>
</html>
