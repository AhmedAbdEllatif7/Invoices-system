<?php

namespace App\Http\Controllers\Invoices;

use App\Http\Controllers\Controller;
use App\Models\Invoices_Attachments;
use App\Models\Invoices_Details;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class InvoicesDetailsController extends Controller
{
    public function __construct(){
        $this->middleware('returnRedirectIfNotAuth');
    }


    public function index()
    {

    }

    public function create()
    {
        //
    }


    public function store(Request $request)
    {

    }


    public function show(Invoices_Details $invoices_Details)
    {
        //
    }


    public function edit(Invoices_Details $invoices_Details)
    {
        //
    }


    public function update(Request $request, Invoices_Details $invoices_Details)
    {
        //
    }

    public function destroy(Request $request)
    {
        $invoice_attachment = Invoices_Attachments::find($request->attachment_id);
        $invoice_attachment->delete();

        Storage::disk('public_uploads')->delete($request->invoice_number.'/'.$request->file_name);

        session()->flash('delete', 'تم حذف المرفق بنجاح');
        return redirect()->back();
    }



    public function openFile($invoice_number, $file_name)
    {

        $file = Storage::disk('public_uploads')->path($invoice_number.'/'.$file_name);
        return response()->file($file);
    }



    public function downloadFile($invoice_number, $file_name)
    {
        $file = Storage::disk('public_uploads')->path($invoice_number.'/'.$file_name);
        return response()->download($file);
    }


    public function showDetails($id)
    {

        //Get Id Of Seleted Invoice
        $id2 = DB::table('invoices_details')->where('invoice_id', '=' , $id)->latest()->first()->id;


        //Get Invoice Details By It's Id
        $invoice_details  = Invoices_Details::find($id2);

        //Get All Invoice Details of it
        $all_invoices_details = Invoices_Details::where('invoice_id',$id)->get();


        //Get All Attachments Of It
        $invoice_attachments = DB::table('invoices_attachments')->where('invoice_id', $id)->where('deleted_at','=',null)->get();


        // $noti_ID = DB::table('notifications')->where('data->invoice_id', $id)->first()->id;
        // $t = DB::table('notifications')->where('id',$noti_ID)->update(['read_at' => now()]);


        return view('invoices.invoice_details', compact('invoice_details','all_invoices_details','invoice_attachments'));

    }
}
