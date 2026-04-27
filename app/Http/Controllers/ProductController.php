<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
{
    $query = Product::where('is_active', true);

    // Filter category
    if ($request->has('category') && $request->category !== 'All') {
        $query->where('category', $request->category);
    }

    // Search
    if ($request->has('search') && !empty($request->search)) {
        $query->where(function($q) use ($request) {
            $q->where('name', 'LIKE', '%' . $request->search . '%')
              ->orWhere('category', 'LIKE', '%' . $request->search . '%');
        });
    }

    $products = $query->get();

    $categories = [
        'All',
        'Processor',
        'Graphics Card',
        'Motherboard',
        'Memory',
        'Case',
        'Power Supply',
        'Storage',
        'Cooling',
        'Prebuilt'
    ];

    $cart = session()->get('cart', []);
    $cartCount = array_sum(array_column($cart, 'quantity'));

    return view('build', compact('products', 'categories', 'cart', 'cartCount'));
}
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|integer|min:0',
        ]);

        $product->update($request->all());

        return redirect()->route('build')->with('success', 'Produk berhasil diupdate!');
    }
}
