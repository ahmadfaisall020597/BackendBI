<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\IklanController;
use App\Http\Controllers\KalanganController;
use App\Http\Controllers\PesertaPendaftaranController;
use App\Http\Controllers\WebinarController;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::middleware('auth:sanctum')->group(function () {

    Route::post('/logout', [AuthController::class, 'logout']);

    Route::middleware('admin')->get('/admin', function () {
        return response()->json([
            'message' => 'Welcome Admin'
        ]);
    });

    Route::get('/profile', function () {
        return auth()->user();
    });
});

Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::get('/list-iklan', [IklanController::class, 'index']);
    Route::post('/create-iklan', [IklanController::class, 'store']);
    Route::get('/detail-iklan/{id}', [IklanController::class, 'show']);
    Route::post('/edit-iklan/{id}', [IklanController::class, 'update']);
    Route::delete('/delete-iklan/{id}', [IklanController::class, 'destroy']);

    Route::get('/list-kalangan', [KalanganController::class, 'index']);
    Route::post('/create-kalangan', [KalanganController::class, 'store']);
    Route::get('/detail-kalangan/{id}', [KalanganController::class, 'show']);
    Route::post('/edit-kalangan/{id}', [KalanganController::class, 'update']);
    Route::delete('/delete-kalangan/{id}', [KalanganController::class, 'destroy']);

    Route::get('/list-webinar', [WebinarController::class, 'index']);
    Route::post('/create-webinar', [WebinarController::class, 'store']);
    Route::get('/detail-webinar/{id}', [WebinarController::class, 'show']);
    Route::post('/edit-webinar/{id}', [WebinarController::class, 'update']);
    Route::delete('/delete-webinar/{id}', [WebinarController::class, 'destroy']);

    Route::get('/dashboard', [DashboardController::class, 'index']);
});

Route::middleware(['auth:sanctum', 'role.member'])->group(function () {

    Route::get('/pendaftaran', [PesertaPendaftaranController::class, 'index']);
    Route::post('/pendaftaran', [PesertaPendaftaranController::class, 'store']);
});
