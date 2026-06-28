<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DokumenController;
use App\Http\Controllers\ProsesBisnisController;
use Illuminate\Support\Facades\Route;

// ── Redirect root ke dashboard ────────────────────────────────────────────────
Route::get('/', fn () => redirect()->route('dashboard'));

// ── Auth routes (guest only) ──────────────────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/login',    [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login',   [AuthController::class, 'login']);

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register',[AuthController::class, 'register']);

    Route::get('/forgot-password',  [AuthController::class, 'showForgotPassword'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->name('password.email');
});

// ── Logout ────────────────────────────────────────────────────────────────────
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// ── Protected routes (harus login + status Aktif) ─────────────────────────────
Route::middleware(['auth', 'user.active'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Dokumen
    Route::resource('dokumen', DokumenController::class)->except(['show']);
    Route::get('/dokumen/{dokumen}/download', [DokumenController::class, 'download'])->name('dokumen.download');

    // Proses Bisnis (pakai modal di index)
    Route::resource('proses-bisnis', ProsesBisnisController::class)->except(['show', 'create', 'edit']);

    // Admin (aksi CRUD hanya Super Admin, lihat index boleh semua yang aktif)
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');

    Route::middleware('super.admin')->group(function () {
        Route::post('/admin',                  [AdminController::class, 'store'])->name('admin.store');
        Route::put('/admin/{admin}',           [AdminController::class, 'update'])->name('admin.update');
        Route::patch('/admin/{admin}/approve', [AdminController::class, 'approve'])->name('admin.approve');
        Route::delete('/admin/{admin}',        [AdminController::class, 'destroy'])->name('admin.destroy');
    });
});
