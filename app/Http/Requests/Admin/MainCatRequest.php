<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class MainCatRequest extends FormRequest
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
            'category' => 'required|array|min:1',
            'category.*.name' => 'required|max:100',
            'category.*.description' => 'required|max:255',
            'category.*.translation' => 'required|max:20',
        ];
    }

    public function messages()
    {
        return [
            'required' => 'هذا الحقل مطلوب',
            'category.*.name.max' => 'هذا الحقل يجب الا يزيد عن 100 حرف',
            'category.*.description.max' => 'هذا الحقل يجب الا يزيد عن 255 حرف',
            'category.*.translation.max' => 'هذا الحقل يجب الا يزيد عن 20 حرف',
            'category.photo.mimes' => 'هذه الصوره غير متاحه',
        ];
    }
}
