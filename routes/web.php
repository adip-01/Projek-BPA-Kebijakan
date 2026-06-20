<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\LoginController; 

use App\Http\Controllers\RegisterController;

use App\Http\Controllers\AdminDashboardController;

use App\Http\Controllers\AdminUserController;

use App\Http\Controllers\BisnisProsesController;

use App\Http\Controllers\DokumenUnitController;

use App\Http\Controllers\SasaranMutuController;

use App\Http\Controllers\InformasiTambahanController;

use App\Http\Controllers\DaftarDokumenController;

use App\Http\Controllers\DokumenSpmiController;


Route::get('/', function () {

    return redirect()->route('login');

});


Route::get('/login', [LoginController::class, 'showUserLogin'])
    ->name('login')
    ->middleware('guest');
Route::post('/login', [LoginController::class, 'userLogin'])
    ->middleware('guest');
Route::post('/logout', [LoginController::class, 'logout'])
    ->name('logout');
    Route::get('/register', [LoginController::class, 'showRegister'])
    ->name('register')
    ->middleware('guest');
    Route::post('/register', [LoginController::class, 'register'])
    ->middleware('guest');

/*
|--------------------------------------------------------------------------
| Protected Admin Routes (harus login)
|--------------------------------------------------------------------------
*/
Route::prefix('dashboard')->middleware(['web', 'auth'])->group(function () {
 
    // ── Halaman utama dashboard ────────────────────────────────
    // GET /dashboard
    Route::get('/', [AdminDashboardController::class, 'index'])
        ->name('dashboard');
 
    // ── CRUD dokumen via AJAX ──────────────────────────────────
 
    // POST   /dashboard/daftar-dokumen
    Route::post('/admin_dashboard', [AdminDashboardController::class, 'store'])->name('admin_dashboard.store');
Route::post('/admin_dashboard/{id}', [AdminDashboardController::class, 'update'])->name('admin_dashboard.update');
Route::delete('/admin_dashboard/{id}', [AdminDashboardController::class, 'destroy'])->name('admin_dashboard.destroy');
 
});

