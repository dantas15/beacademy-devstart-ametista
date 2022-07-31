<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AddressRequest extends FormRequest
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
        return [
            'zip' => [
                'required',
                'regex:(^[0-9]{5}-?[0-9]{3}$)',
            ],
            'uf' => [
                'required',
//            'digits:2',
            ],
            'city' => ['required'],
            'street' => ['required'],
            'number' => ['nullable'],
            'neighborhood' => ['nullable'],
            'complement' => ['nullable'],
        ];
    }
}
