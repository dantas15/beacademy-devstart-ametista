<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckoutRequest;
use App\Models\Address;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\OrderStatus;
use App\Models\PaymentMethod;
use App\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

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
            return redirect()->route('shop.checkout.selectAddress')->with('error', 'Selecione um endereço válido');
        }

        return view('shop.checkout.payment', [
            'address' => Address::find($addressId),
            'boletoId' => PaymentMethod::where('name', 'boleto')->first()->id,
            'creditCardId' => PaymentMethod::where('name', 'credit_card')->first()->id,
        ]);
    }

    /**
     * @param CheckoutRequest $request
     * @return View|RedirectResponse
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function payment(CheckoutRequest $request)
    {
        $reqData = $request->validated();
        $paymentMethod = PaymentMethod::find($reqData['paymentMethodId']);

        if (!$paymentMethod) {
            return redirect()->route('shop.checkout.paymentForm', $request->addressId)->with('error', 'Selecione um método de pagamento válido');
        }

        $address = Address::find($request->addressId);

        $completeAddress = $address->street . ', ' . $address->number . ', ' . $address->complement . ', ' . $address->neighborhood . ', ' . $address->city . ', ' . $address->state . ', ' . $address->country . ', ' . $address->zipCode;

        $order = Order::create([
            'id' => Str::uuid(),
            'user_id' => Auth::user()->getAuthIdentifier(),
            'payment_method_id' => $paymentMethod->id,
            'address_id' => $request->addressId,
            'complete_address' => $completeAddress,
            'total_price' => (float)session()->get('totalCartPrice'),
            'status_id' => OrderStatus::where('status', 'pending')->first()->id,
        ]);

        // Create OrderProduct for each product in session()->get('cart')
        foreach (session()->get('cart') as $product) {
            OrderProduct::create([
                'id' => Str::uuid(),
                'order_id' => $order->id,
                'product_id' => $product['id'],
                'amount' => $product['amount'],
            ]);

            // Decrease product amount in stock
            $product = Product::find($product['id']);
            $product->amount -= $product['amount'];
            $product->save();
        }

        $paymentWasApproved = false;

        // TODO Send mail that payment is being processed.

        if ($paymentMethod->name == 'credit_card') {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'token' => env('TRACKTOOLS_API_KEY'),
            ])->post(env('TRACKTOOLS_API_URL'), [
                'transaction_type' => 'card',
                'transaction_amount' => session()->get('totalCartPrice'),
                'transaction_installments' => 1,
                'customer_name' => Auth::user()->name,
                'customer_document' => Auth::user()->document_id,
                'customer_card_number' => $reqData['creditNumber'],
                'customer_card_expiration_date' => $reqData['expDate'],
                'customer_card_cvv' => $reqData['cvc'],
            ]);

            $paymentWasApproved = $response['response']['code'] == 201 && $response['transaction']['status'] == 'paid';
        }

        if ($paymentMethod->name == 'boleto') {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'token' => env('TRACKTOOLS_API_KEY'),
            ])->post(env('TRACKTOOLS_API_URL'), [
                'transaction_type' => 'ticket',
                'transaction_amount' => session()->get('totalCartPrice'),
                'transaction_installments' => 1,
                'customer_name' => Auth::user()->name,
                'customer_document' => Auth::user()->document_id,
                'customer_postcode' => $address->zip,
                'customer_address_street' => $address->street,
                'customer_address_number' => $address->number,
                'customer_address_neighborhood' => $address->neighborhood,
                'customer_address_city' => $address->city,
                'customer_address_state' => $address->uf,
                'customer_address_country' => 'Brasil',
            ]);

            $paymentWasApproved = $response['response']['code'] == 201 && $response['transaction']['status'] == 'paid';
        }

        if ($paymentWasApproved) {
            // TODO Send mail if payment was successful.

            $order->status_id = OrderStatus::where('status', 'approved')->first()->id;
            $order->save();

            session()->put('cart', []);
            session()->put('totalCartPrice', '');

            return view('shop.checkout.success')->with('success', 'Pagamento realizado com sucesso!');
        } else {
            // TODO Send mail if payment was refused.

            $order->status_id = OrderStatus::where('status', 'refused')->first()->id;
            $order->save();

            // Adding the amount of products in stock back to the cart
            foreach ($order->order_products as $orderProduct) {
                $product = Product::find($orderProduct->product_id);
                $product->amount += $orderProduct->amount;
                $product->save();
            }

            return redirect()->route('shop.cart.index')->with('error', 'Erro no pagamento! Tente novamente');
        }
    }
}
