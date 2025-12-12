<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductCategory;

class HomeController extends Controller
{
    public function index(Request $request)
{
    $categories = ProductCategory::all();

    $products = Product::query();

    // filter kategori berdasarkan ID
    if ($request->category) {
        $products->where('product_category_id', $request->category);
    }

    // search
    if ($request->q) {
        $products->where('name', 'like', '%' . $request->q . '%');
    }

    return view('member.home', [
        'products' => $products->get(),
        'categories' => $categories
    ]);
}

}