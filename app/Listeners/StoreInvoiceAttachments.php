<?php

namespace App\Listeners;

use App\Events\InvoiceCreated;
use App\Models\Invoice;
use App\Models\Invoices_Attachments;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Auth;

class StoreInvoiceAttachments
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\InvoiceCreated  $event
     * @return void
     */
    public function handle(InvoiceCreated $event)
{
    $file = $event->file;
    $invoiceData = $event->invoiceData;

    // Check if a file was uploaded
    if ($file) {
        $file_name = $file->getClientOriginalName();

        // Store Data In DataBase
        $attachmentData = [
            'file_name' => $file_name,
            'invoice_number' => $invoiceData['invoice_number'],
            'created_by' => Auth::user()->name,
            'invoice_id' => Invoice::latest()->first()->id,
        ];

        Invoices_Attachments::create($attachmentData);

        // Move File
        $file->move(public_path('Attachments/' . $invoiceData['invoice_number']), $file_name);
    }
}

}
