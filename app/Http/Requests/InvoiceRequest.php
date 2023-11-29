<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InvoiceRequest extends FormRequest
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
        $id = $this->input('id'); // Assuming the ID is passed as 'id' in the request

        return [
            'invoice_number'    => 'required|max:50|unique:invoices,invoice_number,' . $id,
            'invoice_date'      => 'nullable|date',
            'due_date'          => 'nullable|date|after_or_equal:invoice_date',
            'product'           => 'required|max:50',
            'section_id'        => 'required|exists:sections,id',
            'amount_collection' => 'required|numeric',
            'amount_commission' => 'required|numeric',
            'discount'          => 'required|numeric',
            'value_vat'         => 'required|numeric',
            'rate_vat'          => 'required|max:999',
            'total'             => 'required|numeric',
            'file'              => 'nullable|mimes:pdf,jpeg,jpg,png', 

        ];
    }

    public function messages()
    {
        return [
            'invoice_number.required' => 'عفوا يجب إدخال رقم الفاتورة' ,
            'invoice_date.required' => 'عفوا يجب إدخال تاريخ الفاتورة',
            'due_date.required' => 'عفوا يجب إدخال تاريخ الإستحقاق',
            'product.required' => 'عفوا يجب إدخال إاسم المنتيج',
            'section_id.required' => 'عفوا يجب إدخال رقم القسم',
            'amount_collection.required' => 'عفوا يجب  إدخال مبلغ التحصيل',
            'amount_commission.required' => 'عفوا يجب إدخال مبلغ العمولة',
            'Value_VAT.required' => 'عفوا يجب إدخال قيمة ضريبة القيمة المضافة',
            'Rate_VAT.required' => 'عفوا يجب إدخال نسبة ضريبة القيمة المضافة',
            'Total.required' => 'عفوا يجب إدخال رقم الإجمالي شامل الضريبة',
            'file.mimes' => 'عفوا يجب أن يكون نوع الملف pdf أو jpeg أو jpg أو png',

        ];
    }
}
