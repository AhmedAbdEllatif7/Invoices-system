<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class InvoiceCreated extends Notification
{
    use Queueable;



    public $invoiceID , $createdBy;
    public function __construct($invoiceID , $createdBy)
    {
        $this->invoiceID = $invoiceID;
        $this->createdBy = $$createdBy;
    }



    public function via($notifiable)
    {
        return ['mail'];
    }




    public function toMail($notifiable)
    {
        $url = "http://127.0.0.1:8000/details.index/".$this->invoiceID;
        return (new MailMessage)
                    ->subject('إضافة فاتورة جديدة')
                    ->line('تمت إضافة فاتورة جديدة')
                    ->action('عرض الفاتورة', url($url))
                    ->line('شكرا لإستخدامك برنامجنا');
    }




    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
