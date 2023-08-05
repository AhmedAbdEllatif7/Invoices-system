<?php

namespace App\Http\Controllers\Invoices;

use App\Http\Controllers\Controller;
use App\Models\Invoices_Attachments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvoicesAttachmentsController extends Controller
{
    public function __construct(){
        $this->middleware('returnRedirectIfNotAuth');
    }


    public function index()
    {
        //
    }

    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        //Validation
        $this->validate($request,[
            'file_name' => 'mimes:pdf,jpg,jpeg,png',
        ],
        [
            'file_name.mimes' => '  عفوا يجب ان تكون صيغة المرفق من نوع   pdf,png,pneg,jpg'
        ]
        );

        //Get File From Request
        $file = $request->file('file_name');

        //Get File From Request By It's Extension
        $file_name = $file->getClientOriginalName();

        //Save Attachment In Database
        Invoices_Attachments::create([
            'file_name'      => $file_name,
            'invoice_number' => $request->invoice_number,
            'invoice_id'     => $request->invoice_id,
            'created_by'     => Auth::user()->name,
        ]);

        //Save File In My Path
        $file->move(public_path('Attachments/'.$request->invoice_number),$file_name);
        session()->flash('Add', 'تمت إضافة المرفق بنجاح');
        return redirect()->back();
    }


    public function show(Invoices_Attachments $invoices_Attachments)
    {

    }


    public function edit(Invoices_Attachments $invoices_Attachments)
    {
        //
    }


    public function update(Request $request, Invoices_Attachments $invoices_Attachments)
    {
        //
    }

    public function destroy(Invoices_Attachments $invoices_Attachments)
    {
        //
    }
}
