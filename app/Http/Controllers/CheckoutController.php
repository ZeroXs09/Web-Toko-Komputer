<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        $cartCount = array_sum(array_column($cart, 'quantity'));

        if (empty($cart)) {
            return redirect()->route('build')->with('error', 'Your cart is empty!');
        }

        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        $tax = $subtotal * 0.11;
        $total = $subtotal + $tax;

        return view('checkout', compact('cart', 'cartCount', 'subtotal', 'tax', 'total'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_phone' => 'required|string|max:20',
            'payment_method' => 'required|in:cash,card,e-wallet',
            'cash_amount' => 'required_if:payment_method,cash|nullable|numeric|min:0',
        ]);

        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('build')->with('error', 'Your cart is empty!');
        }

        // Calculate totals
        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }
        $tax = $subtotal * 0.11;
        $total = $subtotal + $tax;

        // Validate cash payment
        if ($request->payment_method === 'cash' && $request->cash_amount < $total) {
            return back()->withErrors(['cash_amount' => 'Cash amount is insufficient!'])->withInput();
        }

        // Create transaction
        $transaction = Transaction::create([
            'customer_name' => $request->customer_name,
            'customer_phone' => $request->customer_phone,
            'subtotal' => $subtotal,
            'tax' => $tax,
            'total' => $total,
            'payment_method' => $request->payment_method,
            'cash_amount' => $request->payment_method === 'cash' ? $request->cash_amount : null,
            'change' => $request->payment_method === 'cash' ? ($request->cash_amount - $total) : 0,
        ]);

        // Create transaction items
        foreach ($cart as $item) {
            TransactionItem::create([
                'transaction_id' => $transaction->id,
                'product_id' => $item['id'],
                'product_name' => $item['name'],
                'category' => $item['category'],
                'price' => $item['price'],
                'quantity' => $item['quantity'],
                'subtotal' => $item['price'] * $item['quantity'],
            ]);
        }

        // Clear cart
        session()->forget('cart');

        return redirect()->route('receipt.show', $transaction->id)
            ->with('success', 'Transaction completed successfully!');
    }
}
