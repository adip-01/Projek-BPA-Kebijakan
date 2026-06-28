<?php

namespace App\Http\Controllers;

use App\Models\ProsesBisnis;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProsesBisnisController extends Controller
{
    public function index()
    {
        $processes = ProsesBisnis::latest()->get();

        return view('proses-bisnis.index', compact('processes'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|max:5120',
        ]);

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('proses-bisnis', 'public');
        }

        ProsesBisnis::create($data);

        return redirect()->route('proses-bisnis.index')->with('success', 'Proses bisnis berhasil ditambahkan.');
    }

    // NOTE: nama parameter $proses_bisnis WAJIB sama dengan nama parameter route
    // ({proses_bisnis}) yang dibuat otomatis oleh Route::resource('proses-bisnis', ...)
    // agar implicit route-model-binding jalan.
    public function update(Request $request, ProsesBisnis $proses_bisnis)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|max:5120',
        ]);

        if ($request->hasFile('image')) {
            if ($proses_bisnis->image_path) {
                Storage::disk('public')->delete($proses_bisnis->image_path);
            }
            $data['image_path'] = $request->file('image')->store('proses-bisnis', 'public');
        }

        $proses_bisnis->update($data);

        return redirect()->route('proses-bisnis.index')->with('success', 'Proses bisnis berhasil diperbarui.');
    }

    public function destroy(ProsesBisnis $proses_bisnis)
    {
        if ($proses_bisnis->image_path) {
            Storage::disk('public')->delete($proses_bisnis->image_path);
        }
        $proses_bisnis->delete();

        return back()->with('success', 'Proses bisnis berhasil dihapus.');
    }
}
