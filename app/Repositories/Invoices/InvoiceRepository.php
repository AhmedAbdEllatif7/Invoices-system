<?php

namespace App\Repositories\Invoices;

use App\Events\InvoiceCreated;
use App\Interfaces\Invoices\InvoiceRepositoryInterface;
use App\Models\Invoice;
use App\Models\InvoiceDetail;
use App\Models\Section;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Throwable;

class InvoiceRepository implements InvoiceRepositoryInterface {

    public function index()
    {
        $invoices = Invoice::all();
        return view('invoices.index',compact('invoices'));
    }




    public function create()
    {
        $sections = Section::get();
        return view('invoices.create',compact('sections'));
    }




    public function store($request)
    {
        try {
            DB::beginTransaction();
    
            $invoiceValidatedData = $request->validated();
    
            $invoiceValidatedData['status'] = 'غير مدفوعة';
            $invoiceValidatedData['value_status'] = 0; // غير مدفوعة
    
            if ($request->note) {
                $invoiceValidatedData['note'] = $request->note;
            }
    
            // Save Invoice In DataBase
            $invoice = Invoice::create($invoiceValidatedData);
    
            // Save Invoice Details and Invoice Attachments In Datbase
            event(new InvoiceCreated($invoice));
    
            DB::commit();
    
            session()->flash('Add');
            return redirect()->back();
        } 
        
        catch (Throwable $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'An error occurred: ' . $e->getMessage()]);
        }
        
    }





    //Change Status
    public function show($id)
    {
        $invoice = Invoice::findOrFail($id);
        return view('invoices.status.index',compact('invoice'));
    }





    public function edit($id)
    {
            $invoice  = Invoice::findOrFail($id);
            $sections = Section::get();
            return view('invoices.edit',compact('invoice','sections'));
    }





    //There are an operations done in the InvoiceObserver
    public function update($request)
    {
        $invoiceValidatedData = $request->validated();
        
        $invoice = Invoice::findOrFail($request->id);

        if ($request->has('note')) {
            $invoiceValidatedData['note'] = $request->note;
        }
        
        $invoice->update($invoiceValidatedData);

        session()->flash('edit_invoice');
        return redirect()->back();
    }






    //There are an operations done in the InvoiceObserver
    public function destroy($request)
    {
        $id = $request->id;

        $invoice = Invoice::findOrFail($id);
        $invoice->delete();

        return redirect()->back()->with(['delete' => 'تم حذف الفاتورة بنجاح']);
    }




    //Belongs to ajax
    public function getproducts($id)
    {
        $products = DB::table("products")->where("section_id", $id)->pluck("product_name", "id");
        return json_encode($products);
    }



    public function updateStatus($request)
    {
        $invoice = Invoice::findOrFail($request->id);
        $data = [
            'value_status' => $request->Status === 'مدفوعة' ? 1 : 2,
            'status' => $request->Status,
            'payment_date' => $request->payment_date, 
        ];
        
        $invoice->update($data);
        
        $this->updateDetails($request , $data['value_status']);
        
        session()->flash('edit');
        return redirect('invoices');
    }


    private function updateDetails($request , $valueStatus)
    {
        InvoiceDetail::create([
            'invoice_id'    => $request->id,
            'invoice_number'=> $request->invoice_number,
            'product'       => $request->product,
            'section_id'    => $request->section_id,
            'status'        => $request->Status,
            'value_status'  => $valueStatus,
            'payment_date'  => $request->payment_date,
            'note'          => $request->note,
            'user'          => Auth::user()->name,
        ]);

    }



    public function viewPaidInvoices()
    {
        $invoices = Invoice::where('value_status',1)->get();
        return view('invoices.paid.index',compact('invoices'));
    }


    public function viewUnPaidInvoices()
    {
        $invoices = Invoice::where('value_status',0)->get();
        return view('invoices.unPaid.index',compact('invoices'));
    }


    public function viewPartialPaid()
    {
        $invoices = Invoice::where('value_status',2)->get();
        return view('invoices.partialPaid.index',compact('invoices'));
    }






    public function showPrint($request, $id)
    {
        $invoice = Invoice::findOrFail($id);
        
        return view('invoices.print.index',compact('invoice'));
    }

}