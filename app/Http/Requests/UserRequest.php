<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
            'name' => [
                'required',
                'max:255',
            ],
            'email' => [
                'required',
                'max:255',
                'email',
                Rule::unique('users')->ignore($this->id)->ignore($this->userId),
            ],
            'phone_number' => ['required'],
            'birth_date' => [
                'required',
                'date',
            ],
        ];

        // Create
        if ($this->method() == 'POST') {
            $rules['email'] = [
                Rule::unique('users'),
            ];
            $rules['password'] = [
                'required',
                'confirmed',
            ];
            $rules['document_id'] = [
                'required',
                'regex:/([0-9]{2}[\.]?[0-9]{3}[\.]?[0-9]{3}[\/]?[0-9]{4}[-]?[0-9]{2})|([0-9]{3}[\.]?[0-9]{3}[\.]?[0-9]{3}[-]?[0-9]{2})/',
                'unique:App\Models\User,document_id',
            ];
        }

        return $rules;
    }
}
