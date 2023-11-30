<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SectionRequest extends FormRequest
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

    public function rules()
    {
         $id = request()->id; // Assuming the ID is passed as 'id' in the request
        return [
            'section_name' => ['required','max:50', Rule::unique('sections')->ignore($id)],   
            'description' => 'nullable|string|max:255',
            'created_by' => 'nullable|string|max:100',
        ];
    }

    public function messages()
    {
        
        return [
            'section_name.required' => 'عفوا يجب إدخال أسم القسم',
            'section_name.unique' => 'عفوا هذا القسم موجود بالفعل',
            'section_name.max' => 'عفوا لقد تخطيت الحد الأقصى لعدد الحروف',
            'description.string' => 'يجب أن تكون الوصف نصاً',
            'description.max' => 'عفوا لقد تخطيت الحد الأقصى لعدد الحروف في الوصف',
            'created_by.string' => 'يجب أن يكون الإنشاء من نص',
            'created_by.max' => 'عفوا لقد تخطيت الحد الأقصى لعدد الحروف في الإنشاء',
        ];
    }
}
