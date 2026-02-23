<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Master\Teknologi;
use Illuminate\Support\Str;

class TeknologiSeeder extends Seeder
{
    public function run()
    {
        $teknologiList = [
            // Bahasa Pemrograman
            ['tk_nama' => 'PHP', 'tk_kategori' => 'Bahasa Pemrograman'],
            ['tk_nama' => 'JavaScript', 'tk_kategori' => 'Bahasa Pemrograman'],
            ['tk_nama' => 'Python', 'tk_kategori' => 'Bahasa Pemrograman'],
            ['tk_nama' => 'Java', 'tk_kategori' => 'Bahasa Pemrograman'],

            // Framework (Backend & Frontend)
            ['tk_nama' => 'Laravel', 'tk_kategori' => 'Framework'],
            ['tk_nama' => 'React', 'tk_kategori' => 'Framework'],
            ['tk_nama' => 'Vue.js', 'tk_kategori' => 'Framework'],
            ['tk_nama' => 'Tailwind CSS', 'tk_kategori' => 'Framework'],
            ['tk_nama' => 'Bootstrap', 'tk_kategori' => 'Framework'],

            // Database
            ['tk_nama' => 'PostgreSQL', 'tk_kategori' => 'Database'],
            ['tk_nama' => 'MySQL', 'tk_kategori' => 'Database'],
            ['tk_nama' => 'MongoDB', 'tk_kategori' => 'Database'],

            // Template Engine & Lainnya
            ['tk_nama' => 'Blade', 'tk_kategori' => 'Template Engine'],
            ['tk_nama' => 'Git', 'tk_kategori' => 'Version Control'],
            ['tk_nama' => 'Docker', 'tk_kategori' => 'DevOps/Tools'],
        ];

        foreach ($teknologiList as $item) {
            Teknologi::create([
                'tk_id' => Str::uuid(),
                'tk_nama' => $item['tk_nama'],
                'tk_kategori' => $item['tk_kategori'],
            ]);
        }
    }
}
