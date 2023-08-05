<?php

namespace App\Http\Controllers\Invoices;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Invoices_Attachments;
use App\Models\Invoices_Details;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class InvoicesController extends Controller
{
    public function __construct(){
         $this->middleware('returnRedirectIfNotAuth');
    }

    public function index()
    {
        $invoices = Invoice::all();
        return view('invoices.invoices',compact('invoices'));
    }


    public function create()
    {
        $sections = Section::get();
        return view('invoices.add_invoice',compact('sections'));
    }

    public function store(Request $request)
    {

        //Validation
        $this->validate($request,
        [
            'invoice_number'    => 'required',
            'invoice_date'      => 'required|date',
            'due_date'          => 'required|date',
            'product'           => 'required|max:225',
            'section_id'        => 'required',
            'amount_collection' => 'required',
            'amount_commission' => 'required',
            'Value_VAT'         => 'required',
            'Rate_VAT'          => 'required',
            'Total'             => 'required',
        ],
        [
            'invoice_number.required' => 'عفوا يجب إدخال رقم الفاتورة' ,
            'invoice_date.required' => 'عفوا يجب إدخال تاريخ الفاتورة',
            'due_date.required' => 'عفوا يجب إدخال تاريخ الإستحقاق',
            'product.required' => 'عفوا يجب إدخال إاسم المنتيج',
            'section_id.required' => 'عفوا يجب إدخال رقم القسم',
            'amount_collection.required' => 'عفوا يجب إدخال مبلغ التحصيل',
            'amount_commission.required' => 'عفوا يجب إدخال مبلغ العمولة',
            'Value_VAT.required' => 'عفوا يجب إدخال قيمة ضريبة القيمة المضافة',
            'Rate_VAT.required' => 'عفوا يجب إدخال نسبة ضريبة القيمة المضافة',
            'Total.required' => 'عفوا يجب إدخال رقم الإجمالي شامل الضريبة',
        ]
        );

        //Save Invoice In DataBase
        Invoice::create([
            'invoice_number'     => $request->invoice_number,
            'invoice_date'       => $request->invoice_date,
            'due_date'           => $request->due_date,
            'product'            => $request->product,
            'section_id'         => $request->section_id,
            'amount_collection'  => $request->amount_collection,
            'amount_commission'  => $request->amount_commission,
            'discount'           => $request->discount,
            'value_vat'          => $request->Value_VAT,
            'rate_vat'           => $request->Rate_VAT,
            'total'              => $request->Total,
            'status'             => 'غير مدفوعة',
            'value_status'       => 0,//غير مدفوعة
            'note'               => $request->note,
        ]);

        //Save Invoice_Details In Datbase
        $invoice_id = Invoice::latest()->first()->id;
        Invoices_Details::create([
            'invoice_id'         => $invoice_id,
            'invoice_number'     => $request->invoice_number,
            'product'            => $request->product,
            'section_id'         => $request->section_id,
            'status'             => 'غير مدفوعة',
            'value_status'       => 0,//غير مدفوعة
            'note'               => $request->note,
            'user'               => Auth::user()->name,
        ]);


        //Invoice_Attachments

        //Get Data From Request
        $invoice_id     = Invoice::latest()->first()->id;
        $invoice_number = $request->invoice_number;
        $file           = $request->file('pic');
        $file_name      = $file->getClientOriginalName();

        //Store Data In DataBase
        Invoices_Attachments::create([
            'file_name'      => $file_name,
            'invoice_number' => $request->invoice_number,
            'created_by'     => Auth::user()->name,
            'invoice_id'     => $invoice_id,
        ]);

        //Move File
        $file->move(public_path('Attachments/'.$invoice_number),$file_name);

        // $url = 'http://127.0.0.1:8000/invoice/details/'.$invoice_id;
        // Mail::to('uaahmed89@gmail.com')->send(new AddInvoice($url));
        // //Send Notification

        // $user = User::where('id', 17)->get();
        // $invoice_id = Invoice::latest()->first()->id;

        // Notification::send($user, new InvoiceCreated($invoice_id));

        session()->flash('Add');
        return redirect()->back();

    }


    public function show($id)
    {
        $invoice = Invoice::where('id',$id)->first();
        if(!$invoice)
        {
            session()->flash('error');
            return redirect()->back();
        }
        return view('invoices.showStatus',compact('invoice'));
    }


    public function edit(Request $request, $id)
    {
        $invoice  = Invoice::find($id);
        if(!$invoice)
        {
            session()->flash('error');
            return redirect()->back();
        }
        $sections = Section::get();
        return view('invoices.edit_invoice',compact('invoice','sections'));
    }

    public function update(Request $request)
    {
        $id_invoice = $request->id;
        $invoice_number = $request->invoice_number;
        //Validation
        $this->validate($request,
        [
            'invoice_number'    => 'required|numeric|unique:invoices,invoice_number,'.$id_invoice,
            'invoice_date'      => 'required|date',
            'due_date'          => 'required|date',
            'product'           => 'required',
            'amount_collection' => 'required|numeric',
            'amount_commission' => 'required|numeric',

        ],
        [
            'invoice_number.required'    => 'عفوا يجب إدخال رقم الفاتورة' ,
            'invoice_date.required'      => 'عفوا يجب إدخال تاريخ الفاتورة',
            'due_date.required'          => 'عفوا يجب إدخال تاريخ الإستحقاق',
            'product.required'           => 'عفوا يجب إدخال إاسم المنتيج',
            'amount_collection.required' => 'عفوا يجب إدخال مبلغ التحصيل',
            'amount_commission.required' => 'عفوا يجب إدخال مبلغ العمولة',
        ]
        );

        //Store In Database
        $invoice = Invoice:: findorFail($id_invoice);
        $invoice->update(
            [
                'invoice_number'    =>$request->invoice_number,
                'invoice_date'      =>$request->invoice_date,
                'due_date'          =>$request->due_date,
                'product'           =>$request->product,
                'section_id'        =>$request->section_id,
                'amount_collection' =>$request->amount_collection,
                'amount_commission' =>$request->amount_commission,
                'value_vat'         =>$request->Value_VAT,
                'rate_vat'          =>$request->Rate_VAT,
                'total'             =>$request->Total,
                'discount'          =>$request->discount,
                'note'              =>$request->note,
            ]
            );
            session()->flash('edit_invoice');
            return redirect()->back();
    }



    public function destroy(Request $request)
    {
        $id = $request->id;
        $invoice     = Invoice::where('id',$id)->first();
        $attachments = Invoices_Attachments::where('invoice_id',$id)->first();
        if(!empty($attachments->invoice_number))
        {
            Storage::disk('public_uploads')->delete($attachments->invoice_number.'/'.$attachments->file_name);
        }
        // Storage::disk('s3')->delete('path/file.jpg');
        $invoice->forceDelete();
        return redirect()->back()->with(['delete' => 'تم حذف الفاتورة بنجاح']);
    }

    public function getproducts($id)
    {
        $products = DB::table("products")->where("section_id", $id)->pluck("product_name", "id");
        return json_encode($products);
    }



    public function updateStatus(Request $request,$id)
    {
        $invoice = Invoice::findorFail($id);
        if($request->Status == 'مدفوعة')
        {
        $invoice->update(
            [
                'value_status' =>1,
                'status'       =>$request->Status,
                'payment_date' =>$request->payment_date,
            ]
            );
            Invoices_Details::create([
                'invoice_id'    => $request->id,
                'invoice_number'=> $request->invoice_number,
                'product'       => $request->product,
                'section_id'    => $request->section_id,
                'status'        => $request->Status,
                'value_status'  => 1,
                'payment_date'  => $request->payment_date,
                'note'          => $request->note,
                'user'          => Auth::user()->name,
            ]);
        }


        else
        {
        $invoice->update(
            [
                'value_status' =>2,
                'status'       =>$request->Status,
                'payment_date' =>$request->payment_date,
            ]
            );
            Invoices_Details::create([
                'invoice_id'    => $request->id,
                'invoice_number'=> $request->invoice_number,
                'product'       => $request->product,
                'section_id'    => $request->section_id,
                'status'        => $request->Status,
                'value_status'  => 2,
                'payment_date'  => $request->payment_date,
                'note'          => $request->note,
                'user'          => Auth::user()->name,
            ]);
        }

            session()->flash('edit');
            return redirect('invoices');
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
        $invoice = Invoice::withTrashed()->where('id',$id)->restore();
        $invoice = Invoices_Details::withTrashed()->where('invoice_id',$id)->restore();
        $invoice = Invoices_Attachments::withTrashed()->where('invoice_id',$id)->restore();

        session()->flash('restore');
        return redirect()->back();
    }


    public function showPrint(Request $request, $id)
    {
        $invoice = Invoice::find($id);
        if(!$invoice)
        {
            session()->flash('error');
            return redirect()->back();
        }
        return view('invoices.print_invoice',compact('invoice'));
    }

}
