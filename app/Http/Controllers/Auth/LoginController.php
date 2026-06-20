<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User; // Tambahkan ini untuk memanggil Model User saat register

class LoginController extends Controller
{
    // ─── FORM & PROSES REGISTER ──────────────────────────────────────

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // Validasi input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Simpan user baru ke database
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'admin', // Dibuat default 'admin' agar kamu bisa langsung masuk ke dashboard admin
        ]);

        // Login otomatis setelah register berhasil
        Auth::login($user);

        // Redirect ke dashboard
        return redirect()->route('dashboard');
    }


    // ─── FORM & PROSES LOGIN USER ────────────────────────────────────

    public function showUserLogin()
    {
        return view('auth.login');
    }

    public function userLogin(Request $request)
    {
        // Validasi input untuk keamanan
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
            'role' => 'user'
        ];

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            // Gunakan intended() agar jika user dipaksa login saat mau ke halaman tertentu, 
            // akan dikembalikan ke halaman tersebut setelah login.
            return redirect()->intended('/dashboard'); 
        }

        return back()->withErrors([
            'email' => 'Login user gagal. Silakan periksa kembali email dan password Anda.'
        ])->onlyInput('email'); // Tetap pertahankan isian email saat error
    }


    // ─── FORM & PROSES LOGIN ADMIN ───────────────────────────────────

    public function showAdminLogin()
    {
        return view('auth.admin-login');
    }

    public function adminLogin(Request $request)
    {
        // Validasi input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
            'role' => 'admin'
        ];

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            // Redirect ke nama route admin.dashboard
            return redirect()->route('dashboard')->with('success', 'Login Admin berhasil!'); 
        }

        return back()->withErrors([
            'email' => 'Login admin gagal. Pastikan email dan password benar.'
        ])->onlyInput('email');
    }


    // ─── LOGOUT ──────────────────────────────────────────────────────

    public function logout(Request $request)
    {
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}