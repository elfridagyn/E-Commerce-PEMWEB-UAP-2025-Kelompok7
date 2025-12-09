<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\User;

class ProductController extends Controller
{
    // ===========================
    // ADMIN: hanya boleh melihat
    // ===========================
    public function index()
    {
        return view('admin.produk.index', [
            'products' => Product::all(),
            'users' => User::all()
        ]);
    }

    // ===========================
    // SELLER: form tambah produk
    // ===========================
    public function create()
    {
        if (auth()->user()->role !== 'seller') {
            abort(403, 'Anda tidak memiliki akses');
        }

        $categories = ProductCategory::all();
        return view('seller.products.create', compact('categories'));
    }

    // ===========================
    // SELLER: simpan produk baru
    // ===========================
    public function store(Request $request)
    {
        if (auth()->user()->role !== 'seller') {
            abort(403, 'Anda tidak memiliki akses');
        }

        $data = $request->validate([
            'name' => 'required',
            'product_category_id' => 'required|exists:product_categories,id',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'description' => 'nullable',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $thumbnailPath = null;

        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('products', 'public');
        }

        $data['thumbnail'] = $thumbnailPath;
        $data['store_id'] = auth()->user()->store->id;

        Product::create($data);

        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    // ===========================
    // SELLER: edit produk
    // ===========================
    public function edit($id)
    {
        if (auth()->user()->role !== 'seller') {
            abort(403, 'Anda tidak memiliki akses');
        }

        $product = Product::findOrFail($id);

        if ($product->store_id != auth()->user()->store->id) {
            abort(403, 'Anda tidak memiliki izin untuk mengedit produk ini');
        }

        return view('seller.products.edit', compact('product'));
    }

    // ===========================
    // SELLER: update produk
    // ===========================
    public function update(Request $request, $id)
    {
        if (auth()->user()->role !== 'seller') {
            abort(403, 'Anda tidak memiliki akses');
        }

        $product = Product::findOrFail($id);

        if ($product->store_id != auth()->user()->store->id) {
            abort(403, 'Anda tidak memiliki izin untuk mengedit produk ini');
        }

        $request->validate([
            'name' => 'required',
            'product_category_id' => 'required|exists:product_categories,id',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
        ]);

        $product->update([
            'name' => $request->name,
            'product_category_id' => $request->product_category_id,
            'price' => $request->price,
            'stock' => $request->stock,
        ]);

        return redirect()->route('home')->with('success', 'Produk berhasil diperbarui');
    }

    // ===========================
    // SELLER: delete produk
    // ===========================
    public function destroy($id)
    {
        if (auth()->user()->role !== 'seller') {
            abort(403, 'Anda tidak memiliki akses');
        }

        $product = Product::findOrFail($id);

        if ($product->store_id != auth()->user()->store->id) {
            abort(403, 'Anda tidak memiliki izin untuk menghapus produk ini');
        }

        $product->delete();

        return back()->with('success', 'Produk berhasil dihapus');
    }
}