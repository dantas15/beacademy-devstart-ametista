<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckoutRequest;
use App\Models\Address;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    /**
     * Display a listing of the user's addresses.
     *
     * @return View
     */
    public function selectAddress()
    {
        $addresses = Auth::user()->addresses;

        return view('shop.checkout.select-address', [
            'addresses' => $addresses ?? [],
        ]);
    }

    /**
     * @param string $addressId
     * @return View|RedirectResponse
     */
    public function paymentForm(string $addressId)
    {
        $address = Address::find($addressId);

        if (!$address) {
            return redirect()->route('shop.checkout.select-address')->with('error', 'Selecione um endereço válido');
        }

        return view('shop.checkout.payment', [
            'address' => Address::find($addressId),
        ]);
    }

    /**
     * @param CheckoutRequest $request
     * @return
     */
    public function payment(CheckoutRequest $request)
    {
        // TODO Receive payment data and send mail that payment is being processed.


        // TODO Send mail that payment was successful or not.


    }
}
