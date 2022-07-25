<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
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
     * @return array|RedirectResponse
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
            $this->document_id = preg_replace('/[^0-9]/', '', $this->document_id ?? '');

            if (DB::table('users')->where('document_id', $this->document_id)->exists()) {
                return redirect()->back()->withErrors(['document_id' => 'CPF/CNPJ já cadastrado no sistema!']);
            }

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
