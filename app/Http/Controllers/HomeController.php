<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $products = Product::where('amount', '>', 0)->take(8);

        return view('welcome', [
            'products' => $products,
        ]);
    }
}
