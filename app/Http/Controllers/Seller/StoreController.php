<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StoreController extends Controller
{
    public function create()
    {
        return view('seller.store.register');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'logo' => 'nullable|image',
            'about' => 'required'
        ]);

        $logoPath = null;
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('store_logos', 'public');
        }

        Store::create([
            'user_id' => Auth::id(),
            'name'    => $request->name,
            'logo'    => $logoPath,
            'about'   => $request->about,
            'status'  => 'pending'   // default menunggu persetujuan admin
        ]);

        return redirect('/seller/profile')->with('success', 'Toko berhasil didaftarkan! Menunggu persetujuan admin.');
    }
}
