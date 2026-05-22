<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ruangan extends Model
{
    protected $fillable = [
        'kode_ruangan',
        'nama_ruangan',
        'kapasitas',
        'lokasi',
    ];

    public function jadwalUjians()
    {
        return $this->hasMany(JadwalUjian::class);
    }
}
