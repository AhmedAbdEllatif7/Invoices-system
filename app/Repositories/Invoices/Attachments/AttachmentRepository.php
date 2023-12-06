<?php

namespace App\Repositories\Invoices\Attachments;

use App\Interfaces\Invoices\Attachments\AttachmentRepositoryInterface;


use App\Models\InvoiceAttachment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AttachmentRepository implements AttachmentRepositoryInterface
{
    public function store($request)
    {
        
        //Get File From Request
        $file = $request->file('file');

        //Get File From Request By It's Extension
        $file_name = $file->getClientOriginalName();

        //Save Attachment In Database
        InvoiceAttachment::create([
            'file_name'      => $file_name,
            'invoice_number' => $request->invoice_number,
            'invoice_id'     => $request->invoice_id,
            'created_by'     => Auth::user()->name,
        ]);

        //Save File In My Path
        $file->move(public_path('Attachments/'.$request->invoice_number),$file_name);
        session()->flash('Add', 'تمت إضافة المرفق بنجاح');
        return redirect()->back();
    }






    public function destroy($request)
    {
    $invoiceAttachment = InvoiceAttachment::findOrFail($request->attachment_id);

    if ($invoiceAttachment) {
        // Construct the file path
        $filePath = $request->invoice_number . '/' . $request->file_name;

        if (Storage::disk('public_uploads')->exists($filePath)) {
            // Delete the file
            Storage::disk('public_uploads')->delete($filePath);

            // Check if the containing folder is now empty
            $directoryPath = $request->invoice_number;
            $filesInDirectory = Storage::disk('public_uploads')->files($directoryPath);

            if (empty($filesInDirectory)) {
                // Delete the directory if it's empty
                Storage::disk('public_uploads')->deleteDirectory($directoryPath);
            }
        }

        // forceDelete the attachment record from the database
        $invoiceAttachment->forceDelete();

        session()->flash('delete', 'تم حذف المرفق بنجاح');
    } else {
        session()->flash('error', 'لم يتم العثور على المرفق');
    }

    return redirect()->back();
    }



    public function openFile($invoice_number, $file_name)
    {

        $file = Storage::disk('public_uploads')->path($invoice_number.'/'.$file_name);
        return response()->file($file);
    }



    public function downloadFile($invoice_number, $file_name)
    {
        $file = Storage::disk('public_uploads')->path($invoice_number.'/'.$file_name);
        return response()->download($file);
    }
}