<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Transaction;

class AdminController extends Controller
{
    public function index() {

    $totalProducts = Product::count();
    $totalTransactions = Transaction::count();
    $totalSales = Transaction::sum('total');
        return view('admin.dashboard', compact('totalProducts', 'totalTransactions', 'totalSales'));
    }
    //
}
