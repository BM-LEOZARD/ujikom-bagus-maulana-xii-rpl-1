<?php

namespace App\Models;

use App\Models\Alat;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    protected $table = 'peminjaman';

    protected $fillable = [
        'id_alat',
        'nama_peminjam',
        'tgl_pinjam',
        'tgl_kembali',
        'kondisi',
        'status',
    ];

    public function alat()
    {
        return $this->belongsTo(Alat::class, 'id_alat');
    }
}
