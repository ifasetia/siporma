<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Master\Kampus;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    /**
     * Seed the application's database.
     */
   public function run(): void
    {
    $this->call([

        // MASTER DATA (tidak tergantung apa-apa)
        KampusSeeder::class,
        JurusanSeeder::class,
        PekerjaanSeeder::class,
        StatusProyekSeeder::class,
        TeknologiSeeder::class,

        // USER BASE
        UserSeeder::class,

        // PROFILE butuh user + kampus + jurusan
        ProfileSeeder::class,

        // Supervisor mungkin butuh user
        SupervisorSeeder::class,

        // Project butuh status + supervisor + teknologi
        ProjectSeeder::class,
    ]);
    }
}
