<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class SellerCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $store = Auth::user()->store;

        $categories = ProductCategory::where('store_id', $store->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('seller.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $store = Auth::user()->store;

        // hanya parent untuk dropdown
        $parents = ProductCategory::where('store_id', $store->id)->get();

        return view('seller.categories.create', compact('parents'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $store = Auth::user()->store;

        $request->validate([
            'name' => 'required|string|max:255',
            'tagline' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'parent_id' => 'nullable|exists:product_categories,id',
            'image' => 'nullable|image|max:2048'
        ]);

        $data = $request->all();
        $data['store_id'] = $store->id;
        $data['slug'] = Str::slug($request->name);

        // Upload image
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('category-images', 'public');
        }

        ProductCategory::create($data);

        return redirect()->route('seller.categories.index')
            ->with('success', 'Kategori berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProductCategory $category)
    {
        $store = Auth::user()->store;

        // pastikan kategori milik toko yang login
        abort_if($category->store_id != $store->id, 403);

        $parents = ProductCategory::where('store_id', $store->id)
            ->where('id', '!=', $category->id)
            ->get();

        return view('seller.categories.edit', compact('category', 'parents'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductCategory $category)
    {
        $store = Auth::user()->store;

        abort_if($category->store_id != $store->id, 403);

        $request->validate([
            'name' => 'required|string|max:255',
            'tagline' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'parent_id' => 'nullable|exists:product_categories,id',
            'image' => 'nullable|image|max:2048'
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->name);

        // Upload baru jika ada
        if ($request->hasFile('image')) {
            // optionally delete old image

            $data['image'] = $request->file('image')->store('category-images', 'public');
        }

        $category->update($data);

        return redirect()->route('seller.categories.index')
            ->with('success', 'Kategori berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductCategory $category)
    {
        $store = Auth::user()->store;

        abort_if($category->store_id != $store->id, 403);

        $category->delete();

        return redirect()->route('seller.categories.index')
            ->with('success', 'Kategori berhasil dihapus.');
    }
}
