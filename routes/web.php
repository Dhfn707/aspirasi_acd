<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AspirasiController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;

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

// Redirect root to login
Route::redirect('/', '/login');

// Login Routes (No Auth Required)
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// Logout Route
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Admin Routes (Protected)
Route::middleware('auth.admin')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/aspirasi/{aspirasi}', [AdminController::class, 'show'])->name('aspirasi.show');
    Route::put('/aspirasi/{aspirasi}', [AdminController::class, 'update'])->name('aspirasi.update');
});

// Karyawan Routes (Protected)
Route::middleware('auth.karyawan')->prefix('aspirasi')->name('aspirasi.')->group(function () {
    Route::get('/', [AspirasiController::class, 'index'])->name('index');
    Route::get('/create', [AspirasiController::class, 'create'])->name('create');
    Route::post('/', [AspirasiController::class, 'store'])->name('store');
    Route::get('/{aspirasi}', [AspirasiController::class, 'show'])->name('show');
    Route::get('/{aspirasi}/edit', [AspirasiController::class, 'edit'])->name('edit');
    Route::put('/{aspirasi}', [AspirasiController::class, 'update'])->name('update');
    Route::delete('/{aspirasi}', [AspirasiController::class, 'destroy'])->name('destroy');
});
