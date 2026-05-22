<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\JadwalUjian;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\Ruangan;
use App\Models\SubKelas;
use App\Services\TokenService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    public function __construct(
        protected TokenService $tokenService
    ) {}

    public function ruangan(): JsonResponse
    {
        return response()->json([
            'data' => Ruangan::all(['id', 'kode_ruangan', 'nama_ruangan']),
        ]);
    }

    public function kelas(): JsonResponse
    {
        return response()->json([
            'data' => Kelas::all(['id', 'nama_kelas', 'tingkat']),
        ]);
    }

    public function subKelas(Kelas $kelas): JsonResponse
    {
        return response()->json([
            'data' => $kelas->subKelas()->get(['id', 'nama_sub_kelas']),
        ]);
    }

    public function mataPelajaran(): JsonResponse
    {
        return response()->json([
            'data' => MataPelajaran::all(['id', 'kode_mapel', 'nama_mapel']),
        ]);
    }

    public function verifikasiToken(Request $request): JsonResponse
    {
        $request->validate([
            'ruangan_id' => 'required|exists:ruangans,id',
            'kelas_id' => 'required|exists:kelas,id',
            'sub_kelas_id' => 'required|exists:sub_kelas,id',
            'mapel_id' => 'required|exists:mata_pelajarans,id',
            'token' => 'required|string|size:6',
        ]);

        $jadwal = JadwalUjian::where([
            'ruangan_id' => $request->ruangan_id,
            'kelas_id' => $request->kelas_id,
            'sub_kelas_id' => $request->sub_kelas_id,
            'mapel_id' => $request->mapel_id,
            'tanggal' => now()->toDateString(),
        ])->whereIn('status', ['aktif'])->first();

        if (!$jadwal) {
            return response()->json([
                'message' => 'Tidak ada jadwal ujian yang sesuai.',
            ], 404);
        }

        $valid = $this->tokenService->validate($request->token, $jadwal->id);

        if (!$valid) {
            return response()->json([
                'message' => 'Token tidak valid atau sudah kadaluarsa.',
            ], 400);
        }

        return response()->json([
            'message' => 'Token valid. Selamat mengerjakan.',
            'data' => [
                'jadwal_id' => $jadwal->id,
                'ruangan' => $jadwal->ruangan->nama_ruangan,
                'mapel' => $jadwal->mataPelajaran->nama_mapel,
                'jam_mulai' => $jadwal->jam_mulai,
                'jam_selesai' => $jadwal->jam_selesai,
            ],
        ]);
    }
}
