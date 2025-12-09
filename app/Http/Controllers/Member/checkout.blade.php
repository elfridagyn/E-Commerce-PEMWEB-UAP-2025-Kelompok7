public function start(Product $product)
{
    $shippingTypes = \App\Models\ShippingType::all();

    return view('member.checkout', [
        'product' => $product,
        'shippingTypes' => $shippingTypes,
    ]);
}
