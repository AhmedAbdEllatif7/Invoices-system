<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FileUploadRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Adjust this to apply authorization logic if needed
    }

    public function rules()
    {
        return [
            'file' => 'required|mimes:pdf,jpeg,jpg,png', // Adjusted mimes rule
        ];
    }

    public function messages()
    {
        return [
            'file.required' => 'يرجى اختيار ملف',
            'file.mimes' => 'عفوا يجب أن يكون نوع الملف pdf أو jpeg أو jpg أو png',
        ];
    }
}
