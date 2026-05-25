<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Tampilkan dashboard admin
     */
    public function index()
    {
        // Data statistik (bisa dari database atau hardcoded untuk sekarang)
        $statistics = [
            'total_dokumen' => 24,
            'dokumen_magang' => 8,
            'dokumen_iisma' => 5,
            'dokumen_simka' => 11
        ];

        // Data dokumen contoh
        $documents = [
            [
                'id' => 1,
                'name' => 'Dokumen',
                'file_size' => '2.4 MB',
                'type' => 'Magang',
                'date_uploaded' => '20 Jul 2026'
            ],
            [
                'id' => 2,
                'name' => 'Dokumen',
                'file_size' => '1.8 MB',
                'type' => 'IISMA',
                'date_uploaded' => '17 Apr 2024'
            ],
            [
                'id' => 3,
                'name' => 'Dokumen',
                'file_size' => '1 MB',
                'type' => 'SIMKA',
                'date_uploaded' => '1 Apr 2000'
            ],
            [
                'id' => 4,
                'name' => 'Dokumen',
                'file_size' => '2 MB',
                'type' => 'SIMKA',
                'date_uploaded' => '23 Mei 2003'
            ]
        ];

        return view('admin.dashboard', compact('statistics', 'documents'));
    }

    /**
     * Handle pencarian dokumen
     */
    public function search(Request $request)
    {
        $search = $request->input('search');
        // Logic pencarian akan diimplementasi nanti
        return back();
    }

    /**
     * Handle filter dokumen
     */
    public function filter(Request $request)
    {
        $filter = $request->input('filter');
        // Logic filter akan diimplementasi nanti
        return back();
    }
}