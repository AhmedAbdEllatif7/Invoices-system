<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;

class InvoiceCreated extends Notification
{
    use Queueable;


    public $invoice_id;
    public function __construct($invoice_id)
    {
        $this->invoice_id = $invoice_id;
    }


    public function via($notifiable)
    {
        return ['database'];
    }


    public function toArray($notifiable)
    {
        return [
        'invoice_id'     => $this->invoice_id,
        'title'  => ' تمت إضافة فاتورة جديدة بواسطة',
        'user'   => Auth::user()->name,

    ];
    }
}
