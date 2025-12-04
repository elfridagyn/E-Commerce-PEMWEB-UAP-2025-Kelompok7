<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 1 admin
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // 2 member (buyer)
        User::create([
            'name' => 'Member 1',
            'email' => 'member1@example.com',
            'password' => Hash::make('password'),
            'role' => 'member',
        ]);

        User::create([
            'name' => 'Member 2',
            'email' => 'member2@example.com',
            'password' => Hash::make('password'),
            'role' => 'member',
        ]);

        // 1 seller
        User::create([
            'name' => 'Seller 1',
            'email' => 'seller1@example.com',
            'password' => Hash::make('password'),
            'role' => 'seller',
        ]);
    }
}