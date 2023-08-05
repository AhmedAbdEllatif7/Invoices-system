<?php

namespace App\Http\Controllers\Invoices;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Invoices_Attachments;
use App\Models\Invoices_Details;
use Illuminate\Http\Request;

class InvoicesArchiefController extends Controller
{

    public function __construct(){
        $this->middleware('returnRedirectIfNotAuth');
    }

    public function index()
    {
        $invoices = Invoice::onlyTrashed()->get();
        return view('invoices.archief',compact('invoices'));
    }


    public function create()
    {

    }


    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }


    public function destroy(Request $request)
    {
        $id  = $request->id;

        $invoivce            = Invoice::where('id',$id)->delete();
        $invoice_details     = Invoices_Details::where('invoice_id',$id)->delete();
        $invoice_attachments = Invoices_Attachments::where('invoice_id',$id)->delete();
        session()->flash('archiev');
        return redirect('invoice_archievs');
    }

    public function deleteFromArchiev(Request $request)
    {
        $id = $request->id;

        $invoivce            = Invoice::where('id',$id)->forceDelete();
        $invoice_details     = Invoices_Details::where('invoice_id',$id)->forceDelete();
        $invoice_attachments = Invoices_Attachments::where('invoice_id',$id)->forceDelete();
        session()->flash('delete');
        return redirect()->back();
    }
}

