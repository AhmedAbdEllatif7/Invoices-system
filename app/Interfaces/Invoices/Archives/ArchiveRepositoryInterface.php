<?php

namespace App\Interfaces\Invoices\Archives;

interface ArchiveRepositoryInterface {


    public function index();

    public function archive($request);

    public function renameAttachmentFolderWithArchive($invoiceNumber);
    
    public function deleteInvoice($id);
    
    public function deleteInvoiceDetails($id);
    
    public function deleteInvoiceAttachments($id);
    
    public function deleteFromArchive($request);
    
    public function restoreInvoice($request);
    
}