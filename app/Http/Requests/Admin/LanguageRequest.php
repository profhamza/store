<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class LanguageRequest extends FormRequest
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
            'name' => 'required|max:50',
            'abbr' => 'required|max:20',
            'direction' => 'required|in:ltr,rtl'
        ];
    }

    public function messages()
    {
        return [
            'required' => 'هذا الحقل مطلوب',
            'name.max' => 'هذا الحقل يجب الا يزيد عن 50 حرف',
            'abbr.max' => 'هذا الحقل يجب الا يزيد عن 20 حرف',
            'direction:in'    => 'القيمه المختاره غير متاحه'
        ];
    }
}
