<?php

namespace Database\Seeders;

use App\Models\ProductCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductCategorySeeder extends Seeder
{
    public function run(): void
    {
        // contoh untuk store dengan id = 1
        $storeId = 1;

        $names = ['Elektronik', 'Fashion', 'Makanan', 'Minuman', 'Aksesoris'];

        foreach ($names as $name) {
            ProductCategory::create([
                'store_id'    => $storeId,
                'name'        => $name,
                'slug'        => Str::slug($name),
                'tagline'     => 'Kategori ' . $name,
                'description' => 'Deskripsi singkat untuk kategori ' . $name,
                'image'       => null, // belum ada gambar
            ]);
        }
    }
}
