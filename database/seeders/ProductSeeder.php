<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Store;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $store = Store::first();
        $categories = ProductCategory::all();

        for ($i = 1; $i <= 10; $i++) {
            $cat = $categories->random();

            Product::create([
                'store_id' => $store->id,
                'product_category_id' => $cat->id,
                'name' => 'Produk ' . $i,
                'slug' => 'produk-' . $i,
                'description' => 'Deskripsi produk ' . $i,
                'condition' => 'new',
                'price' => 10000 + $i * 1000,
                'weight' => 1,
                'stock' => 10 + $i,
            ]);
        }
    }
}
