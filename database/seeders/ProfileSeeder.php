<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\Master\Kampus;
use App\Models\Master\Jurusan;
use App\Models\Supervisor;


class ProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil beberapa user dari tabel users
        $users = DB::table('users')->limit(3)->get();

        foreach ($users as $index => $user) {

            // Variabel beda tiap user
            $pr_id = Str::uuid();
            $user_id = $user->id;
            $kampus = Kampus::first();
            $jurusan = Jurusan::first(); // sesuaikan nama model
            $supervisor = Supervisor::first();

            DB::table('profiles')->insert([
                'pr_id' => $pr_id,
                'user_id' => $user_id,

                // =====================
                // UMUM
                // =====================
                'pr_nama' => 'User Profile ' . ($index + 1),
                'pr_no_hp' => '0812345678' . $index,
                'pr_alamat' => 'Alamat contoh ke-' . ($index + 1),
                'pr_photo' => 'profiles/default' . ($index + 1) . '.jpg',
                'pr_jenis_kelamin' => $index % 2 == 0 ? 'Perempuan' : 'Laki-laki',
                'pr_tanggal_lahir' => '2002-01-0' . ($index + 1),
                'pr_status' => 'Aktif',

                // =====================
                // KHUSUS INTERN
                // =====================
                'pr_nim' => '23170201' . str_pad($index + 1, 2, '0', STR_PAD_LEFT),
                'pr_km_id' => $kampus?->km_id,
                'pr_js_id' => $jurusan?->js_id,
                'pr_internship_start' => '2025-01-01',
                'pr_internship_end' => '2025-06-01',
                'pr_sp_id' => $supervisor?->sp_id,

                // =====================
                // KHUSUS ADMIN + SUPER ADMIN
                // =====================
                'pr_posisi' => $index == 0 ? 'Admin' : null,

                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
