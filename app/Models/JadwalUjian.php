<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalUjian extends Model
{
    protected $fillable = [
        'ruangan_id',
        'kelas_id',
        'sub_kelas_id',
        'mapel_id',
        'pengawas_id',
        'tanggal',
        'jam_mulai',
        'jam_selesai',
        'status',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'jam_mulai' => 'datetime:H:i',
        'jam_selesai' => 'datetime:H:i',
    ];

    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class);
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function subKelas()
    {
        return $this->belongsTo(SubKelas::class);
    }

    public function mataPelajaran()
    {
        return $this->belongsTo(MataPelajaran::class, 'mapel_id');
    }

    public function pengawas()
    {
        return $this->belongsTo(User::class, 'pengawas_id');
    }

    public function tokenUjians()
    {
        return $this->hasMany(TokenUjian::class, 'jadwal_id');
    }

    public function tokenAktif()
    {
        return $this->hasOne(TokenUjian::class, 'jadwal_id')->where('status', 'aktif')->latest();
    }
}
