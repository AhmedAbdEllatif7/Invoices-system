<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InvoiceDetail extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'invoice_details';
    protected $fillable = [
        'id',
        'invoice_id',
        'invoice_number',
        'product',
        'section_id',
        'status',
        'value_status',
        'payment_date',
        'note',
        'user',
        'deleted_at',
        'created_at',
        'updated_at',
    ];

    public function section()
    {
        return $this->belongsTo('App\Models\Section','section_id','id');
    }


    public function invoices()
    {
        return $this->belongsTo(Invoice::class,'invoice_id');
    }
}
