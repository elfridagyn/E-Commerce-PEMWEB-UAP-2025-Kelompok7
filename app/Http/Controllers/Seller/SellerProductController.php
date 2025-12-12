<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\Auth;

class SellerProductController extends Controller
{
    // Tampilkan semua produk milik seller (melalui store)
    public function index()
    {
        $store = Auth::user()->store; // ambil store milik seller
        if (!$store) {
            return redirect()->route('seller.dashboard')->with('error', 'Anda belum memiliki toko.');
        }

        $products = Product::where('store_id', $store->id)->with('category')->get();
        return view('seller.products.index', compact('products'));
    }

    // Form create produk
    public function create()
    {
        $store = Auth::user()->store;
        if (!$store) {
            return redirect()->route('seller.dashboard')->with('error', 'Anda belum memiliki toko.');
        }

        $categories = ProductCategory::all();
        return view('seller.products.create', compact('categories'));
    }

    // Simpan produk baru
    public function store(Request $request)
    {
        $store = Auth::user()->store;
        if (!$store) {
            return redirect()->route('seller.dashboard')->with('error', 'Anda belum memiliki toko.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:product_categories,id',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048'
        ]);

        $product = new Product();
        $product->name = $request->name;
        $product->category_id = $request->category_id;
        $product->price = $request->price;
        $product->stock = $request->stock;
        $product->description = $request->description;
        $product->store_id = $store->id; // gunakan store_id bukan seller_id

         if ($request->hasFile('image')) {
        $path = $request->file('image')->store('products', 'public');
        $product->image = $path; // simpan ke kolom "image"
    }

        $product->save();

        return redirect()->route('seller.products.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    // Form edit produk
    public function edit(Product $product)
    {
        $store = Auth::user()->store;
        if (!$store || $product->store_id != $store->id) {
            abort(403);
        }

        $categories = ProductCategory::all();
        return view('seller.products.edit', compact('product', 'categories'));
    }

    // Update produk
    public function update(Request $request, Product $product)
    {
        $store = Auth::user()->store;
        if (!$store || $product->store_id != $store->id) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:product_categories,id',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048'
        ]);

        $product->name = $request->name;
        $product->product_category_id = $request->category_id;
        $product->price = $request->price;
        $product->stock = $request->stock;
        $product->description = $request->description;
        
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $path = $file->store('products', 'public');
            $product->image = $path;
        }

        $product->save();

        return redirect()->route('seller.products.index')->with('success', 'Produk berhasil diperbarui.');
    }

    // Hapus produk
    public function destroy(Product $product)
    {
        $store = Auth::user()->store;
        if (!$store || $product->store_id != $store->id) {
            abort(403);
        }

        $product->delete();
        return redirect()->route('seller.products.index')->with('success', 'Produk berhasil dihapus.');
    }
}
