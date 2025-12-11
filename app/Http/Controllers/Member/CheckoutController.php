<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Product;

class CheckoutController extends Controller
{
    public function start(Product $product)
{
    $shippingTypes = \App\Models\ShippingType::all(); // ← Tambahkan ini

    return view('member.checkout', [
        'product' => $product,
        'shippingTypes' => $shippingTypes
    ]);
}
}