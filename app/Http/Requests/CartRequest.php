<?php

namespace App\Http\Requests;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;

class CartRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        $rules = [
            'productId' => [
                'required',
                'exists:products,id',
            ],
        ];

        $product = Product::find($this->productId);

        if (!is_null($product)) {
//            $rules['amount'][] = 'max:' . $product->amount;
            $rules['amount'] = [
                'required',
                "between:1,$product->amount",
            ];
        }


        return $rules;
    }
}
