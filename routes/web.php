<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

// HOME
Route::get('/', function () {
    return redirect('/login');
});


// ================= USER =================

// FORM LOGIN USER
Route::get('/login', [LoginController::class, 'showUserLogin']);

// PROSES LOGIN USER
Route::post('/login', [LoginController::class, 'userLogin']);

// REGISTER
Route::get('/register', [RegisterController::class, 'showRegisterForm']);

Route::post('/register', [RegisterController::class, 'register']);

// DASHBOARD USER
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth');


// ================= ADMIN =================

// FORM LOGIN ADMIN
Route::get('/admin/login', [LoginController::class, 'showAdminLogin']);

// PROSES LOGIN ADMIN
Route::post('/admin/login', [LoginController::class, 'adminLogin']);

// DASHBOARD ADMIN
Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->middleware('auth');


// LOGOUT
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');