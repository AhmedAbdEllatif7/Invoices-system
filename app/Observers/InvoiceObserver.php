<?php

namespace App\Observers;

use App\Models\Invoice;
use Illuminate\Support\Facades\Auth;

class InvoiceObserver
{
    
    public function updated(Invoice $invoice)
    {
        $invoice->details()->update([
            'invoice_number' => $invoice->invoice_number,
            'product' => $invoice->product,
            'section_id' => $invoice->section_id,
            'status' => $invoice->status,
            'value_status' => $invoice->value_status,
            'payment_date' => $invoice->payment_date,
            'note' => $invoice->note,
            'user' => Auth::user()->name,
        ]);
    }

    /**
     * Handle the Invoice "deleted" event.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return void
     */
    public function deleted(Invoice $invoice)
    {
        //
    }

    /**
     * Handle the Invoice "restored" event.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return void
     */
    public function restored(Invoice $invoice)
    {
        //
    }

    /**
     * Handle the Invoice "force deleted" event.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return void
     */
    public function forceDeleted(Invoice $invoice)
    {
        //
    }
}
