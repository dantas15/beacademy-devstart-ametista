<?php

namespace App\Http\Controllers;

use App\Http\Requests\CartRequest;
use App\Models\Product;
use Illuminate\Contracts\View\View;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class CartController extends Controller
{
    /**
     * Show current cart items
     *
     * @return View
     */
    public function index()
    {
        return view('shop.cart.index');
    }

    /**
     * Store a product in the cart
     *
     * @param CartRequest $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function store(CartRequest $request)
    {
        $productData = $request->validationData();

        $product = Product::find($productData['productId']);

        $cart = session()->get('cart');

        if (is_null($cart)) {
            $cart = [];
        }

        if (isset($cart[$productData['productId']])) {
            $cart[$productData['productId']]['amount'] += $productData['amount'];
        } else {
            $cart[$productData['productId']] = [
                'name' => $product->name,
                'amount' => $productData['amount'],
                'description' => $product->description,
                'price' => $product->sale_price,
            ];
        }

        $totalCartPrice = (float)array_reduce($cart, function ($carry, $item) {
            return (float)$carry + (float)$item['price'] * (int)$item['amount'];
        });

        session()->put('cart', $cart);
        session()->put('totalCartPrice', $totalCartPrice);

        return redirect()->back()->with('success', 'Produto adicionado com sucesso!');
    }
}
