<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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

        ShippingType::create($request->all());

        return redirect()->route('shipping-types.index');
    }
}
