<?php

namespace App\Interfaces\Invoices\Attachments;

interface AttachmentRepositoryInterface {

    public function store($request);
    
    public function destroy($request);
    
    public function openFile($invoice_number, $file_name);

    public function downloadFile($invoice_number, $file_name);
    
}