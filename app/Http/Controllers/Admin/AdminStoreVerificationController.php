<?php

namespace App\Http\Controllers;

use App\Models\Store;
use Illuminate\Http\Request;

class AdminStoreVerificationController extends Controller
{
    public function index()
    {
        $stores = Store::where('status', 'pending')->get();

        return view('admin.stores.index', compact('stores'));
    }

    public function approve(Store $store)
    {
        $store->update(['status' => 'approved']);
        return back()->with('success', 'Toko berhasil disetujui!');
    }

    public function reject(Store $store)
    {
        $store->update(['status' => 'rejected']);
        return back()->with('success', 'Toko berhasil ditolak!');
    }
}
