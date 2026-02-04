<?php

namespace Database\Seeders;

use App\Models\User;
use App\RoleEnum;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@app.test',
            'password' => Hash::make('password'),
            'role' => RoleEnum::SUPER_ADMIN,
        ]);

        User::create([
            'name' => 'Admin',
            'email' => 'admin@app.test',
            'password' => Hash::make('password'),
            'role' => RoleEnum::ADMIN,
        ]);

        User::create([
            'name' => 'Intern',
            'email' => 'intern@app.test',
            'password' => Hash::make('password'),
            'role' => RoleEnum::INTERN,
        ]);

        User::create([
            'name' => 'Public User',
            'email' => 'public@app.test',
            'password' => Hash::make('password'),
            'role' => RoleEnum::PUBLIC,
        ]);
    }
}
