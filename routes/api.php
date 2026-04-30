<?php

use App\Http\Controllers\ApiAuthController;
use App\Http\Controllers\PortofolioController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// ─── Public Routes ────────────────────────────────────────────────────────────
Route::get('/test', function () {
    return response()->json([
        'status'  => 'success',
        'message' => 'API is working successfully!',
    ]);
});

// Login
Route::post('/login', [ApiAuthController::class, 'login']);

// Portofolio & Sertifikasi CRUD
Route::apiResource('portofolio', PortofolioController::class);
Route::apiResource('sertifikasi', \App\Http\Controllers\SertifikasiController::class);

// User Profile
Route::get('/user/{id}', [UserController::class, 'show']);
Route::put('/user/{id}', [UserController::class, 'update']);
Route::post('/user/{id}', [UserController::class, 'update']); // multipart fallback (_method=PUT)
Route::get('/user/{id}/portofolio-count', [UserController::class, 'portofolioCount']);
Route::get('/user/{id}/sertifikasi-count', [UserController::class, 'sertifikasiCount']);
