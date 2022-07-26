<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

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
        if ($this->method() == 'POST') {
            // Create
            $this->document_id = preg_replace('/[^0-9]/', '', $this->document_id ?? '');

            $rules = [
                'email' => [
                    'required',
                    'max:255',
                    'email',
//                    'unique:App\Models\User,email',
                ],
                'password' => [
                    'required',
                    'confirmed',
                ],
                'phone_number' => [
                    'required'
                ],
                'birth_date' => [
                    'required',
                    'date',
                ],
                'document_id' => [
                    'required',
                    'regex:/([0-9]{2}[\.]?[0-9]{3}[\.]?[0-9]{3}[\/]?[0-9]{4}[-]?[0-9]{2})|([0-9]{3}[\.]?[0-9]{3}[\.]?[0-9]{3}[-]?[0-9]{2})/',
                    'unique:App\Models\User,document_id',
                ],
            ];
        } else {
            //Update
            $rules = [
                'name' => [
                    'required',
                    'max:255',
                ],
                'email' => [
                    'required',
                    'max:255',
                    'email',
                    Rule::unique('users')->whereNot('id', [$this->userId, $this->id, Auth::user()->getAuthIdentifier()]),
                ],
                'phone_number' => ['required'],
                'birth_date' => [
                    'required',
                    'date',
                ],
            ];
        }

        return $rules;
    }
}
