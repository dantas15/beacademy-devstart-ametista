<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
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
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $availablePaymentMethods = [
            'credit_card', 'boleto'
        ];

        $rules = [
            'addressId' => [
                'required',
                'exists:addresses,id',
            ],
            'paymentMethod' => [
                'required',
                Rule::in($availablePaymentMethods),
            ],
        ];

        if ($this->paymentMethod == 'credit_card') {
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

        if ($this->paymentMethod == 'boleto') {
            $rules['document_id'] = [
                'required',
                Rule::exists('users', 'document_id'),
            ];
            $rules['name'] = [
                'required',
                Rule::exists('users', 'name'),
            ];
        }

        return $rules;
    }
}
