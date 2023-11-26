<?php

namespace App\Observers;

use App\Models\Invoice;
use App\Models\Invoices_Attachments;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class InvoiceObserver
{
    
    public function updated(Invoice $invoice)
    {
        $this->updateDetails($invoice);
        $this->manageAttachmentsAndFolders($invoice);
    }



    private function updateDetails($invoice)
    {
        $invoice->details()->update([
            'invoice_number' => $invoice->invoice_number,
            'product' => $invoice->product,
            'section_id' => $invoice->section_id,
            'note' => $invoice->note,
            'user' => Auth::user()->name,
        ]);
    }

    private function manageAttachmentsAndFolders($invoice)
    {
        $oldInvoiceNumber = $invoice->getOriginal('invoice_number');
        $newInvoiceNumber = $invoice->invoice_number;

        if ($oldInvoiceNumber !== $newInvoiceNumber) {
            $this->renameAttachmentFolder($oldInvoiceNumber, $newInvoiceNumber);
        }

    }


    private function renameAttachmentFolder($oldInvoiceNumber, $newInvoiceNumber)
    {
        $oldFolder = public_path('Attachments/' . $oldInvoiceNumber);
        $newFolder = public_path('Attachments/' . $newInvoiceNumber);

        if (file_exists($oldFolder)) {
            rename($oldFolder, $newFolder);
        }
    }






    public function deleted(Invoice $invoice)
    {
        $this->deleteAttachments($invoice->id);
        $invoice->forceDelete();

    }


    private function deleteAttachments($id)
    {
        $attachments = Invoices_Attachments::where('invoice_id', $id)->get();

        if ($attachments->isNotEmpty()) {
            foreach ($attachments as $attachment) {
                $path = 'Attachments/' . $attachment->invoice_number . '/' . $attachment->file_name;
                Storage::disk('public_uploads')->delete($path);
            }

            $directory = public_path('Attachments/' . $attachments->first()->invoice_number);
            if (File::exists($directory)) {
                File::deleteDirectory($directory);
            }
        }
    }



    
    public function restored(Invoice $invoice)
    {
        //
    }



    
    public function forceDeleted(Invoice $invoice)
    {
    }


    

    

}
