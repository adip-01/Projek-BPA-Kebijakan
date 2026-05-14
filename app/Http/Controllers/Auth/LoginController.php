<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // FORM LOGIN USER
    public function showUserLogin()
    {
        return view('auth.login');
    }

    // LOGIN USER
    public function userLogin(Request $request)
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
            'role' => 'user'
        ];

        if (Auth::attempt($credentials)) {

            $request->session()->regenerate();

            return redirect('/dashboard');
        }

        return back()->withErrors([
            'email' => 'Login user gagal'
        ]);
    }

    // FORM LOGIN ADMIN
    public function showAdminLogin()
    {
        return view('auth.admin-login');
    }

    // LOGIN ADMIN
    public function adminLogin(Request $request)
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
            'role' => 'admin'
        ];

        if (Auth::attempt($credentials)) {

            $request->session()->regenerate();

            return redirect('/admin/dashboard');
        }

        return back()->withErrors([
            'email' => 'Login admin gagal'
        ]);
    }

    // LOGOUT
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
}