<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Seller\SellerProductController;
use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SellerProductCategoryController extends Controller
{
    // Tampilkan semua kategori milik toko seller
    public function index()
    {
        $store = Auth::user()->store;
        $categories = ProductCategory::where('store_id', $store->id)->get();
        return view('seller.product_categories.index', compact('categories'));
    }

    // Form tambah kategori baru
    public function create()
    {
        return view('seller.product_categories.create');
    }

    // Simpan kategori baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $store = Auth::user()->store;

        ProductCategory::create([
            'store_id' => $store->id,
            'name' => $request->name,
        ]);

        return redirect()->route('seller.product_categories.index')
                         ->with('success', 'Kategori berhasil dibuat!');
    }

    // Form edit kategori
    public function edit(ProductCategory $category)
    {
        // Pastikan kategori milik seller yang login
        if ($category->store_id !== Auth::user()->store->id) {
            abort(403, 'Unauthorized action.');
        }

        return view('seller.product_categories.edit', compact('category'));
    }

    // Update kategori
    public function update(Request $request, ProductCategory $category)
    {
        if ($category->store_id !== Auth::user()->store->id) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $category->update(['name' => $request->name]);

        return redirect()->route('seller.product_categories.index')
                         ->with('success', 'Kategori berhasil diperbarui!');
    }

    // Hapus kategori
    public function destroy(ProductCategory $category)
    {
        if ($category->store_id !== Auth::user()->store->id) {
            abort(403, 'Unauthorized action.');
        }

        $category->delete();

        return redirect()->route('seller.product_categories.index')
                         ->with('success', 'Kategori berhasil dihapus!');
    }
}
