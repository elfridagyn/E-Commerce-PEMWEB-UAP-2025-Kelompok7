<?php

namespace Database\Seeders;

use App\Models\Store;
use App\Models\User;
use Illuminate\Database\Seeder;

class StoreSeeder extends Seeder
{
    public function run(): void
    {
        $seller = User::where('role', 'seller')->first();

        Store::create([
            'user_id' => $seller->id,
            'name' => 'Toko Seller 1',
            'phone' => '08123456789',
            'city' => 'Malang',
            'address' => 'Jl. Contoh No. 1',
            'postal_code' => '65100',
            'about' => 'Toko ini menjual berbagai produk berkualitas.',
            'is_verified' => 1,
        ]);
    }
}
