<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\CutiController;
//use App\Http\Controllers\LaporanController;

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

Route::get('/', [DashboardController::class, 'index']);
Route::get('/karyawan', [KaryawanController::class, 'index']);
Route::get('/karyawan/datatable', [KaryawanController::class, 'datatable']);
Route::get('/karyawan/get', [KaryawanController::class, 'get']);
Route::get('/karyawan/select2', [KaryawanController::class, 'select2']);
Route::post('/karyawan/create', [KaryawanController::class, 'create']);
Route::post('/karyawan/destroy', [KaryawanController::class, 'destroy']);
Route::get('/cuti', [CutiController::class, 'index']);
Route::get('/cuti/datatable', [CutiController::class, 'datatable']);
Route::post('/cuti/create', [CutiController::class, 'create']);
Route::get('/cuti/get', [CutiController::class, 'get']);
Route::post('/cuti/destroy', [CutiController::class, 'destroy']);
//Route::get('/laporan', [LaporanController::class, 'index']);
