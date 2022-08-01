<?php

namespace App\Http\Requests;

use App\Models\PaymentMethod;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rule;

class CheckoutRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return RedirectResponse|array
     */
    public function rules()
    {
        $rules = [
            'paymentMethodId' => [
                'required',
            ],
        ];

        $paymentMethod = PaymentMethod::find($this->paymentMethodId);

        if ($paymentMethod != null) {

            if ($paymentMethod->name == 'credit_card') {
                $rules['email'] = [
                    'required',
                ];
                $rules['name'] = [
                    'required',
                ];
                $rules['creditNumber'] = [
                    'required',
                ];
                $rules['expDate'] = [
                    'required',
                ];
                $rules['cvc'] = [
                    'required',
                ];
            }

            if ($paymentMethod->name == 'boleto') {
                $rules['document_id'] = [
                    'required',
                    Rule::exists('users', 'document_id'),
                ];
                $rules['name'] = [
                    'required',
                    Rule::exists('users', 'name'),
                ];
            }

            if (!$this->addressId) {
                redirect()->route('shop.checkout.selectAddress')->with('error', 'Selecione um endereço válido');
            }
        }

        return $rules;
    }
}
