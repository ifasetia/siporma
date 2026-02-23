<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Master\Jurusan;

class JurusanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run(): void
    {
        Jurusan::create([
            'js_nama' => 'Sistem Informasi',
            'js_kode' => 'SI',
        ]);

        Jurusan::create([
            'js_nama' => 'Teknik informatika',
            'js_kode' => 'ITN02',
        ]);
    }
}
