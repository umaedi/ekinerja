<?php

use Illuminate\Support\Facades\Route;
use Ramsey\Uuid\Guid\Guid;

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

Route::middleware('auth')->prefix('admin')->group(function () {
    Route::get('/profile', [\App\Http\Controllers\Admin\ProfileController::class, 'index'])->name('admin.profile');
    Route::post('/profile/update/{id}', [\App\Http\Controllers\Admin\ProfileController::class, 'update'])->name('admin.profile.update');
    Route::post('/auth/destroy', [\App\Http\Controllers\AuthController::class, 'destroy']);

    Route::get('/', [\App\Http\Controllers\Admin\DashboardController::class, 'index']);

    Route::controller(\App\Http\Controllers\Admin\PegawaiController::class)->group(function () {
        Route::get('/pegawai', 'index')->name('admin.pegawai.index');
        Route::get('/pegawai/tambah', 'create')->name('admin.pegawai.create');
        Route::post('/pegawai/store', 'store')->name('admin.pegawai.store');
        Route::get('/pegawai/lihat/{id}', 'show')->name('admin.pegawai.show');
        Route::post('/pegawai/update/{id}', 'update')->name('admin.pegawai.update');
        Route::delete('/pegawai/destory/{id}', 'destory');
    });

    Route::controller(\App\Http\Controllers\Admin\TugasController::class)->group(function () {
        Route::get('/pegawai/tugas', 'index');
        Route::get('/pegawai/tugas/lihat/{id}', 'show');
    });

    Route::get('/import', [\App\Http\Controllers\Admin\ImportController::class, 'index'])->name('admin.import');
    Route::post('/import/store', [\App\Http\Controllers\Admin\ImportController::class, 'store'])->name('admin.import.store');
});

Route::middleware('subadmin')->prefix('pegawai')->group(function () {
    Route::controller(\App\Http\Controllers\Bagain\PegawaiController::class)->group(function () {
        Route::get('/staf', 'index')->name('bagian.pegawai');
        Route::get('/staf/lihat/{id}', 'show')->name('bagian.pegawai.show');
    });

    Route::controller(\App\Http\Controllers\Bagian\TugasController::class)->group(function () {
        Route::get('/data_pegawai/tugas/lihat/{id}', 'show');
    });
});

Route::middleware('pegawai')->prefix('pegawai')->group(function () {
    Route::get('/', [\App\Http\Controllers\Pegawai\DahsboardController::class, 'index']);

    Route::controller(\App\Http\Controllers\Pegawai\TugasController::class)->group(function () {
        Route::get('/tugas/riwayat', 'index')->name('pegawai.tugas');
        Route::post('/tugas/store', 'store');
        Route::get('/tugas/riwayat/lihat/{id}', 'show');
    });

    Route::controller(\App\Http\Controllers\Pegawai\PorfileController::class)->group(function () {
        Route::get('/profile', 'index')->name('pegawai.profile');
        Route::post('/profile/update/{id}', 'update');
    });

    Route::post('/auth/destroy', [\App\Http\Controllers\AuthController::class, 'destroy']);
});
