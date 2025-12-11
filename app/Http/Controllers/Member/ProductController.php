<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductReview;
use Illuminate\Http\Request;


class ProductController extends Controller
{
    public function show($slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();
        $categories = ProductCategory::all();

        $products = Product::latest()->take(8)->get(); // contoh ambil 8 produk terbaru

        return view('member.product-detail', compact('product', 'categories', 'products'));
    }
}
