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
        $shipping = 10000;        // dummy
        $tax = 0;
        $grandTotal = $subtotal + $shipping + $tax;

        $trx = Transaction::create([
            'code' => 'TRX-' . strtoupper(Str::random(6)),
            'buyer_id' => auth()->id(),
            'store_id' => $product->store_id,
            'address' => $request->address,
            'city' => $request->city,
            'postal_code' => $request->postal_code,
            'shipping_type' => 'jne',
            'shipping_cost' => $shipping,
            'tax' => $tax,
            'grand_total' => $grandTotal,
            'payment_status' => 'unpaid',
        ]);

        TransactionDetail::create([
            'transaction_id' => $trx->id,
            'product_id' => $product->id,
            'qty' => $qty,
            'subtotal' => $subtotal,
        ]);

        // kalau mau, kurangi stok
        $product->decrement('stock', $qty);

        // tombol “Bayar” nanti cukup ubah payment_status jadi 'paid'
        return redirect()->route('transactions.index')->with('success', 'Transaksi dibuat, silakan lakukan pembayaran.');
    }
}
