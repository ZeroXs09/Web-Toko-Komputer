<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AboutUs extends Controller
{
    public function TampilanHome() {

    $cart = session()->get('cart', []);
    $cartCount = array_sum(array_column($cart, 'quantity'));

        return view('aboutus', compact('cartCount'));
    }
}
