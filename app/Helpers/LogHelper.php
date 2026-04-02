<?php
namespace App\Helpers;

use App\Models\LogAktivitas;
use Illuminate\Support\Facades\Auth;

class LogHelper
{
    public static function catat(string $aksi, string $modul, string $keterangan): void
    {
        LogAktivitas::create([
            'user_id' => Auth::id(),
            'aksi' => $aksi,
            'modul' => $modul,
            'keterangan' => $keterangan,
        ]);
    }
}