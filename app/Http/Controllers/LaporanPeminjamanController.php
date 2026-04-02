<?php

namespace App\Http\Controllers;

use App\Helpers\LogHelper;
use App\Models\Peminjaman;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class LaporanPeminjamanController extends Controller
{
    public function index()
    {
        $peminjaman = Peminjaman::with('alat')->get();
        return view('laporan-peminjaman.index', compact('peminjaman'));
    }

    public function cetak()
    {
        $peminjaman = Peminjaman::with('alat')->get();
        LogHelper::catat('cetak', 'peminjaman', 'Mencetak laporan peminjaman');
        $pdf = Pdf::loadView('laporan-peminjaman.cetak', compact('peminjaman'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('laporan-peminjaman-' . now()->format('d-m-Y') . '.pdf');
    }

    public function cetakSatu($id)
    {
        $peminjaman = Peminjaman::with('alat')->findOrFail($id);

        if ($peminjaman->status === 'belum kembali') {
            return redirect()->back()->with('error', 'Laporan alat "' . $peminjaman->alat->nama_alat . '" belum bisa dicetak karena belum dikembalikan.');
        }

        LogHelper::catat('cetak', 'laporan', 'Mencetak laporan peminjaman alat "' . $peminjaman->alat->nama_alat . '" atas nama ' . $peminjaman->nama_peminjam);

        $pdf = Pdf::loadView('laporan-peminjaman.cetak-satu', compact('peminjaman'))
            ->setPaper('a4', 'portrait');
        return $pdf->download('laporan-peminjaman-' . $peminjaman->alat->nama_alat . '-' . now()->format('d-m-Y') . '.pdf');
    }
}
