<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\LoginController; 

use App\Http\Controllers\AdminDashboardController;

use App\Http\Controllers\AdminUserController;

use App\Http\Controllers\BisnisProsesController;

use App\Http\Controllers\DokumenUnitController;

use App\Http\Controllers\SasaranMutuController;


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

/*
|--------------------------------------------------------------------------
| Protected Admin Routes (harus login)
|--------------------------------------------------------------------------
*/

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
});