<?php

namespace App\Http\Controllers;

use App\Http\Requests\CartRequest;
use App\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
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
     * @return RedirectResponse
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
                'id' => $productData['productId'],
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

    /**
     * Remove a product from the cart
     *
     * @param Request $request
     * @param int $productId
     * @param int $amount
     * @return RedirectResponse
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function destroy(Request $request, int $productId, int $amount)
    {
        $product = Product::find($productId);

        if (is_null($product)) {
            return redirect()->back()->with('error', 'Produto não encontrado!');
        }

        if ($amount > $product->amount) {
            return redirect()->back()->with('error', 'Quantidade de produtos indisponível!');
        }

        $cart = session()->get('cart');

        if (is_null($cart)) {
            $cart = [];
        }

        if (isset($cart[$productId])) {
            if ($cart[$productId]['amount'] - $amount <= 0) {
                unset($cart[$productId]);
            } else {
                $cart[$productId]['amount'] -= $amount;
            }
        }

        $totalCartPrice = (float)array_reduce($cart, function ($carry, $item) {
            return (float)$carry + (float)$item['price'] * (int)$item['amount'];
        });

        session()->put('cart', $cart);
        session()->put('totalCartPrice', $totalCartPrice);

        return redirect()->back()->with('success', 'Produto removido com sucesso!');
    }

    /**
     * @return RedirectResponse
     */
    public function clearCart()
    {
        session()->forget('cart');
        session()->forget('totalCartPrice');

        return redirect()->back()->with('success', 'Carrinho limpo com sucesso!');
    }
}
