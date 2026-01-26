<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class BuildController extends Controller
{

Public function index()
    {
       $products = Product::all();
       return view('build', compact('products'));
    }

}
