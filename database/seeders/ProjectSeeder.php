<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProjectSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Ambil data Master Status Proyek
        $statusMenunggu = DB::table('master_status_proyek')->where('sp_nama_status', 'Menunggu Validasi')->first();
        $statusRevisi = DB::table('master_status_proyek')->where('sp_nama_status', 'Revisi')->first();
        $statusDivalidasi = DB::table('master_status_proyek')->where('sp_nama_status', 'Divalidasi (Public)')->first();

        // Jika master status belum ada, hentikan proses (mencegah error)
        if (!$statusMenunggu) {
            $this->command->error('Tabel master_status_proyek masih kosong! Jalankan StatusProyekSeeder dulu.');
            return;
        }

        // 2. Cari akun dengan role 'intern'
        $intern = DB::table('users')->where('role', 'intern')->first();

        // Jika belum ada akun intern, kita buatkan 1 akun dummy otomatis!
        if (!$intern) {
            $internId = (string) Str::uuid();
            DB::table('users')->insert([
                'id' => $internId,
                'name' => 'Intern Dummy',
                'email' => 'intern@app.test',
                'password' => bcrypt('password'),
                'role' => 'intern',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            $intern = DB::table('users')->where('id', $internId)->first();
            $this->command->info('Akun Intern dummy berhasil dibuat otomatis.');
        }

        // 3. Masukkan Data Dummy Proyek
        $projects = [
            [
                'id' => (string) Str::uuid(),
                'title' => 'Sistem Informasi Absensi Mahasiswa Magang',
                'description' => 'Aplikasi berbasis web untuk mencatat absensi mahasiswa magang secara realtime dengan fitur geolokasi di lingkungan Diskominfotik.',
                'technologies' => 'Laravel, MySQL, Bootstrap', // Ini nanti bisa kita perbaiki jadi relasi ke tabel teknologi
                'document' => 'proposal_absensi.pdf',
                'links' => json_encode(['github' => 'https://github.com/intern/absensi', 'demo' => 'https://absensi.app.test']),
                'created_by' => $intern->id,
                'status_id' => $statusMenunggu->sp_id,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => (string) Str::uuid(),
                'title' => 'Dashboard Analitik Laporan Warga',
                'description' => 'Dashboard interaktif untuk memonitoring aduan masyarakat dan status penyelesaian jaringan di daerah secara visual.',
                'technologies' => 'React, Tailwind CSS, Firebase',
                'document' => 'dokumen_dashboard.pdf',
                'links' => json_encode(['github' => 'https://github.com/intern/dashboard']),
                'created_by' => $intern->id,
                'status_id' => $statusDivalidasi->sp_id,
                'created_at' => now()->subDays(2),
                'updated_at' => now()->subDays(1),
            ],
            [
                'id' => (string) Str::uuid(),
                'title' => 'Aplikasi e-Surat Internal Kominfo',
                'description' => 'Sistem digitalisasi surat menyurat antar bidang di Dinas Kominfo untuk mengurangi penggunaan kertas.',
                'technologies' => 'CodeIgniter, PostgreSQL, jQuery',
                'document' => null,
                'links' => json_encode(['github' => 'https://github.com/intern/esurat']),
                'created_by' => $intern->id,
                'status_id' => $statusRevisi->sp_id,
                'created_at' => now()->subDays(5),
                'updated_at' => now()->subDays(2),
            ],
        ];

        DB::table('projects')->insert($projects);

        $this->command->info('3 Data Proyek dummy berhasil ditambahkan!');
    }
}
