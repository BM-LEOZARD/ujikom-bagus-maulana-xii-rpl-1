<?php

namespace App\Http\Controllers;

use App\Helpers\LogHelper;
use App\Models\Alat;
use App\Models\Kategori;
use Illuminate\Http\Request;

class AlatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $alat = Alat::with(['kategori', 'peminjaman'])->get();
        $kategori = Kategori::all();

        foreach ($alat as $a) {
            $peminjamanAktif = $a->peminjaman()
                ->where('status', 'belum kembali')
                ->latest()
                ->first();

            $peminjamanSelesai = $a->peminjaman()
                ->where('status', 'selesai')
                ->latest()
                ->first();

            if ($peminjamanAktif) {
                $a->status = 'dipinjam';
            } else {
                $a->status = 'tersedia';

                if ($peminjamanSelesai) {
                    $a->kondisi = $peminjamanSelesai->kondisi;
                }
            }

            $a->saveQuietly();
        }

        $alat = Alat::with('kategori')->get();

        return view('alat.index', compact('alat', 'kategori'));
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
            'nama_alat' => 'required|string|max:255',
            'id_kategori' => 'required|exists:kategori,id',
            'deskripsi' => 'nullable|string',
            'kondisi' => 'required|in:baik,rusak',
        ]);

        Alat::create([
            'nama_alat' => $request->nama_alat,
            'id_kategori' => $request->id_kategori,
            'deskripsi' => $request->deskripsi,
            'kondisi' => $request->kondisi,
            'status' => 'tersedia',
        ]);
        LogHelper::catat('tambah', 'alat', 'Menambahkan alat baru: ' . $request->nama_alat);
        return redirect()->route('alat.index')->with('success', 'Alat "' . $request->nama_alat . '" berhasil ditambahkan.');
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
            'nama_alat' => 'required|string|max:255',
            'id_kategori' => 'required|exists:kategori,id',
            'deskripsi' => 'nullable|string',
            'kondisi' => 'required|in:baik,rusak',
        ]);

        $alat = Alat::findOrFail($id);
        $alat->update([
            'nama_alat' => $request->nama_alat,
            'id_kategori' => $request->id_kategori,
            'deskripsi' => $request->deskripsi,
            'kondisi' => $request->kondisi,
        ]);
        LogHelper::catat('ubah', 'alat', 'Mengubah alat: ' . $request->nama_alat);

        return redirect()->route('alat.index')->with('success', 'Alat "' . $request->nama_alat . '" berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $alat = Alat::findOrFail($id);
        LogHelper::catat('hapus', 'alat', 'Menghapus alat: ' . $alat->nama_alat);
        $alat->delete();

        return redirect()->route('alat.index')->with('success', 'Alat "' . $alat->nama_alat . '" berhasil dihapus.');
    }
}
