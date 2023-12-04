<?php

namespace App\Http\Controllers\Invoices\Reports;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\Section;
use Carbon\Carbon;
use Illuminate\Http\Request;

class InvoiceReportController extends Controller
{

    public function __construct(){
        $this->middleware(['auth' , 'check.user.status'] );
        $this->middleware('permission:تقرير الفواتير',   ['only' => ['index']]);
        $this->middleware('permission:تقرير العملاء',   ['only' => ['indexClients']]);

    }
    public function index()
    {
        $invoices = Invoice::get();
        return view('invoices.reports.index',compact('invoices'));

    }




    public function searchReports(Request $request)
    {        
        if ($request->radio == 1) {
            return $this->searchByTypeAndDate($request);
        } else {
            return $this->searchByInvoiceNumber($request);
        }
    }

    private function searchByTypeAndDate(Request $request)
    {
        if ($request->type && $request->start_at == '' && $request->end_at == '') {
            return $this->searchByType($request);
        } else {
            return $this->searchByDateAndType($request);
        }
    }
    
    private function searchByType(Request $request)
    {
        $type = $request->type;
        $invoices = $type == 'الكل' ? Invoice::get() : Invoice::where('status', $type)->get();
    
        return view('invoices.reports.index', compact('type'))->with('details', $invoices);
    }
    
    private function searchByDateAndType(Request $request)
    {
        $startAt = Carbon::parse($request->start_at);
        $endAt = Carbon::parse($request->end_at)->endOfDay();
        $type = $request->type;
    
        $invoices = Invoice::whereBetween('invoice_date', [$startAt, $endAt])
            ->where('status', $type)
            ->get();
    
        return view('invoices.reports.index', compact('type', 'startAt', 'endAt', 'invoices'))->with('details', $invoices);
    }
    
    private function searchByInvoiceNumber(Request $request)
    {
        $invoiceNumber = $request->invoice_number;
        $invoices = Invoice::where('invoice_number', $invoiceNumber)->get();
    
        return view('invoices.reports.index', compact('invoices'))->with('details', $invoices);
    }
    

    public function indexClients()
    {
        $sections = Section::all();
        $products = Product::all();
        return view('invoices.clients.index',compact('sections','products'));
    }


    public function searchClientReports(Request $request)
    {
        $sections = Section::all(); // For Ajax purposes
        $products = Product::all();

        $sectionId = $request->section_id;
        $sectionName = $this->getSectionName($sectionId);

        $invoices = $this->filterInvoices($request);

        return view('invoices.clients.index', compact('invoices', 'sections', 'products', 'sectionName'));
    }

    private function getSectionName($sectionId)
    {
        $sections = config('sections');
        return $sections[$sectionId] ?? 'Unknown Section';
    }

    private function filterInvoices($request)
    {
        $query = Invoice::query();

        if ($request->start_at && $request->end_at) {
            $query->whereBetween('invoice_date', [$request->start_at, $request->end_at]);
        }

        if ($request->section_id) {
            $query->where('section_id', $request->section_id);
        }

        if ($request->product) {
            $query->where('product', $request->product);
        }

        return $query->get();
    }

}

