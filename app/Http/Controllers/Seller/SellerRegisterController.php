<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Store;

class SellerRegisterController extends Controller
{
    public function index()
    {
        return view('seller.store.register', [
            'user' => Auth::user()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'store_name' => 'required|string|max:255',
            'description' => 'required|string',
            'logo' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        $filename = null;

        if ($request->hasFile('logo')) {
            $filename = time() . '.' . $request->logo->extension();
            $request->logo->storeAs('public/store_logo', $filename);
        }

        Store::create([
            'user_id' => Auth::id(),
            'name' => $request->store_name,
            'about' => $request->description,
            'logo' => $filename,
            'is_verified' => false, // admin harus verifikasi dulu
        ]);

        return redirect()
            ->route('member.dashboard')
            ->with('success', 'Pendaftaran toko berhasil! Tunggu verifikasi admin.');
    }
}
