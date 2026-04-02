<?php

namespace App\Models;

use App\Models\Kategori;
use App\Models\Peminjaman;
use Illuminate\Database\Eloquent\Model;

class Alat extends Model
{
    protected $table = 'alat';

    protected $fillable = [
        'nama_alat',
        'id_kategori',
        'deskripsi',
        'kondisi',
        'status',
    ];

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori');
    }

    public function peminjaman() 
    {
        return $this->hasMany(Peminjaman::class, 'id_alat');
    }
}
