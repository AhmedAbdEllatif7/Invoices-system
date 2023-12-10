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
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\InvoicesExport;
use App\Models\User;
use App\Notifications\NewInvoiceIsCreated;
use App\Observers\InvoiceObserver;

class InvoiceRepository implements InvoiceRepositoryInterface {


    public function export() 
    {
        return Excel::download(new InvoicesExport, 'invoices.xlsx');
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
    
            $invoice = Invoice::create($invoiceValidatedData);
    
            // Save Invoice Details and Invoice Attachments In Datbase
            event(new InvoiceCreated($invoice));

            $this->sendNotificationToOwner();

            DB::commit();
    
            session()->flash('Add');
            return redirect()->back();
        } 
        
        catch (Throwable $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'An error occurred: ' . $e->getMessage()]);
        }
        
    }



    public function sendNotificationToOwner()
    {
        $userToNotify = User::where('email', 'ahmedabdellatif@gmail.com')->first();
        $currentUserEmail = Auth::user()->email;
    
        if ($currentUserEmail !== 'ahmedabdellatif@gmail.com' && $userToNotify) {
            $lastInvoice = Invoice::latest()->first();
            $userToNotify->notify(new NewInvoiceIsCreated($lastInvoice));
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
        
        $this->updateDetails($invoice);
        
        session()->flash('edit');
        return redirect('invoices');
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








    public function deleteSelectedInvoices($request)
    {
        try {
            $delete_all_id = explode(",", $request->delete_all_id);
            
            foreach($delete_all_id as $id)
            {
                InvoiceObserver::deleteAttachments($id);
            }
            
            $deleted = Invoice::whereIn('id', $delete_all_id)->forceDelete();
            if ($deleted) {
                return redirect()->back()->with(['deleteSelected' => 'تم حذف العناصر المحددة بنجاح']);
            }
            return redirect()->back()->withErrors('حدث خطأ في حذف العناصر المحددة');
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }









    public function changeGroupStatus($request)
    {
        try {
            $change_status_selected_id = explode(",", $request->change_status_selected_id);
            
            foreach ($change_status_selected_id as $id) {
                $invoice = Invoice::findOrFail($id);
                
                $data = [
                    'value_status' => $request->Status === 'مدفوعة' ? 1 : 2,
                    'status' => $request->Status,
                    'payment_date' => $request->payment_date, 
                ];
                
                $invoice->update($data);
                
                $this->updateDetails($invoice);
            }
            
            return redirect()->back()->with(['changeStatusGroup' => 'تم تغيير حالة الدفع للعناصر المحددة بنجاح']);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }



    public function updateDetails($invoice)
    {
        InvoiceDetail::create([
            'invoice_id'    => $invoice->id,
            'invoice_number'=> $invoice->invoice_number,
            'product'       => $invoice->product,
            'section_id'    => $invoice->section_id,
            'status'        => $invoice->status,
            'value_status'  => $invoice->value_status,
            'payment_date'  => $invoice->payment_date,
            'note'          => $invoice->note,
            'user'          => Auth::user()->name,
        ]);
    }







}