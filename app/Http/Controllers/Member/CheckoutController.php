<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ShippingType; // <<< Sudah benar

class CheckoutController extends Controller
{
    public function start(Product $product)
    {
        // Mendapatkan semua tipe pengiriman yang tersedia
        $shippingTypes = ShippingType::all(); 

        return view('member.checkout', [
            'product' => $product,
            'shippingTypes' => $shippingTypes
        ]);
    }
}