<?php

namespace App\Http\Controllers\Invoices\Reports;

use App\Http\Controllers\Controller;
use App\Interfaces\Invoices\Reports\ReportRepositoryInterface;
use Illuminate\Http\Request;

class InvoiceReportController extends Controller
{

    public $reportRepository;
    public function __construct(ReportRepositoryInterface  $reportRepository)
    {
        $this->middleware(['auth' , 'check.user.status'] );
        $this->middleware('permission:تقرير الفواتير',   ['only' => ['index']]);
        $this->middleware('permission:تقرير العملاء',   ['only' => ['indexClients']]);
        $this->reportRepository = $reportRepository;

    }


    public function index()
    {
        return $this->reportRepository->index();
    }


    public function searchReports(Request $request)
    {        
        return $this->reportRepository->searchReports($request);
    }


    public function indexClients()
    {
        return $this->reportRepository->indexClients();
    }


    public function searchClientReports(Request $request)
    {
        return $this->reportRepository->searchClientReports($request);
    }


}

