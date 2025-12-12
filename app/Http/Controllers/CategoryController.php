<?php

namespace App\Http\Controllers;

use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str; // Tambahkan untuk helper Str::slug

class CategoryController extends Controller
{
    /**
     * READ: Menampilkan semua kategori dan halaman index utama.
     */
    public function index()
    {
        // Mengambil semua kategori dari database
        $categories = ProductCategory::all();

        return view('admin.kategori.index', [
            'categories' => $categories
        ]);
    }

    /**
     * READ: Menampilkan form untuk menambah kategori baru.
     */
    public function create()
    {
        return view('admin.kategori.create');
    }

    /**
     * CREATE: Menyimpan kategori baru ke database.
     */
    public function store(Request $request)
    {
        // 1. Validasi input
        $validatedData = $request->validate([
            'category_name' => 'required|max:100|unique:product_categories,category_name',
        ], [
            'category_name.required' => 'Nama kategori wajib diisi.',
            'category_name.unique' => 'Nama kategori ini sudah ada.',
        ]);

        // 2. Membuat slug
        $validatedData['slug'] = Str::slug($validatedData['category_name']);
        
        // 3. Simpan ke database
        ProductCategory::create($validatedData);

        // 4. Redirect dengan pesan sukses
        return redirect('/admin/categories')->with('success', 'Kategori baru berhasil ditambahkan!');
    }

    /**
     * READ: Menampilkan form untuk mengedit kategori tertentu.
     */
    public function edit(ProductCategory $category)
    {
        // $category sudah otomatis ditemukan oleh Laravel (Route Model Binding)
        return view('admin.kategori.edit', [
            'category' => $category
        ]);
    }

    /**
     * UPDATE: Memperbarui data kategori di database.
     */
    public function update(Request $request, ProductCategory $category)
    {
        // 1. Validasi input (kecuali namanya sama dengan yang lama)
        $rules = [
            'category_name' => 'required|max:100',
        ];

        // Jika nama kategori berubah, tambahkan aturan unique
        if ($request->category_name !== $category->category_name) {
             $rules['category_name'] = 'required|max:100|unique:product_categories,category_name';
        }
        
        $validatedData = $request->validate($rules, [
            'category_name.unique' => 'Nama kategori ini sudah ada.'
        ]);
        
        // 2. Perbarui slug dan data
        $validatedData['slug'] = Str::slug($validatedData['category_name']);

        // 3. Update database
        $category->update($validatedData);

        // 4. Redirect dengan pesan sukses
        return redirect('/admin/categories')->with('success', 'Kategori berhasil diperbarui!');
    }

    /**
     * DELETE: Menghapus kategori dari database.
     */
    public function destroy(ProductCategory $category)
    {
        // Guardrail: Cek apakah kategori ini masih digunakan oleh produk.
        // Anda perlu menambahkan relasi di model ProductCategory dan Product
        /* if ($category->products()->count()) {
            return redirect('/admin/categories')->with('error', 'Gagal: Kategori ini masih memiliki produk terkait.');
        }
        */
        
        ProductCategory::destroy($category->id);

        return redirect('/admin/categories')->with('success', 'Kategori berhasil dihapus!');
    }
}