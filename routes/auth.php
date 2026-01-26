<?php

use App\Http\Controllers\AboutUs;

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProductController;

use App\Http\Controllers\CartController;

use App\Http\Controllers\CheckoutController;

use App\Http\Controllers\TransactionController;

use App\Http\Controllers\BuildController;

use App\Http\Controllers\AdminController;



// Halaman utama (Public)

Route::get('/', [ProductController::class, 'index'])->name('build');

Route::get('/aboutus', [AboutUs::class, 'TampilanHome'])->name('aboutus');



// Cart Routes (Bisa diakses tanpa login, tapi checkout nanti butuh login)

Route::prefix('cart')->group(function () {

    Route::get('/', [CartController::class, 'view'])->name('cart');

    Route::post('/add/{product}', [CartController::class, 'add'])->name('cart.add');

    Route::patch('/update/{product}', [CartController::class, 'update'])->name('cart.update');

    Route::delete('/remove/{product}', [CartController::class, 'remove'])->name('cart.remove');

    Route::delete('/clear', [CartController::class, 'clear'])->name('cart.clear');

});



// Fitur yang WAJIB LOGIN (Buyer)

Route::middleware(['auth'])->group(function () {

    Route::get('/history', [TransactionController::class, 'index'])->name('receipts');

    Route::get('/receipt/{transaction}', [TransactionController::class, 'show'])->name('receipt.show');



    Route::prefix('checkout')->group(function () {

        Route::get('/', [CheckoutController::class, 'index'])->name('checkout');

        Route::post('/process', [CheckoutController::class, 'process'])->name('checkout.process');

    });

});



// Fitur KHUSUS ADMIN (Role 1)

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {

    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

    Route::resource('products', ProductController::class);

});

