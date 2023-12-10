<?php

namespace App\Listeners;

use App\Events\InvoiceCreated;
use App\Models\InvoiceAttachment;
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
    $invoice = $event->invoiceData;

    // Check if a file was uploaded
    if (request()->hasFile('file')) {
        $file = request()->file('file');
        $file_name = $file->getClientOriginalName();

        // Store Data In DataBase
        $attachmentData = [
            'file_name' => $file_name,
            'invoice_number' => $invoice->invoice_number,
            'created_by' => Auth::user()->name,
            'invoice_id' => $invoice->id,
        ];

        InvoiceAttachment::create($attachmentData);

        // Move File
        $file->move(public_path('Attachments/' . $invoice->invoice_number), $file_name);
    }
}

}
