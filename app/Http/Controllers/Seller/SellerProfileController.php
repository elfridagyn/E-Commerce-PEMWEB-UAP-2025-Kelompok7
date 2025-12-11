<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SellerProfileController extends Controller
{
    public function edit()
    {
        $store = Auth::user()->store;
        return view('seller.profile', compact('store'));
    }

    public function update(Request $request)
    {
        $store = Auth::user()->store;

        $request->validate([
            'name'        => 'required',
            'about'       => 'required',
            'phone'       => 'required',
            'city'        => 'required',
            'address'     => 'required',
            'postal_code' => 'required',
            'logo'        => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'bank_name' => 'required',
            'bank_account_number' => 'required',
            'bank_account_name' => 'required',
        ]);

        $data = $request->except('logo');

        if ($request->hasFile('logo')) {

            if ($store->logo) {
                Storage::delete($store->logo);
            }

            $data['logo'] = $request->file('logo')->store('store-logos');
        }

        $store->update($request->only([
            'name',
            'about',
            'phone',
            'city',
            'address',
            'postal_code',
            'bank_name',
            'bank_account_number',
            'bank_account_name'
        ]));


        return back()->with('success', 'Profil toko berhasil diperbarui');
    }

    public function destroy()
    {
        $store = Auth::user()->store;

        if ($store->logo) {
            Storage::delete($store->logo);
        }

        $store->delete();

        return redirect('/seller/dashboard')->with('success', 'Toko berhasil dihapus');
    }
    public function show()
{
    $store = auth()->user()->store;
    return view('seller.show', compact('store'));
}


};
