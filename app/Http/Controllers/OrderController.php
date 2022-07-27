<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index() {


        $products = Product::orderBy('id', 'desc')->paginate(5);
        // dd('cheguei no controler');
        return view('orders.index', compact('products'));

    }
}
