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
            UserSeeder::class,
            KampusSeeder::class
        ]);
    }
}
