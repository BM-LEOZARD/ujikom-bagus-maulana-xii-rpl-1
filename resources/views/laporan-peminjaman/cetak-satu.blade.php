<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Peminjaman - {{ $peminjaman->alat->nama_alat }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #111;
            padding: 40px;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #111;
            padding-bottom: 12px;
        }

        .header h1 {
            font-size: 16px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .header p {
            font-size: 11px;
            color: #444;
            margin-top: 4px;
        }

        .info-box {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .info-box tr td {
            padding: 7px 10px;
            border: 1px solid #ccc;
            font-size: 12px;
        }

        .info-box tr td:first-child {
            width: 35%;
            font-weight: bold;
        }

        .footer {
            margin-top: 50px;
            font-size: 11px;
            text-align: right;
            color: #444;
        }
    </style>
</head>

<body>

    <div class="header">
        <h1>Laporan Peminjaman Alat</h1>
        <p>Dicetak pada: {{ \Carbon\Carbon::now()->format('d/m/Y H:i') }}</p>
    </div>

    <table class="info-box">
        <tr>
            <td>Nama Alat</td>
            <td>{{ $peminjaman->alat->nama_alat }}</td>
        </tr>
        <tr>
            <td>Nama Peminjam</td>
            <td>{{ $peminjaman->nama_peminjam }}</td>
        </tr>
        <tr>
            <td>Tanggal Pinjam</td>
            <td>{{ \Carbon\Carbon::parse($peminjaman->tgl_pinjam)->format('d/m/Y') }}</td>
        </tr>
        <tr>
            <td>Rencana Kembali</td>
            <td>{{ \Carbon\Carbon::parse($peminjaman->tgl_kembali)->format('d/m/Y') }}</td>
        </tr>
        <tr>
            <td>Waktu Dikembalikan</td>
            <td>
                @if ($peminjaman->status == 'selesai')
                    {{ \Carbon\Carbon::parse($peminjaman->updated_at)->timezone('Asia/Jakarta')->format('d/m/Y H:i') }} WIB
                    @php
                        $rencana = \Carbon\Carbon::parse($peminjaman->tgl_kembali);
                        $aktual = \Carbon\Carbon::parse($peminjaman->updated_at)->startOfDay();
                    @endphp
                    @if ($aktual->gt($rencana))
                        <span style="color: #991b1b; font-size: 10px;">
                            (Terlambat {{ $rencana->diffInDays($aktual) }} hari)
                        </span>
                    @elseif ($aktual->lt($rencana))
                        <span style="color: #065f46; font-size: 10px;">
                            (Lebih awal {{ $aktual->diffInDays($rencana) }} hari)
                        </span>
                    @else
                        <span style="font-size: 10px;">(Tepat waktu)</span>
                    @endif
                @else
                    Belum dikembalikan
                @endif
            </td>
        </tr>
        <tr>
            <td>Kondisi</td>
            <td>{{ ucfirst($peminjaman->kondisi) }}</td>
        </tr>
        <tr>
            <td>Status</td>
            <td>{{ $peminjaman->status == 'belum kembali' ? 'Belum Kembali' : 'Selesai' }}</td>
        </tr>
    </table>
</body>

</html>