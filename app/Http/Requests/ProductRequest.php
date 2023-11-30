<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $id = request()->id; // Assuming the ID is passed as 'id' in the request
        return [
            'product_name' => ['required' , 'max:50' , Rule::unique('products')->ignore($id)],
            'section_name' => 'required',
            'description' => 'nullable'
        ];
    }

    public function messages()
    {
        return [
            'product_name.required' => 'عفوا يجب إدخال اسم المنتج',
            'product_name.unique' => 'عفوا هذا المنتج موجود بالفعل',
            'product_name.max' => 'عفوا لقد تجاوزت الحد الأقصى من الحروف',
            'section_name.required' => 'عفوا يجب اختيار اسم القسم',
        ];
    }
}
