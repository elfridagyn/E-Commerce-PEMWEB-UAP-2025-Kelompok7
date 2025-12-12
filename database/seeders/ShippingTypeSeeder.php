<?php

namespace Database\Seeders; // Pastikan namespace-nya benar

use App\Models\ShippingType;
use Illuminate\Database\Seeder;

class ShippingTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ShippingType::insert([
            [
                'name' => 'Reguler',
                'estimate' => '2 - 4 hari',
                'cost' => 9000,
            ],
            [
                'name' => 'Kargo',
                'estimate' => '3 - 7 hari',
                'cost' => 15000,
            ],
            [
                'name' => 'Instant',
                'estimate' => '1 hari',
                'cost' => 20000,
            ],
        ]);
    }
}
// Pastikan tidak ada blok 'class ShippingTypeSeeder' lain di bawah ini!