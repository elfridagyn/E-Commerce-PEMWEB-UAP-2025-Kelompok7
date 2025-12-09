<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Product;

class CheckoutController extends Controller
{
    public function start(Product $product)
    {
        return view('member.checkout', compact('product'));
    }
}
