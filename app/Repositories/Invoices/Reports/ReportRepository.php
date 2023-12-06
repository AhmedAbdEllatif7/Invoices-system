<?php

namespace App\Repositories\Invoices\Reports;

use App\Interfaces\Invoices\Reports\ReportRepositoryInterface;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\Section;
use Carbon\Carbon;


class ReportRepository implements ReportRepositoryInterface {


    
    public function index()
    {
        $invoices = Invoice::get();
        return view('invoices.reports.index',compact('invoices'));
    }



    public function searchReports($request)
    {        
        if ($request->radio == 1) {
            return $this->searchByTypeAndDate($request);
        } else {
            return $this->searchByInvoiceNumber($request);
        }
    }




    public function searchByTypeAndDate($request)
    {
        if ($request->type && $request->start_at == '' && $request->end_at == '') {
            return $this->searchByType($request);
        } else {
            return $this->searchByDateAndType($request);
        }
    }
    


    public function searchByType($request)
    {
        $type = $request->type;
        $invoices = $type == 'الكل' ? Invoice::get() : Invoice::where('status', $type)->get();
    
        return view('invoices.reports.index', compact('type'))->with('details', $invoices);
    }
    


    public function searchByDateAndType($request)
    {
        $startAt = Carbon::parse($request->start_at);
        $endAt = Carbon::parse($request->end_at)->endOfDay();
        $type = $request->type;
    
        $invoices = Invoice::whereBetween('invoice_date', [$startAt, $endAt])
            ->where('status', $type)
            ->get();
    
        return view('invoices.reports.index', compact('type', 'startAt', 'endAt', 'invoices'))->with('details', $invoices);
    }
    


    public function searchByInvoiceNumber($request)
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




    public function searchClientReports($request)
    {
        $sections = Section::all(); // For Ajax purposes
        $products = Product::all();

        $sectionId = $request->section_id;
        $sectionName = $this->getSectionName($sectionId);

        $invoices = $this->filterInvoices($request);

        return view('invoices.clients.index', compact('invoices', 'sections', 'products', 'sectionName'));
    }




    public function getSectionName($sectionId)
    {
        $sections = config('sections');
        return $sections[$sectionId] ?? 'Unknown Section';
    }




    public function filterInvoices($request)
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