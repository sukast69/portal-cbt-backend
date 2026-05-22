<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ruangan;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RuanganController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json([
            'data' => Ruangan::latest()->get(),
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'kode_ruangan' => 'required|string|max:20|unique:ruangans',
            'nama_ruangan' => 'required|string|max:100',
            'kapasitas' => 'required|integer|min:1',
            'lokasi' => 'nullable|string|max:100',
        ]);

        $ruangan = Ruangan::create($validated);

        return response()->json([
            'message' => 'Ruangan berhasil ditambahkan.',
            'data' => $ruangan,
        ], 201);
    }

    public function show(Ruangan $ruangan): JsonResponse
    {
        return response()->json([
            'data' => $ruangan,
        ]);
    }

    public function update(Request $request, Ruangan $ruangan): JsonResponse
    {
        $validated = $request->validate([
            'kode_ruangan' => 'required|string|max:20|unique:ruangans,kode_ruangan,' . $ruangan->id,
            'nama_ruangan' => 'required|string|max:100',
            'kapasitas' => 'required|integer|min:1',
            'lokasi' => 'nullable|string|max:100',
        ]);

        $ruangan->update($validated);

        return response()->json([
            'message' => 'Ruangan berhasil diupdate.',
            'data' => $ruangan,
        ]);
    }

    public function destroy(Ruangan $ruangan): JsonResponse
    {
        $ruangan->delete();

        return response()->json([
            'message' => 'Ruangan berhasil dihapus.',
        ]);
    }
}
