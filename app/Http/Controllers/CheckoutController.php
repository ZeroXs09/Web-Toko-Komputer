<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;

class CheckoutController extends Controller
{
    public function index()
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('build')->with('error', 'Your cart is empty!');
        }

        $subtotal = array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $cart));
        $tax = $subtotal * 0.11;
        $total = $subtotal + $tax;

        return view('checkout', compact('cart', 'subtotal', 'tax', 'total'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'customer_name'     => 'required|string|max:255',
            'customer_phone'    => 'required|string|max:20',
            'customer_address'  => 'required|string',
            'payment_method'    => 'required|in:cash,credit_card,e-wallet',
            'cash_amount'       => 'required_if:payment_method,cash|nullable|numeric|min:0',
            'ewallet_provider'  => 'required_if:payment_method,e-wallet|nullable|string|in:gopay,ovo,dana,linkaja',
        ]);

        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('build')->with('error', 'Your cart is empty!');
        }

        $subtotal = array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $cart));
        $tax = $subtotal * 0.11;
        $total = $subtotal + $tax;

        if ($request->payment_method === 'cash' && $request->cash_amount < $total) {
            return back()->withErrors(['cash_amount' => 'Cash amount is insufficient!'])->withInput();
        }

        return DB::transaction(function () use ($request, $cart, $subtotal, $tax, $total) {
            $transaction = Transaction::create([
                'user_id'           => Auth::id(),
                'customer_name'     => $request->customer_name,
                'customer_phone'    => $request->customer_phone,
                'customer_address'  => $request->customer_address,
                'subtotal'          => $subtotal,
                'tax'               => $tax,
                'total'             => $total,
                'payment_method'    => $request->payment_method,
                'ewallet_provider'  => $request->ewallet_provider ?? null,
                'cash_amount'       => $request->payment_method === 'cash' ? $request->cash_amount : null,
                'change'            => $request->payment_method === 'cash' ? ($request->cash_amount - $total) : 0,
                'transaction_id'    => 'TRX-' . strtoupper(uniqid()),
                'transaction_date'  => now(),
                'status'            => 'pending'
            ]);

            foreach ($cart as $item) {
                TransactionItem::create([
                    'transaction_id' => $transaction->id,
                    'product_id'     => $item['id'],
                    'product_name'   => $item['name'],
                    'category'       => $item['category'],
                    'price'          => $item['price'],
                    'quantity'       => $item['quantity'],
                    'subtotal'       => $item['price'] * $item['quantity'],
                ]);
            }

            session()->forget('cart');

            if ($request->payment_method === 'e-wallet') {
                return redirect()->route('checkout.payment', $transaction->id);
            }

            return redirect()->route('build')->with('success', 'Pesanan berhasil dibuat, silakan tunggu approval kasir!');
        });
    }

    public function paymentSuccess(Transaction $transaction)
    {
        if ($transaction->user_id !== Auth::id()) {
            abort(403);
        }
        if ($transaction->payment_method !== 'e-wallet') {
            return redirect()->route('build');
        }
        return view('payment-success', compact('transaction'));
    }

    public function generateQR(Transaction $transaction)
    {
        if ($transaction->user_id !== Auth::id()) {
            abort(403);
        }

        $data = "Transaction: {$transaction->transaction_id}\n"
            . "Amount: Rp " . number_format($transaction->total, 0, ',', '.') . "\n"
            . "Provider: " . strtoupper($transaction->ewallet_provider) . "\n"
            . "Merchant: ALTAR PC";

        $result = new Builder(
            writer: new PngWriter(),
            data: $data,
            encoding: new Encoding('UTF-8'),
            errorCorrectionLevel: ErrorCorrectionLevel::High,
            size: 300,
            margin: 10
        );

        $qr = $result->build();

        return response($qr->getString())
            ->header('Content-Type', 'image/png');
    }
}
