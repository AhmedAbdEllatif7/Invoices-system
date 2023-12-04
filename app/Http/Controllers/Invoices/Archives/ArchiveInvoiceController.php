<?php

namespace App\Http\Controllers\Invoices\Archives;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\InvoiceAttachment;
use App\Models\InvoiceDetail;
use App\Observers\InvoiceObserver;
use Illuminate\Http\Request;


class ArchiveInvoiceController extends Controller
{
    public function __construct(){
        $this->middleware(['auth' , 'check.user.status'] );
        $this->middleware('permission:ارشيف الفواتير',   ['only' => ['index']]);
        $this->middleware('permission:ارشفة الفاتورة',   ['only' => ['archive','restore']]);

    }

    public function index()
    {
        $invoices = Invoice::onlyTrashed()->get();
        return view('invoices.archive.index',compact('invoices'));
    }


    public function archive(Request $request)
    {
        $id = $request->id;
        $invoice = Invoice::findOrFail($id);
        
        $this->renameAttachmentFolderWithArchive($invoice->invoice_number);

        $this->deleteInvoiceDetails($id);
        $this->deleteInvoiceAttachments($id);
        $this->deleteInvoice($id);

        session()->flash('archiev');
        return redirect()->route('archives.index');
    }
    

    public function renameAttachmentFolderWithArchive($invoiceNumber)
    {
        $oldFolder = public_path('Attachments/' . $invoiceNumber);
        $newFolder = public_path('Attachments/' . $invoiceNumber . ' (Archived)');

        if (file_exists($oldFolder)) {
            rename($oldFolder, $newFolder);
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








    public function deleteFromArchive(Request $request)
    {
        $id = $request->id;
        InvoiceObserver::deleteAttachments($id);
        Invoice::onlyTrashed()->where('id', $id)->forceDelete();

        session()->flash('delete');
        return redirect()->back();
    }






    //There are an operations done in the InvoiceObserver
    public function restoreInvoice(Request $request)
    {
        Invoice::onlyTrashed()->findOrFail($request->id)->restore();

        session()->flash('restore');
        return redirect()->back();
    }

}
