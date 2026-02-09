<?php

namespace Database\Seeders;

use App\Models\Master\Pekerjaan;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PekerjaanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'pk_kode_tipe_pekerjaan' => 'PK001',
                'pk_nama_pekerjaan' => 'Frontend Developer',
                'pk_deskripsi_pekerjaan' => 'Membuat tampilan website menggunakan React / Blade',
                'pk_level_pekerjaan' => 'medium',
                'pk_estimasi_durasi_hari' => 7,
                'pk_minimal_skill' => 'HTML, CSS, JavaScript',
            ],
            [
                'pk_kode_tipe_pekerjaan' => 'PK002',
                'pk_nama_pekerjaan' => 'Backend Developer',
                'pk_deskripsi_pekerjaan' => 'Membuat API dan logic backend menggunakan Laravel',
                'pk_level_pekerjaan' => 'hard',
                'pk_estimasi_durasi_hari' => 10,
                'pk_minimal_skill' => 'PHP, Laravel, MySQL',
            ],
            [
                'pk_kode_tipe_pekerjaan' => 'PK003',
                'pk_nama_pekerjaan' => 'Data Entry',
                'pk_deskripsi_pekerjaan' => 'Input data ke sistem sesuai SOP',
                'pk_level_pekerjaan' => 'easy',
                'pk_estimasi_durasi_hari' => 3,
                'pk_minimal_skill' => 'Microsoft Excel',
            ],
            [
                'pk_kode_tipe_pekerjaan' => 'PK004',
                'pk_nama_pekerjaan' => 'UI Designer',
                'pk_deskripsi_pekerjaan' => 'Membuat desain UI menggunakan Figma',
                'pk_level_pekerjaan' => 'medium',
                'pk_estimasi_durasi_hari' => 5,
                'pk_minimal_skill' => 'Figma, UI UX',
            ],
        ];

        foreach ($data as $item) {
            Pekerjaan::create($item);
        }
    }
}
