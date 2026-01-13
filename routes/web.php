<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\TransactionController;

// Homepage - Build Now Page
Route::get('/', [ProductController::class, 'index'])->name('build');

// Cart Routes
Route::prefix('cart')->group(function () {
    Route::get('/', [CartController::class, 'view'])->name('cart');
    Route::post('/add/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/update/{product}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/remove/{product}', [CartController::class, 'remove'])->name('cart.remove');
    Route::delete('/clear', [CartController::class, 'clear'])->name('cart.clear');
});

// Checkout Routes
Route::prefix('checkout')->group(function () {
    Route::get('/', [CheckoutController::class, 'index'])->name('checkout');
    Route::post('/process', [CheckoutController::class, 'process'])->name('checkout.process');
});

// Receipt/Transaction Routes
Route::prefix('receipts')->group(function () {
    Route::get('/', [TransactionController::class, 'index'])->name('receipts');
    Route::get('/{transaction}', [TransactionController::class, 'show'])->name('receipt.show');
    Route::delete('/{transaction}', [TransactionController::class, 'delete'])->name('receipt.delete');
    Route::get('/{transaction}/print', [TransactionController::class, 'print'])->name('receipt.print');
});
