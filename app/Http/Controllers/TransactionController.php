<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaction::with('items')->latest('transaction_date');

        // Search functionality
        if ($request->has('search') && !empty($request->search)) {
            $query->where(function($q) use ($request) {
                $q->where('transaction_id', 'LIKE', '%' . $request->search . '%')
                  ->orWhere('customer_name', 'LIKE', '%' . $request->search . '%');
            });
        }

        $transactions = $query->get();

        // Statistics
        $totalRevenue = Transaction::sum('total');
        $totalTransactions = Transaction::count();
        $totalItems = Transaction::with('items')->get()->sum(function($transaction) {
            return $transaction->items->sum('quantity');
        });

        $cartCount = array_sum(array_column(session()->get('cart', []), 'quantity'));

        return view('receipts', compact('transactions', 'totalRevenue', 'totalTransactions', 'totalItems', 'cartCount'));
    }

    public function show($id)
    {
        $transaction = Transaction::with('items')->findOrFail($id);
        $cartCount = array_sum(array_column(session()->get('cart', []), 'quantity'));

        return view('receipt-detail', compact('transaction', 'cartCount'));
    }

    public function delete($id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->delete();

        return redirect()->route('receipts')->with('success', 'Receipt deleted successfully!');
    }

    public function print($id)
    {
        $transaction = Transaction::with('items')->findOrFail($id);

        $pdf = Pdf::loadView('pdf.receipt', compact('transaction'));
        return $pdf->download('receipt-' . $transaction->transaction_id . '.pdf');
    }
}
