<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShippingType; // <<< Import Class Model

class ShippingTypeController extends Controller
{
    public function index()
    {
        $shippingTypes = ShippingType::all();
        return view('admin.shipping-types.index', compact('shippingTypes'));
    }

    public function create()
    {
        return view('admin.shipping-types.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'estimate' => 'required',
            'cost' => 'required|numeric',
        ]);

        // Pastikan Model ShippingType memiliki $fillable untuk 'name', 'estimate', dan 'cost'.
        ShippingType::create($request->all());

        return redirect()->route('admin.shipping-types.index')->with('success', 'Tipe pengiriman berhasil ditambahkan.');
    }
}