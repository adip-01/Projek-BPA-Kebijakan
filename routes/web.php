<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\DashboardController;

// HOME
Route::get('/', function () {
    return redirect('/login');
});


// ================= USER =================

// FORM LOGIN USER (Wajib pakai name('login') untuk middleware auth)
Route::get('/login', [LoginController::class, 'showUserLogin'])->name('login');

// PROSES LOGIN USER
Route::post('/login', [LoginController::class, 'userLogin']);

// REGISTER
Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// DASHBOARD USER
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth')->name('dashboard');


// ================= ADMIN =================

// FORM LOGIN ADMIN
Route::get('/admin/login', [LoginController::class, 'showAdminLogin'])->name('admin.login');

// PROSES LOGIN ADMIN
Route::post('/admin/login', [LoginController::class, 'adminLogin']);

// DASHBOARD ADMIN
Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});


// LOGOUT
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');