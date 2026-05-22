<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    protected $fillable = [
        'nama_kelas',
        'tingkat',
    ];

    public function subKelas()
    {
        return $this->hasMany(SubKelas::class);
    }

    public function jadwalUjians()
    {
        return $this->hasMany(JadwalUjian::class);
    }
}
