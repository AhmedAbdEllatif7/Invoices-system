<?php

namespace App\Http\Controllers\Invoices;

use App\Exports\InvoicesExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\InvoiceRequest;
use App\Interfaces\Invoices\InvoiceRepositoryInterface;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Invoice;

class InvoicesController extends Controller
{
    private $invoiceRepository;

    public function __construct(InvoiceRepositoryInterface $invoiceRepository){
        $this->middleware(['auth' , 'check.user.status'] );
        $this->middleware('permission:قائمة الفواتير',  ['only' => ['index']]);
        $this->middleware('permission:الفواتير المدفوعة',  ['only' => ['viewPaidInvoices']]);
        $this->middleware('permission:الفواتير الغير مدفوعة', ['only' => ['viewUnPaidInvoices']]);
        $this->middleware('permission:الفواتير المدفوعة جزئيا', ['only' => ['viewUnPaidInvoices']]);
        $this->middleware('permission:اضافة فاتورة', ['only' => ['create' ,'store']]);
        $this->middleware('permission:تعديل الفاتورة', ['only' => ['edit' , 'update']]);
        $this->middleware('permission:حذف الفاتورة', ['only' => ['destroy']]);
        $this->middleware('permission:طباعةالفاتورة', ['only' => ['showPrint']]);

        $this->invoiceRepository = $invoiceRepository;
    }

    public function export() 
    {
        return $this->invoiceRepository->export();

    }

    public function index()
    {
        return $this->invoiceRepository->index();
    }


    public function create() {
        return $this->invoiceRepository->create();
    }


    public function store(InvoiceRequest $request) {
        return $this->invoiceRepository->store($request);
    }


    public function show($id) {
        return $this->invoiceRepository->show($id);
    }

    
    public function edit($id) {
        return $this->invoiceRepository->edit($id);
    }


    public function update(InvoiceRequest $request) {
        return $this->invoiceRepository->update($request);
    }


    public function destroy(Request $request) {
        return $this->invoiceRepository->destroy($request);
    }

    
    public function getProducts($id) {
        return $this->invoiceRepository->getProducts($id);
    }


    public function updateStatus(Request $request) {
        return $this->invoiceRepository->updateStatus($request);
    }


    public function viewPaidInvoices() {
        return $this->invoiceRepository->viewPaidInvoices();
    }


    public function viewUnPaidInvoices() {
        return $this->invoiceRepository->viewUnPaidInvoices();
    }


    public function viewPartialPaid() {
        return $this->invoiceRepository->viewPartialPaid();
    }


    public function showPrint(Request $request, $id) {
        return $this->invoiceRepository->showPrint($request, $id);
    }


    public function deleteSelectedInvoices(Request $request)
    {
        return $this->invoiceRepository->deleteSelectedInvoices($request);
    }
    
}

