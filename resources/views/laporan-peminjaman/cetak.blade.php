<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Peminjaman Alat</title>
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
            padding: 30px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #111;
            padding-bottom: 10px;
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

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 16px;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 6px 8px;
            text-align: left;
        }

        th {
            font-weight: bold;
            font-size: 11px;
        }

        td {
            font-size: 11px;
        }

        .footer {
            margin-top: 20px;
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

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Alat</th>
                <th>Peminjam</th>
                <th>Tgl Pinjam</th>
                <th>Rencana Kembali</th>
                <th>Waktu Dikembalikan</th>
                <th>Kondisi</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($peminjaman as $i => $p)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $p->alat->nama_alat }}</td>
                    <td>{{ $p->nama_peminjam }}</td>
                    <td>{{ \Carbon\Carbon::parse($p->tgl_pinjam)->format('d/m/Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($p->tgl_kembali)->format('d/m/Y') }}</td>
                    <td>
                        @if ($p->status == 'selesai')
                            {{ \Carbon\Carbon::parse($p->updated_at)->timezone('Asia/Jakarta')->format('d/m/Y H:i') }}
                            WIB
                            @php
                                $rencana = \Carbon\Carbon::parse($p->tgl_kembali);
                                $aktual = \Carbon\Carbon::parse($p->updated_at)->startOfDay();
                            @endphp
                            @if ($aktual->gt($rencana))
                                (Terlambat {{ $rencana->diffInDays($aktual) }} hari)
                            @elseif ($aktual->lt($rencana))
                                (Lebih awal {{ $aktual->diffInDays($rencana) }} hari)
                            @else
                                (Tepat waktu)
                            @endif
                        @else
                            -
                        @endif
                    </td>
                    <td>{{ ucfirst($p->kondisi) }}</td>
                    <td>{{ $p->status == 'belum kembali' ? 'Belum Kembali' : 'Selesai' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="text-align:center; padding: 16px; color: #999;">
                        Belum ada data peminjaman
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Total: {{ $peminjaman->count() }} data peminjaman</p>
    </div>

</body>

</html>
