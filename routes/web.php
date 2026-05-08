<?php

use App\Http\Controllers\AboutUs;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\KasirController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;

// PUBLIC
Route::get('/', [ProductController::class, 'index'])->name('build');
Route::get('/aboutus', [AboutUs::class, 'TampilanHome'])->name('aboutus');

// CART
Route::prefix('cart')->group(function () {
    Route::get('/', [CartController::class, 'view'])->name('cart');
    Route::post('/add/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/update/{product}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/remove/{product}', [CartController::class, 'remove'])->name('cart.remove');
    Route::delete('/clear', [CartController::class, 'clear'])->name('cart.clear');
});

// CHECKOUT
Route::prefix('checkout')->group(function () {
    Route::get('/', [CheckoutController::class, 'index'])->name('checkout');
    Route::post('/process', [CheckoutController::class, 'process'])->name('checkout.process');
    Route::get('/payment/{transaction}', [CheckoutController::class, 'paymentSuccess'])->name('checkout.payment');
    Route::get('/qr-code/{transaction}', [CheckoutController::class, 'generateQR'])->name('checkout.qr');
});

// AUTH
Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store']);
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
Route::post('/login', [AuthenticatedSessionController::class, 'store']);
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

// PROTECTED
Route::middleware(['auth'])->group(function () {
    // KASIR
    Route::prefix('kasir')->group(function () {
        Route::get('/', [KasirController::class, 'index'])->name('kasir.index');
        Route::post('/approve/{id}', [KasirController::class, 'approve'])->name('kasir.approve');
        Route::post('/reject/{id}', [KasirController::class, 'reject'])->name('kasir.reject');
    });

    // RECEIPTS
    Route::prefix('receipts')->group(function () {
        Route::get('/', [TransactionController::class, 'index'])->name('receipts');
        Route::get('/{transaction}', [TransactionController::class, 'show'])->name('receipt.show');
        Route::delete('/{transaction}', [TransactionController::class, 'delete'])->name('receipt.delete');
        Route::get('/{transaction}/print', [TransactionController::class, 'print'])->name('receipt.print');
    });

    // ADMIN
    Route::prefix('admin')->group(function () {
        Route::get('/stats', [AdminController::class, 'index'])->name('admin.dashboard');
        Route::prefix('products')->group(function () {
            Route::post('/store', [AdminController::class, 'storeProduct'])->name('admin.products.store');
            Route::put('/update/{id}', [AdminController::class, 'updateProduct'])->name('admin.products.update');
            Route::delete('/delete/{id}', [AdminController::class, 'destroyProduct'])->name('admin.products.destroy');
            Route::patch('/stock/{id}', [AdminController::class, 'updateStock'])->name('admin.products.updateStock');
        });
    });
});
