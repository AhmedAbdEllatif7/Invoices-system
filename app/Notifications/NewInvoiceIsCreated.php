<?php

namespace App\Notifications;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class NewInvoiceIsCreated extends Notification
{
    use Queueable;



    private $invoice ;
    public function __construct($invoice )
    {
        $this->invoice = $invoice;
    }



    public function via($notifiable)
    {
        return ['database'];
    }




    public function toArray($notifiable)
    {
        return [

            'title' => ' تمت إضافة فاتورة بواسطة',
            'id' => $this->invoice->id,
            'created_by' => Auth::user()->name,
        ];
    }
}
