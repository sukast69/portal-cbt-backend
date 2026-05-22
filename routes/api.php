<?php

use App\Http\Controllers\Api\Admin\JadwalController;
use App\Http\Controllers\Api\Admin\KelasController;
use App\Http\Controllers\Api\Admin\MapelController;
use App\Http\Controllers\Api\Admin\RuanganController;
use App\Http\Controllers\Api\Admin\SubKelasController;
use App\Http\Controllers\Api\Admin\UserController;
use App\Http\Controllers\Api\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Api\Guru\JadwalGuruController;
use App\Http\Controllers\Api\PublicController;
use Illuminate\Support\Facades\Route;

// ========== PUBLIC ==========
Route::get('ruangan', [PublicController::class, 'ruangan']);
Route::get('kelas', [PublicController::class, 'kelas']);
Route::get('sub-kelas/{kelas}', [PublicController::class, 'subKelas']);
Route::get('mata-pelajaran', [PublicController::class, 'mataPelajaran']);
Route::post('verifikasi-token', [PublicController::class, 'verifikasiToken']);

// ========== AUTH ==========
Route::post('login', [AuthenticatedSessionController::class, 'store']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy']);
    Route::get('me', [AuthenticatedSessionController::class, 'me']);
});

// ========== ADMIN ==========
Route::middleware(['auth:sanctum', 'admin'])->prefix('admin')->group(function () {
    Route::apiResource('ruangan', RuanganController::class)->except(['edit', 'create']);
    Route::apiResource('kelas', KelasController::class)->except(['edit', 'create']);
    Route::apiResource('sub-kelas', SubKelasController::class)->except(['edit', 'create']);
    Route::apiResource('mata-pelajaran', MapelController::class)->except(['edit', 'create']);
    Route::apiResource('jadwal', JadwalController::class)->except(['edit', 'create']);
    Route::apiResource('users', UserController::class)->except(['edit', 'create']);
});

// ========== GURU ==========
Route::middleware(['auth:sanctum', 'guru'])->prefix('guru')->group(function () {
    Route::get('jadwal', [JadwalGuruController::class, 'index']);
    Route::get('jadwal/{jadwal}', [JadwalGuruController::class, 'show']);
    Route::post('rilis-token/{jadwal}', [JadwalGuruController::class, 'rilisToken']);
    Route::post('reset-token/{jadwal}', [JadwalGuruController::class, 'resetToken']);
    Route::delete('akhiri-ujian/{jadwal}', [JadwalGuruController::class, 'akhiriUjian']);
});
