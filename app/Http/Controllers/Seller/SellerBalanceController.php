<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StoreBalance;

class SellerBalanceController extends Controller
{
    public function index()
    {
        // Ambil store milik seller yang login
        $store = auth()->user()->store;

        // Ambil saldo store
        $balance = $store->storeBalance;

        // Ambil riwayat saldo (urut terbaru dulu)
        $history = $balance ? $balance->storeBalanceHistories()->latest()->get() : collect();

        return view('seller.balance.index', compact('balance', 'history'));
    }
}
