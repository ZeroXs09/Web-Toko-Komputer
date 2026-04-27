<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function add(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);
        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity']++;
        } else {
            $cart[$productId] = [
                "id"       => $product->id,
                "name"     => $product->name,
                "category" => $product->category,
                "price"    => $product->price,
                "image"    => $product->image,
                "quantity" => 1,
            ];
        }

        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Produk ditambahkan ke keranjang!');
    }

    public function view()
    {
        $cart = session()->get('cart', []);
        $cartCount = array_sum(array_column($cart, 'quantity'));

        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        $tax = $subtotal * 0.11;
        $total = $subtotal + $tax;

        return view('cart', compact('cart', 'cartCount', 'subtotal', 'tax', 'total'));
    }

    public function update(Request $request, $productId)
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] = $request->quantity;
            if ($cart[$productId]['quantity'] <= 0) {
                unset($cart[$productId]);
            }
            session()->put('cart', $cart);
        }
        return redirect()->back()->with('success', 'Keranjang diperbarui!');
    }

    public function remove($productId)
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            session()->put('cart', $cart);
        }
        return redirect()->back()->with('success', 'Item dihapus!');
    }

    public function clear()
    {
        session()->forget('cart');
        return redirect()->route('build')->with('success', 'Keranjang dikosongkan!');
    }
}
