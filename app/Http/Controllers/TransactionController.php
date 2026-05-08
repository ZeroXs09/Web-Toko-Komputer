<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    /**
     * Halaman daftar riwayat transaksi.
     * - Admin (role=1): lihat semua transaksi.
     * - Kasir (role=2): lihat semua transaksi (untuk approve/reject).
     * - User (role=3 atau selain 1&2): lihat transaksi miliknya sendiri, SEMUA STATUS (pending, approved, rejected).
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        if ($user->role == 1) {
            // Admin: semua transaksi
            $query = Transaction::with('items')->latest('transaction_date');
        } elseif ($user->role == 2) {
            // Kasir: semua transaksi (biar bisa approve/reject)
            $query = Transaction::with('items')->latest('transaction_date');
        } else {
            // User biasa: hanya transaksi milik sendiri, semua status
            $query = Transaction::with('items')
                ->where('user_id', $user->id)
                ->latest('transaction_date');
        }

        // Fitur search berdasarkan transaction_id atau customer_name
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('transaction_id', 'LIKE', "%{$search}%")
                    ->orWhere('customer_name', 'LIKE', "%{$search}%");
            });
        }

        $transactions = $query->get();

        // Statistik dari transaksi yang tampil (bukan semua database)
        $totalRevenue = $transactions->sum('total');
        $totalTransactions = $transactions->count();
        $totalItems = $transactions->sum(function ($transaction) {
            return $transaction->items->sum('quantity');
        });

        $cartCount = array_sum(array_column(session()->get('cart', []), 'quantity'));

        return view('receipts', compact('transactions', 'totalRevenue', 'totalTransactions', 'totalItems', 'cartCount'));
    }

    /**
     * Detail transaksi.
     * - Admin & kasir: bisa lihat semua detail.
     * - User: hanya bisa lihat transaksi milik sendiri (tanpa batasan status, bisa pending/approved/rejected).
     */
    public function show($id)
    {
        $transaction = Transaction::with('items')->findOrFail($id);
        $user = Auth::user();

        // Jika bukan admin/kasir, maka harus pemilik transaksi
        if (!in_array($user->role, [1, 2])) {
            if ($transaction->user_id !== $user->id) {
                abort(403, 'You are not authorized to view this transaction.');
            }
        }

        $cartCount = array_sum(array_column(session()->get('cart', []), 'quantity'));

        return view('receipt-detail', compact('transaction', 'cartCount'));
    }

    /**
     * Hapus transaksi.
     * - Admin: bisa hapus transaksi apapun.
     * - Kasir: hanya bisa hapus transaksi dengan status 'rejected'.
     * - User: hanya bisa hapus transaksi milik sendiri dengan status 'approved' (atau sesuai kebijakan).
     */
    /**
     * Hapus transaksi.
     * - Admin (role=1): hapus semua.
     * - Kasir (role=2): hanya hapus transaksi dengan status 'rejected'.
     * - User (role selain 1&2): hanya hapus transaksi milik sendiri dengan status 'approved' atau 'rejected'.
     */
    public function delete($id)
    {
        $transaction = Transaction::findOrFail($id);
        $user = Auth::user();

        // Kasir (role 2) tidak boleh menghapus
        if ($user->role == 2) {
            return redirect()->route('receipts')->with('error', 'Kasir tidak diizinkan menghapus transaksi.');
        }

        // Jika user biasa (bukan admin), cek kepemilikan
        if ($user->role != 1) {
            if ($transaction->user_id !== $user->id) {
                abort(403, 'Anda bukan pemilik transaksi ini.');
            }
        }

        $transaction->delete();
        return redirect()->route('receipts')->with('success', 'Transaksi berhasil dihapus.');
    }
    /**
     * Cetak PDF.
     * - User: hanya bisa cetak transaksi milik sendiri (boleh pending atau approved, sesuai kebutuhan).
     * - Kasir/admin: bisa cetak semua.
     */
    public function print($id)
    {
        $transaction = Transaction::with('items')->findOrFail($id);
        $user = Auth::user();

        if (!in_array($user->role, [1, 2])) {
            // User biasa: harus milik sendiri
            if ($transaction->user_id !== $user->id) {
                abort(403, 'Unauthorized.');
            }
        }

        $pdf = Pdf::loadView('pdf.receipt', compact('transaction'));
        return $pdf->download('receipt-' . $transaction->transaction_id . '.pdf');
    }
}
