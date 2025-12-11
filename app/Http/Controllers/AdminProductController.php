<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required',
        'price' => 'required|numeric',
        'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    $path = null;

    // SIMPAN FILE GAMBAR
    if ($request->hasFile('thumbnail')) {
        $path = $request->file('thumbnail')->store('products', 'public');
    }

    // SIMPAN PRODUK
    Product::create([
        'name' => $request->name,
        'price' => $request->price,
        'thumbnail' => $path, // simpan path gambar
    ]);

    return redirect()->route('admin.products.index')
                     ->with('success', 'Produk berhasil ditambahkan.');
}

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
