<?php

namespace App\Http\Controllers\Notifications;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NotificationController extends Controller
{

    //add middleware of roles and auth
    public function viewNotificationInvoice()
    {
        $invoice = Invoice::findOrFail(request()->id);
        $invoiceDetails = $invoice->details->last();
        $AllInvoiceDetails = $invoice->details;
        $AllInvoiceAttachments = $invoice->attachment;
    
        $this->markNotificationAsRead($invoice);
    
        return view('invoices.details.index', compact('invoiceDetails', 'AllInvoiceDetails', 'AllInvoiceAttachments'));
    }
    
    private function markNotificationAsRead($invoice)
    {
        // Fetch notifications related to the invoice ID
        $relatedNotifications = Auth::user()->unreadNotifications()
            ->where('data->id', $invoice->id)
            ->get();
    
        // Mark related notifications as read
        $relatedNotifications->markAsRead();
    }



    public function readAllNotification()
    {
        $allNotifications = Auth::user()->unreadNotifications;
    
        if ($allNotifications->isNotEmpty()) {
            
            $allNotifications->markAsRead();

            session()->flash('readAllNoti');
            return redirect()->back();
        }

        return redirect()->back()->with('notFound' , 'لا يوجد إشعارات');

    }



    public function viewReadNotificationInvoice()
    {
        $allReadNotifications = Auth::user()->readNotifications;

        if ($allReadNotifications->isNotEmpty()) {
            return view('notifications.readNotifications');
        }

        return redirect()->route('home')->with('notFound' , 'لا يوجد إشعارات');
    }
    


    public function deleteSelectedNotifications(Request $request)
    {
        try {
            $delete_all_id = explode(",", $request->delete_all_id);
            
            foreach ($delete_all_id as $id) {
                DB::table('notifications')->where('id', $id)->delete();
            }
    
            return redirect()->back()->with(['deleteSelected' => 'تم حذف العناصر المحددة بنجاح']);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
    
}
