<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'email'     => 'required',
            'password'  => 'required|min:7'
        ];
    }
    public function messages()
    {
        return [
            'email.required'     => 'هذا الحقل مطلوب',
            'password.required'  => 'هذا الحقل مطلوب',
            'password.min'       => 'لا يقل هذا الحقل عن 7 حروف'
        ];
    }
}
