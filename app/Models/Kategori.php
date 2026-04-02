<?php

namespace App\Models;

use App\Models\Alat;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    protected $table = 'kategori';
    protected $fillable = ['nama_kategori'];

    public function alat()
    {
        return $this->hasMany(Alat::class, 'id_kategori');
    }
}
