<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Mail;
class Invoice extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Notifiable;
    protected $fillable = [
        'invoice_number',
        'invoice_date',
        'due_date',
        'product',
        'section_id',
        'amount_collection',
        'amount_commission',
        'discount',
        'value_vat',
        'rate_vat',
        'total',
        'status',
        'value_status',
        'note',
        'deleted_at',
    ];
    
    public function section()
    {
        return $this->belongsTo('App\Models\Section','section_id','id');
    }

    public function attachment()
    {
        return $this->hasMany(InvoiceAttachment::class , 'invoice_id' , 'id', 'id');
    }

    public function details()
    {
        return $this->hasMany(InvoiceDetail::class, 'invoice_id');
    }
}
