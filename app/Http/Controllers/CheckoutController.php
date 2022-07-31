<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckoutRequest;
use App\Models\Address;
use App\Models\PaymentMethod;
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
            'boletoId' => PaymentMethod::where('name', 'boleto')->first()->id,
            'creditCardId' => PaymentMethod::where('name', 'credit_card')->first()->id,
        ]);
    }

    /**
     * @param CheckoutRequest $request
     * @return
     */
    public function payment(CheckoutRequest $request)
    {
        $reqData = $request->validated();

        $paymentMethod = PaymentMethod::find($reqData['paymentMethodId'])->name;

        // TODO Send mail that payment is being processed.

        if ($paymentMethod == 'credit_card') {
            // TODO: implement credit card payment
        }

        if ($paymentMethod == 'boleto') {
            // TODO: implement boleto payment
        }

        // TODO Send mail that payment was successful or not.
        dd($reqData);
    }
}
