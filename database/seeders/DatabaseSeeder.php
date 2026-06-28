<?php

namespace Database\Seeders;

use App\Models\Dokumen;
use App\Models\ProsesBisnis;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Super Admin default - login: raguel@univ.edu / password
        User::firstOrCreate(
            ['email' => 'raguel@univ.edu'],
            [
                'name'     => 'Raguel Sianipar',
                'password' => Hash::make('password'),
                'role'     => 'Super Admin',
                'status'   => 'Aktif',
            ]
        );

        User::firstOrCreate(
            ['email' => 'admin.baru@univ.edu'],
            [
                'name'     => 'Admin Baru',
                'password' => Hash::make('password'),
                'role'     => 'Admin Fakultas',
                'status'   => 'Pending',
            ]
        );

        $categories = ['Panduan', 'SOP', 'Petunjuk Teknis', 'Peraturan Univ'];

        foreach ($categories as $i => $cat) {
            Dokumen::create([
                'title'          => "Contoh Dokumen {$cat}",
                'number'         => 'BPA/PND/2026/00' . ($i + 1),
                'category'       => $cat,
                'owner'          => 'Internal BPA',
                'effective_date' => now()->subMonths($i),
                'version'        => 'v1.0',
                'status'         => 'Aktif',
                'description'    => "Deskripsi singkat untuk dokumen kategori {$cat}.",
            ]);
        }

        ProsesBisnis::create([
            'title'       => 'Penerimaan Mahasiswa Baru',
            'description' => 'Alur proses penerimaan mahasiswa baru dari pendaftaran sampai pengumuman.',
        ]);
    }
}
