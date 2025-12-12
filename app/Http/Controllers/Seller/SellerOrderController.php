<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class SellerOrderController extends Controller
{
    // Tampilkan semua pesanan masuk untuk seller
    public function index()
    {
        $store = Auth::user()->store;

        if (!$store) {
            return redirect()->route('seller.dashboard')->with('error', 'Anda belum memiliki toko.');
        }

        // Ambil transaksi yang punya produk milik store seller
        $orders = Transaction::whereHas('transactionDetails.product', function($query) use ($store) {
            $query->where('store_id', $store->id);
        })->with(['transactionDetails.product', 'buyer'])->get();

        return view('seller.orders.index', compact('orders'));
    }

    // Update status & tracking_number
    public function update(Request $request, Transaction $transaction)
    {
        $store = Auth::user()->store;

        // Pastikan transaksi punya produk milik seller
        $hasProduct = $transaction->transactionDetails->contains(function($detail) use ($store) {
            return $detail->product->store_id == $store->id;
        });

        if (!$hasProduct) {
            abort(403);
        }

        $request->validate([
            'status' => 'required|string',
            'tracking_number' => 'nullable|string|max:255',
        ]);

        $transaction->status = $request->status;
        $transaction->tracking_number = $request->tracking_number;
        $transaction->save();

        return redirect()->route('seller.orders.index')->with('success', 'Pesanan berhasil diperbarui.');
    }
}