Route::middleware(['auth'])->group(function () {

    // Dashboard utama

    Route::get('/dashboard', [AdminDashboardController::class, 'index'])
        ->name('dashboard');

    // CRUD Admin Users

    Route::prefix('dashboard/admins')->name('admins.')->group(function () {

        Route::get('/',          [AdminUserController::class, 'index'])   ->name('index');

        Route::post('/',         [AdminUserController::class, 'store'])   ->name('store');

        Route::put('/{user}',    [AdminUserController::class, 'update'])  ->name('update');

        Route::delete('/{user}', [AdminUserController::class, 'destroy']) ->name('destroy');

    });

    // --- Bisnis Proses ---

    Route::prefix('dashboard/bisnis-proses')->name('bisnis-proses.')->group(function () {

        Route::get('/',                 [BisnisProsesController::class, 'index'])   ->name('index');

        Route::post('/',                [BisnisProsesController::class, 'store'])   ->name('store');

        Route::put('/{bisnisProses}',   [BisnisProsesController::class, 'update'])  ->name('update');

        Route::delete('/{bisnisProses}',[BisnisProsesController::class, 'destroy']) ->name('destroy');

    });
    // ── Tentang Dokumen Unit ──
Route::prefix('dashboard/dokumen-unit')->name('dokumen-unit.')->group(function () {
    Route::get('/',                    [DokumenUnitController::class, 'index'])   ->name('index');
    Route::post('/',                   [DokumenUnitController::class, 'store'])   ->name('store');
    Route::post('/{dokumenUnit}',      [DokumenUnitController::class, 'update'])  ->name('update');
    Route::delete('/{dokumenUnit}',    [DokumenUnitController::class, 'destroy']) ->name('destroy');
});
Route::prefix('dashboard')->middleware(['web', 'auth'])->group(function () {
 
    Route::get('/sasaran-mutu', [SasaranMutuController::class, 'index'])
        ->name('sasaran-mutu.index');
 
    Route::post('/sasaran-mutu', [SasaranMutuController::class, 'store'])
        ->name('sasaran-mutu.store');
 
    Route::post('/sasaran-mutu/{sasaran}', [SasaranMutuController::class, 'update'])
        ->name('sasaran-mutu.update');
 
    Route::delete('/sasaran-mutu/{sasaran}', [SasaranMutuController::class, 'destroy'])
        ->name('sasaran-mutu.destroy');
});
Route::prefix('dashboard')->middleware(['web', 'auth'])->group(function () {
 
 
    Route::get('/informasi-tambahan', [InformasiTambahanController::class, 'index'])
        ->name('informasi-tambahan.index');
 
    Route::post('/informasi-tambahan', [InformasiTambahanController::class, 'store'])
        ->name('informasi-tambahan.store');
 
    Route::post('/informasi-tambahan/{informasiTambahan}', [InformasiTambahanController::class, 'update'])
        ->name('informasi-tambahan.update');
    Route::delete('/informasi-tambahan/{informasiTambahan}', [InformasiTambahanController::class, 'destroy'])
        ->name('informasi-tambahan.destroy');
 
});
Route::prefix('dashboard')->middleware(['web', 'auth'])->group(function () {
 
    // INDEX  — GET    /dashboard/daftar-dokumen
    Route::get('/daftar-dokumen', [DaftarDokumenController::class, 'index'])
        ->name('daftar-dokumen.index');
 
    // STORE  — POST   /dashboard/daftar-dokumen
    Route::post('/daftar-dokumen', [DaftarDokumenController::class, 'store'])
        ->name('daftar-dokumen.store');
 
    // UPDATE — POST   /dashboard/daftar-dokumen/{daftarDokumen}
    // Menggunakan POST agar FormData multipart bekerja benar dari Alpine.js.
    Route::post('/daftar-dokumen/{daftarDokumen}', [DaftarDokumenController::class, 'update'])
        ->name('daftar-dokumen.update');
 
    // DESTROY — DELETE /dashboard/daftar-dokumen/{daftarDokumen}
    Route::delete('/daftar-dokumen/{daftarDokumen}', [DaftarDokumenController::class, 'destroy'])
        ->name('daftar-dokumen.destroy');
 
});
Route::prefix('dashboard')->middleware(['web', 'auth'])->group(function () {
 
    // INDEX  — GET    /dashboard/dokumen-spmi
    Route::get('/dokumen-spmi', [DokumenSpmiController::class, 'index'])
        ->name('dokumen-spmi.index');
 
    // STORE  — POST   /dashboard/dokumen-spmi
    Route::post('/dokumen-spmi', [DokumenSpmiController::class, 'store'])
        ->name('dokumen-spmi.store');
 
    // UPDATE — POST   /dashboard/dokumen-spmi/{dokumenSpmi}
    // Menggunakan POST agar FormData multipart bekerja benar dari Alpine.js.
    Route::post('/dokumen-spmi/{dokumenSpmi}', [DokumenSpmiController::class, 'update'])
        ->name('dokumen-spmi.update');
 
    // DESTROY — DELETE /dashboard/dokumen-spmi/{dokumenSpmi}
    Route::delete('/dokumen-spmi/{dokumenSpmi}', [DokumenSpmiController::class, 'destroy'])
        ->name('dokumen-spmi.destroy');
 
});
Route::prefix('dashboard')->middleware(['web', 'auth'])->group(function () {
 
    // INDEX  — GET    /dashboard
    Route::get('/', [AdminDashboardController::class, 'index'])
        ->name('dashboard');
 
    // STORE  — POST   /dashboard/dokumen
    Route::post('/dokumen', [AdminDashboardController::class, 'store'])
        ->name('dashboard.dokumen.store');
 
    // UPDATE — POST   /dashboard/dokumen/{adminDashboard}
    // POST (bukan PUT) agar FormData multipart bekerja benar dari Alpine.js.
    Route::post('/dokumen/{adminDashboard}', [AdminDashboardController::class, 'update'])
        ->name('dashboard.dokumen.update');
 
    // DESTROY — DELETE /dashboard/dokumen/{adminDashboard}
    Route::delete('/dokumen/{adminDashboard}', [AdminDashboardController::class, 'destroy'])
        ->name('dashboard.dokumen.destroy');
 
});
});