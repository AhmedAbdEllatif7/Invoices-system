<?php

namespace App\Http\Controllers\Invoices\Archives;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\InvoiceAttachment;
use App\Models\InvoiceDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

    // You need the custom function:

    // Move_Folder_To("./path/old_folder_name",   "./path/new_folder_name"); 
    // function code:
    
    // function Move_Folder_To($source, $target){
    //     if( !is_dir($target) ) mkdir(dirname($target),null,true);
    //     rename( $source,  $target);
    // }

    public function destroy(Request $request)
    {
        $id = $request->id;
    
        $this->moveInvoiceToArchive($id); // Move the invoice folder to the Archive
    
        $this->deleteInvoice($id);
        $this->deleteInvoiceDetails($id);
        $this->deleteInvoiceAttachments($id);
    
        session()->flash('archiev');
        return redirect('invoice_archievs');
    }
    
    private function moveInvoiceToArchive($id)
    {
        $invoice = Invoice::findOrFail($id);
        $invoiceNumber = $invoice->number;

        $sourcePath = public_path('Attachments/' . $invoiceNumber);
        $destinationPath = public_path('Attachments/Archive/' . $invoiceNumber);

        if (Storage::disk('public')->exists('Attachments/' . $invoiceNumber)) {
            Storage::move( $sourcePath, $destinationPath);

        }
        
    }



    private function deleteInvoice($id)
    {
        return Invoice::where('id', $id)->delete();
    }

    private function deleteInvoiceDetails($id)
    {
        return InvoiceDetail::where('invoice_id', $id)->delete();
    }

    private function deleteInvoiceAttachments($id)
    {
        return InvoiceAttachment::where('invoice_id', $id)->delete();
    }






    public function deleteFromArchiev(Request $request)
    {
        $id = $request->id;

        $this->forceDeleteInvoice($id);
        $this->forceDeleteInvoiceDetails($id);
        $this->forceDeleteInvoiceAttachments($id);

        session()->flash('delete');
        return redirect()->back();
    }

    private function forceDeleteInvoice($id)
    {
        return Invoice::where('id', $id)->forceDelete();
    }

    private function forceDeleteInvoiceDetails($id)
    {
        return InvoiceDetail::where('invoice_id', $id)->forceDelete();
    }

    private function forceDeleteInvoiceAttachments($id)
    {
        return InvoiceAttachment::where('invoice_id', $id)->forceDelete();
    }

}

