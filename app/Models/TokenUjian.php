<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TokenUjian extends Model
{
    protected $fillable = [
        'jadwal_id',
        'token',
        'status',
        'expired_at',
    ];

    protected $casts = [
        'expired_at' => 'datetime',
    ];

    public function jadwal()
    {
        return $this->belongsTo(JadwalUjian::class, 'jadwal_id');
    }
}
