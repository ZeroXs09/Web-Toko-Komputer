<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('build')->with('error', 'Your cart is empty!');
        }

        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        $tax = $subtotal * 0.11;
        $total = $subtotal + $tax;

        return view('checkout', compact('cart', 'subtotal', 'tax', 'total'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'customer_address' => 'required|string',
            'payment_method' => 'required|in:cash,credit_card,e-wallet',
            'cash_amount' => 'required_if:payment_method,cash|nullable|numeric|min:0',
        ]);

        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('build')->with('error', 'Your cart is empty!');
        }

        // Kalkulasi Total
        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }
        $tax = $subtotal * 0.11;
        $total = $subtotal + $tax;

        // Cek Uang Cash
        if ($request->payment_method === 'cash' && $request->cash_amount < $total) {
            return back()->withErrors(['cash_amount' => 'Cash amount is insufficient!'])->withInput();
        }

        // Jalankan Database Transaction agar aman
        return DB::transaction(function () use ($request, $cart, $subtotal, $tax, $total) {
            $transaction = Transaction::create([
                'user_id' => Auth::id(),
                'customer_name' => $request->customer_name,
                'customer_phone' => $request->customer_phone,
                'customer_address' => $request->customer_address,
                'subtotal' => $subtotal,
                'tax' => $tax,
                'total' => $total,
                'payment_method' => $request->payment_method,
                'cash_amount' => $request->payment_method === 'cash' ? $request->cash_amount : null,
                'change' => $request->payment_method === 'cash' ? ($request->cash_amount - $total) : 0,
                'transaction_id' => 'TRX-' . strtoupper(uniqid()),
                'transaction_date' => now(),
                'status' => 'pending'
            ]);

            foreach ($cart as $item) {
                TransactionItem::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $item['id'], // Mengambil ID dari session
                    'product_name' => $item['name'],
                    'category' => $item['category'],
                    'price' => $item['price'],
                    'quantity' => $item['quantity'],
                    'subtotal' => $item['price'] * $item['quantity'],
                ]);
            }

            session()->forget('cart');

            return redirect()->route('build')->with('success', 'Pesanan berhasil dibuat, silakan tunggu approval kasir!');
        });
    }

    public function showReceipt($id)
    {
        $transaction = Transaction::with('items')->findOrFail($id);

        if ($transaction->status !== 'approved') {
            return redirect()->route('build')->with('error', 'Pesanan masih menunggu approval!');
        }

        return view('receipt', compact('transaction'));
    }
}
