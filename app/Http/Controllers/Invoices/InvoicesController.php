<?php

namespace App\Http\Controllers\Invoices;

use App\Events\InvoiceCreated;
use App\Http\Controllers\Controller;
use App\Http\Requests\InvoiceRequest;
use App\Models\Invoice;
use App\Models\Invoices_Attachments;
use App\Models\Invoices_Details;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Filesystem\Filesystem; // Import the Filesystem class
use Illuminate\Support\Facades\File; // Import the File facade

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

        //Save Invoice In DataBase
        $invoiceValidatedData = $request->validated();

        $invoiceValidatedData['status'] = 'غير مدفوعة';
        $invoiceValidatedData['value_status'] = 0; //غير مدفوعة

        if($request->note){
            $invoiceValidatedData['note'] = $request->note;
        }
        
        $invoice = Invoice::create($invoiceValidatedData);

        //Save Invoice_Details and Invoice_Attachments In Datbase 
        $file = $request->file('file');       
        event(new InvoiceCreated($invoice , $file));
        
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
        $invoiceId = $request->id;
        $invoice = Invoice::findOrFail($invoiceId);

        if ($request->note) {
            $invoiceValidatedData['note'] = $request->note;
        }
        // Get the current invoice number before updating
        $oldInvoiceNumber = $invoice->invoice_number;
        
        // Update invoice data
        $invoice->update($invoiceValidatedData);
        $newInvoiceNumber = $invoice->invoice_number;

        // Rename attachments folder if the invoice number has changed
        if ($oldInvoiceNumber !== $invoice->invoice_number) {
            $this->renameAttachmentFolder($oldInvoiceNumber, $newInvoiceNumber);
        }

        // Handle attachments
        if ($request->hasFile('file')) {
            $this->handleAttachment($request->file('file'), $invoice);
        }

        session()->flash('edit_invoice');
        return redirect()->back();
    }


    private function renameAttachmentFolder($oldInvoiceNumber, $newInvoiceNumber)
    {
        $oldFolder = public_path('Attachments/' . $oldInvoiceNumber);
        $newFolder = public_path('Attachments/' . $newInvoiceNumber);

        if (file_exists($oldFolder)) {
            rename($oldFolder, $newFolder);
        }
    }


    private function handleAttachment($attachmentFile, $invoice)
    {
        $filesystem = new FileSystem(); // Create an instance of the Filesystem class

        $oldFolder = public_path('Attachments/' . $invoice->invoice_number);

        // Check if the directory exists before attempting to delete
        if ($filesystem->isDirectory($oldFolder)) {
            $filesystem->deleteDirectory($oldFolder);
        }

        $fileName = $attachmentFile->getClientOriginalName();
        $attachmentFile->move(public_path('Attachments/' . $invoice->invoice_number), $fileName);

        // Update the file_name in the database
        $invoice->attachment()->update([
            'file_name' => $fileName,
        ]);
    }






    public function destroy(Request $request)
    {
        $id = $request->id;

        // Delete attachments related to the invoice
        $this->deleteAttachments($id);

        // Delete the invoice
        $this->deleteInvoice($id);

        return redirect()->back()->with(['delete' => 'تم حذف الفاتورة بنجاح']);
    }


    private function deleteAttachments($id)
    {
        $attachments = Invoices_Attachments::where('invoice_id', $id)->get();

        if ($attachments->isNotEmpty()) {
            foreach ($attachments as $attachment) {
                $path = 'Attachments/' . $attachment->invoice_number . '/' . $attachment->file_name;
                Storage::disk('public_uploads')->delete($path);
            }

            $directory = public_path('Attachments/' . $attachments->first()->invoice_number);
            if (File::exists($directory)) {
                File::deleteDirectory($directory);
            }
        }
    }


    private function deleteInvoice($id)
    {
        $invoice = Invoice::findOrFail($id);
        $invoice->forceDelete();
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
