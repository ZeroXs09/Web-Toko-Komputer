<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::where('is_active', true);

        // Filter by category
        if ($request->has('category') && $request->category !== 'All') {
            $query->where('category', $request->category);
        }

        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'LIKE', '%' . $request->search . '%')
                  ->orWhere('category', 'LIKE', '%' . $request->search . '%');
            });
        }

        $products = $query->get();
        $categories = ['All', 'Processor', 'Graphics Card', 'Motherboard', 'Memory', 'Case'];

        // Get cart count
        $cart = session()->get('cart', []);
        $cartCount = array_sum(array_column($cart, 'quantity'));

        return view('build', compact('products', 'categories', 'cart', 'cartCount'));
    }
}
