<?php

namespace App\Http\Controllers;

use App\Helpers\LogHelper;
use App\Models\Alat;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class PeminjamanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $peminjaman = Peminjaman::with('alat')->get();
        $alat = Alat::where('status', 'tersedia')->get();
        return view('peminjaman.index', compact('peminjaman', 'alat'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_alat' => 'required|exists:alat,id',
            'nama_peminjam' => 'required|string|max:255',
            'tgl_pinjam' => 'required|date',
            'tgl_kembali' => 'required|date|after_or_equal:tgl_pinjam',
            'kondisi' => 'required|in:baik,rusak',
        ]);

        Peminjaman::create([
            'id_alat' => $request->id_alat,
            'nama_peminjam' => $request->nama_peminjam,
            'tgl_pinjam' => $request->tgl_pinjam,
            'tgl_kembali' => $request->tgl_kembali,
            'kondisi' => $request->kondisi,
            'status' => 'belum kembali',
        ]);

        $alat = Alat::findOrFail($request->id_alat);
        $alat->status = 'dipinjam';
        $alat->save();
        LogHelper::catat('tambah', 'peminjaman', 'Menambahkan peminjaman baru: ' . $request->nama_peminjam);

        return redirect()->route('peminjaman.index')->with('success', 'Peminjaman alat "' . $alat->nama_alat . '" atas nama ' . $request->nama_peminjam . ' berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'id_alat' => 'required|exists:alat,id',
            'nama_peminjam' => 'required|string|max:255',
            'tgl_pinjam' => 'required|date',
            'tgl_kembali' => 'required|date|after_or_equal:tgl_pinjam',
        ]);

        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->update([
            'id_alat' => $request->id_alat,
            'nama_peminjam' => $request->nama_peminjam,
            'tgl_pinjam' => $request->tgl_pinjam,
            'tgl_kembali' => $request->tgl_kembali,
        ]);
        LogHelper::catat('ubah', 'peminjaman', 'Mengubah peminjaman: ' . $request->nama_peminjam);

        return redirect()->route('peminjaman.index')->with('success', 'Data peminjaman "' . $peminjaman->alat->nama_alat . '" atas nama ' . $request->nama_peminjam . ' berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        LogHelper::catat('hapus', 'peminjaman', 'Menghapus peminjaman: ' . $peminjaman->nama_peminjam);
        $peminjaman->delete();

        return redirect()->route('peminjaman.index')->with('success', 'Data peminjaman atas nama "' . $peminjaman->nama_peminjam . '" berhasil dihapus.');
    }
}
