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
        $this->middleware('returnRedirectIfNotAuth');
    }

    public function index()
    {
        $invoices = Invoice::get();
        return view('invoices.reports.index',compact('invoices'));

    }




    public function search(Request $request)
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
    

    public function showClients()
    {
        $sections = Section::all();
        $products = Product::all();
        return view('invoices.clients.index',compact('sections','products'));
    }


    public function searchClients(Request $request)
    {
        $sections = Section::all();
        $products = Product::all();
        $section = $request->section_id;
        if($section == 1)
        {
            $section = 'البنك الأهلي';
        }

        else if($section == 2)
        {
            $section = 'البنك الرياض';
        }

        else
        {
            $section = 'البنك البلاد';
        }
        //في حالة البحث بدون تاريخ
        if($request->section_id && $request->strat_at == '' && $request->end_at == '')
        {

            $invoices = Invoice::where('section_id', '=' ,$request->section_id)->where( 'product', '=', $request->product)->get();
            return view('invoices.clients.index',compact('invoices','sections','products','section'));
        }
        else
        {
            $start_at = $request->start_at;
            $end_at   = $request->end_at;
            $invoices = Invoice::whereBetween('invoice_date', [$start_at,$end_at])->where('section_id', '=' ,$request->section_id)->where( 'product', '=', $request->product)->get();
            return view('invoices.clients.index',compact('invoices','sections','products'));

        }
    }
}

