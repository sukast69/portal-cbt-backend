<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubKelas extends Model
{
    protected $fillable = [
        'kelas_id',
        'nama_sub_kelas',
    ];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function jadwalUjians()
    {
        return $this->hasMany(JadwalUjian::class);
    }
}
