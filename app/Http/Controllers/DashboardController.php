<?php

namespace App\Http\Controllers;

use App\Models\Dokumen;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $totalActive     = Dokumen::where('status', 'Aktif')->count();
        $totalCategories = Dokumen::distinct()->count('category');
        $pendingAdmins   = User::where('status', 'Pending')->count();

        // category => jumlah dokumen, dipakai untuk card kategori & bar chart
        $statsPerCategory = Dokumen::selectRaw('category, count(*) as total')
            ->groupBy('category')
            ->pluck('total', 'category')
            ->toArray();

        $categoryCounts = $statsPerCategory;

        $recentDocuments = Dokumen::latest()->take(5)->get();

        $totalAll    = Dokumen::count();
        $healthScore = $totalAll > 0 ? (int) round(($totalActive / $totalAll) * 100) : 0;

        return view('dashboard', compact(
            'totalActive',
            'totalCategories',
            'pendingAdmins',
            'categoryCounts',
            'recentDocuments',
            'statsPerCategory',
            'healthScore'
        ));
    }
}
