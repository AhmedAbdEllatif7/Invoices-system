<?php

namespace App\Http\Controllers\Invoices\Reports;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\Section;
use Illuminate\Http\Request;

class InvoiceReportController extends Controller
{

    public function __construct(){
        $this->middleware('returnRedirectIfNotAuth');
    }

    public function index()
    {
        $invoices = Invoice::get();
        return view('invoices.reports',compact('invoices'));

    }


    public function create()
    {

    }


    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }


    public function destroy(Request $request)
    {

    }

    public function search(Request $request)
    {
        if($request->rdio == 1)
        {
        //في حالة لم يتم اختيار تاريخ
            if($request->type && $request->start_at=='' &&  $request->end_at=='')
            {
                if($request->type == 'الكل')
                {
                    $invoices = Invoice::get();
                    $type = $request->type;
                    return view('invoices.reports',compact('type'))->with('details',$invoices);
                }
                else
                {
                    $invoices = Invoice::select('*')->where('status','=', $request->type)->get();
                    $type = $request->type;
                    return view('invoices.reports',compact('type'))->with('details',$invoices);
                }
            }
        //في حالةتم اختيار تاريخ
            else
            {
                $start_at = date($request->start_at);
                $end_at   = date($request->end_at);
                $type     = $request->type;
                $invoices = Invoice::whereBetween('invoice_date',[$start_at,$end_at])->where('status','=',$request->type)->get();
                return view('invoices.reports',compact('type','start_at','end_at','invoices'))->with('details',$invoices);
            }
        }


        // في البحث برقم الفاتورة
        else {
            $invoices = invoice::select('*')->where('invoice_number','=',$request->invoice_number)->get();
            return view('invoices.reports',compact('invoices'))->with('details',$invoices);
        }
    }

    public function showClients()
    {
        $sections = Section::get();
        $products = Product::get();
        return view('invoices.clients',compact('sections','products'));
    }


    public function searchClients(Request $request)
    {
        $sections = Section::get();
        $products = Product::get();
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
            return view('invoices.clients',compact('invoices','sections','products','section'));
        }
        else
        {
            $start_at = $request->start_at;
            $end_at   = $request->end_at;
            $invoices = Invoice::whereBetween('invoice_date', [$start_at,$end_at])->where('section_id', '=' ,$request->section_id)->where( 'product', '=', $request->product)->get();
            return view('invoices.clients',compact('invoices','sections','products'));

        }
    }
}

