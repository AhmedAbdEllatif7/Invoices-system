<?php

namespace App\Observers;

use App\Models\Invoice;
use App\Models\InvoiceAttachment;
use App\Models\InvoiceDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class InvoiceObserver
{
    
    public function updated(Invoice $invoice)
    {
        $this->updateDetails($invoice);
        $this->updateAttachment($invoice);
        $this->manageAttachmentsAndFolders($invoice);
    }



    public static function updateDetails($invoice)
    {
        $invoice->details()->update([
            'invoice_number' => $invoice->invoice_number,
            'product' => $invoice->product,
            'section_id' => $invoice->section_id,
            'note' => $invoice->note,
            'user' => Auth::user()->name,
        ]);
    }

    private function updateAttachment($invoice)
    {
        $invoice->attachment()->update([
            'invoice_number' => $invoice->invoice_number,
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


    public static function renameAttachmentFolder($oldInvoiceNumber, $newInvoiceNumber)
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


    public static function deleteAttachments($id)
    {
        $attachments = InvoiceAttachment::withTrashed()->where('invoice_id', $id)->get();

        if ($attachments->isNotEmpty()) {
            foreach ($attachments as $attachment) {
                $path = 'Attachments/' . $attachment->invoice_number . '/' . $attachment->file_name;
                Storage::disk('public_uploads')->delete($path);
            }

            $directory = public_path('Attachments/' . $attachments->first()->invoice_number);
            if (File::exists($directory) ) {
                File::deleteDirectory($directory);
            }
            else if(File::exists($directory.' (Archived)'))
            {
                File::deleteDirectory($directory.' (Archived)');
            }
        }
    }



    
    public function restored(Invoice $invoice)
    {
        $this->restoreInvoiceDetailsById($invoice->id);
        $this->restoreInvoiceAttachmentsById($invoice->id);
        $this->removeArchivedFromFolderName($invoice->invoice_number);
    }

    private function removeArchivedFromFolderName($invoiceNumber)
    {
        $archivedFolder = public_path('Attachments/' . $invoiceNumber . ' (Archived)');
        $nonArchivedFolder = public_path('Attachments/' . $invoiceNumber);

        if (file_exists($archivedFolder)) {
            rename($archivedFolder, $nonArchivedFolder);
        }
    }


    private function restoreInvoiceDetailsById($id)
    {
        return InvoiceDetail::onlyTrashed()->where('invoice_id', $id)->restore();
    }

    private function restoreInvoiceAttachmentsById($id)
    {
        return InvoiceAttachment::onlyTrashed()->where('invoice_id', $id)->restore();
    }


}
