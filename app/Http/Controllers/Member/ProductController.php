<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Support\Facades\Schema;

class ProductController extends Controller
{
    public function show($slug)
{
    $product = Product::where('slug', $slug)->firstOrFail();

    // Ambil review + user
    $reviews = $product->productReviews()->with('user')->get();

    return view('member.product', compact('product', 'reviews'));
}
}
