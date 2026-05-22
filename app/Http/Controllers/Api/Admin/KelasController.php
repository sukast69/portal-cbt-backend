<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json([
            'data' => Kelas::with('subKelas')->latest()->get(),
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'nama_kelas' => 'required|string|max:50',
            'tingkat' => 'required|in:X,XI,XII',
        ]);

        $kelas = Kelas::create($validated);

        return response()->json([
            'message' => 'Kelas berhasil ditambahkan.',
            'data' => $kelas,
        ], 201);
    }

    public function show(Kelas $kelas): JsonResponse
    {
        return response()->json([
            'data' => $kelas->load('subKelas'),
        ]);
    }

    public function update(Request $request, Kelas $kelas): JsonResponse
    {
        $validated = $request->validate([
            'nama_kelas' => 'required|string|max:50',
            'tingkat' => 'required|in:X,XI,XII',
        ]);

        $kelas->update($validated);

        return response()->json([
            'message' => 'Kelas berhasil diupdate.',
            'data' => $kelas,
        ]);
    }

    public function destroy(Kelas $kelas): JsonResponse
    {
        $kelas->delete();

        return response()->json([
            'message' => 'Kelas berhasil dihapus.',
        ]);
    }
}
