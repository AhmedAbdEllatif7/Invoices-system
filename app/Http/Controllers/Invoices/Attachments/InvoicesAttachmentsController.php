<?php

namespace App\Http\Controllers\Invoices\Attachments;

use App\Http\Controllers\Controller;
use App\Http\Requests\FileUploadRequest;
use App\Interfaces\Invoices\Attachments\AttachmentRepositoryInterface;
use Illuminate\Http\Request;


class InvoicesAttachmentsController extends Controller
{
    public $attachmentRepository;
    public function __construct(AttachmentRepositoryInterface  $attachmentRepository)
    {
        $this->middleware(['auth' , 'check.user.status'] );
        $this->middleware('permission:اضافة مرفق',   ['only' => ['create' , 'store']]);
        $this->middleware('permission:حذف المرفق',   ['only' => ['destroy']]);
        $this->attachmentRepository = $attachmentRepository;
    }


    public function store(FileUploadRequest $request)
    {
        return $this->attachmentRepository->store($request);
    }


    public function destroy(Request $request)
    {
        return $this->attachmentRepository->destroy($request);
    }


    public function openFile($invoice_number, $file_name)
    {
        return $this->attachmentRepository->openFile($invoice_number, $file_name);
    }


    public function downloadFile($invoice_number, $file_name)
    {
        return $this->attachmentRepository->downloadFile($invoice_number, $file_name);
    }

}
