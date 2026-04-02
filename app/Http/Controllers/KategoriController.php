<?php

namespace App\Http\Controllers;

use App\Helpers\LogHelper;
use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kategori = Kategori::all();
        return view('kategori.index', compact('kategori'));
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
            'nama_kategori' => 'required|string|max:255',
        ]);

        Kategori::create($request->all());
        LogHelper::catat('tambah', 'kategori', 'Menambahkan kategori baru: ' . $request->nama_kategori);

        return redirect()->route('kategori.index')->with('success', 'Kategori "' . $request->nama_kategori . '" berhasil ditambahkan.');
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
            'nama_kategori' => 'required|string|max:255',
        ]);

        $kategori = Kategori::findOrFail($id);
        $request->validate(['nama_kategori' => 'required']);
        $kategori->update($request->all());
        LogHelper::catat('ubah', 'kategori', 'Mengubah kategori: ' . $request->nama_kategori);

        return redirect()->route('kategori.index')->with('success', 'Kategori "' . $request->nama_kategori . '" berhasil diubah.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $kategori = Kategori::findOrFail($id);
        LogHelper::catat('hapus', 'kategori', 'Menghapus kategori: ' . $kategori->nama_kategori);
        $kategori->delete();

        return redirect()->route('kategori.index')->with('success', 'Kategori "' . $kategori->nama_kategori . '" berhasil dihapus.');
    }
}
