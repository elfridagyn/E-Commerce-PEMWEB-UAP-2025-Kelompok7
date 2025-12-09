<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::where('buyer_id', auth()->id())
            ->with('details.product')
            ->latest()
            ->get();

        return view('member.transactions.index', compact('transactions'));
    }

    public function store(Request $request, Product $product)
{
    $request->validate([
        'qty' => 'required|integer|min:1',
        'address' => 'required',
        'city' => 'required',
        'postal_code' => 'required',
    ]);

    $qty = $request->qty;

    $subtotal = $product->price * $qty;
    $shipping_cost = 10000; // dummy
    $tax = 0;
    $grand_total = $subtotal + $shipping_cost + $tax;

    $transaction = \App\Models\Transaction::create([
        'code' => 'TRX-' . strtoupper(Str::random(8)),

        // sesuai database kamu
        'user_id' => auth()->id(),
        'buyer_id' => auth()->id(),
        'store_id' => $product->store_id,
        'product_id' => $product->id,

        'address' => $request->address,
        'city' => $request->city,
        'postal_code' => $request->postal_code,

        // sesuai tabel kamu
        'shipping_type' => 'jne',
        'shipping_cost' => $shipping_cost,

        'tax' => $tax,
        'grand_total' => $grand_total,

        // SESUAI DATABASE MU
        'payment_status' => 'unpaid',
    ]);

    // create detail transaksi
    TransactionDetail::create([
        'transaction_id' => $transaction->id,
        'product_id' => $product->id,
        'qty' => $qty,
        'subtotal' => $subtotal,
    ]);

    // kurangi stok
    $product->decrement('stock', $qty);

    return redirect()->route('member.transactions.index')
        ->with('success', 'Transaksi berhasil dibuat.');
}
}