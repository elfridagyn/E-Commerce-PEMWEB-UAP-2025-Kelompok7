<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StoreBalance;
use Illuminate\Support\Facades\Auth;

class SellerBalanceController extends Controller
{
    public function index()
    {
        $store = Auth::user()->store;
        if (!$store) {
            return redirect()->route('seller.dashboard')->with('error', 'Anda belum memiliki toko.');
        }

        // Ambil saldo toko
        $balance = StoreBalance::firstOrCreate(
            ['store_id' => $store->id],
            ['balance' => 0]
        );

        // Ambil riwayat saldo (terbaru dulu)
        $histories = $balance->storeBalanceHistories()->orderBy('created_at', 'desc')->get();

        return view('seller.balance.index', compact('balance', 'histories'));
    }
}
