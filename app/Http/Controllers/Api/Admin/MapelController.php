<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\MataPelajaran;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MapelController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json([
            'data' => MataPelajaran::latest()->get(),
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'kode_mapel' => 'required|string|max:20|unique:mata_pelajarans',
            'nama_mapel' => 'required|string|max:100',
        ]);

        $mapel = MataPelajaran::create($validated);

        return response()->json([
            'message' => 'Mata pelajaran berhasil ditambahkan.',
            'data' => $mapel,
        ], 201);
    }

    public function show(MataPelajaran $mataPelajaran): JsonResponse
    {
        return response()->json([
            'data' => $mataPelajaran,
        ]);
    }

    public function update(Request $request, MataPelajaran $mataPelajaran): JsonResponse
    {
        $validated = $request->validate([
            'kode_mapel' => 'required|string|max:20|unique:mata_pelajarans,kode_mapel,' . $mataPelajaran->id,
            'nama_mapel' => 'required|string|max:100',
        ]);

        $mataPelajaran->update($validated);

        return response()->json([
            'message' => 'Mata pelajaran berhasil diupdate.',
            'data' => $mataPelajaran,
        ]);
    }

    public function destroy(MataPelajaran $mataPelajaran): JsonResponse
    {
        $mataPelajaran->delete();

        return response()->json([
            'message' => 'Mata pelajaran berhasil dihapus.',
        ]);
    }
}
