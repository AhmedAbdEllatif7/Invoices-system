<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InvoiceAttachment extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'invoice_attachments';
    protected $fillable = [
        'file_name',
        'invoice_number',
        'created_by',
        'invoice_id',
        'deleted_at',
        'created_at',
        'updated_at',
    ];

    public function invoices()
    {
        return $this->belongsTo(Invoice::class);
    }
}
