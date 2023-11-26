<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class InvoiceCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $invoiceData;
    public $file;

    public function __construct($invoiceData , $file)
    {
        $this->invoiceData = $invoiceData;
        $this->file = $file;
    }

    
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}