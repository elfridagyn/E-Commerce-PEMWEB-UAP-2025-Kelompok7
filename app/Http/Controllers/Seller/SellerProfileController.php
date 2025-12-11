<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SellerProfileController extends Controller
{
    /**
     * HALAMAN PROFIL TOKO (VIEW ONLY)
     */
    public function show()
    {
        $store = Auth::user()->store;
        return view('seller.profile.show', compact('store'));
    }

    /**
     * HALAMAN EDIT PROFIL TOKO (FORM)
     */
    public function edit()
    {
        $store = Auth::user()->store;
        return view('seller.profile.edit', compact('store'));
    }

    /**
     * UPDATE PROFIL TOKO
     */
    public function update(Request $request)
    {
        $store = Auth::user()->store;

        // Validasi input
        $request->validate([
            'name'                  => 'required',
            'about'                 => 'required',
            'phone'                 => 'required',
            'city'                  => 'required',
            'address'               => 'required',
            'postal_code'           => 'required',
            'logo'                  => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'bank_name'             => 'required',
            'bank_account_number'   => 'required',
            'bank_account_name'     => 'required',
        ]);

        // Ambil data kecuali logo
        $data = $request->except('logo');

        // Jika upload logo baru
        if ($request->hasFile('logo')) {

            // Hapus logo lama jika ada
            if ($store->logo && Storage::exists($store->logo)) {
                Storage::delete($store->logo);
            }

            // Upload logo baru
            $data['logo'] = $request->file('logo')->store('store-logos', 'public');
        }

        // Update store dengan data yang sudah fix
        $store->update($data);

        // Redirect ke halaman profil
        return redirect()->route('seller.profile.show')
            ->with('success', 'Profil toko berhasil diperbarui!');
    }

    /**
     * HAPUS TOKO
     */
    public function destroy()
    {
        $store = Auth::user()->store;

        if ($store->logo && Storage::disk('public')->exists($store->logo)) {
            Storage::disk('public')->delete($store->logo);
        }


        $store->delete();

        return redirect('/seller/dashboard')
            ->with('success', 'Toko berhasil dihapus');
    }
}
