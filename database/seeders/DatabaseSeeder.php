<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\AdminUserSeeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\StoreSeeder;
use Database\Seeders\ProductCategorySeeder; // Pastikan ini di-import
use Database\Seeders\ProductSeeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
    $this->call([
        AdminUserSeeder::class,
        UserSeeder::class,
        StoreSeeder::class,
        ProductCategorySeeder::class,
        ProductSeeder::class,
    ]);
    }
}
