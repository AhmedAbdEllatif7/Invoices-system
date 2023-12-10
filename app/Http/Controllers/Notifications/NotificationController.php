<?php

namespace App\Http\Controllers\Notifications;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class NotificationController extends Controller
{
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
    
}
