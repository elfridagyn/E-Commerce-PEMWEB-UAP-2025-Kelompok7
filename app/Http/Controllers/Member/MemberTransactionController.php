<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Support\Str;

class MemberTransactionController extends Controller
{
    public function details()
{
    return $this->hasMany(TransactionDetail::class, 'transaction_id', 'id');
}
public function product()
{
    return $this->belongsTo(Product::class, 'product_id', 'id');
}

    // Menyimpan transaksi baru
    public function store(Request $request, Product $product)
    {
        $qty = $request->qty;

        // Hitung subtotal, ongkir, pajak, grand total
        $subtotal = $product->price * $qty;
        $shipping_cost = 10000; // dummy ongkir
        $tax = 0; // dummy pajak
        $grand_total = $subtotal + $shipping_cost + $tax;

        // Buat transaksi
        $transaction = Transaction::create([
            'code' => 'TRX-' . strtoupper(Str::random(8)),
            'user_id' => auth()->id(),
            'buyer_id' => auth()->id(),
            'store_id' => $product->store_id,
            'product_id' => $product->id,
            'address' => $request->address,
            'shipping_type' => 'jne',
            'shipping_cost' => $shipping_cost,
            'tax' => $tax,
            'grand_total' => $grand_total,
            'payment_status' => 'unpaid',
            'subtotal' => $subtotal,
        ]);

        // Buat detail transaksi
        TransactionDetail::create([
            'transaction_id' => $transaction->id,
            'product_id' => $product->id,
            'qty' => $qty,
            'subtotal' => $subtotal,
        ]);

        // Kurangi stock produk
        $product->decrement('stock', $qty);

        // Redirect ke halaman history
        return redirect()->route('member.member.history')
            ->with('success', 'Transaksi berhasil dibuat.');
    }

    // Menampilkan halaman history
    public function history()
{
    $transaction = Transaction::where('user_id', auth()->id())
        ->with('details.product') // pastikan relasi details dan product ada
        ->orderBy('created_at', 'desc')
        ->first(); // Hanya ambil 1 transaksi terakhir

    return view('member.history', compact('transaction'));
}
}
