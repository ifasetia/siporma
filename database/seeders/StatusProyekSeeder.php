<?php

namespace Database\Seeders;

use App\Models\Master\StatusProyek;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StatusProyekSeeder extends Seeder
{
    public function run(): void
    {
        // Kosongkan tabel dulu supaya data yang lama (Perencanaan, Pengembangan, dll) hilang
        DB::table('master_status_proyek')->truncate();

        $statuses = [
            [
                'sp_nama_status' => 'Menunggu Validasi',
                'sp_warna'       => 'bg-yellow-100 text-yellow-700 border-yellow-200',
                'sp_keterangan'  => 'Proyek baru diunggah oleh Intern dan menunggu pengecekan Admin.'
            ],
            [
                'sp_nama_status' => 'Revisi',
                'sp_warna'       => 'bg-red-100 text-red-700 border-red-200',
                'sp_keterangan'  => 'Proyek dikembalikan ke Intern untuk diperbaiki.'
            ],
            [
                'sp_nama_status' => 'Divalidasi (Public)',
                'sp_warna'       => 'bg-green-100 text-green-700 border-green-200',
                'sp_keterangan'  => 'Proyek disetujui Admin dan sudah bisa dilihat oleh publik.'
            ],
        ];

        foreach ($statuses as $status) {
            StatusProyek::create($status);
        }
    }
}


