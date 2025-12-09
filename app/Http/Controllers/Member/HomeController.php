<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductCategory;

class HomeController extends Controller
{
    public function index()
    {
        $categories = ProductCategory::all();
        $products   = Product::latest()->get();

        return view('member.home', compact('categories', 'products'));
    }
}
