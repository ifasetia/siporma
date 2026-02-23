<?php

namespace Database\Seeders;

use App\Models\Supervisor;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SupervisorSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'sp_id' => Str::uuid(),
                'sp_nip' => '198501012010011001',
                'sp_nama' => 'Budi Santoso, S.Kom',
                'sp_jabatan' => 'Kepala Seksi Infrastruktur',
                'sp_divisi' => 'Teknologi Informasi',
                'sp_email' => 'budi.kominfo@example.com',
                'sp_telepon' => '081234567890'
            ],
            [
                'sp_id' => Str::uuid(),
                'sp_nip' => '199005122015032002',
                'sp_nama' => 'Siti Aminah, M.T',
                'sp_jabatan' => 'Analyst Statistik',
                'sp_divisi' => 'Statistik Sektoral',
                'sp_email' => 'siti.stats@example.com',
                'sp_telepon' => '089988776655'
            ],
        ];

        foreach ($data as $val) {
            Supervisor::create($val);
        }
    }
}
