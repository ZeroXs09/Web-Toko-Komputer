<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Gunakan view composer untuk SEMUA tampilan ('*')
        View::composer('*', function ($view) {
            // Ambil cart dari session
            $cart = session()->get('cart', []);
            // Hitung total quantity
            $cartCount = array_sum(array_column($cart, 'quantity'));
            // Kirim variabel cartCount ke view
            $view->with('cartCount', $cartCount);
        });
    }

    public function register()
    {
        //
    }
}
