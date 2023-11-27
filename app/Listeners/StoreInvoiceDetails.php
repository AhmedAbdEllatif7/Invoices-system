<?php

namespace App\Listeners;

use App\Events\InvoiceCreated;
use App\Models\Invoice;
use App\Models\InvoiceDetail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Auth;

class StoreInvoiceDetails
{

    public function __construct()
    {
        //
    }


    public function handle(InvoiceCreated $event)
    {
        $invoiceData = $event->invoiceData;

        InvoiceDetail::create([
            'invoice_id'     => Invoice::latest()->first()->id,
            'invoice_number' => $invoiceData['invoice_number'],
            'product'        => $invoiceData['product'],
            'section_id'     => $invoiceData['section_id'],
            'status'         => 'غير مدفوعة',
            'value_status'   => 0,
            'note'           => $invoiceData['note'],
            'user'           => Auth::user()->name,
        ]);
    }
}
