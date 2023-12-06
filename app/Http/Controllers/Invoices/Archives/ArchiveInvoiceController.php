<?php

namespace App\Http\Controllers\Invoices\Archives;

use App\Http\Controllers\Controller;
use App\Interfaces\Invoices\Archives\ArchiveRepositoryInterface;
use Illuminate\Http\Request;


class ArchiveInvoiceController extends Controller
{
    public $archiveRepository;
    public function __construct(ArchiveRepositoryInterface  $archiveRepository){
        $this->middleware(['auth' , 'check.user.status'] );
        $this->middleware('permission:ارشيف الفواتير',   ['only' => ['index']]);
        $this->middleware('permission:ارشفة الفاتورة',   ['only' => ['archive','restore']]);

        $this->archiveRepository = $archiveRepository;
    }




    public function index()
    {
        return $this->archiveRepository->index();
    }



    public function archive(Request $request)
    {
        return $this->archiveRepository->archive($request);
    }
    



    public function deleteFromArchive(Request $request)
    {
        return $this->archiveRepository->deleteFromArchive($request);
    }



    public function restoreInvoice(Request $request)
    {
        return $this->archiveRepository->restoreInvoice($request);

    }

}
