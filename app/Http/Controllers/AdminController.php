<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File; 

class AdminController extends Controller
{
    public function index()
    {
        if (!Auth::check() || Auth::user()->role != 1) {
            abort(403, 'Anda bukan Admin!');
        }

        $totalProducts = Product::count();
        $totalTransactions = Transaction::count();
        $totalSales = Transaction::sum('total');
        $products = Product::latest()->get();

        return view('admin.dashboard', compact('totalProducts', 'totalTransactions', 'totalSales', 'products'));
    }

    public function updateStock(Request $request, $id)
    {
        if (!Auth::check() || Auth::user()->role != 1) abort(403);
        $product = Product::findOrFail($id);

        if ($request->action === 'plus') {
            $product->increment('stock');
        } elseif ($request->action === 'minus' && $product->stock > 0) {
            $product->decrement('stock');
        }

        return back()->with('success', 'Stock updated!');
    }

    public function storeProduct(Request $request)
    {
        if (!Auth::check() || Auth::user()->role != 1) abort(403);

        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        $imagePath = 'images/default.png';

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images/products'), $fileName);
            $imagePath = 'images/products/' . $fileName;
        }

        Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'stock' => $request->stock,
            'category' => $request->category,
            'description' => $request->description,
            'image' => $imagePath
        ]);

        return back()->with('success', 'Barang berhasil ditambah!');
    }


    public function destroyProduct($id)
    {
        if (!Auth::check() || Auth::user()->role != 1) abort(403);

        $product = Product::findOrFail($id);


        if ($product->image && $product->image != 'images/default.png') {
            $fullPath = public_path($product->image);
            if (File::exists($fullPath)) {
                File::delete($fullPath);
            }
        }

        $product->delete();
        return back()->with('success', 'Barang dan gambar berhasil dihapus!');
    }

    public function updateProduct(Request $request, $id)
    {
        if (!Auth::check() || Auth::user()->role != 1) abort(403);

        $product = Product::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|integer|min:0',
            'category' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        $data = [
            'name' => $request->name,
            'price' => $request->price,
            'stock' => $request->stock,
            'category' => $request->category,
            'description' => $request->description,
        ];

        if ($request->hasFile('image')) {

            if ($product->image && $product->image != 'images/default.png') {
                $oldPath = public_path($product->image);
                if (File::exists($oldPath)) {
                    File::delete($oldPath);
                }
            }

            $file = $request->file('image');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('images/products'), $fileName);
            $data['image'] = 'images/products/' . $fileName;
        }

        $product->update($data);
        return back()->with('success', 'Komponen berhasil diperbarui!');
    }
}
