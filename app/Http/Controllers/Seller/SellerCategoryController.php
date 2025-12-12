<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str; // Import Str untuk membuat slug

class SellerCategoryController extends Controller
{
    /**
     * Menampilkan daftar kategori untuk toko seller yang sedang login.
     */
    public function index()
    {
        // Ambil semua kategori yang store_id-nya sama dengan store ID milik user yang login
        $categories = ProductCategory::where('store_id', Auth::user()->store->id)->get();
        return view('seller.categories.index', compact('categories'));
    }

    /**
     * Menampilkan form untuk membuat kategori baru.
     */
    public function create()
    {
        
        return view('seller.categories.create');
    }

    /**
     * Menyimpan kategori baru ke database.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'tagline'     => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image'       => 'nullable|string', 
            'parent_id'   => 'nullable|exists:product_categories,id', 
        ]);

        $store = Auth::user()->store;
        
        if (!$store) {
             return back()->with('error', 'Anda belum memiliki toko yang terdaftar.');
        }

        // --- Perbaikan Mulai di Sini ---

        // 1. Tambahkan nilai default (null) untuk field yang bersifat nullable 
        //    tetapi mungkin tidak dikirim dari form (misalnya: tagline, description, image, parent_id).
        $data = array_merge([
            'tagline'     => null,
            'description' => null,
            'image'       => null,
            'parent_id'   => null,
        ], $validated);


        // 2. Buat slug unik
        $slug = Str::slug($data['name']); // Gunakan data['name'] dari array yang sudah digabungkan
        
        $originalSlug = $slug;
        $count = 1;
        while (ProductCategory::where('store_id', $store->id)->where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }
        
        // 3. Simpan kategori
        $category = ProductCategory::create([
            'store_id'    => $store->id, 
            'name'        => $data['name'],
            'slug'        => $slug,
            'tagline'     => $data['tagline'],     // Pasti ada, minimal null
            'description' => $data['description'], // Pasti ada, minimal null
            // 'image'       => $data['image'],
        ]);

        // --- Perbaikan Selesai ---

        return redirect()->route('seller.categories.index')->with('success', 'Kategori **' . $category->name . '** berhasil dibuat!');
    }

    /**
     * Menampilkan form untuk mengedit kategori.
     * Menggunakan Route Model Binding untuk mengambil Category.
     */
    public function edit(ProductCategory $category)
    {
        // Pengecekan: Pastikan kategori ini milik toko user yang login
        if ($category->store_id !== Auth::user()->store->id) {
            abort(403, 'Akses ditolak. Kategori bukan milik toko Anda.');
        }

        $parentCategories = ProductCategory::where('store_id', Auth::user()->store->id)
        ->where('id', '!=', $category->id) // agar kategori sendiri tidak jadi parent
        ->get();
    
        return view('seller.categories.edit', compact('category', 'parentCategories'));
    }

    /**
     * Memperbarui kategori di database.
     */
    public function update(Request $request, ProductCategory $category)
    {
        // Pengecekan: Pastikan kategori ini milik toko user yang login
        if ($category->store_id !== Auth::user()->store->id) {
            abort(403, 'Akses ditolak. Kategori bukan milik toko Anda.');
        }
        
        // PENTING: Jika Anda mengimplementasikan file upload, validasi 'image' perlu disesuaikan
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'tagline'     => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image'       => 'nullable|string',
            'parent_id'   => 'nullable|exists:product_categories,id',
        ]);
        
        $dataToUpdate = $validated;
        
        // 1. Tangani perubahan slug jika nama berubah
        if ($category->name !== $validated['name']) {
            $slug = Str::slug($validated['name']);
            $originalSlug = $slug;
            $count = 1;
            while (ProductCategory::where('store_id', Auth::user()->store->id)
                                 ->where('slug', $slug)
                                 ->where('id', '!=', $category->id) // Abaikan kategori saat ini
                                 ->exists()) {
                $slug = $originalSlug . '-' . $count++;
            }
            $dataToUpdate['slug'] = $slug;
        }

        $category->update($dataToUpdate);

        return redirect()->route('seller.categories.index')->with('success', 'Kategori **' . $category->name . '** berhasil diperbarui!');
    }

    /**
     * Menghapus kategori dari database.
     */
    public function destroy(ProductCategory $category)
    {
        // Pengecekan: Pastikan kategori ini milik toko user yang login
        if ($category->store_id !== Auth::user()->store->id) {
            abort(403, 'Akses ditolak. Kategori bukan milik toko Anda.');
        }
        
        // PENTING: Tambahkan logika untuk menangani produk yang terasosiasi 
        // (misalnya: ubah product->category_id menjadi null, atau hapus produk)
        // Saat ini, diasumsikan relasi database menangani ini (misalnya: cascade on delete).
        // Jika tidak, Anda bisa menambahkan:
        // $category->products()->update(['product_category_id' => null]);
        
        $category->delete();

        return redirect()->route('seller.categories.index')->with('success', 'Kategori **' . $category->name . '** berhasil dihapus!');
    }
}