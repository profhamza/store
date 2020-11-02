<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class VendorRequest extends FormRequest
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
        $rules =  [
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:50|unique:vendors',
            'phone' => 'required|string|max:20|unique:vendors',
            'password' => 'required|string|min:6',
            'logo'  => 'required_without:id|mimes:jpg,jpeg,png,gif',
            'address' => 'required|string|max:150',
            'cat_id' => 'numeric|exists:main_categories,id'
        ];
        if (in_array(request()->method(), ['PUT', 'PATCH']))
        {
            $rules['password'] = 'sometimes|nullable|string|min:6';
            $rules['email'] = 'required|email|max:50';
            $rules['phone'] = 'required|string|max:20';
        }
        return $rules;
    }

    public function messages()
    {
        return [
            'required' => 'هذا الحقل مطلوب',
            'email.email' => 'الايميل غير صحيح',
            'name.max' => 'يجب الا يزيد هذا الحقل عن 100 حرف',
            'phone.max' => 'يجب الا يزيد هذا الحقل عن 20 حرف',
            'email.max' => 'يجب الا يزيد هذا الحقل عن 50 حرف',
            'address.max' => 'يجب الا يزيد هذا الحقل عن 150 حرف',
            'cat_id.number' => 'هذا الحقل يجب ان يحتوى على ارقام فقط',
            'cat_id.exists' => 'هذا القسم غير موجود',
            'logo.mimes' => 'هذه الصوره غير متاحه',
            'unique' => 'هذه القيمه موجوده بالفعل',
            'password.min' => 'الرقم السرى يجب الا يقل عن 6 حروف'
        ];
    }
}
