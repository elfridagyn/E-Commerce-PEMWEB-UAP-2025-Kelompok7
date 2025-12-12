<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\StoreBalance;
use App\Models\StoreBalanceHistory;
use Illuminate\Support\Str;

class StoreBalanceSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil semua store
        $stores = \App\Models\Store::all();

        foreach ($stores as $store) {
            // Buat saldo awal
            $balance = StoreBalance::create([
                'store_id' => $store->id,
                'balance' => rand(500000, 5000000), // saldo awal random
            ]);

            // Buat beberapa riwayat saldo (contoh 5 history)
            for ($i = 1; $i <= 5; $i++) {
                StoreBalanceHistory::create([
                    'store_balance_id' => $balance->id,
                    'type' => ['income', 'withdraw'][rand(0,1)], // income atau withdraw
                    'reference_id' => Str::uuid(),
                    'reference_type' => 'SeederExample',
                    'amount' => rand(50000, 500000),
                    'remarks' => 'Riwayat seeder #' . $i,
                ]);
            }
        }
    }
}
