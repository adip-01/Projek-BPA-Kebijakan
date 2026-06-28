<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $admins = User::query()
            ->when($request->search, fn ($q, $v) => $q->where(
                fn ($q2) => $q2->where('name', 'like', "%{$v}%")
                                ->orWhere('email', 'like', "%{$v}%")
            ))
            ->when($request->status, fn ($q, $v) => $q->where('status', $v))
            ->latest()
            ->get();

        return view('admin.index', compact('admins'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'   => 'required|string|max:255',
            'email'  => 'required|email|unique:users,email',
            'role'   => 'required|string',
            'status' => 'nullable|in:Aktif,Pending',
        ]);

        // Belum ada field password di modal "Tambah Admin", jadi di-generate random.
        // Idealnya: kirim email undangan supaya admin set password sendiri.
        $data['password'] = Hash::make(Str::random(16));

        User::create($data);

        return redirect()->route('admin.index')->with('success', 'Admin berhasil ditambahkan.');
    }

    public function update(Request $request, User $admin)
    {
        $data = $request->validate([
            'name'   => 'required|string|max:255',
            'email'  => 'required|email|unique:users,email,' . $admin->id,
            'role'   => 'required|string',
            'status' => 'nullable|in:Aktif,Pending',
        ]);

        $admin->update($data);

        return redirect()->route('admin.index')->with('success', 'Admin berhasil diperbarui.');
    }

    public function approve(User $admin)
    {
        $admin->update(['status' => 'Aktif']);

        return back()->with('success', 'Admin berhasil disetujui.');
    }

    public function destroy(User $admin)
    {
        $admin->delete();

        return back()->with('success', 'Admin berhasil dihapus.');
    }
}
