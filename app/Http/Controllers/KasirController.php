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

    public function approve($id)
    {
        if (!Auth::check() || Auth::user()->role != 2) abort(403);

        return DB::transaction(function () use ($id) {
            $transaction = Transaction::with('items.product')->findOrFail($id);
            if ($transaction->status !== 'pending') {
                return redirect()->back()->with('error', 'Transaksi sudah diproses.');
            }

            foreach ($transaction->items as $item) {
                $product = $item->product;
                if (!$product) return redirect()->back()->with('error', "Produk tidak ditemukan!");
                if ($product->stock < $item->quantity) {
                    return redirect()->back()->with('error', "Stok {$product->name} tidak mencukupi!");
                }
                $product->decrement('stock', $item->quantity);
            }

            $transaction->update(['status' => 'approved', 'rejection_reason' => null]);

            return redirect()->route('receipt.show', $transaction->id)->with('success', 'Transaksi disetujui!');
        });
    }

    // method reject yang benar
    public function reject(Request $request, $id)
    {
        if (!Auth::check() || Auth::user()->role != 2) {
            abort(403);
        }

        // Validasi input
        $request->validate([
            'rejection_reason' => 'required|string|min:5|max:500'
        ]);

        $transaction = Transaction::findOrFail($id);
        if ($transaction->status !== 'pending') {
            return redirect()->back()->with('error', 'Transaksi sudah diproses sebelumnya.');
        }

        // Update status dan simpan alasan
        $transaction->status = 'rejected';
        $transaction->rejection_reason = $request->rejection_reason;
        $transaction->save();

        return redirect()->route('receipt.show', $transaction->id)
            ->with('success', 'Transaksi ditolak dengan alasan.');
    }
}
