<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Route;

Route::get('/', [\App\Http\Controllers\AuthController::class, 'index'])->name('login')->middleware('guest');
Route::post('/auth/login', [\App\Http\Controllers\AuthController::class, 'login']);

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', DashboardController::class);

    //route for pegawai
    Route::get('/pegawai', [PegawaiController::class, 'index']);
    Route::get('/pegawai/create', [PegawaiController::class, 'create']);
    Route::post('/pegawai/store', [PegawaiController::class, 'store']);
    Route::get('/pegawai/show/{id}', [PegawaiController::class, 'show']);

    //route for tugas
    Route::get('/tugas', [TugasController::class, 'index']);
    Route::post('/tugas/store', [TugasController::class, 'store']);
    Route::get('/tugas/show/{id}', [TugasController::class, 'show']);
    Route::get('/tugas/show_lists', [TugasController::class, 'show_lists']);
    Route::get('/tugas/show_list/{id}', [TugasController::class, 'show_list']);
    Route::get('/tugas/show/{id}', [TugasController::class, 'show']);

    //route for profile
    Route::get('/profile', [ProfileController::class, 'index']);
    Route::put('/profile/update/{id}', [ProfileController::class, 'update']);

    //route for other
    Route::get('/import', [ImportController::class, 'index']);
    Route::post('/user/store', [ImportController::class, 'store']);
    Route::get('/export', [ExportController::class, 'index']);

    //route for logout
    Route::post('/auth/destroy', [AuthController::class, 'destroy']);
});
