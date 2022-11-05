<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LaporanController;

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

Route::get('/', [HomeController::class, 'index'])->name('login');
Route::post('/', [laporanController::class, 'create']);
Route::get('/konfirmasi', [laporanController::class, 'confirm']);
Route::get('/hapus', [laporanController::class, 'delete']);
Route::post('/login', [HomeController::class, 'authenticate'])->middleware('guest');
Route::post('/logout', [HomeController::class, 'logout'])->middleware('auth');
Route::get('/caripasien', [laporanController::class, 'cari']);
Route::get('/hilang', [HomeController::class, 'hilang'])->middleware('guest');
Route::get('/ditemukan', [HomeController::class, 'ditemukan'])->middleware('guest');
Route::get('/laporan', [LaporanController::class, 'index'])->middleware('auth');
Route::post('/crop', [HomeController::class, 'crop'])->name('crop');