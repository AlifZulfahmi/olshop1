<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        // Kategori utama
        $makanan = Category::create([
            'name' => 'Makanan',
            'description' => 'Kategori untuk semua jenis makanan',
        ]);

        $minuman = Category::create([
            'name' => 'Minuman',
            'description' => 'Kategori untuk semua jenis minuman',
        ]);

        $jajanan = Category::create([
            'name' => 'Jajanan',
            'description' => 'Kategori untuk semua jenis minuman',
        ]);

        // Subkategori untuk Makanan
        Category::create([
            'name' => 'Makanan Ringan',
            'description' => 'Subkategori untuk makanan ringan',
            'parent_id' => $makanan->id,
        ]);

        Category::create([
            'name' => 'Makanan Cepat Saji',
            'description' => 'Subkategori untuk makanan cepat saji',
            'parent_id' => $makanan->id,
        ]);

        // Subkategori untuk Minuman
        Category::create([
            'name' => 'Minuman Soda',
            'description' => 'Subkategori untuk minuman soda',
            'parent_id' => $minuman->id,
        ]);

        Category::create([
            'name' => 'Minuman Energi',
            'description' => 'Subkategori untuk minuman energi',
            'parent_id' => $minuman->id,
        ]);

        Category::create([
            'name' => 'Minuman Dingin',
            'description' => 'Subkategori untuk minuman dingin',
            'parent_id' => $minuman->id,
        ]);

        Category::create([
            'name' => 'Ciki - Ciki',
            'description' => 'Subkategori untuk ciki',
            'parent_id' => $jajanan->id,
        ]);
    }
}
