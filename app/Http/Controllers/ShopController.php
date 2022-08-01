<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    /**
     * Show products index page
     *
     * @return View
     */
    public function index(Request $request)
    {
        $products = Product::where('amount', '>', 0)->orderBy('id', 'desc')->paginate(15);

        if ($request->has('search')) {
            $products = Product::query()
                ->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('description', 'like', '%' . $request->search . '%')
                ->where('amount', '>', 0)
                ->paginate(20);

            return view('shop.index', [
                'products' => $products,
                'searchQuery' => $request->search,
            ]);
        }

        return view('shop.index', [
            'products' => $products,
        ]);
    }
}
