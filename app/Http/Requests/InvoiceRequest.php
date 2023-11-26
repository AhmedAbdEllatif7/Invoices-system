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
        return [
            'invoice_number'    => 'required',
            'invoice_date'      => 'required|date',
            'due_date'          => 'required|date',
            'product'           => 'required|max:225',
            'section_id'        => 'required',
            'amount_collection' => 'required',
            'amount_commission' => 'required',
            'value_vat'         => 'required',
            'rate_vat'          => 'required',
            'total'             => 'required',
            'discount'          => 'required',
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
        ];
    }
}
