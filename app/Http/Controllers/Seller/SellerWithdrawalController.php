<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Withdrawal; 
use App\Models\StoreBalance; // Asumsi: Digunakan untuk mendapatkan ID relasi
use Illuminate\Pagination\LengthAwarePaginator; // Digunakan untuk menangani pagination kosong

class SellerWithdrawalController extends Controller
{
    /**
     * Tampilkan riwayat penarikan dana (withdrawals) seller.
     * Route name: seller.withdrawals.index
     */
    public function index(Request $request)
    {
        $seller = auth()->user()->seller;
        $storeBalanceId = null;
        $withdrawals = null;
        
        if ($seller) {
            // Cek dan ambil StoreBalance
            $storeBalance = $seller->storeBalance;
            $storeBalanceId = $storeBalance->id ?? null; 
            
            if ($storeBalanceId) {
                // Query riwayat penarikan (Paginator)
                $withdrawals = Withdrawal::where('store_balance_id', $storeBalanceId)
                                         ->latest()
                                         ->paginate(15); 
            }
        }

        // ⭐ SOLUSI ERROR BADMETHODCALLEXCEPTION: links() ⭐
        // Jika $withdrawals masih null (karena seller atau storeBalance tidak ada),
        // inisialisasi dengan Paginator kosong agar $withdrawals->links() tidak error di view.
        if (is_null($withdrawals)) {
            $withdrawals = new LengthAwarePaginator(
                [], // items
                0,  // total
                15, // per page
                $request->input('page', 1) // current page
            );
        }
        
        return view('seller.withdrawals.index', compact('withdrawals'));
    }

    /**
     * Tampilkan formulir pengajuan penarikan dana.
     * Route name: seller.withdrawals.create
     */
    public function create()
    {
        // $balance adalah objek Seller (yang berisi properti 'balance')
        $balance = auth()->user()->seller ?? null; 
        
        return view('seller.withdrawals.create', compact('balance'));
    }

    /**
     * Proses pengajuan penarikan dana dan kurangi saldo.
     * Route name: seller.withdrawals.store
     */
    public function store(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'amount' => 'required|numeric|min:10000',
            'bank_name' => 'required|string',
            'account_number' => 'required|string',
            'account_holder' => 'required|string',
        ]);
        
        $seller = auth()->user()->seller;

        // ⭐ Pengecekan Eksistensi Seller dan StoreBalance (Pencegahan Error Null) ⭐
        if (!$seller) {
            return back()->with('error', 'Akun Seller Anda tidak ditemukan. Pastikan Anda sudah terdaftar sebagai Seller.');
        }

        // Ambil StoreBalance untuk mendapatkan relasi withdrawals()
        $storeBalance = $seller->storeBalance;
        
        if (!$storeBalance) {
            return back()->with('error', 'Data Saldo Toko tidak ditemukan. Silakan hubungi Administrator.');
        }

        $currentBalance = $seller->balance ?? 0;
        
        // 2. Cek Saldo Mencukupi
        if ($request->amount > $currentBalance) {
            return back()->withInput()->with('error', 'Saldo tidak mencukupi untuk penarikan ini. Saldo tersedia: Rp ' . number_format($currentBalance, 0, ',', '.'));
        }

        DB::beginTransaction();
        try {
            
            // 3. Mencatat Withdrawal (Melalui relasi StoreBalance)
            $withdrawal = $storeBalance->withdrawals()->create([
                'amount' => $request->amount,
                'bank_name' => $request->bank_name,
                'bank_account_number' => $request->account_number,
                'bank_account_name' => $request->account_holder, 
                'status' => 'pending', 
            ]);

            // 4. Pengurangan Saldo KUMULATIF di tabel sellers
            $seller->balance -= $request->amount;
            $seller->save();
            
            DB::commit();

            return redirect()->route('seller.withdrawals.index')
                             ->with('success', 'Permintaan penarikan dana sebesar Rp ' . number_format($request->amount, 0, ',', '.') . ' berhasil diajukan dan sedang diproses.');

        } catch (\Exception $e) {
            DB::rollBack();
            // Logging error untuk debugging
            \Log::error("Withdrawal Error: " . $e->getMessage() . " on line " . $e->getLine());
            return back()->withInput()->with('error', 'Terjadi kesalahan sistem saat memproses permintaan penarikan. Silakan coba lagi.');
        }
    }
}