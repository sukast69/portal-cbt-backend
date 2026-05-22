<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\JadwalUjian;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json([
            'data' => JadwalUjian::with([
                'ruangan',
                'kelas',
                'subKelas',
                'mataPelajaran',
                'pengawas',
            ])->latest()->get(),
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'ruangan_id' => 'required|exists:ruangans,id',
            'kelas_id' => 'required|exists:kelas,id',
            'sub_kelas_id' => 'required|exists:sub_kelas,id',
            'mapel_id' => 'required|exists:mata_pelajarans,id',
            'pengawas_id' => 'required|exists:users,id,role,guru',
            'tanggal' => 'required|date|after_or_equal:today',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
        ]);

        $validated['status'] = 'draft';

        $jadwal = JadwalUjian::create($validated);

        return response()->json([
            'message' => 'Jadwal ujian berhasil ditambahkan.',
            'data' => $jadwal->load([
                'ruangan', 'kelas', 'subKelas', 'mataPelajaran', 'pengawas',
            ]),
        ], 201);
    }

    public function show(JadwalUjian $jadwal): JsonResponse
    {
        return response()->json([
            'data' => $jadwal->load([
                'ruangan', 'kelas', 'subKelas', 'mataPelajaran', 'pengawas', 'tokenAktif',
            ]),
        ]);
    }

    public function update(Request $request, JadwalUjian $jadwal): JsonResponse
    {
        $validated = $request->validate([
            'ruangan_id' => 'required|exists:ruangans,id',
            'kelas_id' => 'required|exists:kelas,id',
            'sub_kelas_id' => 'required|exists:sub_kelas,id',
            'mapel_id' => 'required|exists:mata_pelajarans,id',
            'pengawas_id' => 'required|exists:users,id,role,guru',
            'tanggal' => 'required|date',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            'status' => 'nullable|in:draft,aktif,selesai,dibatalkan',
        ]);

        $jadwal->update($validated);

        return response()->json([
            'message' => 'Jadwal ujian berhasil diupdate.',
            'data' => $jadwal->load([
                'ruangan', 'kelas', 'subKelas', 'mataPelajaran', 'pengawas',
            ]),
        ]);
    }

    public function destroy(JadwalUjian $jadwal): JsonResponse
    {
        $jadwal->delete();

        return response()->json([
            'message' => 'Jadwal ujian berhasil dihapus.',
        ]);
    }
}
