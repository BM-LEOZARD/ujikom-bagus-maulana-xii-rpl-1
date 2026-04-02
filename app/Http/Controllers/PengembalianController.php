<?php

namespace App\Http\Controllers;

use App\Helpers\LogHelper;
use App\Models\Alat;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class PengembalianController extends Controller
{
    public function index()
    {
        $peminjaman = Peminjaman::with('alat')->where('status', 'belum kembali')->get();
        return view('pengembalian.index', compact('peminjaman'));
    }

    public function update(Request $request, $id)
    {
        $request->validate(['kondisi' => 'required']);

        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->update([
            'kondisi' => $request->kondisi,
            'status'  => 'selesai',
        ]);

        Alat::find($peminjaman->id_alat)->update(['status' => 'tersedia']);
        LogHelper::catat('ubah', 'peminjaman', 'Menyelesaikan peminjaman: ' . $peminjaman->nama_peminjam);

        return redirect()->route('pengembalian.index')->with('success', 'Alat "' . $peminjaman->alat->nama_alat . '" atas nama ' . $peminjaman->nama_peminjam . ' berhasil dikembalikan.');
    }
}
