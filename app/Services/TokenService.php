<?php

namespace App\Services;

use App\Models\JadwalUjian;
use App\Models\TokenUjian;
use Illuminate\Support\Str;

class TokenService
{
    public function generate(JadwalUjian $jadwal): TokenUjian
    {
        TokenUjian::where('jadwal_id', $jadwal->id)
            ->where('status', 'aktif')
            ->update(['status' => 'kadaluarsa']);

        $token = new TokenUjian();
        $token->jadwal_id = $jadwal->id;
        $token->token = $this->generateToken();
        $token->status = 'aktif';
        $token->expired_at = now()->addHours(5);
        $token->save();

        $jadwal->update(['status' => 'aktif']);

        return $token;
    }

    public function reset(JadwalUjian $jadwal): TokenUjian
    {
        return $this->generate($jadwal);
    }

    public function validate(string $token, int $jadwalId): bool
    {
        $tokenUjian = TokenUjian::where('jadwal_id', $jadwalId)
            ->where('token', $token)
            ->where('status', 'aktif')
            ->where('expired_at', '>', now())
            ->first();

        if (!$tokenUjian) {
            return false;
        }

        $tokenUjian->update(['status' => 'kadaluarsa']);

        return true;
    }

    public function endExam(JadwalUjian $jadwal): void
    {
        TokenUjian::where('jadwal_id', $jadwal->id)->delete();
        $jadwal->delete();
    }

    private function generateToken(): string
    {
        return str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);
    }
}
