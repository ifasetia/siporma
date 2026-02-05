<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Master\Kampus;

class KampusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Kampus::create([
            'km_nama_kampus' => 'Universitas Contoh Indonesia',
            'km_kode_kampus' => 'UCI01',
            'km_email'       => 'info@uci.ac.id',
            'km_alamat'      => 'Jl. Pendidikan No. 123, Jakarta',
            'km_telepon'     => '081234567890',
            'km_foto'        => 'kampus/default.jpg', // dummy foto
        ]);

        Kampus::create([
            'km_nama_kampus' => 'Institut Teknologi Nusantara',
            'km_kode_kampus' => 'ITN02',
            'km_email'       => 'admin@itn.ac.id',
            'km_alamat'      => 'Jl. Teknologi No. 45, Bandung',
            'km_telepon'     => '082345678901',
            'km_foto'        => 'kampus/default.jpg',
        ]);
    }
}
