<?php

namespace App\Repositories\Notifications;

use App\Interfaces\Notifications\NotificationsRepositoryInterface;
use App\Models\Invoice;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NotificationsRepository implements NotificationsRepositoryInterface {


    public function viewNotificationInvoice()
    {
        $invoice = Invoice::findOrFail(request()->id);
        $invoiceDetails = $invoice->details->last();
        $AllInvoiceDetails = $invoice->details;
        $AllInvoiceAttachments = $invoice->attachment;
    
        $this->markNotificationAsRead($invoice);
    
        return view('invoices.details.index', compact('invoiceDetails', 'AllInvoiceDetails', 'AllInvoiceAttachments'));
    }
    
    public function markNotificationAsRead($invoice)
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
    


    public function deleteSelectedNotifications($request)
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