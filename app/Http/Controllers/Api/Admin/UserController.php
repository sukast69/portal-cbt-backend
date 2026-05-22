<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json([
            'data' => User::where('role', 'guru')->latest()->get(),
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
            'nip' => 'nullable|string|unique:users,nip',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['role'] = 'guru';

        $user = User::create($validated);

        return response()->json([
            'message' => 'User guru berhasil ditambahkan.',
            'data' => $user,
        ], 201);
    }

    public function show(User $user): JsonResponse
    {
        if ($user->role !== 'guru') {
            return response()->json(['message' => 'User bukan guru.'], 404);
        }

        return response()->json([
            'data' => $user,
        ]);
    }

    public function update(Request $request, User $user): JsonResponse
    {
        if ($user->role !== 'guru') {
            return response()->json(['message' => 'User bukan guru.'], 404);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:6',
            'nip' => 'nullable|string|unique:users,nip,' . $user->id,
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return response()->json([
            'message' => 'User guru berhasil diupdate.',
            'data' => $user,
        ]);
    }

    public function destroy(User $user): JsonResponse
    {
        if ($user->role !== 'guru') {
            return response()->json(['message' => 'User bukan guru.'], 404);
        }

        $user->delete();

        return response()->json([
            'message' => 'User guru berhasil dihapus.',
        ]);
    }
}
