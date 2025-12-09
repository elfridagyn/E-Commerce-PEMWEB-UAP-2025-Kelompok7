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
    $request->validate([
        'name' => 'required',
        'price' => 'required|numeric',
        'thumbnail' => 'image|mimes:jpeg,png,jpg|max:2048'
    ]);

    $thumbnailPath = null;

    if ($request->hasFile('thumbnail')) {
        $thumbnailPath = $request->file('thumbnail')->store('products', 'public');
    }

    Product::create([
        'name' => $request->name,
        'price' => $request->price,
        'thumbnail' => $thumbnailPath,
    ]);

    return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan!');
}

    // dst: edit, update, destroy
}
