<?php

namespace App\Http\Controllers;

use App\Models\ProductCategory;

class CategoryController extends Controller
{
    // Admin hanya bisa melihat kategori
    public function index()
    {
        return view('admin.kategori.index', [
            'categories' => ProductCategory::all()
        ]);
    }
}
