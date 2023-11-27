<?php

namespace App\Http\Controllers\Invoices;

use App\Events\InvoiceCreated;
use App\Http\Controllers\Controller;
use App\Http\Requests\InvoiceRequest;
use App\Models\Invoice;
use App\Models\InvoiceAttachment;
use App\Models\InvoiceDetail;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use Throwable;

class InvoicesController extends Controller
{
    public function __construct(){
        $this->middleware('returnRedirectIfNotAuth');
    }



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




    public function store(InvoiceRequest $request)
    {
        try {
            DB::beginTransaction();
    
            // Save Invoice In DataBase
            $invoiceValidatedData = $request->validated();
    
            $invoiceValidatedData['status'] = 'غير مدفوعة';
            $invoiceValidatedData['value_status'] = 0; // غير مدفوعة
    
            if ($request->note) {
                $invoiceValidatedData['note'] = $request->note;
            }
    
            $invoice = Invoice::create($invoiceValidatedData);
    
            // Save Invoice_Details and Invoice_Attachments In Datbase
            $file = $request->file('file');
            event(new InvoiceCreated($invoice, $file));
    
            DB::commit();
    
            session()->flash('Add');
            return redirect()->back();
        } 
        
        catch (Throwable $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'An error occurred: ' . $e->getMessage()]);
        }
        
    }



    public function show($id)
    {
        $invoice = Invoice::where('id',$id)->first();
        if(!$invoice)
        {
            session()->flash('error');
            return redirect()->back();
        }
        return view('invoices.changeInvoiceStatus',compact('invoice'));
    }



    public function edit($id)
    {
            $invoice  = Invoice::findOrFail($id);
            $sections = Section::get();
            return view('invoices.edit',compact('invoice','sections'));
    }




    public function update(InvoiceRequest $request)
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








    public function destroy(Request $request)
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



    public function updateStatus(Request $request)
    {
        $invoice = Invoice::findOrFail($request->id);
        $data = [
            'value_status' => $request->Status === 'مدفوعة' ? 1 : 2,
            'status' => $request->Status,
            'payment_date' => $request->payment_date, 
        ];
        
        $invoice->update($data);
        
        $this->updateInvoiceDetails($request , $data['value_status']);
        
        session()->flash('edit');
        return redirect('invoices');
    }


    private function updateInvoiceDetails($request , $valueStatus)
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



    public function showPayedInvoices()
    {
        $invoices = Invoice::where('value_status',1)->get();
        return view('invoices.payed_invoices',compact('invoices'));
    }


    public function showUnPayedInvoices()
    {
        $invoices = Invoice::where('value_status',0)->get();
        return view('invoices.unpayed_invoices',compact('invoices'));
    }


    public function showPartialPayedInvoices()
    {
        $invoices = Invoice::where('value_status',2)->get();
        return view('invoices.partial_payed_invoices',compact('invoices'));
    }



    public function restoreInvoice(Request $request)
    {
        $id = $request->id;

        $this->restoreInvoiceById($id);
        $this->restoreInvoiceDetailsById($id);
        $this->restoreInvoiceAttachmentsById($id);

        session()->flash('restore');
        return redirect()->back();
    }

    private function restoreInvoiceById($id)
    {
        return Invoice::withTrashed()->where('id', $id)->restore();
    }

    private function restoreInvoiceDetailsById($id)
    {
        return InvoiceDetail::withTrashed()->where('invoice_id', $id)->restore();
    }

    private function restoreInvoiceAttachmentsById($id)
    {
        return InvoiceAttachment::withTrashed()->where('invoice_id', $id)->restore();
    }



    public function showPrint(Request $request, $id)
    {
        $invoice = Invoice::findOrFail($id);
        
        return view('invoices.print_invoice',compact('invoice'));
    }

}


// $url = 'http://127.0.0.1:8000/invoice/details/'.$invoice_id;
        // Mail::to('uaahmed89@gmail.com')->send(new AddInvoice($url));
        // //Send Notification

        // $user = User::where('id', 17)->get();
        // $invoice_id = Invoice::latest()->first()->id;

        // Notification::send($user, new InvoiceCreated($invoice_id));




        // $invoice_number = $request->invoice_number;
        // //Validation
        // $this->validate($request,
        // [
        //     'invoice_number'    => 'required|numeric|unique:invoices,invoice_number,'.$id_invoice,
        //     'invoice_date'      => 'required|date',
        //     'due_date'          => 'required|date',
        //     'product'           => 'required',
        //     'amount_collection' => 'required|numeric',
        //     'amount_commission' => 'required|numeric',

        // ],
        // [
        //     'invoice_number.required'    => 'عفوا يجب إدخال رقم الفاتورة' ,
        //     'invoice_date.required'      => 'عفوا يجب إدخال تاريخ الفاتورة',
        //     'due_date.required'          => 'عفوا يجب إدخال تاريخ الإستحقاق',
        //     'product.required'           => 'عفوا يجب إدخال إاسم المنتيج',
        //     'amount_collection.required' => 'عفوا يجب إدخال مبلغ التحصيل',
        //     'amount_commission.required' => 'عفوا يجب إدخال مبلغ العمولة',
        // ]
        // );
