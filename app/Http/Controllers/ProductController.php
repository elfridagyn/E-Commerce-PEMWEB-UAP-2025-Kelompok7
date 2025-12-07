<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\User;

class ProductController extends Controller
{
    public function index()
    {
        return view('products.index', [
            'products' => \App\Models\Product::all()
        ]);

        return view('products.index', [
            'users' => User::all()
        ]);
    }

    // Seller: form tambah produk
    public function create()
    {
        $categories = ProductCategory::all();
        return view('seller.products.create', compact('categories'));
    }

    // Seller: simpan produk
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'product_category_id' => 'required|exists:product_categories,id',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'description' => 'nullable',
        ]);

        $data['store_id'] = auth()->user()->store->id;
        $data['slug'] = Str::slug($data['name']);
        $data['condition'] = 'new';
        $data['weight'] = 1;

        Product::create($data);

        return redirect()->route('home')->with('success', 'Produk berhasil ditambahkan');
    }

    // dst: edit, update, destroy
}
