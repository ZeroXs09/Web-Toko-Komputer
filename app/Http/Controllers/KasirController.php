<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class KasirController extends Controller
{
    public function index()
    {
        if (!Auth::check() || Auth::user()->role != 2) {
            abort(403, 'Unauthorized - Kasir only');
        }

        $transactions = Transaction::with(['items.product'])
            ->where('status', 'pending')
            ->latest()
            ->get();

        return view('kasir.index', compact('transactions'));
    }

    // Approve transaksi, lalu redirect kembali ke halaman detail transaksi tersebut
    public function approve($id)
    {
        if (!Auth::check() || Auth::user()->role != 2) {
            abort(403);
        }

        return DB::transaction(function () use ($id) {
            $transaction = Transaction::with('items.product')->findOrFail($id);
            if ($transaction->status !== 'pending') {
                return redirect()->back()->with('error', 'Transaksi sudah diproses sebelumnya.');
            }

            foreach ($transaction->items as $item) {
                $product = $item->product;
                if (!$product) {
                    return redirect()->back()->with('error', "Produk dengan ID {$item->product_id} tidak ditemukan!");
                }
                if ($product->stock < $item->quantity) {
                    return redirect()->back()->with('error', "Stok produk {$product->name} tidak mencukupi!");
                }
                $product->decrement('stock', $item->quantity);
            }

            $transaction->update(['status' => 'approved']);
            return redirect()->route('receipt.show', $transaction->id)
                ->with('success', 'Transaksi berhasil disetujui!');
        });
    }

    // Reject transaksi, redirect kembali ke halaman detail
    public function reject($id)
    {
        if (!Auth::check() || Auth::user()->role != 2) {
            abort(403);
        }

        $transaction = Transaction::findOrFail($id);
        if ($transaction->status !== 'pending') {
            return redirect()->back()->with('error', 'Transaksi sudah diproses sebelumnya.');
        }
        $transaction->update(['status' => 'rejected']);
        return redirect()->route('receipt.show', $transaction->id)
            ->with('success', 'Transaksi telah ditolak!');
    }
}
