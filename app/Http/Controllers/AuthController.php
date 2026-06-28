<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // ── Tampilkan form login ──────────────────────────────────────────────
    public function showLogin()
    {
        return view('auth.login');
    }

    // ── Proses login ──────────────────────────────────────────────────────
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Cek apakah user ada dan statusnya Aktif
        $user = User::where('email', $request->email)->first();

        if (! $user) {
            return back()->withErrors(['email' => 'Email tidak terdaftar.'])->withInput();
        }

        if ($user->status !== 'Aktif') {
            return back()->withErrors([
                'email' => 'Akun Anda masih menunggu persetujuan Administrator.',
            ])->withInput();
        }

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()->withErrors(['email' => 'Password salah.'])->withInput();
        }

        $request->session()->regenerate();

        return redirect()->intended(route('dashboard'));
    }

    // ── Tampilkan form register ───────────────────────────────────────────
    public function showRegister()
    {
        return view('auth.register');
    }

    // ── Proses register ───────────────────────────────────────────────────
    public function register(Request $request)
    {
        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'name.required'      => 'Nama lengkap wajib diisi.',
            'email.required'     => 'Email wajib diisi.',
            'email.unique'       => 'Email sudah terdaftar.',
            'password.min'       => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => 'Admin',
            'status'   => 'Pending',
        ]);

        return redirect()->route('login')->with('success',
            'Pendaftaran berhasil! Akun Anda sedang menunggu persetujuan Administrator.'
        );
    }

    // ── Tampilkan form lupa password ──────────────────────────────────────
    public function showForgotPassword()
    {
        return view('auth.forgot-password');
    }

    // ── Proses lupa password ──────────────────────────────────────────────
    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        // Pada produksi: gunakan Password::sendResetLink($request->only('email'))
        // Untuk sekarang, tampilkan pesan sukses saja.
        return back()->with('success',
            'Jika email Anda terdaftar, link reset password akan segera dikirim.'
        );
    }

    // ── Logout ────────────────────────────────────────────────────────────
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
