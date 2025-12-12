<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\ShippingType;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\Log;

class MemberTransactionController extends Controller
{
    /**
     * Menyimpan transaksi baru.
     */
    public function store(Request $request, Product $product)
    {
        // 1. Validasi Data Masukan
        $validatedData = $request->validate([
            'qty' => 'required|integer|min:1|max:' . $product->stock,
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'shipping_type_id' => 'required|exists:shipping_types,id',
            'payment_method' => 'required|in:wallet,va',
        ]);

        DB::beginTransaction();

        try {
            // 2. Ambil Data Pendukung
            $qty = $validatedData['qty'];
            // Menggunakan findOrFail untuk memastikan shipping type ada
            $shippingType = ShippingType::findOrFail($validatedData['shipping_type_id']);

            // 3. Perhitungan
            $subtotal = $product->price * $qty;
            $shipping_cost = $shippingType->cost;
            $tax = 0; // Asumsi Tax 0 untuk saat ini
            $grand_total = $subtotal + $shipping_cost + $tax;

            // 4. Buat Transaksi UTAMA (Tabel 'transactions')
            $transaction = Transaction::create([
                'code' => 'TRX-' . strtoupper(Str::random(8)),
                'buyer_id' => auth()->id(), 
                'store_id' => $product->store_id, 
                'address' => $validatedData['address'],
                'phone' => $validatedData['phone'], 
                'shipping_type_id' => $validatedData['shipping_type_id'], 
                'shipping_type' => $shippingType->name,
                'shipping_cost' => $shipping_cost,
                'tax' => $tax,
                'grand_total' => $grand_total,
                'payment_method' => $validatedData['payment_method'],
                'payment_status' => 'unpaid',
                'subtotal' => $subtotal, 
                'status' => 'pending',
            ]);

            // 5. Buat Detail Transaksi (Tabel 'transaction_details')
            TransactionDetail::create([
                'transaction_id' => $transaction->id,
                'product_id' => $product->id,
                'qty' => $qty,
                'subtotal' => $subtotal,
                'store_id' => $product->store_id, 
            ]);

            // 6. Kurangi Stok Produk
            $product->decrement('stock', $qty);

            // 🔥🔥 DI SINI KAMU TARUH KODE WALLET!
    if ($validatedData['payment_method'] === 'wallet') {
        $user = auth()->user();

        if ($user->balance < $grand_total) {
            throw new \Exception("Saldo tidak mencukupi.");
        }

        $user->decrement('balance', $grand_total);

        $transaction->update([
            'payment_status' => 'paid'
        ]);
    }
            // 7. Commit Transaksi DB
            DB::commit();

            // 8. Redirect
            return redirect()->route('member.history')->with('success', 'Checkout berhasil!');

        } catch (\Exception $e) {
            DB::rollBack();
            
            Log::error("Transaction failed: " . $e->getMessage(), ['user_id' => auth()->id(), 'product_id' => $product->id]);

            return redirect()->back()
                ->with('error', 'Gagal membuat pesanan. Silakan coba lagi. Error: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Menampilkan halaman riwayat transaksi (Member/Buyer).
     */
    public function history()
    {
        $transactions = Transaction::where('buyer_id', auth()->id()) 
            ->with(['transactionDetails.product', 'shippingType']) 
            ->orderBy('created_at', 'desc')
            ->get(); 

        return view('member.history', compact('transactions'));
    }
}