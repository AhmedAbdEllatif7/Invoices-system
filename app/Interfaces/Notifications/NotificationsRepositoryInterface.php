<?php

namespace App\Interfaces\Notifications;

interface NotificationsRepositoryInterface {

    public function viewNotificationInvoice();
    
    public function markNotificationAsRead($invoice);
    
    public function readAllNotification();
    
    public function viewReadNotificationInvoice();
    
    public function deleteSelectedNotifications($request);

}