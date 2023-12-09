<?php

namespace App\Repositories\Invoices\Archives;

use App\Interfaces\Invoices\Archives\ArchiveRepositoryInterface;
use App\Models\Invoice;
use App\Models\InvoiceAttachment;
use App\Models\InvoiceDetail;
use App\Observers\InvoiceObserver;

class ArchiveRepository implements ArchiveRepositoryInterface {

    public function index()
    {
        $invoices = Invoice::onlyTrashed()->get();
        return view('invoices.archive.index',compact('invoices'));
    }


    public function archive($request)
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
    



    public function deleteInvoice($id)
    {
        return Invoice::where('id', $id)->delete();
    }

    public function deleteInvoiceDetails($id)
    {
        return InvoiceDetail::where('invoice_id', $id)->delete();
    }

    public function deleteInvoiceAttachments($id)
    {
        return InvoiceAttachment::where('invoice_id', $id)->delete();
    }








    public function deleteFromArchive($request)
    {
        $id = $request->id;
        InvoiceObserver::deleteAttachments($id);
        Invoice::onlyTrashed()->where('id', $id)->forceDelete();

        session()->flash('delete');
        return redirect()->back();
    }






    //There are an operations done in the InvoiceObserver
    public function restoreInvoice($request)
    {
        Invoice::onlyTrashed()->findOrFail($request->id)->restore();

        session()->flash('restore');
        return redirect()->back();
    }




    public function archiveSelectedInvoices($request){

        try {
            $archive_selected_id = explode(",", $request->archive_selected_id);
            
            if($archive_selected_id)
            {
                foreach($archive_selected_id as $id)
                {
                    $invoice = Invoice::findOrfail($id);
                    $this->renameAttachmentFolderWithArchive($invoice->invoice_number);

                    $this->deleteInvoiceDetails($id);
                    $this->deleteInvoiceAttachments($id);
                    $this->deleteInvoice($id);
                }            
                return redirect()->back()->with(['archiveSelectedInvoices' => 'تم أرشفة العناصر المحددة بنجاح']);
        }
            return redirect()->back()->withErrors(trans('grade_trans.Failed to delete selected grades.'));
        
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }




    public function restoreSelectedInvoices($request){

        try {
            $restore_archive_selected_id = explode(",", $request->restore_archive_selected_id);
            
            if($restore_archive_selected_id)
            {
                foreach($restore_archive_selected_id as $id)
                {
                    Invoice::onlyTrashed()->findOrFail($id)->restore();
                }            
                return redirect()->back()->with(['restoreSelected' => 'تم إستعادة العناصر المحددة بنجاح']);
        }
            return redirect()->back()->withErrors(trans('grade_trans.Failed to delete selected grades.'));
        
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    
    }


    public function forceDeleteSelectedInvoices($request)
    {
        try {
            $force_delete_selected_id = explode(",", $request->force_delete_selected_id);
            
            if($force_delete_selected_id)
            {
                foreach($force_delete_selected_id as $id)
                {
                    InvoiceObserver::deleteAttachments($id);
                    Invoice::onlyTrashed()->where('id', $id)->forceDelete();
                }            
                return redirect()->back()->with(['deleteSelectedInvoices' => 'تم حذف العناصر المحددة بنجاح']);
        }
            return redirect()->back()->withErrors(trans('grade_trans.Failed to delete selected grades.'));
        
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }


}