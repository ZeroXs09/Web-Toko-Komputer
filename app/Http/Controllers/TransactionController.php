<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    // Halaman daftar riwayat transaksi untuk customer (hanya yang approved)
    public function index(Request $request)
    {
        // Jika user adalah kasir (role = 2), tampilkan semua transaksi (pending & approved)
        if (Auth::user()->role == 2) {
            $query = Transaction::with('items')
                ->latest('transaction_date');
        } else {
            // Customer biasa: hanya lihat transaksi miliknya sendiri yang sudah approved
            $query = Transaction::with('items')
                ->where('user_id', Auth::id())
                ->where('status', 'approved')
                ->latest('transaction_date');
        }

        // Search
        if ($request->has('search') && !empty($request->search)) {
            $query->where(function ($q) use ($request) {
                $q->where('transaction_id', 'LIKE', '%' . $request->search . '%')
                    ->orWhere('customer_name', 'LIKE', '%' . $request->search . '%');
            });
        }

        $transactions = $query->get();

        // Statistik berdasarkan transaksi yang tampil (bukan seluruh database)
        $totalRevenue = $transactions->sum('total');
        $totalTransactions = $transactions->count();
        $totalItems = $transactions->sum(function ($transaction) {
            return $transaction->items->sum('quantity');
        });

        $cartCount = array_sum(array_column(session()->get('cart', []), 'quantity'));

        return view('receipts', compact('transactions', 'totalRevenue', 'totalTransactions', 'totalItems', 'cartCount'));
    }

    // Halaman detail receipt (bisa diakses customer untuk transaksi approved, atau kasir untuk semua)
    public function show($id)
    {
        $transaction = Transaction::with('items')->findOrFail($id);

        // Customer hanya boleh melihat transaksi miliknya sendiri dan sudah approved
        if (Auth::user()->role != 2) { // bukan kasir
            if ($transaction->user_id != Auth::id() || $transaction->status !== 'approved') {
                abort(403, 'Unauthorized or transaction not approved yet.');
            }
        }

        $cartCount = array_sum(array_column(session()->get('cart', []), 'quantity'));

        return view('receipt-detail', compact('transaction', 'cartCount'));
    }

    // Hapus transaksi (hanya untuk customer, hanya transaksi approved)
    public function delete($id)
    {
        $transaction = Transaction::findOrFail($id);

        // Jika user adalah kasir (role 2), izinkan hapus transaksi yang statusnya rejected
        if (Auth::user()->role == 2) {
            if ($transaction->status !== 'rejected') {
                return redirect()->route('receipts')->with('error', 'Hanya transaksi yang ditolak yang dapat dihapus oleh kasir.');
            }
            $transaction->delete();
            return redirect()->route('receipts')->with('success', 'Transaksi berhasil dihapus.');
        }

        
        if ($transaction->user_id !== Auth::id() || $transaction->status !== 'approved') {
            abort(403, 'Unauthorized action.');
        }

        $transaction->delete();
        return redirect()->route('receipts')->with('success', 'Receipt deleted successfully!');
    }

    // Cetak PDF (sama seperti sebelumnya)
    public function print($id)
    {
        $transaction = Transaction::with('items')
            ->where('user_id', Auth::id())
            ->where('status', 'approved')
            ->findOrFail($id);

        $pdf = Pdf::loadView('pdf.receipt', compact('transaction'));
        return $pdf->download('receipt-' . $transaction->transaction_id . '.pdf');
    }
}
