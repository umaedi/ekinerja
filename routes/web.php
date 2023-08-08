<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get('/', [\App\Http\Controllers\AuthController::class, 'index'])->name('login')->middleware('guest');

Route::post('/auth/login', [\App\Http\Controllers\AuthController::class, 'login']);

Route::get('/dashboard', DashboardController::class);

Route::get('/pegawai', [PegawaiController::class, 'index']);
Route::get('/pegawai/create', [PegawaiController::class, 'create']);
Route::post('/pegawai/store', [PegawaiController::class, 'store']);
Route::get('/pegawai/show/{id}', [PegawaiController::class, 'show']);

Route::get('/tugas', [TugasController::class, 'index']);
Route::post('/tugas/store', [TugasController::class, 'store']);
Route::get('/tugas/show/{id}', [TugasController::class, 'show']);
Route::get('/tugas/show_lists', [TugasController::class, 'show_lists']);
Route::get('/tugas/show_list/{id}', [TugasController::class, 'show_list']);
Route::get('/tugas/show/{id}', [TugasController::class, 'show']);

Route::get('/profile', [ProfileController::class, 'index']);
Route::put('/profile/update/{id}', [ProfileController::class, 'update']);

Route::get('/import', [\App\Http\Controllers\ImportController::class, 'index']);
Route::post('/user/store', [\App\Http\Controllers\ImportController::class, 'store']);
Route::get('/export', [\App\Http\Controllers\ExportController::class, 'index']);
