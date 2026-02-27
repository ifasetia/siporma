<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

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
                'pr_kampus' => 'UIN Imam Bonjol Padang',
                'pr_jurusan' => 'Sistem Informasi',
                'pr_internship_start' => '2025-01-01',
                'pr_internship_end' => '2025-06-01',
                'pr_supervisor_name' => 'Supervisor ' . ($index + 1),
                'pr_supervisor_contact' => '0822334455' . $index,

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
