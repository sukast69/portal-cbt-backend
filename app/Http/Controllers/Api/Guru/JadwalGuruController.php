<?php

namespace App\Http\Controllers\Api\Guru;

use App\Http\Controllers\Controller;
use App\Models\JadwalUjian;
use App\Services\TokenService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class JadwalGuruController extends Controller
{
    public function __construct(
        protected TokenService $tokenService
    ) {}

    public function index(Request $request): JsonResponse
    {
        $jadwals = JadwalUjian::with([
            'ruangan',
            'kelas',
            'subKelas',
            'mataPelajaran',
        ])
            ->where('pengawas_id', $request->user()->id)
            ->where('tanggal', now()->toDateString())
            ->whereIn('status', ['draft', 'aktif'])
            ->latest()
            ->get();

        return response()->json([
            'data' => $jadwals,
        ]);
    }

    public function show(Request $request, JadwalUjian $jadwal): JsonResponse
    {
        if ($jadwal->pengawas_id !== $request->user()->id) {
            return response()->json(['message' => 'Unauthorized.'], 403);
        }

        $jadwal->load([
            'ruangan',
            'kelas',
            'subKelas',
            'mataPelajaran',
            'tokenAktif',
        ]);

        return response()->json([
            'data' => $jadwal,
        ]);
    }

    public function rilisToken(Request $request, JadwalUjian $jadwal): JsonResponse
    {
        if ($jadwal->pengawas_id !== $request->user()->id) {
            return response()->json(['message' => 'Unauthorized.'], 403);
        }

        if ($jadwal->tanggal->format('Y-m-d') !== now()->format('Y-m-d')) {
            return response()->json(['message' => 'Token hanya bisa dirilis pada hari ujian.'], 400);
        }

        $token = $this->tokenService->generate($jadwal);

        return response()->json([
            'message' => 'Token berhasil dirilis.',
            'data' => [
                'token' => $token->token,
                'expired_at' => $token->expired_at,
            ],
        ]);
    }

    public function resetToken(Request $request, JadwalUjian $jadwal): JsonResponse
    {
        if ($jadwal->pengawas_id !== $request->user()->id) {
            return response()->json(['message' => 'Unauthorized.'], 403);
        }

        $token = $this->tokenService->reset($jadwal);

        return response()->json([
            'message' => 'Token berhasil direset.',
            'data' => [
                'token' => $token->token,
                'expired_at' => $token->expired_at,
            ],
        ]);
    }

    public function akhiriUjian(Request $request, JadwalUjian $jadwal): JsonResponse
    {
        if ($jadwal->pengawas_id !== $request->user()->id) {
            return response()->json(['message' => 'Unauthorized.'], 403);
        }

        $this->tokenService->endExam($jadwal);

        return response()->json([
            'message' => 'Ujian berhasil diakhiri. Jadwal dihapus.',
        ]);
    }
}
