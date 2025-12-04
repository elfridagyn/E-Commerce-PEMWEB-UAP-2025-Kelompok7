<?php

namespace Database\Seeders;

use App\Models\ProductCategory;
use Illuminate\Database\Seeder;

class ProductCategorySeeder extends Seeder
{
    public function run(): void
    {
        $names = ['Elektronik', 'Fashion', 'Makanan', 'Minuman', 'Aksesoris'];

        foreach ($names as $name) {
            ProductCategory::create([
                'name' => $name,
                'slug' => str()->slug($name),
                'tagline' => 'Kategori ' . $name,
            ]);
        }
    }
}
