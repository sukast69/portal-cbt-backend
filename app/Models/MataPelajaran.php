<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MataPelajaran extends Model
{
    protected $fillable = [
        'kode_mapel',
        'nama_mapel',
    ];

    public function jadwalUjians()
    {
        return $this->hasMany(JadwalUjian::class);
    }
}
