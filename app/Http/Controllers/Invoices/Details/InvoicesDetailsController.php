<?php

namespace App\Http\Controllers\Invoices\Details;

use App\Http\Controllers\Controller;
use App\Models\Invoice;


class InvoicesDetailsController extends Controller
{
    public function __construct(){
        $this->middleware(['auth' , 'check.user.status'] );
    }



    public function index()
    {

        $invoice = Invoice::findOrFail(request()->id);
        $invoiceDetails = $invoice->details->last();
        $AllInvoiceDetails = $invoice->details;
        $AllInvoiceAttachments = $invoice->attachment;

        return view('invoices.details.index', compact('invoiceDetails','AllInvoiceDetails','AllInvoiceAttachments'));
    }



}
