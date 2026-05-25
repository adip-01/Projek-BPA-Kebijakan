<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Display a listing of all admins (paginated)
     */
    public function index()
    {
        $admins = User::where('role', 'admin')
            ->paginate(5);
        
        $totalAdmins = User::where('role', 'admin')->count();

        return view('admin.admins_index', compact('admins', 'totalAdmins'));
    }

    /**
     * Store a newly created admin in storage
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin'
        ], [
            'name.required' => 'Nama admin wajib diisi',
            'name.string' => 'Nama admin harus berupa teks',
            'name.max' => 'Nama admin maksimal 255 karakter',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 8 karakter',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
            'role.required' => 'Role wajib dipilih',
            'role.in' => 'Role tidak valid'
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role']
        ]);

        return redirect()->route('admin.admins.index')
            ->with('success', 'Admin baru berhasil ditambahkan');
    }

    /**
     * Update the specified admin in storage
     */
    public function update(Request $request, User $admin)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $admin->id,
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|in:admin'
        ], [
            'name.required' => 'Nama admin wajib diisi',
            'name.string' => 'Nama admin harus berupa teks',
            'name.max' => 'Nama admin maksimal 255 karakter',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'password.min' => 'Password minimal 8 karakter',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
            'role.required' => 'Role wajib dipilih',
            'role.in' => 'Role tidak valid'
        ]);

        $admin->name = $validated['name'];
        $admin->email = $validated['email'];
        $admin->role = $validated['role'];

        if ($validated['password']) {
            $admin->password = Hash::make($validated['password']);
        }

        $admin->save();

        return redirect()->route('admin.admins.index')
            ->with('success', 'Data admin berhasil diperbarui');
    }

    /**
     * Remove the specified admin from storage
     */
    public function destroy(User $admin)
    {
        $admin->delete();

        return redirect()->route('admin.admins.index')
            ->with('success', 'Admin berhasil dihapus');
    }
}
