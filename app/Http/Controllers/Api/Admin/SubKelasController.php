<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\SubKelas;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SubKelasController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json([
            'data' => SubKelas::with('kelas')->latest()->get(),
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'nama_sub_kelas' => 'required|string|max:50',
        ]);

        $subKelas = SubKelas::create($validated);

        return response()->json([
            'message' => 'Sub kelas berhasil ditambahkan.',
            'data' => $subKelas,
        ], 201);
    }

    public function show(SubKelas $subKelas): JsonResponse
    {
        return response()->json([
            'data' => $subKelas->load('kelas'),
        ]);
    }

    public function update(Request $request, SubKelas $subKelas): JsonResponse
    {
        $validated = $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'nama_sub_kelas' => 'required|string|max:50',
        ]);

        $subKelas->update($validated);

        return response()->json([
            'message' => 'Sub kelas berhasil diupdate.',
            'data' => $subKelas,
        ]);
    }

    public function destroy(SubKelas $subKelas): JsonResponse
    {
        $subKelas->delete();

        return response()->json([
            'message' => 'Sub kelas berhasil dihapus.',
        ]);
    }
}
