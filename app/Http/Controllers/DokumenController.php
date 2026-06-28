<?php

namespace App\Http\Controllers;

use App\Models\Dokumen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DokumenController extends Controller
{
    protected array $categories = [
        'Panduan', 'Pedoman', 'Buletin', 'RPS', 'Petunjuk Teknis',
        'Peraturan Univ', 'Template', 'SOP', 'Kebijakan',
    ];

    public function index(Request $request)
    {
        $documents = Dokumen::query()
            ->when($request->search, fn ($q, $v) => $q->where('title', 'like', "%{$v}%"))
            ->when($request->category, fn ($q, $v) => $q->where('category', $v))
            ->when($request->owner, fn ($q, $v) => $q->where('owner', $v))
            ->when($request->status, fn ($q, $v) => $q->where('status', $v))
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('dokumen.index', compact('documents'));
    }

    public function create()
    {
        return view('dokumen.create', ['categories' => $this->categories]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'          => 'required|string|max:255',
            'number'         => 'nullable|string|max:255',
            'category'       => 'required|string',
            'owner'          => 'required|string',
            'effective_date' => 'nullable|date',
            'version'        => 'nullable|string|max:50',
            'status'         => 'nullable|in:Aktif,Tidak Aktif',
            'description'    => 'nullable|string',
            'klausul'        => 'nullable|string',
            'link'           => 'nullable|url',
            'document_file'  => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx|max:20480',
        ]);

        if ($request->hasFile('document_file')) {
            $data['file_path'] = $request->file('document_file')->store('dokumen', 'public');
        }

        Dokumen::create($data);

        return redirect()->route('dokumen.index')->with('success', 'Dokumen berhasil ditambahkan.');
    }

    public function edit(Dokumen $dokumen)
    {
        return view('dokumen.edit', ['dokumen' => $dokumen, 'categories' => $this->categories]);
    }

    public function update(Request $request, Dokumen $dokumen)
    {
        $data = $request->validate([
            'title'          => 'required|string|max:255',
            'number'         => 'nullable|string|max:255',
            'category'       => 'required|string',
            'owner'          => 'required|string',
            'effective_date' => 'nullable|date',
            'version'        => 'nullable|string|max:50',
            'status'         => 'nullable|in:Aktif,Tidak Aktif',
            'description'    => 'nullable|string',
            'klausul'        => 'nullable|string',
            'link'           => 'nullable|url',
            'document_file'  => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx,ppt,pptx|max:20480',
        ]);

        if ($request->hasFile('document_file')) {
            if ($dokumen->file_path) {
                Storage::disk('public')->delete($dokumen->file_path);
            }
            $data['file_path'] = $request->file('document_file')->store('dokumen', 'public');
        }

        $dokumen->update($data);

        return redirect()->route('dokumen.index')->with('success', 'Dokumen berhasil diperbarui.');
    }

    public function destroy(Dokumen $dokumen)
    {
        if ($dokumen->file_path) {
            Storage::disk('public')->delete($dokumen->file_path);
        }
        $dokumen->delete();

        return back()->with('success', 'Dokumen berhasil dihapus.');
    }

    public function download(Dokumen $dokumen)
    {
        abort_unless($dokumen->file_path, 404);

        return Storage::disk('public')->download($dokumen->file_path);
    }
}
