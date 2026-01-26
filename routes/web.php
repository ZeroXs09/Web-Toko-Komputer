<?php

use App\Http\Controllers\AboutUs;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\BuildController;
use App\Http\Controllers\AdminController;

Route::get('/', [ProductController::class, 'index'])->name('build');
Route::get('/aboutus', [AboutUs::class, 'TampilanHome'])->name('aboutus');


Route::prefix('cart')->group(function () {
    Route::get('/', [CartController::class, 'view'])->name('cart');
    Route::post('/add/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/update/{product}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/remove/{product}', [CartController::class, 'remove'])->name('cart.remove');
    Route::delete('/clear', [CartController::class, 'clear'])->name('cart.clear');
});


Route::prefix('checkout')->group(function () {
    Route::get('/', [CheckoutController::class, 'index'])->name('checkout');
    Route::post('/process', [CheckoutController::class, 'process'])->name('checkout.process');
});

Route::prefix('receipts')->group(function () {
    Route::get('/', [TransactionController::class, 'index'])->name('receipts');
    Route::get('/{transaction}', [TransactionController::class, 'show'])->name('receipt.show');
    Route::delete('/{transaction}', [TransactionController::class, 'delete'])->name('receipt.delete');
    Route::get('/{transaction}/print', [TransactionController::class, 'print'])->name('receipt.print');
});


Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::resource('products', ProductController::class);
});


Route::get('/login', function () {
    return view('login');
})->name('login');

Route::get('/register', function () {
    return view('register');
})->name('register');


